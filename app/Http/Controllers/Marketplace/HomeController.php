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
        $categories = Category::query()
            ->where('is_active', true)
            ->withCount([
                'subcategories' => function ($query) {
                    $query->where('is_active', true);
                },
            ])
            ->orderBy('sort_order')
            ->get();

        $featuredServices = Service::query()
            ->with([
                'freelancerProfile.user',
                'category',
                'subcategory',
            ])
            ->where('status', 'published')
            ->where('is_featured', true)
            ->orderByDesc('orders_count')
            ->limit(8)
            ->get();

        $popularServices = Service::query()
            ->with([
                'freelancerProfile.user',
                'category',
                'subcategory',
            ])
            ->where('status', 'published')
            ->orderByDesc('orders_count')
            ->limit(8)
            ->get();

        $featuredFreelancers = FreelancerProfile::query()
            ->with('user')
            ->where('is_available', true)
            ->orderByDesc('is_verified')
            ->orderByDesc('rating')
            ->orderByDesc('completed_orders')
            ->limit(6)
            ->get();

        return view('marketplace.home', [
            'categories' => $categories,
            'featuredServices' => $featuredServices,
            'popularServices' => $popularServices,
            'featuredFreelancers' => $featuredFreelancers,
        ]);
    }
}