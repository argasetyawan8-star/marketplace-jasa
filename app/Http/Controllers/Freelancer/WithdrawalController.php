<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class WithdrawalController extends Controller
{
    /**
     * Menampilkan halaman penarikan.
     */
    public function index()
    {
        $freelancerProfile = Auth::user()->freelancerProfile;

        abort_unless($freelancerProfile, 403);

        $wallet = Wallet::firstOrCreate(
            [
                'freelancer_profile_id' => $freelancerProfile->id,
            ],
            [
                'balance' => 0,
                'pending_balance' => 0,
                'total_earned' => 0,
                'total_withdrawn' => 0,
            ]
        );

        $withdrawals = Withdrawal::query()
            ->where(
                'freelancer_profile_id',
                $freelancerProfile->id
            )
            ->latest()
            ->paginate(10);

        return view(
            'freelancer.withdrawals.index',
            compact(
                'wallet',
                'withdrawals'
            )
        );
    }

    /**
     * Menampilkan form pengajuan penarikan.
     */
    public function create()
    {
        $freelancerProfile = Auth::user()->freelancerProfile;

        abort_unless($freelancerProfile, 403);

        $wallet = Wallet::firstOrCreate(
            [
                'freelancer_profile_id' => $freelancerProfile->id,
            ],
            [
                'balance' => 0,
                'pending_balance' => 0,
                'total_earned' => 0,
                'total_withdrawn' => 0,
            ]
        );

        return view(
            'freelancer.withdrawals.create',
            compact('wallet')
        );
    }

    /**
     * Menyimpan pengajuan penarikan.
     */
    public function store(Request $request)
    {
        $freelancerProfile = Auth::user()->freelancerProfile;

        abort_unless($freelancerProfile, 403);

        $validated = $request->validate([
            'amount' => [
                'required',
                'numeric',
                'min:10000',
            ],
            'method' => [
                'required',
                'string',
                'max:100',
            ],
            'account_name' => [
                'required',
                'string',
                'max:255',
            ],
            'account_number' => [
                'required',
                'string',
                'max:100',
            ],
            'note' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $amount = (float) $validated['amount'];

        DB::transaction(function () use (
            $freelancerProfile,
            $validated,
            $amount
        ) {
            /*
             * Ambil wallet di dalam transaction dan lock row-nya.
             * Ini mencegah dua request withdrawal memakai saldo
             * yang sama secara bersamaan.
             */
            $wallet = Wallet::where(
                'freelancer_profile_id',
                $freelancerProfile->id
            )
                ->lockForUpdate()
                ->first();

            /*
             * Kalau wallet belum ada, buat terlebih dahulu.
             */
            if (! $wallet) {
                $wallet = Wallet::create([
                    'freelancer_profile_id' => $freelancerProfile->id,
                    'balance' => 0,
                    'pending_balance' => 0,
                    'total_earned' => 0,
                    'total_withdrawn' => 0,
                ]);

                $wallet = Wallet::whereKey($wallet->id)
                    ->lockForUpdate()
                    ->firstOrFail();
            }

            $balance = (float) $wallet->balance;

            /*
             * Cek ulang saldo setelah row wallet dikunci.
             */
            if ($amount > $balance) {
                throw ValidationException::withMessages([
                    'amount' => 'Nominal penarikan melebihi saldo yang tersedia.',
                ]);
            }

            /*
             * Untuk tahap development, admin fee masih 0.
             * Nanti bisa dibuat configurable.
             */
            $adminFee = 0;

            $netAmount = $amount - $adminFee;

            /*
             * Buat data withdrawal.
             */
            $withdrawal = Withdrawal::create([
                'freelancer_profile_id' => $freelancerProfile->id,
                'amount' => $amount,
                'admin_fee' => $adminFee,
                'net_amount' => $netAmount,
                'method' => $validated['method'],
                'account_name' => $validated['account_name'],
                'account_number' => $validated['account_number'],
                'note' => $validated['note'] ?? null,
                'status' => 'pending',
                'rejection_reason' => null,
                'processed_at' => null,
            ]);

            /*
             * Saldo tersedia dikurangi.
             * Nilai withdrawal dipindahkan ke pending_balance
             * sampai admin memproses pengajuan.
             */
            $newBalance = $balance - $amount;

            $newPendingBalance =
                (float) $wallet->pending_balance + $amount;

            $wallet->update([
                'balance' => $newBalance,
                'pending_balance' => $newPendingBalance,
            ]);

            /*
             * Catat transaksi wallet.
             */
            WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'type' => 'debit',
                'category' => 'withdrawal',
                'amount' => $amount,
                'balance_after' => $newBalance,
                'description' =>
                    'Pengajuan penarikan sebesar Rp ' .
                    number_format(
                        $amount,
                        0,
                        ',',
                        '.'
                    ),
                'reference_type' => 'Withdrawal',
                'reference_id' => $withdrawal->id,
            ]);
        });

        return redirect()
            ->route('freelancer.withdrawals.index')
            ->with(
                'success',
                'Pengajuan penarikan berhasil dibuat dan sedang menunggu proses admin.'
            );
    }
}