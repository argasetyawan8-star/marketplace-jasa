<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OfferController extends Controller
{
    public function accept(
        Offer $offer
    ): RedirectResponse {
        abort_unless(
            $offer->client_id === Auth::id(),
            403
        );

        abort_unless(
            $offer->status === 'sent',
            404
        );

        if (
            $offer->expires_at &&
            $offer->expires_at->isPast()
        ) {
            $offer->update([
                'status' => 'expired',
            ]);

            return back()->with(
                'error',
                'Quotation ini sudah kedaluwarsa.'
            );
        }

        $offer->load([
            'conversation',
            'job',
            'jobProposal',
            'service',
            'freelancerProfile',
        ]);

        $order = DB::transaction(function () use ($offer) {
            /*
            |--------------------------------------------------------------------------
            | Platform fee
            |--------------------------------------------------------------------------
            |
            | Untuk sekarang kita gunakan 10%.
            | Nanti bisa dipindahkan ke setting admin.
            |
            */

            $subtotal = (float) $offer->price;

            $platformFeeRate = 10;

            $platformFee = round(
                $subtotal * ($platformFeeRate / 100),
                2
            );

            $total = $subtotal;

            $freelancerAmount = max(
                0,
                $total - $platformFee
            );

            $order = Order::create([
                'client_id' => $offer->client_id,
                'freelancer_profile_id' =>
                    $offer->freelancer_profile_id,
                'conversation_id' =>
                    $offer->conversation_id,
                'order_number' =>
                    $this->generateOrderNumber(),
                'status' => 'pending_payment',
                'subtotal' => $subtotal,
                'platform_fee' => $platformFee,
                'total' => $total,
                'freelancer_amount' =>
                    $freelancerAmount,
                'requirements' =>
                    $offer->description,
                'delivery_days' =>
                    $offer->delivery_days,
                'due_at' => now()->addDays(
                    $offer->delivery_days
                ),
            ]);

            OrderItem::create([
                'order_id' => $order->id,

                /*
                |--------------------------------------------------------------------------
                | Job Board
                |--------------------------------------------------------------------------
                |
                | Karena Job Board tidak harus berasal dari service,
                | service_id sengaja dibuat NULL.
                |
                */

                'service_id' => null,

                'service_title' =>
                    $offer->title,

                'quantity' => 1,

                'unit_price' => $subtotal,

                'subtotal' => $subtotal,

                'delivery_days' =>
                    $offer->delivery_days,

                'requirements' =>
                    $offer->description,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Offer
            |--------------------------------------------------------------------------
            */

            $offer->update([
                'status' => 'accepted',
                'accepted_at' => now(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | Proposal
            |--------------------------------------------------------------------------
            */

            if ($offer->jobProposal) {
                $offer->jobProposal->update([
                    'status' => 'accepted',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Job
            |--------------------------------------------------------------------------
            |
            | Setelah quotation diterima, Job tidak boleh lagi
            | menerima proposal baru.
            |
            | Status tetap in_review sampai pembayaran berhasil.
            |
            */

            if ($offer->job) {
                $offer->job->update([
                    'status' => 'in_review',
                ]);

                $offer->job
                    ->proposals()
                    ->where('id', '!=', $offer->jobProposal?->id)
                    ->where('status', 'pending')
                    ->update([
                        'status' => 'rejected',
                    ]);
            }

            return $order;
        });

        /*
        |--------------------------------------------------------------------------
        | Redirect ke checkout
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'client.orders.checkout',
                $order
            )
            ->with(
                'success',
                'Quotation diterima. Order berhasil dibuat, silakan lanjut ke pembayaran.'
            );
    }

    public function reject(
        Offer $offer
    ): RedirectResponse {
        abort_unless(
            $offer->client_id === Auth::id(),
            403
        );

        abort_unless(
            $offer->status === 'sent',
            404
        );

        $offer->update([
            'status' => 'rejected',
            'rejected_at' => now(),
        ]);

        return back()->with(
            'success',
            'Quotation berhasil ditolak.'
        );
    }

    private function generateOrderNumber(): string
    {
        do {
            $number =
                'JASAIN-' .
                now()->format('Ymd') .
                '-' .
                strtoupper(
                    Str::random(8)
                );

            $exists = Order::query()
                ->where(
                    'order_number',
                    $number
                )
                ->exists();

        } while ($exists);

        return $number;
    }
}