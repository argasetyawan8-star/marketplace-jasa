<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
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
     */
    public function approve(Order $order)
    {
        abort_unless(
            $order->client_id === Auth::id(),
            403
        );

        /*
        |--------------------------------------------------------------------------
        | Delivery harus sudah dikirim freelancer
        |--------------------------------------------------------------------------
        */

        if ($order->status !== 'delivered') {
            return back()->with(
                'error',
                'Order ini belum dapat disetujui.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Ambil delivery terbaru
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


        if ($delivery->status !== 'submitted') {
            return back()->with(
                'error',
                'Delivery ini sudah tidak dapat diproses.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Update delivery + order
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use ($delivery, $order) {

            $delivery->update([
                'status' => 'approved',
            ]);


            $order->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);

        });


        return redirect()
            ->route(
                'client.orders.show',
                $order
            )
            ->with(
                'success',
                'Hasil pekerjaan berhasil disetujui. Order telah selesai.'
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

        $validated = $request->validate([
            'revision_note' => [
                'required',
                'string',
                'min:10',
                'max:2000',
            ],
        ], [
            'revision_note.required' =>
                'Jelaskan bagian yang perlu direvisi.',

            'revision_note.min' =>
                'Catatan revisi minimal 10 karakter.',

            'revision_note.max' =>
                'Catatan revisi maksimal 2000 karakter.',
        ]);


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


        if ($delivery->status !== 'submitted') {
            return back()->with(
                'error',
                'Delivery ini sudah tidak dapat direvisi.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Update status
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use (
            $delivery,
            $order,
            $validated
        ) {

            /*
            |--------------------------------------------------------------------------
            | Saat ini kita belum punya kolom khusus revision_note.
            | Untuk sementara catatan revisi dicatat di delivery message
            | setelah hasil delivery sebelumnya.
            |--------------------------------------------------------------------------
            */

            $revisionMessage =
                "PERMINTAAN REVISI CLIENT:\n\n"
                . $validated['revision_note'];


            $delivery->update([
                'status' => 'revision',
                'message' => $revisionMessage,
            ]);


            $order->update([
                'status' => 'revision',
            ]);

        });


        return back()->with(
            'success',
            'Permintaan revisi berhasil dikirim ke freelancer.'
        );
    }
}
