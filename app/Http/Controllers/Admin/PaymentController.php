<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Menampilkan daftar seluruh pembayaran.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search'));
        $status = $request->input('status');

        $allowedStatuses = [
            'pending',
            'paid',
            'failed',
            'expired',
            'cancelled',
        ];

        $payments = Payment::query()
            ->with([
                'order.client',
                'order.freelancerProfile.user',
            ])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('transaction_id', 'like', '%' . $search . '%')
                        ->orWhereHas('order', function ($orderQuery) use ($search) {
                            $orderQuery->where(
                                'order_number',
                                'like',
                                '%' . $search . '%'
                            );
                        })
                        ->orWhereHas('order.client', function ($clientQuery) use ($search) {
                            $clientQuery
                                ->where('name', 'like', '%' . $search . '%')
                                ->orWhere('email', 'like', '%' . $search . '%');
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

        return view('admin.payments.index', compact(
            'payments',
            'search',
            'status'
        ));
    }

    /**
     * Menampilkan detail pembayaran.
     */
    public function show(Payment $payment)
    {
        $payment->load([
            'order.client',
            'order.freelancerProfile.user',
            'order.items',
        ]);

        return view('admin.payments.show', compact('payment'));
    }
}