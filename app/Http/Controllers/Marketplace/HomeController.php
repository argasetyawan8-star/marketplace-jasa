<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FreelancerProfile;
use App\Models\Service;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        /*
        |--------------------------------------------------------------------------
        | Kategori aktif
        |--------------------------------------------------------------------------
        */
        $categories = Category::query()
            ->where('is_active', true)
            ->withCount([
                'subcategories as subcategories_count' => function ($query) {
                    $query->where('is_active', true);
                },
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Layanan pilihan
        |--------------------------------------------------------------------------
        */
        $featuredServices = Service::query()
            ->with([
                'freelancerProfile.user',
                'category',
                'subcategory',
            ])
            ->where('status', 'published')
            ->orderByDesc('is_featured')
            ->orderByDesc('orders_count')
            ->orderByDesc('rating')
            ->orderByDesc('reviews_count')
            ->latest()
            ->limit(8)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Freelancer pilihan
        |--------------------------------------------------------------------------
        */
        $featuredFreelancers = FreelancerProfile::query()
            ->with([
                'user',
            ])
            ->whereHas('services', function ($query) {
                $query->where('status', 'published');
            })
            ->orderByDesc('is_verified')
            ->orderByDesc('rating')
            ->orderByDesc('completed_orders')
            ->latest()
            ->limit(6)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Statistik marketplace
        |--------------------------------------------------------------------------
        */
        $totalServices = Service::query()
            ->where('status', 'published')
            ->count();

        $totalFreelancers = FreelancerProfile::query()
            ->whereHas('services', function ($query) {
                $query->where('status', 'published');
            })
            ->count();

        $averageRating = (float) (
            Service::query()
                ->where('status', 'published')
                ->where('reviews_count', '>', 0)
                ->avg('rating') ?? 0
        );

        $totalCompletedOrders = (int) (
            Service::query()
                ->where('status', 'published')
                ->sum('orders_count')
        );

        return view(
            'marketplace.home',
            [
                'categories' => $categories,
                'featuredServices' => $featuredServices,
                'featuredFreelancers' => $featuredFreelancers,
                'totalServices' => $totalServices,
                'totalFreelancers' => $totalFreelancers,
                'averageRating' => $averageRating,
                'totalCompletedOrders' => $totalCompletedOrders,
            ]
        );
    }
}