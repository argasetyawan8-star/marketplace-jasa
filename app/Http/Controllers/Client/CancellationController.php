<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\CancellationRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CancellationController extends Controller
{
    /**
     * Status order yang masih dapat diajukan pembatalan.
     */
    private const CANCELABLE_STATUSES = [
        'pending_payment',
        'paid',
        'in_progress',
        'revision',
    ];

    /**
     * Menampilkan halaman cancellation client.
     */
    public function create(Order $order): View
    {
        abort_unless(
            $order->client_id === Auth::id(),
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

        $latestRequest = CancellationRequest::query()
            ->where('order_id', $order->id)
            ->latest('id')
            ->first();

        $pendingRequest = null;

        if (
            $latestRequest &&
            in_array(
                $latestRequest->status,
                [
                    'pending_freelancer',
                    'mediation_pending',
                ],
                true
            )
        ) {
            $pendingRequest = $latestRequest;
        }

        return view(
            'client.orders.cancellation',
            compact(
                'order',
                'pendingRequest',
                'latestRequest'
            )
        );
    }

    /**
     * Pengajuan cancellation awal oleh client.
     */
    public function store(
        Request $request,
        Order $order
    ): RedirectResponse {
        abort_unless(
            $order->client_id === Auth::id(),
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

        $latestRequest = CancellationRequest::query()
            ->where('order_id', $order->id)
            ->latest('id')
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Jangan membuat pengajuan baru ketika request masih aktif
        |--------------------------------------------------------------------------
        */
        if (
            $latestRequest &&
            in_array(
                $latestRequest->status,
                [
                    'pending_freelancer',
                    'mediation_pending',
                ],
                true
            )
        ) {
            return back()->with(
                'error',
                'Pengajuan pembatalan masih sedang diproses.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Jika freelancer sudah menolak, client wajib menggunakan mediasi
        |--------------------------------------------------------------------------
        */
        if (
            $latestRequest &&
            $latestRequest->status === 'rejected_by_freelancer'
        ) {
            return back()->with(
                'error',
                'Pengajuan pembatalan sudah ditolak freelancer. Gunakan fitur mediasi ke admin.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Jika sudah ada keputusan akhir
        |--------------------------------------------------------------------------
        */
        if (
            $latestRequest &&
            in_array(
                $latestRequest->status,
                [
                    'approved_by_freelancer',
                    'approved_by_admin',
                    'rejected_by_admin',
                ],
                true
            )
        ) {
            return back()->with(
                'error',
                'Pengajuan pembatalan untuk order ini sudah memiliki keputusan akhir.'
            );
        }

        $validated = $request->validate([
            'reason' => [
                'required',
                'string',
                'min:10',
                'max:2000',
            ],
        ]);

        CancellationRequest::create([
            'order_id' => $order->id,
            'requester_id' => Auth::id(),
            'requester_role' => 'client',
            'reason' => $validated['reason'],
            'status' => 'pending_freelancer',
        ]);

        return redirect()
            ->route(
                'client.orders.show',
                $order
            )
            ->with(
                'success',
                'Pengajuan pembatalan berhasil dikirim. Sekarang pengajuan sedang menunggu tanggapan freelancer.'
            );
    }

    /**
     * Client mengajukan mediasi ke admin setelah freelancer menolak.
     */
    public function mediation(
        Request $request,
        Order $order
    ): RedirectResponse {
        abort_unless(
            $order->client_id === Auth::id(),
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

        abort_unless(
            $cancellationRequest->status === 'rejected_by_freelancer',
            422
        );

        $validated = $request->validate([
            'mediation_reason' => [
                'required',
                'string',
                'min:10',
                'max:2000',
            ],
        ]);

        $cancellationRequest->update([
            'status' => 'mediation_pending',
            'mediation_reason' => $validated['mediation_reason'],
            'mediation_requested_at' => now(),
        ]);

        return redirect()
            ->route(
                'client.orders.show',
                $order
            )
            ->with(
                'success',
                'Pengajuan mediasi berhasil dikirim dan sedang menunggu peninjauan admin.'
            );
    }
}