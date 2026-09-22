<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Order;
use App\Services\NotificationService;
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

        /**
         * Simpan status sebelum order diubah.
         *
         * Kalau sebelumnya revision, berarti freelancer
         * sedang mengirim hasil revisi.
         */
        $isRevision = $order->status === 'revision';

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
                    'delivery' =>
                        'Isi pesan, link, atau upload file hasil pekerjaan.',
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

        /**
         * Simpan delivery dan simpan object-nya
         * untuk kebutuhan notifikasi.
         */
        $delivery = Delivery::create([
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

        /**
         * Setelah delivery berhasil dibuat,
         * order masuk ke status delivered.
         */
        $order->update([
            'status' => 'delivered',
        ]);

        /**
         * --------------------------------------------------------------------------
         * Notification: Client
         * --------------------------------------------------------------------------
         */
        $order->loadMissing('client');

        $client = $order->client;

        if ($client) {
            if ($isRevision) {
                $event = NotificationService::REVISION_SENT;

                $title = 'Hasil revisi diterima';

                $message =
                    'Freelancer telah mengirim hasil revisi untuk order "' .
                    $order->order_number .
                    '". Silakan periksa hasil terbaru.';
            } else {
                $event = NotificationService::DELIVERY_SENT;

                $title = 'Hasil pekerjaan diterima';

                $message =
                    'Freelancer telah mengirim hasil pekerjaan untuk order "' .
                    $order->order_number .
                    '". Silakan periksa hasilnya.';
            }

            app(NotificationService::class)->send(
                recipient: $client,
                event: $event,
                title: $title,
                message: $message,
                actionUrl: route(
                    'client.delivery.show',
                    $order
                ),
                priority: 'action',
                actor: Auth::user(),
                relatedType: 'order',
                relatedId: $order->id,
                extra: [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'delivery_id' => $delivery->id,
                    'delivery_status' => $delivery->status,
                    'is_revision' => $isRevision,
                ],
                dedupeKey:
                    ($isRevision
                        ? 'revision_sent:'
                        : 'delivery_sent:'
                    ) . $delivery->id
            );
        }

        return redirect()
            ->route(
                'freelancer.orders.show',
                $order
            )
            ->with(
                'success',
                $isRevision
                    ? 'Hasil revisi berhasil dikirim ke client.'
                    : 'Hasil pekerjaan berhasil dikirim ke client.'
            );
    }
}