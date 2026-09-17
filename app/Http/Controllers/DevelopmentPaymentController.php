<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DevelopmentPaymentController extends Controller
{
    /**
     * Simulasi pembayaran berhasil.
     *
     * Fitur ini hanya boleh digunakan pada environment local.
     */
    public function simulate(Order $order): RedirectResponse
    {
        abort_unless(app()->environment('local'), 404);

        abort_unless(Auth::check(), 403);

        abort_unless(
            $order->client_id === Auth::id(),
            403
        );

        if ($order->status !== 'pending_payment') {
            return back()->with(
                'error',
                'Order ini tidak sedang menunggu pembayaran.'
            );
        }

        $payment = $order->payment;

        if (!$payment) {
            return back()->with(
                'error',
                'Data pembayaran untuk order ini belum tersedia.'
            );
        }

        if ($payment->status !== 'pending') {
            return back()->with(
                'error',
                'Pembayaran order ini sudah tidak berstatus pending.'
            );
        }

        DB::transaction(function () use ($order, $payment) {

            $transactionId = 'DEV-' .
                now()->format('YmdHis') .
                '-' .
                Str::upper(Str::random(6));

            $payment->update([
                'transaction_id' => $transactionId,
                'payment_type' => 'development',
                'status' => 'paid',
                'paid_at' => now(),
                'gateway_response' => [
                    'mode' => 'development',
                    'status' => 'paid',
                    'message' => 'Simulated development payment',
                    'transaction_id' => $transactionId,
                ],
            ]);

            $order->update([
                'status' => 'paid',
                'paid_at' => now(),
            ]);
        });

        return redirect()
            ->route('client.orders.show', $order)
            ->with(
                'success',
                'Pembayaran simulasi berhasil. Order sekarang siap dikerjakan freelancer.'
            );
    }
}