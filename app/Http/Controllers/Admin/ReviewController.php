<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Menampilkan daftar review.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search'));
        $status = $request->input('status');
        $rating = $request->input('rating');

        $allowedStatuses = [
            'published',
            'hidden',
        ];

        $allowedRatings = [
            '1',
            '2',
            '3',
            '4',
            '5',
        ];

        $reviews = Review::query()
            ->with([
                'order',
                'client',
                'freelancerProfile.user',
            ])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('comment', 'like', '%' . $search . '%')

                        ->orWhereHas('client', function ($clientQuery) use ($search) {
                            $clientQuery
                                ->where('name', 'like', '%' . $search . '%')
                                ->orWhere('email', 'like', '%' . $search . '%');
                        })

                        ->orWhereHas('freelancerProfile.user', function ($userQuery) use ($search) {
                            $userQuery->where(
                                'name',
                                'like',
                                '%' . $search . '%'
                            );
                        })

                        ->orWhereHas('order', function ($orderQuery) use ($search) {
                            $orderQuery->where(
                                'order_number',
                                'like',
                                '%' . $search . '%'
                            );
                        });
                });
            })
            ->when(
                in_array($status, $allowedStatuses, true),
                fn ($query) => $query->where('status', $status)
            )
            ->when(
                in_array($rating, $allowedRatings, true),
                fn ($query) => $query->where('rating', (int) $rating)
            )
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.reviews.index', compact(
            'reviews',
            'search',
            'status',
            'rating'
        ));
    }

    /**
     * Menampilkan detail review.
     */
    public function show(Review $review)
    {
        $review->load([
            'order',
            'order.items',
            'client',
            'freelancerProfile.user',
        ]);

        return view('admin.reviews.show', compact('review'));
    }

    /**
     * Memperbarui status moderasi review.
     */
    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:published,hidden',
            ],
            'admin_note' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ]);

        $review->update([
            'status' => $validated['status'],
            'admin_note' => $validated['admin_note'] ?? null,
            'published_at' => $validated['status'] === 'published'
                ? ($review->published_at ?? now())
                : null,
        ]);

        return redirect()
            ->route('admin.reviews.show', $review)
            ->with('success', 'Status review berhasil diperbarui.');
    }
}