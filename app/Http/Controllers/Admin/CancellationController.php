<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CancellationRequest;
use App\Models\Order;
use App\Services\RefundService;
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
            /*
            |--------------------------------------------------------------------------
            | Lock Cancellation Request
            |--------------------------------------------------------------------------
            */

            $lockedRequest = CancellationRequest::query()
                ->lockForUpdate()
                ->findOrFail(
                    $cancellationRequest->id
                );

            abort_unless(
                $lockedRequest->status === 'mediation_pending',
                422,
                'Pengajuan ini tidak lagi menunggu mediasi admin.'
            );

            /*
            |--------------------------------------------------------------------------
            | Lock Order
            |--------------------------------------------------------------------------
            */

            $order = Order::query()
                ->with('payment')
                ->lockForUpdate()
                ->findOrFail(
                    $lockedRequest->order_id
                );

            /*
            |--------------------------------------------------------------------------
            | Pastikan Order Masih Dapat Dibatalkan
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
                    'admin_note' =>
                        'Mediasi tidak dapat diproses karena status order sudah berubah.',
                    'reviewed_at' => now(),
                ]);

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | Batalkan Order
            |--------------------------------------------------------------------------
            */

            $order->update([
                'status' => 'cancelled',
                'cancel_reason' => $lockedRequest->reason,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Payment
            |--------------------------------------------------------------------------
            */

            if ($order->payment) {
                /*
                |--------------------------------------------------------------------------
                | Belum Dibayar
                |--------------------------------------------------------------------------
                */

                if (
                    $order->payment->status === 'pending'
                ) {
                    $order->payment->update([
                        'status' => 'cancelled',
                    ]);
                }

                /*
                |--------------------------------------------------------------------------
                | Sudah Dibayar
                |--------------------------------------------------------------------------
                |
                | Tandai payment sebagai refund_pending.
                | Kemudian otomatis buat record Refund.
                |
                */

                elseif (
                    $order->payment->status === 'paid'
                ) {
                    $order->payment->update([
                        'status' => 'refund_pending',
                    ]);

                    app(RefundService::class)->createPending(
                        $order,
                        'cancellation',
                        $lockedRequest->id,
                        $lockedRequest->reason
                    );
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Update Cancellation Request
            |--------------------------------------------------------------------------
            */

            $lockedRequest->update([
                'status' => 'approved_by_admin',
                'reviewed_by' => Auth::id(),
                'admin_note' =>
                    $validated['admin_note'] ?? null,
                'reviewed_at' => now(),
            ]);
        });

        $freshRequest = $cancellationRequest->fresh();

        if (
            $freshRequest &&
            $freshRequest->status === 'rejected_by_admin'
        ) {
            return back()->with(
                'error',
                'Mediasi tidak dapat diproses karena status order sudah berubah.'
            );
        }

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
            /*
            |--------------------------------------------------------------------------
            | Lock Cancellation Request
            |--------------------------------------------------------------------------
            */

            $lockedRequest = CancellationRequest::query()
                ->lockForUpdate()
                ->findOrFail(
                    $cancellationRequest->id
                );

            /*
            |--------------------------------------------------------------------------
            | Pastikan Masih Menunggu Mediasi
            |--------------------------------------------------------------------------
            */

            abort_unless(
                $lockedRequest->status === 'mediation_pending',
                422,
                'Pengajuan ini tidak lagi menunggu mediasi admin.'
            );

            /*
            |--------------------------------------------------------------------------
            | Tolak Mediasi
            |--------------------------------------------------------------------------
            |
            | Order tetap berjalan.
            | Tidak ada Refund yang dibuat.
            |
            */

            $lockedRequest->update([
                'status' => 'rejected_by_admin',
                'reviewed_by' => Auth::id(),
                'admin_note' => $validated['admin_note'],
                'reviewed_at' => now(),
            ]);
        });

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
}