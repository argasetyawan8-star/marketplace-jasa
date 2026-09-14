<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    /**
     * Mengirim hasil pekerjaan.
     */
    public function store(Request $request, Order $order)
    {
        $freelancerProfile = Auth::user()->freelancerProfile;

        abort_unless(
            $freelancerProfile &&
            $order->freelancer_profile_id === $freelancerProfile->id,
            403
        );

        if (!in_array($order->status, [
            'paid',
            'in_progress',
            'revision',
        ])) {
            return back()->with(
                'error',
                'Pesanan ini belum dapat menerima hasil pekerjaan.'
            );
        }

        $validated = $request->validate([
            'message' => [
                'nullable',
                'string',
                'max:5000',
            ],

            'external_link' => [
                'nullable',
                'url',
                'max:2048',
            ],

            'file' => [
                'nullable',
                'file',
                'max:10240',
            ],
        ]);

        if (
            empty($validated['message']) &&
            empty($validated['external_link']) &&
            !$request->hasFile('file')
        ) {
            return back()
                ->withErrors([
                    'delivery' => 'Isi pesan, link, atau upload file hasil pekerjaan.',
                ])
                ->withInput();
        }

        $filePath = null;
        $fileName = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $filePath = $file->store(
                'deliveries',
                'public'
            );

            $fileName = $file->getClientOriginalName();
        }

        Delivery::create([
            'order_id' => $order->id,

            'freelancer_profile_id' =>
                $freelancerProfile->id,

            'message' =>
                $validated['message'] ?? null,

            'file_path' =>
                $filePath,

            'file_name' =>
                $fileName,

            'external_link' =>
                $validated['external_link'] ?? null,

            'status' =>
                'submitted',

            'submitted_at' =>
                now(),
        ]);

        $order->update([
            'status' => 'delivered',
        ]);

        return redirect()
            ->route(
                'freelancer.orders.show',
                $order
            )
            ->with(
                'success',
                'Hasil pekerjaan berhasil dikirim ke client.'
            );
    }
}