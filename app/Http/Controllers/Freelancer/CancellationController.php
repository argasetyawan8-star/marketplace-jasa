<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\CancellationRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class CancellationController extends Controller
{
    /**
     * Status order yang masih dapat diproses untuk cancellation.
     */
    private const CANCELABLE_STATUSES = [
        'pending_payment',
        'paid',
        'in_progress',
        'revision',
    ];

    /**
     * Menampilkan detail pengajuan cancellation kepada freelancer.
     */
    public function create(Order $order): View
    {
        $freelancerProfile = Auth::user()->freelancerProfile;

        abort_unless(
            $freelancerProfile,
            403
        );

        abort_unless(
            $order->freelancer_profile_id === $freelancerProfile->id,
            403
        );

        abort_unless(
            in_array(
                $order->status,
                self::CANCELABLE_STATUSES,
                true
            ),
            422
        );

        $cancellationRequest = CancellationRequest::query()
            ->where('order_id', $order->id)
            ->latest('id')
            ->first();

        abort_unless(
            $cancellationRequest,
            404
        );

        abort_unless(
            $cancellationRequest->requester_role === 'client',
            403
        );

        return view(
            'freelancer.orders.cancellation',
            compact(
                'order',
                'cancellationRequest'
            )
        );
    }

    /**
     * Freelancer menyetujui cancellation.
     */
    public function approve(
        Request $request,
        Order $order
    ): RedirectResponse {
        $freelancerProfile = Auth::user()->freelancerProfile;

        abort_unless(
            $freelancerProfile,
            403
        );

        abort_unless(
            $order->freelancer_profile_id === $freelancerProfile->id,
            403
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
            $freelancerProfile,
            $validated
        ) {
            $lockedOrder = Order::query()
                ->with('payment')
                ->lockForUpdate()
                ->findOrFail($order->id);

            abort_unless(
                $lockedOrder->freelancer_profile_id === $freelancerProfile->id,
                403
            );

            abort_unless(
                in_array(
                    $lockedOrder->status,
                    self::CANCELABLE_STATUSES,
                    true
                ),
                422
            );

            $cancellationRequest = CancellationRequest::query()
                ->lockForUpdate()
                ->where('order_id', $lockedOrder->id)
                ->latest('id')
                ->first();

            abort_unless(
                $cancellationRequest,
                404
            );

            abort_unless(
                $cancellationRequest->requester_role === 'client',
                403
            );

            abort_unless(
                $cancellationRequest->status === 'pending_freelancer',
                422
            );

            /*
            |--------------------------------------------------------------------------
            | Batalkan Order
            |--------------------------------------------------------------------------
            */
            $lockedOrder->update([
                'status' => 'cancelled',
                'cancel_reason' => $cancellationRequest->reason,
            ]);

            /*
            |--------------------------------------------------------------------------
            | Payment
            |--------------------------------------------------------------------------
            */
            if ($lockedOrder->payment) {
                if ($lockedOrder->payment->status === 'pending') {
                    $lockedOrder->payment->update([
                        'status' => 'cancelled',
                    ]);
                } elseif ($lockedOrder->payment->status === 'paid') {
                    $lockedOrder->payment->update([
                        'status' => 'refund_pending',
                    ]);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Update Cancellation Request
            |--------------------------------------------------------------------------
            */
            $cancellationRequest->update([
                'status' => 'approved_by_freelancer',
                'freelancer_note' => $validated['freelancer_note'] ?? null,
                'freelancer_reviewed_at' => now(),
            ]);
        });

        return redirect()
            ->route(
                'freelancer.orders.show',
                $order
            )
            ->with(
                'success',
                'Pembatalan disetujui. Order telah dibatalkan.'
            );
    }

    /**
     * Freelancer menolak cancellation.
     */
    public function reject(
        Request $request,
        Order $order
    ): RedirectResponse {
        $freelancerProfile = Auth::user()->freelancerProfile;

        abort_unless(
            $freelancerProfile,
            403
        );

        abort_unless(
            $order->freelancer_profile_id === $freelancerProfile->id,
            403
        );

        $validated = $request->validate([
            'freelancer_note' => [
                'required',
                'string',
                'min:5',
                'max:2000',
            ],
        ]);

        DB::transaction(function () use (
            $order,
            $freelancerProfile,
            $validated
        ) {
            $lockedOrder = Order::query()
                ->lockForUpdate()
                ->findOrFail($order->id);

            abort_unless(
                $lockedOrder->freelancer_profile_id === $freelancerProfile->id,
                403
            );

            abort_unless(
                in_array(
                    $lockedOrder->status,
                    self::CANCELABLE_STATUSES,
                    true
                ),
                422
            );

            $cancellationRequest = CancellationRequest::query()
                ->lockForUpdate()
                ->where('order_id', $lockedOrder->id)
                ->latest('id')
                ->first();

            abort_unless(
                $cancellationRequest,
                404
            );

            abort_unless(
                $cancellationRequest->requester_role === 'client',
                403
            );

            abort_unless(
                $cancellationRequest->status === 'pending_freelancer',
                422
            );

            /*
            |--------------------------------------------------------------------------
            | Order tetap berjalan
            |--------------------------------------------------------------------------
            */
            $cancellationRequest->update([
                'status' => 'rejected_by_freelancer',
                'freelancer_note' => $validated['freelancer_note'],
                'freelancer_reviewed_at' => now(),
            ]);
        });

        return redirect()
            ->route(
                'freelancer.orders.show',
                $order
            )
            ->with(
                'success',
                'Pengajuan pembatalan ditolak. Client dapat mengajukan mediasi kepada admin.'
            );
    }
}