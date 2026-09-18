<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OfferController extends Controller
{
    public function accept(
        Offer $offer
    ): RedirectResponse {
        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $offer->client_id === Auth::id(),
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Offer harus masih terkirim
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $offer->status === 'sent',
            404
        );

        /*
        |--------------------------------------------------------------------------
        | Cek expiration
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | Load relasi
        |--------------------------------------------------------------------------
        */

        $offer->load([
            'conversation',
            'job',
            'jobProposal',
            'service',
            'freelancerProfile',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Buat Order + Payment
        |--------------------------------------------------------------------------
        */

        $order = DB::transaction(function () use ($offer) {

            /*
            |--------------------------------------------------------------------------
            | Platform fee
            |--------------------------------------------------------------------------
            |
            | Untuk sekarang 10%.
            | Nanti bisa dipindahkan ke pengaturan admin.
            |
            */

            $subtotal = (float) $offer->price;

            $platformFeeRate = 10;

            $platformFee = round(
                $subtotal * (
                    $platformFeeRate / 100
                ),
                2
            );

            /*
            |--------------------------------------------------------------------------
            | Total yang dibayar client
            |--------------------------------------------------------------------------
            |
            | Saat ini biaya platform sudah termasuk
            | di dalam nilai transaksi.
            |
            */

            $total = $subtotal;

            /*
            |--------------------------------------------------------------------------
            | Penghasilan freelancer
            |--------------------------------------------------------------------------
            */

            $freelancerAmount = max(
                0,
                $total - $platformFee
            );

            /*
            |--------------------------------------------------------------------------
            | Create Order
            |--------------------------------------------------------------------------
            */

            $order = Order::create([
                'client_id' =>
                    $offer->client_id,

                'freelancer_profile_id' =>
                    $offer->freelancer_profile_id,

                'conversation_id' =>
                    $offer->conversation_id,

                'order_number' =>
                    $this->generateOrderNumber(),

                'status' =>
                    'pending_payment',

                'subtotal' =>
                    $subtotal,

                'platform_fee' =>
                    $platformFee,

                'total' =>
                    $total,

                'freelancer_amount' =>
                    $freelancerAmount,

                'requirements' =>
                    $offer->description,

                'delivery_days' =>
                    $offer->delivery_days,

                'due_at' =>
                    now()->addDays(
                        $offer->delivery_days
                    ),
            ]);

            /*
            |--------------------------------------------------------------------------
            | Create Payment
            |--------------------------------------------------------------------------
            |
            | Ini bagian yang sebelumnya belum ada.
            |
            | Untuk development kita memakai payment_type
            | "development". Nanti pada tahap akhir akan
            | diganti/dihubungkan dengan Xendit.
            |
            */

            Payment::create([
                'order_id' =>
                    $order->id,

                'transaction_id' =>
                    null,

                'payment_type' =>
                    'development',

                'status' =>
                    'pending',

                'gross_amount' =>
                    $total,

                'paid_at' =>
                    null,

                'gateway_response' =>
                    null,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Create Order Item
            |--------------------------------------------------------------------------
            */

            OrderItem::create([
                'order_id' =>
                    $order->id,

                /*
                |--------------------------------------------------------------------------
                | Job Board tidak wajib memiliki service
                |--------------------------------------------------------------------------
                */

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

                'delivery_days' =>
                    $offer->delivery_days,

                'requirements' =>
                    $offer->description,
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

            /*
            |--------------------------------------------------------------------------
            | Update Proposal Job Board
            |--------------------------------------------------------------------------
            */

            if ($offer->jobProposal) {

                $offer->jobProposal->update([
                    'status' =>
                        'accepted',
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Update Job Board
            |--------------------------------------------------------------------------
            |
            | Setelah quotation diterima,
            | Job tidak menerima proposal baru.
            |
            */

            if ($offer->job) {

                $offer->job->update([
                    'status' =>
                        'in_review',
                ]);

                $offer->job
                    ->proposals()
                    ->where(
                        'id',
                        '!=',
                        $offer->jobProposal?->id
                    )
                    ->where(
                        'status',
                        'pending'
                    )
                    ->update([
                        'status' =>
                            'rejected',
                    ]);
            }

            return $order;
        });

        /*
        |--------------------------------------------------------------------------
        | Redirect Checkout
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
        /*
        |--------------------------------------------------------------------------
        | Authorization
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $offer->client_id === Auth::id(),
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Offer harus masih terkirim
        |--------------------------------------------------------------------------
        */

        abort_unless(
            $offer->status === 'sent',
            404
        );

        /*
        |--------------------------------------------------------------------------
        | Reject
        |--------------------------------------------------------------------------
        */

        $offer->update([
            'status' =>
                'rejected',

            'rejected_at' =>
                now(),
        ]);

        return back()->with(
            'success',
            'Quotation berhasil ditolak.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Generate Order Number
    |--------------------------------------------------------------------------
    */

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