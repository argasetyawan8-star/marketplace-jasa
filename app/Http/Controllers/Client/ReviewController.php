<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
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
        abort_unless($order->client_id === Auth::id(), 403);

        if ($order->status !== 'completed') {
            return redirect()
                ->route('client.orders.show', $order)
                ->with('error', 'Review hanya dapat diberikan setelah order selesai.');
        }

        $existingReview = Review::where('order_id', $order->id)->first();

        if ($existingReview) {
            return redirect()
                ->route('client.orders.show', $order)
                ->with('error', 'Review untuk order ini sudah diberikan.');
        }

        $order->load([
            'freelancerProfile.user',
            'items.service',
        ]);

        return view('client.orders.review', compact('order'));
    }

    /**
     * Menyimpan review client.
     */
    public function store(Request $request, Order $order)
    {
        abort_unless($order->client_id === Auth::id(), 403);

        if ($order->status !== 'completed') {
            return back()->with(
                'error',
                'Order belum selesai sehingga belum dapat diberi review.'
            );
        }

        if (Review::where('order_id', $order->id)->exists()) {
            return redirect()
                ->route('client.orders.show', $order)
                ->with('error', 'Review untuk order ini sudah diberikan.');
        }

        $validated = $request->validate([
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
        ], [
            'rating.required' => 'Berikan rating terlebih dahulu.',
            'rating.between' => 'Rating harus antara 1 sampai 5.',
            'comment.required' => 'Tulis pengalamanmu menggunakan jasa ini.',
            'comment.min' => 'Komentar minimal 10 karakter.',
            'comment.max' => 'Komentar maksimal 2000 karakter.',
        ]);

        DB::transaction(function () use ($validated, $order) {

            Review::create([
                'order_id' => $order->id,
                'client_id' => $order->client_id,
                'freelancer_profile_id' => $order->freelancer_profile_id,
                'rating' => $validated['rating'],
                'comment' => $validated['comment'],
                'status' => 'published',
                'published_at' => now(),
            ]);

            $this->refreshFreelancerRating($order->freelancer_profile_id);
        });

        return redirect()
            ->route('client.orders.show', $order)
            ->with(
                'success',
                'Terima kasih. Review berhasil diberikan.'
            );
    }

    /**
     * Menghitung ulang rating freelancer berdasarkan review yang published.
     */
    private function refreshFreelancerRating(int $freelancerProfileId): void
    {
        $average = Review::where(
                'freelancer_profile_id',
                $freelancerProfileId
            )
            ->where('status', 'published')
            ->avg('rating');

        DB::table('freelancer_profiles')
            ->where('id', $freelancerProfileId)
            ->update([
                'rating' => round($average ?? 0, 2),
                'updated_at' => now(),
            ]);
    }
}
