<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\FreelancerProfile;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FreelancerController extends Controller
{
    /**
     * Menampilkan profil publik freelancer.
     */
    public function show(Request $request, string $username): View
    {
        /*
        |--------------------------------------------------------------------------
        | Freelancer Profile
        |--------------------------------------------------------------------------
        */
        $freelancerProfile = FreelancerProfile::query()
            ->with([
                'user',
            ])
            ->where('username', $username)
            ->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Published Services Base Query
        |--------------------------------------------------------------------------
        */
        $publishedServicesQuery = $freelancerProfile
            ->services()
            ->where('status', 'published');

        /*
        |--------------------------------------------------------------------------
        | Profile Statistics
        |--------------------------------------------------------------------------
        */
        $serviceCount = (clone $publishedServicesQuery)
            ->count();

        $reviewCount = (int) (
            (clone $publishedServicesQuery)
                ->sum('reviews_count')
        );

        $totalOrders = (int) (
            (clone $publishedServicesQuery)
                ->sum('orders_count')
        );

        $minimumPrice = (clone $publishedServicesQuery)
            ->min('starting_price');

        /*
        |--------------------------------------------------------------------------
        | Service Categories
        |--------------------------------------------------------------------------
        */
        $serviceCategories = Category::query()
            ->where('is_active', true)
            ->whereHas('services', function ($query) use ($freelancerProfile) {
                $query
                    ->where('freelancer_profile_id', $freelancerProfile->id)
                    ->where('status', 'published');
            })
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */
        $search = trim(
            $request->string('q')->toString()
        );

        $servicesQuery = $freelancerProfile
            ->services()
            ->with([
                'category',
                'subcategory',
            ])
            ->where('status', 'published');

        if ($search !== '') {
            $servicesQuery->where(function ($query) use ($search) {

                $query
                    ->where('title', 'like', '%' . $search . '%')
                    ->orWhere(
                        'description',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhereHas(
                        'category',
                        function ($categoryQuery) use ($search) {
                            $categoryQuery->where(
                                'name',
                                'like',
                                '%' . $search . '%'
                            );
                        }
                    )
                    ->orWhereHas(
                        'subcategory',
                        function ($subcategoryQuery) use ($search) {
                            $subcategoryQuery->where(
                                'name',
                                'like',
                                '%' . $search . '%'
                            );
                        }
                    );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Category Filter
        |--------------------------------------------------------------------------
        */
        $selectedCategorySlug = trim(
            $request->string('category')->toString()
        );

        $selectedCategory = null;

        if ($selectedCategorySlug !== '') {

            $selectedCategory = $serviceCategories
                ->firstWhere(
                    'slug',
                    $selectedCategorySlug
                );

            if ($selectedCategory) {

                $servicesQuery->where(
                    'category_id',
                    $selectedCategory->id
                );

            } else {

                $selectedCategorySlug = '';
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */
        $allowedSorts = [
            'relevance',
            'popular',
            'rating',
            'price_low',
            'price_high',
            'newest',
        ];

        $sort = $request
            ->string('sort')
            ->toString();

        if (! in_array($sort, $allowedSorts, true)) {
            $sort = 'relevance';
        }

        switch ($sort) {

            case 'popular':

                $servicesQuery
                    ->orderByDesc('orders_count')
                    ->orderByDesc('rating')
                    ->orderByDesc('reviews_count');

                break;

            case 'rating':

                $servicesQuery
                    ->orderByDesc('rating')
                    ->orderByDesc('reviews_count')
                    ->orderByDesc('orders_count');

                break;

            case 'price_low':

                $servicesQuery
                    ->orderBy('starting_price')
                    ->orderByDesc('rating');

                break;

            case 'price_high':

                $servicesQuery
                    ->orderByDesc('starting_price')
                    ->orderByDesc('rating');

                break;

            case 'newest':

                $servicesQuery
                    ->orderByDesc('created_at');

                break;

            case 'relevance':
            default:

                $servicesQuery
                    ->orderByDesc('is_featured')
                    ->orderByDesc('orders_count')
                    ->orderByDesc('rating')
                    ->orderByDesc('reviews_count');

                break;
        }

        /*
        |--------------------------------------------------------------------------
        | Services
        |--------------------------------------------------------------------------
        */
        $services = $servicesQuery->get();

        /*
        |--------------------------------------------------------------------------
        | Authentication State
        |--------------------------------------------------------------------------
        */
        $canContactFreelancer = auth()->check()
            && in_array(
                auth()->user()->role,
                ['client', 'freelancer'],
                true
            );

        $isOwner = auth()->check()
            && $freelancerProfile->user_id === auth()->id();

        /*
        |--------------------------------------------------------------------------
        | Contact Service
        |--------------------------------------------------------------------------
        |
        | Route client.messages.start menggunakan service sebagai parameter.
        | Karena itu kita gunakan service pertama yang tersedia sebagai
        | konteks awal percakapan.
        |
        */
        $contactService = $freelancerProfile
            ->services()
            ->where('status', 'published')
            ->orderByDesc('is_featured')
            ->orderByDesc('orders_count')
            ->latest()
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Basic Profile Data
        |--------------------------------------------------------------------------
        */
        $freelancerName = $freelancerProfile->user?->name
            ?? $freelancerProfile->username
            ?? 'Freelancer';

        $freelancerInitial = strtoupper(
            substr(
                $freelancerName,
                0,
                1
            )
        );

        $isAvailable = (bool) (
            $freelancerProfile->is_available
            ?? false
        );

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */
        return view(
            'marketplace.freelancer',
            [
                'freelancerProfile' => $freelancerProfile,

                'services' => $services,

                'serviceCategories' => $serviceCategories,

                'selectedCategory' => $selectedCategory,

                'selectedCategorySlug' => $selectedCategorySlug,

                'search' => $search,

                'sort' => $sort,

                'serviceCount' => $serviceCount,

                'reviewCount' => $reviewCount,

                'totalOrders' => $totalOrders,

                'minimumPrice' => $minimumPrice,

                'freelancerName' => $freelancerName,

                'freelancerInitial' => $freelancerInitial,

                'isAvailable' => $isAvailable,

                'canContactFreelancer' => $canContactFreelancer,

                'isOwner' => $isOwner,

                'contactService' => $contactService,
            ]
        );
    }
}
