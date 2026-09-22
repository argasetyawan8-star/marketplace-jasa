<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * Menampilkan detail service.
     */
    public function show(string $slug): View
    {
        /*
        |--------------------------------------------------------------------------
        | Service utama
        |--------------------------------------------------------------------------
        */
        $service = Service::query()
            ->with([
                'freelancerProfile.user',
                'category',
                'subcategory',
            ])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Related services
        |--------------------------------------------------------------------------
        |
        | Ambil service lain dalam kategori yang sama.
        |
        */
        $relatedServices = Service::query()
            ->with([
                'freelancerProfile.user',
                'category',
                'subcategory',
            ])
            ->where('status', 'published')
            ->where('category_id', $service->category_id)
            ->where('id', '!=', $service->id)
            ->orderByDesc('is_featured')
            ->orderByDesc('orders_count')
            ->orderByDesc('rating')
            ->orderByDesc('reviews_count')
            ->limit(4)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Freelancer
        |--------------------------------------------------------------------------
        */
        $freelancer = $service->freelancerProfile;
        $freelancerUser = $freelancer?->user;

        /*
        |--------------------------------------------------------------------------
        | Image
        |--------------------------------------------------------------------------
        */
        $serviceImage = $service->thumbnail
            ? asset('storage/' . $service->thumbnail)
            : null;

        $freelancerAvatar = $freelancer?->avatar
            ? asset('storage/' . $freelancer->avatar)
            : null;

        /*
        |--------------------------------------------------------------------------
        | Authentication state
        |--------------------------------------------------------------------------
        */
        $isClient = auth()->check()
            && auth()->user()->role === 'client';

        $isOwner = auth()->check()
            && $freelancerUser
            && auth()->id() === $freelancerUser->id;

        /*
        |--------------------------------------------------------------------------
        | Service statistics
        |--------------------------------------------------------------------------
        */
        $rating = (float) ($service->rating ?? 0);

        $reviewsCount = (int) ($service->reviews_count ?? 0);

        $ordersCount = (int) ($service->orders_count ?? 0);

        $deliveryDays = (int) ($service->delivery_days ?? 0);

        $startingPrice = (float) ($service->starting_price ?? 0);

        /*
        |--------------------------------------------------------------------------
        | Freelancer information
        |--------------------------------------------------------------------------
        */
        $freelancerName = $freelancerUser?->name
            ?? 'Freelancer';

        $freelancerUsername = $freelancer?->username;

        $freelancerInitial = strtoupper(
            substr($freelancerName, 0, 1)
        );

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */
        return view('marketplace.service-detail', [
            'service' => $service,

            'relatedServices' => $relatedServices,

            'freelancer' => $freelancer,

            'freelancerUser' => $freelancerUser,

            'serviceImage' => $serviceImage,

            'freelancerAvatar' => $freelancerAvatar,

            'isClient' => $isClient,

            'isOwner' => $isOwner,

            'rating' => $rating,

            'reviewsCount' => $reviewsCount,

            'ordersCount' => $ordersCount,

            'deliveryDays' => $deliveryDays,

            'startingPrice' => $startingPrice,

            'freelancerName' => $freelancerName,

            'freelancerUsername' => $freelancerUsername,

            'freelancerInitial' => $freelancerInitial,
        ]);
    }
}