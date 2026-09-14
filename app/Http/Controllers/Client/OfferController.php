<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OfferController extends Controller
{
    public function accept(Offer $offer)
    {
        abort_unless(
            $offer->client_id === Auth::id(),
            403
        );

        if ($offer->status !== 'sent') {
            return back()->with(
                'error',
                'Penawaran ini sudah tidak dapat diproses.'
            );
        }

        if ($offer->expires_at && $offer->expires_at->isPast()) {
            $offer->update([
                'status' => 'expired',
            ]);

            return back()->with(
                'error',
                'Penawaran ini sudah kedaluwarsa.'
            );
        }

        $order = DB::transaction(function () use ($offer) {

            /*
            |--------------------------------------------------------------------------
            | Perhitungan
            |--------------------------------------------------------------------------
            |
            | 10% adalah asumsi sementara untuk project JASAIN.
            |
            */

            $platformFeeRate = 10;

            $subtotal = (float) $offer->price;

            $platformFee = round(
                $subtotal * ($platformFeeRate / 100),
                2
            );

            $total = $subtotal;

            $freelancerAmount = round(
                $subtotal - $platformFee,
                2
            );


            /*
            |--------------------------------------------------------------------------
            | Order
            |--------------------------------------------------------------------------
            */

            $order = Order::create([
                'order_number' =>
                    'ORD-' .
                    now()->format('YmdHis') .
                    '-' .
                    random_int(1000, 9999),

                'client_id' =>
                    $offer->client_id,

                'freelancer_profile_id' =>
                    $offer->freelancer_profile_id,

                'subtotal' =>
                    $subtotal,

                'platform_fee' =>
                    $platformFee,

                'total' =>
                    $total,

                'freelancer_amount' =>
                    $freelancerAmount,

                'status' =>
                    'pending_payment',

                'due_at' =>
                    now()->addDays($offer->delivery_days),

               'requirements' =>
                         $offer->description,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Order Item
            |--------------------------------------------------------------------------
            */

            OrderItem::create([
                'order_id' =>
                    $order->id,

                'service_id' =>
                    $offer->service_id,

                'service_title' =>
                    $offer->title,

                'quantity' =>
                    1,

                'unit_price' =>
                    $subtotal,

                'subtotal' =>
                    $subtotal,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Payment
            |--------------------------------------------------------------------------
            */

            Payment::create([
                'order_id' =>
                    $order->id,

                'payment_type' =>
                    'midtrans',

                'status' =>
                    'pending',

                'gross_amount' =>
                    $total,
            ]);


            /*
            |--------------------------------------------------------------------------
            | Update Offer
            |--------------------------------------------------------------------------
            */

            $offer->update([
                'status' =>
                    'accepted',

                'accepted_at' =>
                    now(),
            ]);


            return $order;
        });


        return redirect()
            ->route(
                'client.orders.checkout',
                $order
            )
            ->with(
                'success',
                'Penawaran diterima. Silakan lanjutkan pembayaran.'
            );
    }


    public function reject(Offer $offer)
    {
        abort_unless(
            $offer->client_id === Auth::id(),
            403
        );

        if ($offer->status !== 'sent') {
            return back()->with(
                'error',
                'Penawaran ini sudah tidak dapat diproses.'
            );
        }

        $offer->update([
            'status' =>
                'rejected',

            'rejected_at' =>
                now(),
        ]);

        return back()->with(
            'success',
            'Penawaran berhasil ditolak.'
        );
    }
}
