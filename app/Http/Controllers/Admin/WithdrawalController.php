<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class WithdrawalController extends Controller
{
    /**
     * Menampilkan daftar seluruh pengajuan penarikan.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search'));
        $status = $request->input('status');

        $allowedStatuses = [
            'pending',
            'processing',
            'completed',
            'rejected',
        ];

        $withdrawals = Withdrawal::query()
            ->with([
                'freelancerProfile.user',
            ])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where(
                        'account_name',
                        'like',
                        '%' . $search . '%'
                    )
                        ->orWhere(
                            'account_number',
                            'like',
                            '%' . $search . '%'
                        )
                        ->orWhere(
                            'method',
                            'like',
                            '%' . $search . '%'
                        )
                        ->orWhereHas(
                            'freelancerProfile.user',
                            function ($userQuery) use ($search) {
                                $userQuery
                                    ->where(
                                        'name',
                                        'like',
                                        '%' . $search . '%'
                                    )
                                    ->orWhere(
                                        'email',
                                        'like',
                                        '%' . $search . '%'
                                    );
                            }
                        );
                });
            })
            ->when(
                in_array($status, $allowedStatuses, true),
                fn ($query) => $query->where('status', $status)
            )
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view(
            'admin.withdrawals.index',
            compact(
                'withdrawals',
                'search',
                'status'
            )
        );
    }

    /**
     * Menampilkan detail pengajuan penarikan.
     */
    public function show(Withdrawal $withdrawal)
    {
        $withdrawal->load([
            'freelancerProfile.user',
        ]);

        return view(
            'admin.withdrawals.show',
            compact('withdrawal')
        );
    }

    /**
     * Memperbarui status pengajuan penarikan.
     */
    public function update(
        Request $request,
        Withdrawal $withdrawal
    ) {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:pending,processing,completed,rejected',
            ],
            'rejection_reason' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        DB::transaction(function () use (
            $validated,
            $withdrawal
        ) {
            /*
             * Lock withdrawal agar tidak diproses bersamaan.
             */
            $lockedWithdrawal = Withdrawal::query()
                ->whereKey($withdrawal->id)
                ->lockForUpdate()
                ->firstOrFail();

            /*
             * Status yang sama tidak perlu diproses ulang.
             */
            if ($lockedWithdrawal->status === $validated['status']) {
                return;
            }

            /*
             * Withdrawal yang sudah completed tidak boleh
             * diubah kembali.
             */
            if ($lockedWithdrawal->status === 'completed') {
                throw ValidationException::withMessages([
                    'status' =>
                        'Withdrawal yang sudah selesai tidak dapat diubah lagi.',
                ]);
            }

            /*
             * Withdrawal yang sudah rejected tidak boleh
             * langsung diubah ke status lain.
             */
            if ($lockedWithdrawal->status === 'rejected') {
                throw ValidationException::withMessages([
                    'status' =>
                        'Withdrawal yang sudah ditolak tidak dapat diproses kembali.',
                ]);
            }

            /*
             * Ambil wallet freelancer dan lock row wallet.
             */
            $wallet = Wallet::query()
                ->where(
                    'freelancer_profile_id',
                    $lockedWithdrawal->freelancer_profile_id
                )
                ->lockForUpdate()
                ->first();

            if (! $wallet) {
                throw ValidationException::withMessages([
                    'status' =>
                        'Wallet freelancer tidak ditemukan.',
                ]);
            }

            $currentBalance = (float) $wallet->balance;
            $currentPendingBalance =
                (float) $wallet->pending_balance;

            /*
             * ==========================================
             * REJECTED
             * ==========================================
             *
             * Uang yang sebelumnya dipindahkan ke
             * pending_balance dikembalikan ke balance.
             */
            if ($validated['status'] === 'rejected') {
                $amount = (float) $lockedWithdrawal->amount;

                $newBalance = $currentBalance + $amount;
                $newPendingBalance =
                    max(
                        0,
                        $currentPendingBalance - $amount
                    );

                $wallet->update([
                    'balance' => $newBalance,
                    'pending_balance' => $newPendingBalance,
                ]);

                WalletTransaction::create([
                    'wallet_id' => $wallet->id,
                    'type' => 'credit',
                    'category' => 'withdrawal_reversal',
                    'amount' => $amount,
                    'balance_after' => $newBalance,
                    'description' =>
                        'Pengembalian saldo karena withdrawal #' .
                        $lockedWithdrawal->id .
                        ' ditolak.',
                    'reference_type' => 'Withdrawal',
                    'reference_id' => $lockedWithdrawal->id,
                ]);

                $lockedWithdrawal->update([
                    'status' => 'rejected',
                    'rejection_reason' =>
                        $validated['rejection_reason'] ?? null,
                    'processed_at' => now(),
                ]);

                return;
            }

            /*
             * ==========================================
             * PROCESSING
             * ==========================================
             *
             * Uang tetap berada di pending_balance.
             * Belum masuk total_withdrawn.
             */
            if ($validated['status'] === 'processing') {
                $lockedWithdrawal->update([
                    'status' => 'processing',
                    'rejection_reason' => null,
                    'processed_at' =>
                        $lockedWithdrawal->processed_at ?? now(),
                ]);

                return;
            }

            /*
             * ==========================================
             * PENDING
             * ==========================================
             *
             * Hanya boleh mengembalikan ke pending
             * sebelum proses selesai.
             */
            if ($validated['status'] === 'pending') {
                $lockedWithdrawal->update([
                    'status' => 'pending',
                    'rejection_reason' => null,
                    'processed_at' => null,
                ]);

                return;
            }

            /*
             * ==========================================
             * COMPLETED
             * ==========================================
             *
             * Withdrawal berhasil dilakukan.
             *
             * pending_balance berkurang.
             * total_withdrawn bertambah.
             */
            if ($validated['status'] === 'completed') {
                $amount = (float) $lockedWithdrawal->amount;

                if ($currentPendingBalance < $amount) {
                    throw ValidationException::withMessages([
                        'status' =>
                            'Pending balance tidak mencukupi untuk menyelesaikan withdrawal ini.',
                    ]);
                }

                $newPendingBalance =
                    $currentPendingBalance - $amount;

                $newTotalWithdrawn =
                    (float) $wallet->total_withdrawn + $amount;

                $wallet->update([
                    'pending_balance' => $newPendingBalance,
                    'total_withdrawn' => $newTotalWithdrawn,
                ]);

                WalletTransaction::create([
                    'wallet_id' => $wallet->id,
                    'type' => 'debit',
                    'category' => 'withdrawal_completed',
                    'amount' => $amount,
                    'balance_after' => $currentBalance,
                    'description' =>
                        'Withdrawal berhasil diproses sebesar Rp ' .
                        number_format(
                            $amount,
                            0,
                            ',',
                            '.'
                        ),
                    'reference_type' => 'Withdrawal',
                    'reference_id' => $lockedWithdrawal->id,
                ]);

                $lockedWithdrawal->update([
                    'status' => 'completed',
                    'rejection_reason' => null,
                    'processed_at' => now(),
                ]);
            }
        });

        return redirect()
            ->route(
                'admin.withdrawals.show',
                $withdrawal
            )
            ->with(
                'success',
                'Status penarikan berhasil diperbarui.'
            );
    }
}