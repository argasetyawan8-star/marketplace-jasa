<?php

namespace App\Http\Controllers\Admin;

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
     * Status order yang masih dapat dibatalkan.
     */
    private const CANCELABLE_STATUSES = [
        'pending_payment',
        'paid',
        'in_progress',
        'revision',
    ];

    /**
     * Event notifikasi cancellation.
     */
    private const NOTIFICATION_CANCELLATION_MEDIATION_APPROVED =
        'cancellation.mediation_approved';

    private const NOTIFICATION_CANCELLATION_MEDIATION_REJECTED =
        'cancellation.mediation_rejected';

    /**
     * Daftar pengajuan cancellation.
     */
    public function index(Request $request): View
    {
        $query = CancellationRequest::query()
            ->with([
                'order.client',
                'order.freelancerProfile.user',
                'requester',
                'reviewer',
            ])
            ->latest();

        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->string('status')
            );
        }

        if ($request->filled('search')) {
            $search = $request->string('search');

            $query->where(function ($query) use ($search) {
                $query
                    ->where(
                        'reason',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'mediation_reason',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhereHas(
                        'order',
                        function ($orderQuery) use ($search) {
                            $orderQuery->where(
                                'order_number',
                                'like',
                                '%' . $search . '%'
                            );
                        }
                    )
                    ->orWhereHas(
                        'requester',
                        function ($userQuery) use ($search) {
                            $userQuery
                                ->where(
                                    'name',
                                    'like',
                                    '%' . $search . '%'
                                )
                                ->orWhere(
                                    'email',
                                    'like',
                                    '%' . $search . '%'
                                );
                        }
                    );
            });
        }

        $cancellations = $query
            ->paginate(15)
            ->withQueryString();

        $counts = [
            'all' => CancellationRequest::count(),

            'pending_freelancer' => CancellationRequest::where(
                'status',
                'pending_freelancer'
            )->count(),

            'rejected_by_freelancer' => CancellationRequest::where(
                'status',
                'rejected_by_freelancer'
            )->count(),

            'mediation_pending' => CancellationRequest::where(
                'status',
                'mediation_pending'
            )->count(),

            'approved_by_freelancer' => CancellationRequest::where(
                'status',
                'approved_by_freelancer'
            )->count(),

            'approved_by_admin' => CancellationRequest::where(
                'status',
                'approved_by_admin'
            )->count(),

            'rejected_by_admin' => CancellationRequest::where(
                'status',
                'rejected_by_admin'
            )->count(),
        ];

        return view(
            'admin.cancellations.index',
            compact(
                'cancellations',
                'counts'
            )
        );
    }

    /**
     * Detail cancellation.
     */
    public function show(
        CancellationRequest $cancellationRequest
    ): View {
        $cancellationRequest->load([
            'order.client',
            'order.freelancerProfile.user',
            'order.payment',
            'requester',
            'reviewer',
        ]);

        return view(
            'admin.cancellations.show',
            compact('cancellationRequest')
        );
    }

    /**
     * Admin menyetujui mediasi.
     */
    public function approve(
        Request $request,
        CancellationRequest $cancellationRequest
    ): RedirectResponse {
        $validated = $request->validate([
            'admin_note' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        DB::transaction(function () use (
            $cancellationRequest,
            $validated
        ) {
            $lockedRequest = CancellationRequest::query()
                ->lockForUpdate()
                ->findOrFail(
                    $cancellationRequest->id
                );

            abort_unless(
                $lockedRequest->status === 'mediation_pending',
                422,
                'Pengajuan ini tidak sedang menunggu keputusan admin.'
            );

            $order = Order::query()
                ->with('payment')
                ->lockForUpdate()
                ->findOrFail(
                    $lockedRequest->order_id
                );

            /*
            |--------------------------------------------------------------------------
            | Pastikan order masih dapat dibatalkan
            |--------------------------------------------------------------------------
            */
            if (
                ! in_array(
                    $order->status,
                    self::CANCELABLE_STATUSES,
                    true
                )
            ) {
                $lockedRequest->update([
                    'status' => 'rejected_by_admin',
                    'reviewed_by' => Auth::id(),
                    'admin_note' => 'Mediasi tidak dapat diproses karena status order sudah berubah.',
                    'reviewed_at' => now(),
                ]);

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | Batalkan order
            |--------------------------------------------------------------------------
            */
            $order->update([
                'status' => 'cancelled',
                'cancel_reason' => $lockedRequest->reason,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Update payment
            |--------------------------------------------------------------------------
            */
            if ($order->payment) {
                if ($order->payment->status === 'pending') {
                    $order->payment->update([
                        'status' => 'cancelled',
                    ]);
                } elseif ($order->payment->status === 'paid') {
                    /*
                    | Refund aktual akan diproses pada modul Refund/Xendit
                    | pada tahap payment final.
                    */
                    $order->payment->update([
                        'status' => 'refund_pending',
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Update cancellation
            |--------------------------------------------------------------------------
            */
            $lockedRequest->update([
                'status' => 'approved_by_admin',
                'reviewed_by' => Auth::id(),
                'admin_note' => $validated['admin_note'] ?? null,
                'reviewed_at' => now(),
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | Ambil data terbaru
        |--------------------------------------------------------------------------
        */
        $freshRequest = $cancellationRequest
            ->fresh([
                'order.client',
                'order.freelancerProfile.user',
            ]);

        abort_unless(
            $freshRequest,
            404,
            'Pengajuan pembatalan tidak ditemukan.'
        );

        /*
        |--------------------------------------------------------------------------
        | Jika otomatis ditolak karena status order sudah berubah
        |--------------------------------------------------------------------------
        */
        if (
            $freshRequest->status === 'rejected_by_admin'
        ) {
            $this->notifyAdminDecision(
                cancellationRequest: $freshRequest,
                approved: false,
                fallbackReason: true
            );

            return redirect()
                ->route(
                    'admin.cancellations.show',
                    $cancellationRequest
                )
                ->with(
                    'error',
                    'Mediasi tidak dapat diproses karena status order sudah berubah.'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Notifikasi Client + Freelancer
        |--------------------------------------------------------------------------
        */
        $this->notifyAdminDecision(
            cancellationRequest: $freshRequest,
            approved: true
        );

        return redirect()
            ->route(
                'admin.cancellations.show',
                $cancellationRequest
            )
            ->with(
                'success',
                'Mediasi disetujui. Order telah dibatalkan.'
            );
    }

    /**
     * Admin menolak mediasi.
     */
    public function reject(
        Request $request,
        CancellationRequest $cancellationRequest
    ): RedirectResponse {
        $validated = $request->validate([
            'admin_note' => [
                'required',
                'string',
                'min:5',
                'max:2000',
            ],
        ]);

        DB::transaction(function () use (
            $cancellationRequest,
            $validated
        ) {
            $lockedRequest = CancellationRequest::query()
                ->lockForUpdate()
                ->findOrFail(
                    $cancellationRequest->id
                );

            abort_unless(
                $lockedRequest->status === 'mediation_pending',
                422,
                'Pengajuan ini tidak sedang menunggu keputusan admin.'
            );

            $lockedRequest->update([
                'status' => 'rejected_by_admin',
                'reviewed_by' => Auth::id(),
                'admin_note' => $validated['admin_note'],
                'reviewed_at' => now(),
            ]);
        });

        /*
        |--------------------------------------------------------------------------
        | Ambil data terbaru
        |--------------------------------------------------------------------------
        */
        $freshRequest = $cancellationRequest
            ->fresh([
                'order.client',
                'order.freelancerProfile.user',
            ]);

        abort_unless(
            $freshRequest,
            404,
            'Pengajuan pembatalan tidak ditemukan.'
        );

        /*
        |--------------------------------------------------------------------------
        | Notifikasi Client + Freelancer
        |--------------------------------------------------------------------------
        */
        $this->notifyAdminDecision(
            cancellationRequest: $freshRequest,
            approved: false
        );

        return redirect()
            ->route(
                'admin.cancellations.show',
                $cancellationRequest
            )
            ->with(
                'success',
                'Mediasi ditolak. Order tetap berjalan.'
            );
    }

    /**
     * Kirim notifikasi keputusan admin kepada Client dan Freelancer.
     */
    private function notifyAdminDecision(
        CancellationRequest $cancellationRequest,
        bool $approved,
        bool $fallbackReason = false
    ): void {
        $order = $cancellationRequest->order;

        if (! $order) {
            return;
        }

        $client = $order->client;
        $freelancer = $order->freelancerProfile?->user;

        $event = $approved
            ? self::NOTIFICATION_CANCELLATION_MEDIATION_APPROVED
            : self::NOTIFICATION_CANCELLATION_MEDIATION_REJECTED;

        if ($approved) {
            $clientTitle = 'Mediasi pembatalan disetujui';
            $clientMessage =
                'Admin menyetujui mediasi pembatalan order ' .
                ($order->order_number ?? '#' . $order->id) .
                '. Order telah dibatalkan.';

            $freelancerTitle = 'Mediasi pembatalan disetujui';
            $freelancerMessage =
                'Admin menyetujui mediasi pembatalan order ' .
                ($order->order_number ?? '#' . $order->id) .
                '. Order telah dibatalkan.';

            $priority = 'action';
        } else {
            $clientTitle = 'Mediasi pembatalan ditolak';
            $clientMessage = $fallbackReason
                ? 'Mediasi pembatalan order ' .
                    ($order->order_number ?? '#' . $order->id) .
                    ' tidak dapat disetujui karena status order sudah berubah.'
                : 'Admin menolak mediasi pembatalan order ' .
                    ($order->order_number ?? '#' . $order->id) .
                    '. Order tetap berjalan.';

            $freelancerTitle = 'Mediasi pembatalan ditolak';
            $freelancerMessage = $fallbackReason
                ? 'Mediasi pembatalan order ' .
                    ($order->order_number ?? '#' . $order->id) .
                    ' tidak dapat disetujui karena status order sudah berubah.'
                : 'Admin menolak mediasi pembatalan order ' .
                    ($order->order_number ?? '#' . $order->id) .
                    '. Order tetap berjalan.';

            $priority = 'info';
        }

        /*
        |--------------------------------------------------------------------------
        | Client
        |--------------------------------------------------------------------------
        */
        if ($client) {
            app(NotificationService::class)->send(
                recipient: $client,
                event: $event,
                title: $clientTitle,
                message: $clientMessage,
                actionUrl: route(
                    'client.orders.show',
                    $order
                ),
                priority: $priority,
                actor: Auth::user(),
                relatedType: 'cancellation_request',
                relatedId: $cancellationRequest->id,
                extra: [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'cancellation_request_id' => $cancellationRequest->id,
                    'status' => $cancellationRequest->status,
                    'decision' => $approved
                        ? 'approved'
                        : 'rejected',
                ],
                dedupeKey:
                    'cancellation_admin_decision:client:' .
                    $cancellationRequest->id .
                    ':' .
                    ($approved ? 'approved' : 'rejected')
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Freelancer
        |--------------------------------------------------------------------------
        */
        if ($freelancer) {
            app(NotificationService::class)->send(
                recipient: $freelancer,
                event: $event,
                title: $freelancerTitle,
                message: $freelancerMessage,
                actionUrl: route(
                    'freelancer.orders.show',
                    $order
                ),
                priority: $priority,
                actor: Auth::user(),
                relatedType: 'cancellation_request',
                relatedId: $cancellationRequest->id,
                extra: [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'cancellation_request_id' => $cancellationRequest->id,
                    'status' => $cancellationRequest->status,
                    'decision' => $approved
                        ? 'approved'
                        : 'rejected',
                ],
                dedupeKey:
                    'cancellation_admin_decision:freelancer:' .
                    $cancellationRequest->id .
                    ':' .
                    ($approved ? 'approved' : 'rejected')
            );
        }
    }
}
