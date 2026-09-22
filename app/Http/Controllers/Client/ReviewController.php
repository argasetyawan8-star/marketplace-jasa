<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    /**
     * Menampilkan form review untuk order yang sudah selesai.
     */
    public function create(Order $order)
    {
        abort_unless(
            $order->client_id === Auth::id(),
            403
        );

        if ($order->status !== 'completed') {
            return redirect()
                ->route(
                    'client.orders.show',
                    $order
                )
                ->with(
                    'error',
                    'Review hanya dapat diberikan setelah order selesai.'
                );
        }

        $existingReview = Review::where(
            'order_id',
            $order->id
        )->first();

        if ($existingReview) {
            return redirect()
                ->route(
                    'client.orders.show',
                    $order
                )
                ->with(
                    'error',
                    'Review untuk order ini sudah diberikan.'
                );
        }

        $order->load([
            'freelancerProfile.user',
            'items.service',
        ]);

        return view(
            'client.orders.review',
            compact('order')
        );
    }

    /**
     * Menyimpan review client.
     */
    public function store(
        Request $request,
        Order $order
    ) {
        abort_unless(
            $order->client_id === Auth::id(),
            403
        );

        if ($order->status !== 'completed') {
            return back()->with(
                'error',
                'Order belum selesai sehingga belum dapat diberi review.'
            );
        }

        if (
            Review::where(
                'order_id',
                $order->id
            )->exists()
        ) {
            return redirect()
                ->route(
                    'client.orders.show',
                    $order
                )
                ->with(
                    'error',
                    'Review untuk order ini sudah diberikan.'
                );
        }

        $validated = $request->validate(
            [
                'rating' => [
                    'required',
                    'integer',
                    'between:1,5',
                ],

                'comment' => [
                    'required',
                    'string',
                    'min:10',
                    'max:2000',
                ],
            ],
            [
                'rating.required' =>
                    'Berikan rating terlebih dahulu.',

                'rating.between' =>
                    'Rating harus antara 1 sampai 5.',

                'comment.required' =>
                    'Tulis pengalamanmu menggunakan jasa ini.',

                'comment.min' =>
                    'Komentar minimal 10 karakter.',

                'comment.max' =>
                    'Komentar maksimal 2000 karakter.',
            ]
        );

        /**
         * --------------------------------------------------------------------------
         * Simpan review + refresh rating
         * --------------------------------------------------------------------------
         */
        $review = DB::transaction(
            function () use (
                $validated,
                $order
            ) {
                $review = Review::create([
                    'order_id' =>
                        $order->id,

                    'client_id' =>
                        $order->client_id,

                    'freelancer_profile_id' =>
                        $order->freelancer_profile_id,

                    'rating' =>
                        $validated['rating'],

                    'comment' =>
                        $validated['comment'],

                    'status' =>
                        'published',

                    'published_at' =>
                        now(),
                ]);

                $this->refreshFreelancerRating(
                    $order->freelancer_profile_id
                );

                return $review;
            }
        );

        /**
         * --------------------------------------------------------------------------
         * Notification data
         * --------------------------------------------------------------------------
         */
        $order->loadMissing([
            'freelancerProfile.user',
            'client',
        ]);

        $freelancer = $order->freelancerProfile?->user;
        $client = $order->client;

        /**
         * --------------------------------------------------------------------------
         * Notification: Freelancer
         * --------------------------------------------------------------------------
         */
        if ($freelancer) {
            NotificationService::send(
                recipient: $freelancer,

                event: NotificationService::REVIEW_RECEIVED,

                title: 'Review baru dari client',

                message:
                    'Client memberikan rating ' .
                    $review->rating .
                    '/5 untuk order "' .
                    $order->order_number .
                    '". Buka order untuk melihat review.',

                actionUrl: route(
                    'freelancer.orders.show',
                    $order
                ),

                priority: NotificationService::PRIORITY_INFO,

                actor: $client,

                relatedType: 'review',

                relatedId: $review->id,

                extra: [
                    'review_id' =>
                        $review->id,

                    'order_id' =>
                        $order->id,

                    'order_number' =>
                        $order->order_number,

                    'rating' =>
                        $review->rating,

                    'status' =>
                        $review->status,
                ],

                dedupeKey:
                    'review_received:freelancer:' .
                    $freelancer->id .
                    ':' .
                    $review->id
            );
        }

        /**
         * --------------------------------------------------------------------------
         * Notification: Client
         * Konfirmasi bahwa review berhasil tersimpan.
         * --------------------------------------------------------------------------
         */
        if ($client) {
            NotificationService::send(
                recipient: $client,

                event: NotificationService::REVIEW_RECEIVED,

                title: 'Review berhasil diberikan',

                message:
                    'Review untuk order "' .
                    $order->order_number .
                    '" berhasil dikirim. Terima kasih atas penilaianmu.',

                actionUrl: route(
                    'client.orders.show',
                    $order
                ),

                priority: NotificationService::PRIORITY_INFO,

                actor: $client,

                relatedType: 'review',

                relatedId: $review->id,

                extra: [
                    'review_id' =>
                        $review->id,

                    'order_id' =>
                        $order->id,

                    'order_number' =>
                        $order->order_number,

                    'rating' =>
                        $review->rating,

                    'status' =>
                        $review->status,
                ],

                dedupeKey:
                    'review_confirmation:client:' .
                    $client->id .
                    ':' .
                    $review->id
            );
        }

        return redirect()
            ->route(
                'client.orders.show',
                $order
            )
            ->with(
                'success',
                'Terima kasih. Review berhasil diberikan.'
            );
    }

    /**
     * Menghitung ulang rating freelancer berdasarkan review yang published.
     */
    private function refreshFreelancerRating(
        int $freelancerProfileId
    ): void {
        $average = Review::where(
            'freelancer_profile_id',
            $freelancerProfileId
        )
            ->where(
                'status',
                'published'
            )
            ->avg('rating');

        DB::table('freelancer_profiles')
            ->where(
                'id',
                $freelancerProfileId
            )
            ->update([
                'rating' =>
                    round(
                        $average ?? 0,
                        2
                    ),

                'updated_at' =>
                    now(),
            ]);
    }
}
