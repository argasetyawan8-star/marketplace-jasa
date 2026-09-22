<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CancellationRequest;
use App\Models\Commission;
use App\Models\Dispute;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Refund;
use App\Models\Review;
use App\Models\Service;
use App\Models\User;
use App\Models\Withdrawal;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Dashboard utama admin.
     */
    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | USER
        |--------------------------------------------------------------------------
        */

        $totalUsers = User::count();

        $totalClients = User::where('role', 'client')->count();

        $totalFreelancers = User::where('role', 'freelancer')->count();

        $totalAdmins = User::where('role', 'admin')->count();

        /*
        |--------------------------------------------------------------------------
        | MARKETPLACE
        |--------------------------------------------------------------------------
        */

        $totalServices = Service::count();

        /*
        |--------------------------------------------------------------------------
        | ORDER
        |--------------------------------------------------------------------------
        */

        $totalOrders = Order::count();

        $completedOrders = Order::where('status', 'completed')->count();

        $paidOrders = Order::where('status', 'paid')->count();

        $cancelledOrders = Order::where('status', 'cancelled')->count();

        /*
        |--------------------------------------------------------------------------
        | PAYMENT
        |--------------------------------------------------------------------------
        */

        $totalPayments = Payment::count();

        $paidPayments = Payment::where('status', 'paid')->count();

        $refundPendingPayments = Payment::where(
            'status',
            'refund_pending'
        )->count();

        $refundedPayments = Payment::where(
            'status',
            'refunded'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | PLATFORM REVENUE / COMMISSION
        |--------------------------------------------------------------------------
        |
        | Commission yang statusnya "earned" dianggap sebagai
        | pendapatan komisi platform.
        |
        */

        $totalCommission = Commission::where(
            'status',
            'earned'
        )->sum('commission_amount');

        $totalCommissions = Commission::count();

        /*
        |--------------------------------------------------------------------------
        | WITHDRAWAL
        |--------------------------------------------------------------------------
        |
        | Saat ini tabel withdrawal belum memiliki data.
        | Kita tetap siapkan query untuk status pending/processing
        | agar dashboard otomatis siap ketika withdrawal mulai digunakan.
        |
        */

        $totalWithdrawals = Withdrawal::count();

        $pendingWithdrawals = Withdrawal::whereIn(
            'status',
            ['pending', 'processing']
        )->count();

        /*
        |--------------------------------------------------------------------------
        | CANCELLATION
        |--------------------------------------------------------------------------
        |
        | Dari data saat ini:
        | approved_by_freelancer = masih menunggu keputusan admin.
        |
        */

        $totalCancellations = CancellationRequest::count();

        $pendingCancellations = CancellationRequest::where(
            'status',
            'approved_by_freelancer'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | DISPUTE
        |--------------------------------------------------------------------------
        |
        | Model Order mendefinisikan dispute aktif sebagai:
        | open, pending_response, under_review.
        |
        */

        $totalDisputes = Dispute::count();

        $openDisputes = Dispute::whereIn(
            'status',
            [
                'open',
                'pending_response',
                'under_review',
            ]
        )->count();

        /*
        |--------------------------------------------------------------------------
        | REFUND
        |--------------------------------------------------------------------------
        |
        | Refund model saat ini seluruh data yang ada berstatus "refunded".
        | Payment memiliki status refund_pending, sehingga kita tampilkan
        | refund yang sedang menunggu proses dari sisi payment.
        |
        */

        $totalRefunds = Refund::count();

        $pendingRefunds = Payment::where(
            'status',
            'refund_pending'
        )->count();

        $completedRefunds = Refund::where(
            'status',
            'refunded'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | REVIEW
        |--------------------------------------------------------------------------
        */

        $totalReviews = Review::count();

        $publishedReviews = Review::where(
            'status',
            'published'
        )->count();

        $pendingReviews = Review::where(
            'status',
            '!=',
            'published'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | DATA DASHBOARD
        |--------------------------------------------------------------------------
        */

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalClients',
            'totalFreelancers',
            'totalAdmins',

            'totalServices',

            'totalOrders',
            'completedOrders',
            'paidOrders',
            'cancelledOrders',

            'totalPayments',
            'paidPayments',
            'refundPendingPayments',
            'refundedPayments',

            'totalCommission',
            'totalCommissions',

            'totalWithdrawals',
            'pendingWithdrawals',

            'totalCancellations',
            'pendingCancellations',

            'totalDisputes',
            'openDisputes',

            'totalRefunds',
            'pendingRefunds',
            'completedRefunds',

            'totalReviews',
            'publishedReviews',
            'pendingReviews'
        ));
    }
}