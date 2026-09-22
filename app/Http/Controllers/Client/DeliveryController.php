<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Commission;
use App\Models\Message;
use App\Models\Order;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Services\NotificationService;
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
     *      ↓
     * Notification client + freelancer
     *      ↓
     * Review window terbuka
     */
    public function approve(Order $order)
    {
        abort_unless(
            $order->client_id === Auth::id(),
            403
        );

        /**
         * --------------------------------------------------------------------------
         * Semua proses approval dilakukan dalam transaction
         * --------------------------------------------------------------------------
         */
        DB::transaction(function () use ($order) {
            /**
             * ----------------------------------------------------------------------
             * Kunci order supaya tidak diproses dua kali bersamaan
             * ----------------------------------------------------------------------
             */
            $order = Order::query()
                ->whereKey($order->id)
                ->lockForUpdate()
                ->firstOrFail();

            /**
             * ----------------------------------------------------------------------
             * Order harus dalam status delivered
             * ----------------------------------------------------------------------
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

            /**
             * ----------------------------------------------------------------------
             * Ambil delivery terbaru
             * ----------------------------------------------------------------------
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

            /**
             * ----------------------------------------------------------------------
             * Delivery harus masih submitted
             * ----------------------------------------------------------------------
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

            /**
             * ----------------------------------------------------------------------
             * Approve delivery
             * ----------------------------------------------------------------------
             */
            $delivery->update([
                'status' => 'approved',
            ]);

            /**
             * ----------------------------------------------------------------------
             * Selesaikan order
             * ----------------------------------------------------------------------
             */
            $order->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            /**
             * ----------------------------------------------------------------------
             * Commission
             * ----------------------------------------------------------------------
             *
             * Order sudah memiliki:
             *
             * subtotal
             * platform_fee
             * total
             * freelancer_amount
             *
             * Jadi kita gunakan angka yang sudah tersimpan di order.
             */
            $commission = Commission::query()
                ->where(
                    'order_id',
                    $order->id
                )
                ->lockForUpdate()
                ->first();

            /**
             * ----------------------------------------------------------------------
             * Buat commission hanya sekali
             * ----------------------------------------------------------------------
             */
            if (!$commission) {
                $orderTotal = (float) $order->total;

                $commissionAmount = (float) $order->platform_fee;

                $freelancerAmount = (float) $order->freelancer_amount;

                $commissionRate = $orderTotal > 0
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

                /**
                 * ------------------------------------------------------------------
                 * Wallet Freelancer
                 * ------------------------------------------------------------------
                 */
                $wallet = Wallet::query()
                    ->where(
                        'freelancer_profile_id',
                        $order->freelancer_profile_id
                    )
                    ->lockForUpdate()
                    ->first();

                /**
                 * ------------------------------------------------------------------
                 * Buat wallet jika belum tersedia
                 * ------------------------------------------------------------------
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
                }

                /**
                 * ------------------------------------------------------------------
                 * Tambahkan penghasilan ke wallet
                 * ------------------------------------------------------------------
                 */
                $newBalance =
                    (float) $wallet->balance
                    + (float) $commission->freelancer_amount;

                $newTotalEarned =
                    (float) $wallet->total_earned
                    + (float) $commission->freelancer_amount;

                $wallet->update([
                    'balance' =>
                        $newBalance,

                    'total_earned' =>
                        $newTotalEarned,
                ]);

                /**
                 * ------------------------------------------------------------------
                 * Catat transaksi wallet
                 * ------------------------------------------------------------------
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

        /**
         * --------------------------------------------------------------------------
         * Ambil data terbaru setelah transaction selesai
         * --------------------------------------------------------------------------
         *
         * Jangan menggunakan object order lama karena status di dalam
         * transaction sudah diperbarui.
         */
        $freshOrder = Order::query()
            ->with([
                'client',
                'freelancerProfile.user',
                'conversation',
            ])
            ->findOrFail(
                $order->id
            );

        /**
         * --------------------------------------------------------------------------
         * Ambil commission terbaru
         * --------------------------------------------------------------------------
         */
        $commission = Commission::query()
            ->where(
                'order_id',
                $freshOrder->id
            )
            ->first();

        /**
         * --------------------------------------------------------------------------
         * Notification: Client - Order selesai
         * --------------------------------------------------------------------------
         */
        if ($freshOrder->client) {
            app(NotificationService::class)->send(
                recipient: $freshOrder->client,

                event: NotificationService::ORDER_COMPLETED,

                title: 'Order selesai',

                message:
                    'Order ' .
                    $freshOrder->order_number .
                    ' telah selesai setelah hasil pekerjaan disetujui.',

                actionUrl: route(
                    'client.orders.show',
                    $freshOrder
                ),

                priority: NotificationService::PRIORITY_INFO,

                actor: Auth::user(),

                relatedType: 'order',

                relatedId: $freshOrder->id,

                extra: [
                    'order_id' =>
                        $freshOrder->id,

                    'order_number' =>
                        $freshOrder->order_number,

                    'order_status' =>
                        $freshOrder->status,
                ],

                dedupeKey:
                    'order_completed:client:' .
                    $freshOrder->id
            );

            /**
             * ----------------------------------------------------------------------
             * Notification: Client - Review window terbuka
             * ----------------------------------------------------------------------
             *
             * Review baru tersedia setelah order benar-benar completed.
             */
            app(NotificationService::class)->send(
                recipient: $freshOrder->client,

                event: NotificationService::REVIEW_WINDOW_OPEN,

                title: 'Berikan review untuk jasa ini',

                message:
                    'Order ' .
                    $freshOrder->order_number .
                    ' sudah selesai. Sekarang kamu dapat memberikan rating dan review untuk jasa freelancer.',

                actionUrl: route(
                    'client.orders.show',
                    $freshOrder
                ),

                priority: NotificationService::PRIORITY_ACTION,

                actor: Auth::user(),

                relatedType: 'order',

                relatedId: $freshOrder->id,

                extra: [
                    'order_id' =>
                        $freshOrder->id,

                    'order_number' =>
                        $freshOrder->order_number,

                    'order_status' =>
                        $freshOrder->status,

                    'review_available' =>
                        true,
                ],

                dedupeKey:
                    'review_window_open:client:' .
                    $freshOrder->id
            );

        /**
         * --------------------------------------------------------------------------
         * Notification: Client - Invoice tersedia
         * --------------------------------------------------------------------------
         */
        app(NotificationService::class)->send(
            recipient: $freshOrder->client,

            event: NotificationService::INVOICE_AVAILABLE,

            title: 'Invoice tersedia',

            message:
                'Invoice INV-' .
                $freshOrder->order_number .
                ' sudah tersedia. Kamu dapat melihat detail transaksi order ini.',

            actionUrl: route(
                'client.orders.show',
                $freshOrder
            ),

            priority: NotificationService::PRIORITY_INFO,

            actor: Auth::user(),

            relatedType: 'order',

            relatedId: $freshOrder->id,

            extra: [
                'order_id' =>
                    $freshOrder->id,

                'order_number' =>
                    $freshOrder->order_number,

                'invoice_number' =>
                    'INV-' . $freshOrder->order_number,

                'order_status' =>
                    $freshOrder->status,
            ],

            dedupeKey:
                'invoice_available:client:' .
                $freshOrder->id
        );
                }

        /**
         * --------------------------------------------------------------------------
         * Notification: Freelancer - Order selesai
         * --------------------------------------------------------------------------
         */
        $freelancerUser =
            $freshOrder->freelancerProfile?->user;

        if ($freelancerUser) {
            app(NotificationService::class)->send(
                recipient: $freelancerUser,

                event: NotificationService::ORDER_COMPLETED,

                title: 'Order selesai',

                message:
                    'Order ' .
                    $freshOrder->order_number .
                    ' telah selesai dan hasil pekerjaanmu telah disetujui client.',

                actionUrl: route(
                    'freelancer.orders.show',
                    $freshOrder
                ),

                priority: NotificationService::PRIORITY_INFO,

                actor: Auth::user(),

                relatedType: 'order',

                relatedId: $freshOrder->id,

                extra: [
                    'order_id' =>
                        $freshOrder->id,

                    'order_number' =>
                        $freshOrder->order_number,

                    'order_status' =>
                        $freshOrder->status,
                ],

                dedupeKey:
                    'order_completed:freelancer:' .
                    $freshOrder->id
            );

            /**
             * ----------------------------------------------------------------------
             * Notification: Freelancer - Wallet bertambah
             * ----------------------------------------------------------------------
             */
            if ($commission) {
                $wallet = Wallet::query()
                    ->where(
                        'freelancer_profile_id',
                        $freshOrder->freelancer_profile_id
                    )
                    ->first();

                if ($wallet) {
                    app(NotificationService::class)->send(
                        recipient: $freelancerUser,

                        event: NotificationService::WALLET_CREDITED,

                        title: 'Pendapatan masuk ke wallet',

                        message:
                            'Pendapatan sebesar Rp' .
                            number_format(
                                (float) $commission->freelancer_amount,
                                0,
                                ',',
                                '.'
                            ) .
                            ' dari Order ' .
                            $freshOrder->order_number .
                            ' telah masuk ke wallet.',

                        actionUrl: route(
                            'freelancer.wallet.index'
                        ),

                        priority:
                            NotificationService::PRIORITY_CRITICAL,

                        actor: Auth::user(),

                        relatedType: 'wallet',

                        relatedId: $wallet->id,

                        extra: [
                            'order_id' =>
                                $freshOrder->id,

                            'order_number' =>
                                $freshOrder->order_number,

                            'wallet_id' =>
                                $wallet->id,

                            'amount' =>
                                (float) $commission->freelancer_amount,

                            'balance' =>
                                (float) $wallet->balance,
                        ],

                        dedupeKey:
                            'wallet_credited:order:' .
                            $freshOrder->id
                    );
                }

                /**
                 * ------------------------------------------------------------------
                 * Notification: Freelancer - Commission
                 * ------------------------------------------------------------------
                 */
                app(NotificationService::class)->send(
                    recipient: $freelancerUser,

                    event: NotificationService::COMMISSION_DEDUCTED,

                    title: 'Komisi platform tercatat',

                    message:
                        'Komisi platform sebesar Rp' .
                        number_format(
                            (float) $commission->commission_amount,
                            0,
                            ',',
                            '.'
                        ) .
                        ' telah diperhitungkan dari Order ' .
                        $freshOrder->order_number .
                        '.',

                    actionUrl: route(
                        'freelancer.wallet.index'
                    ),

                    priority:
                        NotificationService::PRIORITY_INFO,

                    actor: Auth::user(),

                    relatedType: 'commission',

                    relatedId: $commission->id,

                    extra: [
                        'order_id' =>
                            $freshOrder->id,

                        'order_number' =>
                            $freshOrder->order_number,

                        'commission_id' =>
                            $commission->id,

                        'commission_amount' =>
                            (float) $commission->commission_amount,

                        'freelancer_amount' =>
                            (float) $commission->freelancer_amount,
                    ],

                    dedupeKey:
                        'commission_deducted:order:' .
                        $freshOrder->id
                );
            }
        }

        /**
         * --------------------------------------------------------------------------
         * Message system
         * --------------------------------------------------------------------------
         */
        if ($freshOrder->conversation_id) {
            Message::create([
                'conversation_id' =>
                    $freshOrder->conversation_id,

                'sender_id' =>
                    Auth::id(),

                'message' =>
                    'Hasil pekerjaan telah disetujui oleh client. ' .
                    'Order ' .
                    $freshOrder->order_number .
                    ' telah selesai.',

                'type' =>
                    'text',

                'is_read' =>
                    false,
            ]);

            $freshOrder->conversation?->update([
                'last_message_at' =>
                    now(),
            ]);
        }

        return redirect()
            ->route(
                'client.orders.show',
                $freshOrder
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

        /**
         * --------------------------------------------------------------------------
         * Validate
         * --------------------------------------------------------------------------
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

        /**
         * --------------------------------------------------------------------------
         * Status harus delivered
         * --------------------------------------------------------------------------
         */
        if ($order->status !== 'delivered') {
            return back()->with(
                'error',
                'Order ini belum dapat meminta revisi.'
            );
        }

        /**
         * --------------------------------------------------------------------------
         * Delivery terbaru
         * --------------------------------------------------------------------------
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

        /**
         * --------------------------------------------------------------------------
         * Delivery harus submitted
         * --------------------------------------------------------------------------
         */
        if ($delivery->status !== 'submitted') {
            return back()->with(
                'error',
                'Delivery ini sudah tidak dapat direvisi.'
            );
        }

        /**
         * --------------------------------------------------------------------------
         * Update revision
         * --------------------------------------------------------------------------
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

        /**
         * --------------------------------------------------------------------------
         * Message system
         * --------------------------------------------------------------------------
         */
        $order->loadMissing([
            'conversation',
            'freelancerProfile.user',
        ]);

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

        /**
         * --------------------------------------------------------------------------
         * Notification: Freelancer - Revision requested
         * --------------------------------------------------------------------------
         */
        $freelancerUser =
            $order->freelancerProfile?->user;

        if ($freelancerUser) {
            app(NotificationService::class)->send(
                recipient: $freelancerUser,

                event: NotificationService::REVISION_REQUESTED,

                title: 'Permintaan revisi baru',

                message:
                    'Client meminta revisi untuk Order ' .
                    $order->order_number .
                    '. Silakan periksa catatan revisi dan kirim hasil terbaru.',

                actionUrl: route(
                    'freelancer.orders.show',
                    $order
                ),

                priority:
                    NotificationService::PRIORITY_ACTION,

                actor: Auth::user(),

                relatedType: 'order',

                relatedId: $order->id,

                extra: [
                    'order_id' =>
                        $order->id,

                    'order_number' =>
                        $order->order_number,

                    'delivery_id' =>
                        $delivery->id,

                    'revision_note' =>
                        $validated['revision_note'],
                ],

                dedupeKey:
                    'revision_requested:' .
                    $delivery->id .
                    ':' .
                    sha1(
                        $validated['revision_note']
                    )
            );
        }

        return back()->with(
            'success',
            'Permintaan revisi berhasil dikirim ke freelancer.'
        );
    }
}
