<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Daftar order milik freelancer.
     */
    public function index()
    {
        $profile = Auth::user()->freelancerProfile;

        abort_unless($profile, 403);

        $orders = Order::with([
            'client',
            'items.service',
            'payment',
            'deliveries',
        ])
            ->where('freelancer_profile_id', $profile->id)
            ->latest()
            ->paginate(10);

        return view('freelancer.orders.index', compact('orders'));
    }

    /**
     * Detail + workspace sebuah order.
     */
    public function show(Order $order)
    {
        $profile = Auth::user()->freelancerProfile;

        abort_unless($profile, 403);

        abort_unless(
            $order->freelancer_profile_id === $profile->id,
            403
        );

        $order->load([
            'client.profile',
            'items.service',
            'payment',
            'deliveries' => fn ($query) => $query->latest(),
            'review.client',
            'conversation',
        ]);

        $latestDelivery = $order->deliveries->first();

        return view(
            'freelancer.orders.show',
            compact(
                'order',
                'latestDelivery'
            )
        );
    }
}
