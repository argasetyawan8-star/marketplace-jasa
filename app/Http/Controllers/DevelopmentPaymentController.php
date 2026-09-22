<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\NotificationService;
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

        /*
        |--------------------------------------------------------------------------
        | Simpan pembayaran + ubah status order
        |--------------------------------------------------------------------------
        */
        DB::transaction(function () use ($order, $payment) {
            $transactionId =
                'DEV-' .
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

        /*
        |--------------------------------------------------------------------------
        | Load recipient notification
        |--------------------------------------------------------------------------
        */
        $order->loadMissing([
            'client',
            'freelancerProfile.user',
            'items.service',
        ]);

        $client = $order->client;

        $freelancer =
            $order->freelancerProfile?->user;

        $serviceTitle =
            $order->items->first()?->service_title
            ?? 'Jasa JASAIN';

        /*
        |--------------------------------------------------------------------------
        | Notification: Client
        |--------------------------------------------------------------------------
        */
        if ($client) {
            app(NotificationService::class)->send(
                recipient: $client,
                event: 'payment.success',
                title: 'Pembayaran berhasil',
                message:
                    'Pembayaran untuk order "' .
                    $order->order_number .
                    '" berhasil. Order sekarang diproses dan siap dikerjakan freelancer.',
                actionUrl: route(
                    'client.orders.show',
                    $order
                ),
                priority: 'normal',
                actor: $client,
                relatedType: 'order',
                relatedId: $order->id,
                extra: [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'payment_id' => $payment->id,
                    'transaction_id' => $payment->transaction_id,
                    'payment_type' => $payment->payment_type,
                    'amount' => $order->total,
                    'service_title' => $serviceTitle,
                ],
                dedupeKey:
                    'payment_success_client:' .
                    $payment->id
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Notification: Freelancer
        |--------------------------------------------------------------------------
        */
        if ($freelancer) {
            app(NotificationService::class)->send(
                recipient: $freelancer,
                event: 'payment.success',
                title: 'Pembayaran order diterima',
                message:
                    'Pembayaran order "' .
                    $order->order_number .
                    '" dari client sudah berhasil. Order siap dikerjakan.',
                actionUrl: route(
                    'freelancer.orders.show',
                    $order
                ),
                priority: 'action',
                actor: $client,
                relatedType: 'order',
                relatedId: $order->id,
                extra: [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'payment_id' => $payment->id,
                    'transaction_id' => $payment->transaction_id,
                    'payment_type' => $payment->payment_type,
                    'amount' => $order->total,
                    'service_title' => $serviceTitle,
                ],
                dedupeKey:
                    'payment_success_freelancer:' .
                    $payment->id
            );
        }

        return redirect()
            ->route(
                'client.orders.show',
                $order
            )
            ->with(
                'success',
                'Pembayaran simulasi berhasil. Order sekarang siap dikerjakan freelancer.'
            );
    }
}