<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar seluruh pesanan.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search'));
        $status = $request->input('status');

        $allowedStatuses = [
            'pending_payment',
            'paid',
            'in_progress',
            'revision',
            'completed',
            'cancelled',
        ];

        $orders = Order::query()
            ->with([
                'client',
                'freelancerProfile.user',
                'items',
                'payment',
            ])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('order_number', 'like', '%' . $search . '%')

                        ->orWhereHas('client', function ($clientQuery) use ($search) {
                            $clientQuery
                                ->where('name', 'like', '%' . $search . '%')
                                ->orWhere('email', 'like', '%' . $search . '%');
                        })

                        ->orWhereHas('freelancerProfile.user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', '%' . $search . '%');
                        });
                });
            })
            ->when(
                in_array($status, $allowedStatuses, true),
                fn ($query) => $query->where('status', $status)
            )
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.orders.index', compact(
            'orders',
            'search',
            'status'
        ));
    }

    /**
     * Menampilkan detail pesanan.
     */
    public function show(Order $order)
    {
        $order->load([
            'client',
            'freelancerProfile.user',
            'items',
            'payment',
            'deliveries',
        ]);

        return view('admin.orders.show', compact('order'));
    }
}