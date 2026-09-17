<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Message;
use App\Models\Order;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeliveryController extends Controller
{
    /**
     * Menampilkan delivery terbaru dari sebuah order.
     */
    public function show(Order $order)
    {
        abort_unless(
            $order->client_id === Auth::id(),
            403
        );

        $order->load([
            'client',
            'freelancerProfile.user',
            'items.service',
            'deliveries' => fn ($query) => $query->latest(),
        ]);

        $delivery = $order->deliveries->first();

        return view(
            'client.orders.delivery',
            compact(
                'order',
                'delivery'
            )
        );
    }

    /**
     * Client menyetujui hasil pekerjaan.
     *
     * Alur:
     *
     * Delivery submitted
     *      ↓
     * Delivery approved
     *      ↓
     * Order completed
     *      ↓
     * Commission dibuat
     *      ↓
     * Wallet freelancer bertambah
     *      ↓
     * WalletTransaction tercatat
     */
    public function approve(Order $order)
    {
        abort_unless(
            $order->client_id === Auth::id(),
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Semua proses approval dilakukan dalam transaction
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use ($order) {

            /*
            |--------------------------------------------------------------------------
            | Kunci order supaya tidak diproses dua kali bersamaan
            |--------------------------------------------------------------------------
            */

            $order = Order::query()
                ->whereKey($order->id)
                ->lockForUpdate()
                ->firstOrFail();

            /*
            |--------------------------------------------------------------------------
            | Order harus dalam status delivered
            |--------------------------------------------------------------------------
            */

            if ($order->status !== 'delivered') {
                abort(
                    redirect()
                        ->back()
                        ->with(
                            'error',
                            'Order ini belum dapat disetujui.'
                        )
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Ambil delivery terbaru
            |--------------------------------------------------------------------------
            */

            $delivery = $order->deliveries()
                ->latest()
                ->lockForUpdate()
                ->first();

            if (!$delivery) {
                abort(
                    redirect()
                        ->back()
                        ->with(
                            'error',
                            'Belum ada hasil pekerjaan yang dikirim freelancer.'
                        )
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Delivery harus masih submitted
            |--------------------------------------------------------------------------
            */

            if ($delivery->status !== 'submitted') {
                abort(
                    redirect()
                        ->back()
                        ->with(
                            'error',
                            'Delivery ini sudah tidak dapat diproses.'
                        )
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Approve delivery
            |--------------------------------------------------------------------------
            */

            $delivery->update([
                'status' => 'approved',
            ]);

            /*
            |--------------------------------------------------------------------------
            | Selesaikan order
            |--------------------------------------------------------------------------
            */

            $order->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | Commission
            |--------------------------------------------------------------------------
            |
            | Order sudah memiliki:
            |
            | subtotal
            | platform_fee
            | total
            | freelancer_amount
            |
            | Jadi kita gunakan angka yang sudah tersimpan di order.
            |
            */

            $commission = Commission::query()
                ->where(
                    'order_id',
                    $order->id
                )
                ->lockForUpdate()
                ->first();

            /*
            |--------------------------------------------------------------------------
            | Buat commission hanya sekali
            |--------------------------------------------------------------------------
            */

            if (!$commission) {

                $orderTotal = (float) $order->total;

                /*
                | Jika platform_fee sudah tersimpan di Order,
                | gunakan nilai tersebut.
                */
                $commissionAmount =
                    (float) $order->platform_fee;

                /*
                | Freelancer amount berasal dari Order.
                */
                $freelancerAmount =
                    (float) $order->freelancer_amount;

                /*
                | Hitung kembali rate untuk pencatatan.
                */
                $commissionRate =
                    $orderTotal > 0
                        ? round(
                            ($commissionAmount / $orderTotal) * 100,
                            2
                        )
                        : 0;

                $commission = Commission::create([
                    'order_id' =>
                        $order->id,

                    'freelancer_profile_id' =>
                        $order->freelancer_profile_id,

                    'order_total' =>
                        $orderTotal,

                    'commission_rate' =>
                        $commissionRate,

                    'commission_amount' =>
                        $commissionAmount,

                    'freelancer_amount' =>
                        $freelancerAmount,

                    'status' =>
                        'earned',

                    'earned_at' =>
                        now(),

                    'paid_at' =>
                        null,
                ]);

                /*
                |--------------------------------------------------------------------------
                | Wallet Freelancer
                |--------------------------------------------------------------------------
                */

                $wallet = Wallet::query()
                    ->where(
                        'freelancer_profile_id',
                        $order->freelancer_profile_id
                    )
                    ->lockForUpdate()
                    ->first();

                /*
                |--------------------------------------------------------------------------
                | Buat wallet jika belum tersedia
                |--------------------------------------------------------------------------
                */

                if (!$wallet) {
                    $wallet = Wallet::create([
                        'freelancer_profile_id' =>
                            $order->freelancer_profile_id,

                        'balance' =>
                            0,

                        'pending_balance' =>
                            0,

                        'total_earned' =>
                            0,

                        'total_withdrawn' =>
                            0,
                    ]);
                } else {
                    /*
                    | Refresh object agar nilai terbaru digunakan.
                    */
                    $wallet->refresh();

                    $wallet->lockForUpdate();
                }

                /*
                |--------------------------------------------------------------------------
                | Tambahkan penghasilan ke wallet
                |--------------------------------------------------------------------------
                */

                $newBalance =
                    (float) $wallet->balance
                    + $commission->freelancer_amount;

                $newTotalEarned =
                    (float) $wallet->total_earned
                    + $commission->freelancer_amount;

                $wallet->update([
                    'balance' =>
                        $newBalance,

                    'total_earned' =>
                        $newTotalEarned,
                ]);

                /*
                |--------------------------------------------------------------------------
                | Catat transaksi wallet
                |--------------------------------------------------------------------------
                */

                WalletTransaction::create([
                    'wallet_id' =>
                        $wallet->id,

                    'type' =>
                        'credit',

                    'category' =>
                        'earning',

                    'amount' =>
                        $commission->freelancer_amount,

                    'balance_after' =>
                        $newBalance,

                    'description' =>
                        'Penghasilan dari Order ' .
                        $order->order_number,

                    'reference_type' =>
                        'Order',

                    'reference_id' =>
                        $order->id,
                ]);
            }
        });

        /*
        |--------------------------------------------------------------------------
        | Message system
        |--------------------------------------------------------------------------
        */

        $order->loadMissing('conversation');

        if ($order->conversation_id) {

            Message::create([
                'conversation_id' =>
                    $order->conversation_id,

                'sender_id' =>
                    Auth::id(),

                'message' =>
                    'Hasil pekerjaan telah disetujui oleh client. ' .
                    'Order ' .
                    $order->order_number .
                    ' telah selesai.',

                'type' =>
                    'text',

                'is_read' =>
                    false,
            ]);

            $order->conversation?->update([
                'last_message_at' =>
                    now(),
            ]);
        }

        return redirect()
            ->route(
                'client.orders.show',
                $order
            )
            ->with(
                'success',
                'Hasil pekerjaan berhasil disetujui. Order telah selesai dan penghasilan freelancer sudah masuk ke wallet.'
            );
    }

    /**
     * Client meminta revisi.
     */
    public function revision(
        Request $request,
        Order $order
    ) {
        abort_unless(
            $order->client_id === Auth::id(),
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Validate
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate(
            [
                'revision_note' => [
                    'required',
                    'string',
                    'min:10',
                    'max:2000',
                ],
            ],
            [
                'revision_note.required' =>
                    'Jelaskan bagian yang perlu direvisi.',

                'revision_note.min' =>
                    'Catatan revisi minimal 10 karakter.',

                'revision_note.max' =>
                    'Catatan revisi maksimal 2000 karakter.',
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Status harus delivered
        |--------------------------------------------------------------------------
        */

        if ($order->status !== 'delivered') {
            return back()->with(
                'error',
                'Order ini belum dapat meminta revisi.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Delivery terbaru
        |--------------------------------------------------------------------------
        */

        $delivery = $order->deliveries()
            ->latest()
            ->first();

        if (!$delivery) {
            return back()->with(
                'error',
                'Belum ada hasil pekerjaan yang dikirim freelancer.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Delivery harus submitted
        |--------------------------------------------------------------------------
        */

        if ($delivery->status !== 'submitted') {
            return back()->with(
                'error',
                'Delivery ini sudah tidak dapat direvisi.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Update revision
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $delivery,
            $order,
            $validated
        ) {

            $revisionMessage =
                "PERMINTAAN REVISI CLIENT:\n\n" .
                $validated['revision_note'];

            $delivery->update([
                'status' =>
                    'revision',

                'message' =>
                    $revisionMessage,
            ]);

            $order->update([
                'status' =>
                    'revision',
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | Message system
        |--------------------------------------------------------------------------
        */

        $order->loadMissing('conversation');

        if ($order->conversation_id) {

            Message::create([
                'conversation_id' =>
                    $order->conversation_id,

                'sender_id' =>
                    Auth::id(),

                'message' =>
                    "Client meminta revisi untuk Order " .
                    $order->order_number .
                    ".\n\n" .
                    $validated['revision_note'],

                'type' =>
                    'text',

                'is_read' =>
                    false,
            ]);

            $order->conversation?->update([
                'last_message_at' =>
                    now(),
            ]);
        }

        return back()->with(
            'success',
            'Permintaan revisi berhasil dikirim ke freelancer.'
        );
    }
}
