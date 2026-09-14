<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            ->where('freelancer_profile_id', $freelancerProfile->id)
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
        $balance = (float) $wallet->balance;

        if ($amount > $balance) {
            return back()
                ->withErrors([
                    'amount' => 'Nominal penarikan melebihi saldo yang tersedia.',
                ])
                ->withInput();
        }

        DB::transaction(function () use (
            $wallet,
            $freelancerProfile,
            $validated,
            $amount
        ) {
            $adminFee = 0;
            $netAmount = $amount - $adminFee;

            Withdrawal::create([
                'freelancer_profile_id' => $freelancerProfile->id,
                'amount' => $amount,
                'admin_fee' => $adminFee,
                'net_amount' => $netAmount,
                'method' => $validated['method'],
                'account_name' => $validated['account_name'],
                'account_number' => $validated['account_number'],
                'note' => $validated['note'] ?? null,
                'status' => 'pending',
            ]);

            $wallet->decrement('balance', $amount);

            $wallet->increment('pending_balance', $amount);
        });

        return redirect()
            ->route('freelancer.withdrawals.index')
            ->with(
                'success',
                'Pengajuan penarikan berhasil dibuat dan sedang menunggu proses admin.'
            );
    }
}