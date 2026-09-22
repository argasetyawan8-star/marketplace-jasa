<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\CancellationRequest;
use App\Models\Order;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CancellationController extends Controller
{
    /**
     * Status order yang masih dapat diajukan pembatalannya.
     */
    private const CANCELABLE_STATUSES = [
        'pending_payment',
        'paid',
        'in_progress',
        'revision',
    ];

    /**
     * Event notifikasi.
     */
    private const NOTIFICATION_CANCELLATION_APPROVED =
        'cancellation.approved_by_freelancer';

    private const NOTIFICATION_CANCELLATION_REJECTED =
        'cancellation.rejected_by_freelancer';

    /**
     * Menampilkan detail pengajuan pembatalan
     * yang perlu ditinjau freelancer.
     */
    public function create(Order $order): View
    {
        $freelancerProfile = Auth::user()->freelancerProfile;

        abort_unless(
            $freelancerProfile,
            403,
            'Profil freelancer tidak ditemukan.'
        );

        abort_unless(
            $order->freelancer_profile_id === $freelancerProfile->id,
            403,
            'Kamu tidak memiliki akses ke order ini.'
        );

        /*
        |--------------------------------------------------------------------------
        | Ambil pengajuan terbaru
        |--------------------------------------------------------------------------
        */
        $latestRequest = CancellationRequest::query()
            ->where('order_id', $order->id)
            ->latest('id')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Pengajuan yang masih menunggu keputusan freelancer
        |--------------------------------------------------------------------------
        */
        $pendingRequest = CancellationRequest::query()
            ->where('order_id', $order->id)
            ->where('status', 'pending_freelancer')
            ->latest('id')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Halaman ini tetap dapat dibuka untuk melihat hasil
        | pengajuan yang sudah diproses.
        |--------------------------------------------------------------------------
        */
        abort_unless(
            $pendingRequest ||
            (
                $latestRequest &&
                in_array(
                    $latestRequest->status,
                    [
                        'rejected_by_freelancer',
                        'mediation_pending',
                        'approved_by_freelancer',
                        'approved_by_admin',
                        'rejected_by_admin',
                    ],
                    true
                )
            ),
            404,
            'Pengajuan pembatalan tidak ditemukan.'
        );

        return view(
            'freelancer.orders.cancellation',
            compact(
                'order',
                'latestRequest',
                'pendingRequest'
            )
        );
    }

    /**
     * Freelancer menyetujui pembatalan.
     */
    public function approve(
        Request $request,
        Order $order
    ): RedirectResponse {
        $freelancerProfile = Auth::user()->freelancerProfile;

        abort_unless(
            $freelancerProfile,
            403,
            'Profil freelancer tidak ditemukan.'
        );

        abort_unless(
            $order->freelancer_profile_id === $freelancerProfile->id,
            403,
            'Kamu tidak memiliki akses ke order ini.'
        );

        $validated = $request->validate([
            'freelancer_note' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        DB::transaction(function () use (
            $order,
            $validated
        ) {
            /*
            |--------------------------------------------------------------------------
            | Kunci cancellation request agar tidak diproses dua kali
            |--------------------------------------------------------------------------
            */
            $cancellationRequest = CancellationRequest::query()
                ->where('order_id', $order->id)
                ->where('status', 'pending_freelancer')
                ->latest('id')
                ->lockForUpdate()
                ->first();

            abort_unless(
                $cancellationRequest,
                422,
                'Tidak ada pengajuan pembatalan yang sedang menunggu keputusan freelancer.'
            );

            /*
            |--------------------------------------------------------------------------
            | Kunci order
            |--------------------------------------------------------------------------
            */
            $lockedOrder = Order::query()
                ->with('payment')
                ->lockForUpdate()
                ->findOrFail($order->id);

            /*
            |--------------------------------------------------------------------------
            | Pastikan order masih dapat dibatalkan
            |--------------------------------------------------------------------------
            */
            abort_unless(
                in_array(
                    $lockedOrder->status,
                    self::CANCELABLE_STATUSES,
                    true
                ),
                422,
                'Order sudah tidak dapat dibatalkan.'
            );

            /*
            |--------------------------------------------------------------------------
            | Batalkan order
            |--------------------------------------------------------------------------
            */
            $lockedOrder->update([
                'status' => 'cancelled',
                'cancel_reason' => $cancellationRequest->reason,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Update payment
            |--------------------------------------------------------------------------
            */
            if ($lockedOrder->payment) {
                if ($lockedOrder->payment->status === 'pending') {
                    $lockedOrder->payment->update([
                        'status' => 'cancelled',
                    ]);
                } elseif ($lockedOrder->payment->status === 'paid') {
                    /*
                    | Refund aktual diproses pada modul Refund/Xendit
                    | di tahap payment final.
                    */
                    $lockedOrder->payment->update([
                        'status' => 'refund_pending',
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Update cancellation request
            |--------------------------------------------------------------------------
            */
            $cancellationRequest->update([
                'status' => 'approved_by_freelancer',
                'freelancer_note' => $validated['freelancer_note'] ?? null,
                'freelancer_reviewed_at' => now(),
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | Ambil data terbaru untuk notifikasi
        |--------------------------------------------------------------------------
        */
        $freshRequest = CancellationRequest::query()
            ->with([
                'order.client',
            ])
            ->findOrFail(
                CancellationRequest::query()
                    ->where('order_id', $order->id)
                    ->where('status', 'approved_by_freelancer')
                    ->latest('id')
                    ->value('id')
            );

        $freshOrder = $freshRequest->order;

        /*
        |--------------------------------------------------------------------------
        | Notifikasi ke Client
        |--------------------------------------------------------------------------
        */
        if ($freshOrder?->client) {
            app(NotificationService::class)->send(
                recipient: $freshOrder->client,
                event: self::NOTIFICATION_CANCELLATION_APPROVED,
                title: 'Pembatalan pesanan disetujui',
                message:
                    'Freelancer menyetujui pembatalan order ' .
                    ($freshOrder->order_number ?? '#' . $freshOrder->id) .
                    '. Order telah dibatalkan.',
                actionUrl: route(
                    'client.orders.show',
                    $freshOrder
                ),
                priority: 'action',
                actor: Auth::user(),
                relatedType: 'cancellation_request',
                relatedId: $freshRequest->id,
                extra: [
                    'order_id' => $freshOrder->id,
                    'order_number' => $freshOrder->order_number,
                    'cancellation_request_id' => $freshRequest->id,
                    'status' => $freshRequest->status,
                    'decision' => 'approved',
                ],
                dedupeKey:
                    'cancellation_freelancer_decision:client:' .
                    $freshRequest->id .
                    ':approved'
            );
        }

        return redirect()
            ->route(
                'freelancer.orders.show',
                $freshOrder
            )
            ->with(
                'success',
                'Pembatalan berhasil disetujui. Order telah dibatalkan.'
            );
    }

    /**
     * Freelancer menolak pembatalan.
     */
    public function reject(
        Request $request,
        Order $order
    ): RedirectResponse {
        $freelancerProfile = Auth::user()->freelancerProfile;

        abort_unless(
            $freelancerProfile,
            403,
            'Profil freelancer tidak ditemukan.'
        );

        abort_unless(
            $order->freelancer_profile_id === $freelancerProfile->id,
            403,
            'Kamu tidak memiliki akses ke order ini.'
        );

        $validated = $request->validate([
            'freelancer_note' => [
                'required',
                'string',
                'min:5',
                'max:2000',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Simpan penolakan
        |--------------------------------------------------------------------------
        */
        DB::transaction(function () use (
            $order,
            $validated
        ) {
            $cancellationRequest = CancellationRequest::query()
                ->where('order_id', $order->id)
                ->where('status', 'pending_freelancer')
                ->latest('id')
                ->lockForUpdate()
                ->first();

            abort_unless(
                $cancellationRequest,
                422,
                'Tidak ada pengajuan pembatalan yang sedang menunggu keputusan freelancer.'
            );

            /*
            |--------------------------------------------------------------------------
            | Pastikan order masih dalam status yang relevan
            |--------------------------------------------------------------------------
            */
            abort_unless(
                in_array(
                    $order->status,
                    self::CANCELABLE_STATUSES,
                    true
                ),
                422,
                'Order sudah tidak dapat diproses.'
            );

            $cancellationRequest->update([
                'status' => 'rejected_by_freelancer',
                'freelancer_note' => $validated['freelancer_note'],
                'freelancer_reviewed_at' => now(),
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | Ambil data terbaru
        |--------------------------------------------------------------------------
        */
        $freshRequest = CancellationRequest::query()
            ->with([
                'order.client',
            ])
            ->findOrFail(
                CancellationRequest::query()
                    ->where('order_id', $order->id)
                    ->where('status', 'rejected_by_freelancer')
                    ->latest('id')
                    ->value('id')
            );

        $freshOrder = $freshRequest->order;

        /*
        |--------------------------------------------------------------------------
        | Notifikasi ke Client
        |--------------------------------------------------------------------------
        */
        if ($freshOrder?->client) {
            app(NotificationService::class)->send(
                recipient: $freshOrder->client,
                event: self::NOTIFICATION_CANCELLATION_REJECTED,
                title: 'Pembatalan pesanan ditolak',
                message:
                    'Freelancer menolak pembatalan order ' .
                    ($freshOrder->order_number ?? '#' . $freshOrder->id) .
                    '. Kamu dapat meneruskan pengajuan melalui mediasi Admin.',
                actionUrl: route(
                    'client.orders.cancellation.create',
                    $freshOrder
                ),
                priority: 'info',
                actor: Auth::user(),
                relatedType: 'cancellation_request',
                relatedId: $freshRequest->id,
                extra: [
                    'order_id' => $freshOrder->id,
                    'order_number' => $freshOrder->order_number,
                    'cancellation_request_id' => $freshRequest->id,
                    'status' => $freshRequest->status,
                    'decision' => 'rejected',
                ],
                dedupeKey:
                    'cancellation_freelancer_decision:client:' .
                    $freshRequest->id .
                    ':rejected'
            );
        }

        return redirect()
            ->route(
                'freelancer.orders.show',
                $freshOrder
            )
            ->with(
                'success',
                'Pembatalan ditolak. Client dapat mengajukan mediasi Admin.'
            );
    }
}
