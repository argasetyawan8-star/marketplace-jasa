<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    /**
     * Menampilkan wallet freelancer.
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

        $transactions = $wallet->transactions()
            ->latest()
            ->paginate(10);

        return view(
            'freelancer.wallet.index',
            compact(
                'wallet',
                'transactions'
            )
        );
    }
}