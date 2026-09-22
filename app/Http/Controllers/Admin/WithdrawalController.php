<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\Withdrawal;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        /**
         * Nilai ini akan diisi di dalam transaction.
         *
         * Notification baru akan dikirim setelah transaction selesai
         * dan berhasil commit.
         */
        $notificationData = DB::transaction(
            function () use (
                $validated,
                $withdrawal
            ) {
                /**
                 * Lock withdrawal agar tidak diproses bersamaan.
                 */
                $lockedWithdrawal = Withdrawal::query()
                    ->whereKey($withdrawal->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $oldStatus = $lockedWithdrawal->status;
                $newStatus = $validated['status'];

                /**
                 * Status yang sama tidak perlu diproses ulang.
                 */
                if ($oldStatus === $newStatus) {
                    return [
                        'changed' => false,
                        'status' => $oldStatus,
                        'withdrawal_id' => $lockedWithdrawal->id,
                    ];
                }

                /**
                 * Withdrawal yang sudah completed tidak boleh
                 * diubah kembali.
                 */
                if ($oldStatus === 'completed') {
                    throw ValidationException::withMessages([
                        'status' =>
                            'Withdrawal yang sudah selesai tidak dapat diubah lagi.',
                    ]);
                }

                /**
                 * Withdrawal yang sudah rejected tidak boleh
                 * diproses kembali.
                 */
                if ($oldStatus === 'rejected') {
                    throw ValidationException::withMessages([
                        'status' =>
                            'Withdrawal yang sudah ditolak tidak dapat diproses kembali.',
                    ]);
                }

                /**
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

                /**
                 * ==============================================================
                 * REJECTED
                 * ==============================================================
                 *
                 * Uang yang sebelumnya dipindahkan ke pending_balance
                 * dikembalikan ke balance.
                 */
                if ($newStatus === 'rejected') {
                    $amount = (float) $lockedWithdrawal->amount;

                    $newBalance = $currentBalance + $amount;

                    $newPendingBalance = max(
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

                    return [
                        'changed' => true,
                        'status' => 'rejected',
                        'withdrawal_id' => $lockedWithdrawal->id,
                        'amount' => $amount,
                        'rejection_reason' =>
                            $validated['rejection_reason'] ?? null,
                        'freelancer_profile_id' =>
                            $lockedWithdrawal->freelancer_profile_id,
                    ];
                }

                /**
                 * ==============================================================
                 * PROCESSING
                 * ==============================================================
                 *
                 * Uang tetap berada di pending_balance.
                 * Belum masuk total_withdrawn.
                 */
                if ($newStatus === 'processing') {
                    $lockedWithdrawal->update([
                        'status' => 'processing',
                        'rejection_reason' => null,
                        'processed_at' =>
                            $lockedWithdrawal->processed_at ?? now(),
                    ]);

                    return [
                        'changed' => true,
                        'status' => 'processing',
                        'withdrawal_id' => $lockedWithdrawal->id,
                        'amount' =>
                            (float) $lockedWithdrawal->amount,
                        'freelancer_profile_id' =>
                            $lockedWithdrawal->freelancer_profile_id,
                    ];
                }

                /**
                 * ==============================================================
                 * PENDING
                 * ==============================================================
                 *
                 * Hanya boleh mengembalikan ke pending
                 * sebelum proses selesai.
                 *
                 * Tidak ada notification event khusus untuk pending.
                 */
                if ($newStatus === 'pending') {
                    $lockedWithdrawal->update([
                        'status' => 'pending',
                        'rejection_reason' => null,
                        'processed_at' => null,
                    ]);

                    return [
                        'changed' => true,
                        'status' => 'pending',
                        'withdrawal_id' => $lockedWithdrawal->id,
                        'amount' =>
                            (float) $lockedWithdrawal->amount,
                        'freelancer_profile_id' =>
                            $lockedWithdrawal->freelancer_profile_id,
                    ];
                }

                /**
                 * ==============================================================
                 * COMPLETED
                 * ==============================================================
                 *
                 * Withdrawal berhasil dilakukan.
                 *
                 * pending_balance berkurang.
                 * total_withdrawn bertambah.
                 */
                if ($newStatus === 'completed') {
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

                    return [
                        'changed' => true,
                        'status' => 'completed',
                        'withdrawal_id' => $lockedWithdrawal->id,
                        'amount' => $amount,
                        'freelancer_profile_id' =>
                            $lockedWithdrawal->freelancer_profile_id,
                    ];
                }

                throw ValidationException::withMessages([
                    'status' =>
                        'Status withdrawal tidak dapat diproses.',
                ]);
            }
        );

        /**
         * ----------------------------------------------------------------------
         * NOTIFICATION
         * ----------------------------------------------------------------------
         *
         * Notification dikirim SETELAH transaction berhasil commit.
         */
        if (
            ($notificationData['changed'] ?? false) &&
            in_array(
                $notificationData['status'] ?? null,
                [
                    'processing',
                    'completed',
                    'rejected',
                ],
                true
            )
        ) {
            $withdrawal->loadMissing([
                'freelancerProfile.user',
            ]);

            $freelancer = $withdrawal->freelancerProfile?->user;

            if ($freelancer) {
                $status = $notificationData['status'];

                if ($status === 'processing') {
                    $event = NotificationService::WITHDRAWAL_PROCESSING;

                    $title = 'Withdrawal sedang diproses';

                    $message =
                        'Pengajuan withdrawal sebesar Rp ' .
                        number_format(
                            (float) $withdrawal->amount,
                            0,
                            ',',
                            '.'
                        ) .
                        ' sedang diproses oleh Admin.';

                    $priority = 'info';
                } elseif ($status === 'completed') {
                    $event = NotificationService::WITHDRAWAL_COMPLETED;

                    $title = 'Withdrawal berhasil';

                    $message =
                        'Withdrawal sebesar Rp ' .
                        number_format(
                            (float) $withdrawal->net_amount,
                            0,
                            ',',
                            '.'
                        ) .
                        ' telah selesai diproses dan dana telah dikirim sesuai data penarikan.';

                    $priority = 'critical';
                } else {
                    $event = NotificationService::WITHDRAWAL_REJECTED;

                    $title = 'Withdrawal ditolak';

                    $rejectionReason =
                        $notificationData['rejection_reason']
                        ?? $withdrawal->rejection_reason;

                    $message =
                        'Pengajuan withdrawal sebesar Rp ' .
                        number_format(
                            (float) $withdrawal->amount,
                            0,
                            ',',
                            '.'
                        ) .
                        ' ditolak oleh Admin.';

                    if ($rejectionReason) {
                        $message .=
                            ' Alasan: ' .
                            $rejectionReason;
                    }

                    $priority = 'action';
                }

                app(NotificationService::class)->send(
                    recipient: $freelancer,
                    event: $event,
                    title: $title,
                    message: $message,
                    actionUrl: route(
                        'freelancer.withdrawals.index'
                    ),
                    priority: $priority,
                    actor: Auth::user(),
                    relatedType: 'withdrawal',
                    relatedId: $withdrawal->id,
                    extra: [
                        'withdrawal_id' => $withdrawal->id,
                        'amount' =>
                            (float) $withdrawal->amount,
                        'admin_fee' =>
                            (float) $withdrawal->admin_fee,
                        'net_amount' =>
                            (float) $withdrawal->net_amount,
                        'method' => $withdrawal->method,
                        'account_name' =>
                            $withdrawal->account_name,
                        'account_number' =>
                            $withdrawal->account_number,
                        'status' => $status,
                        'rejection_reason' =>
                            $withdrawal->rejection_reason,
                        'freelancer_profile_id' =>
                            $withdrawal->freelancer_profile_id,
                    ],
                    dedupeKey:
                        'withdrawal_' .
                        $status .
                        ':freelancer:' .
                        $freelancer->id .
                        ':' .
                        $withdrawal->id
                );
            }
        }

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
