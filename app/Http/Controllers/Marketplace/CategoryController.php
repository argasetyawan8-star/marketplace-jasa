<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Menampilkan halaman kategori marketplace.
     */
    public function show(Request $request, string $slug): View
    {
        /*
        |--------------------------------------------------------------------------
        | Ambil kategori
        |--------------------------------------------------------------------------
        */
        $category = Category::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Subkategori aktif
        |--------------------------------------------------------------------------
        */
        $subcategories = Subcategory::query()
            ->where('category_id', $category->id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Query Services
        |--------------------------------------------------------------------------
        */
        $servicesQuery = Service::query()
            ->with([
                'freelancerProfile.user',
                'category',
                'subcategory',
            ])
            ->where('status', 'published')
            ->where('category_id', $category->id);


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */
        $keyword = trim(
            $request->string('q')->toString()
        );

        if ($keyword !== '') {
            $servicesQuery->where(function ($query) use ($keyword) {
                $query
                    ->where('title', 'like', '%' . $keyword . '%')
                    ->orWhere(
                        'description',
                        'like',
                        '%' . $keyword . '%'
                    )
                    ->orWhereHas(
                        'freelancerProfile',
                        function ($profileQuery) use ($keyword) {
                            $profileQuery
                                ->where(
                                    'headline',
                                    'like',
                                    '%' . $keyword . '%'
                                )
                                ->orWhere(
                                    'bio',
                                    'like',
                                    '%' . $keyword . '%'
                                )
                                ->orWhere(
                                    'username',
                                    'like',
                                    '%' . $keyword . '%'
                                );
                        }
                    )
                    ->orWhereHas(
                        'freelancerProfile.user',
                        function ($userQuery) use ($keyword) {
                            $userQuery->where(
                                'name',
                                'like',
                                '%' . $keyword . '%'
                            );
                        }
                    );
            });
        }


        /*
        |--------------------------------------------------------------------------
        | Subcategory Filter
        |--------------------------------------------------------------------------
        |
        | Hanya subkategori yang benar-benar milik kategori aktif yang
        | diperbolehkan.
        |
        */
        $subcategorySlug = trim(
            $request->string('subcategory')->toString()
        );

        $selectedSubcategory = null;

        if ($subcategorySlug !== '') {
            $selectedSubcategory = $subcategories->firstWhere(
                'slug',
                $subcategorySlug
            );

            if ($selectedSubcategory) {
                $servicesQuery->where(
                    'subcategory_id',
                    $selectedSubcategory->id
                );
            } else {
                $subcategorySlug = '';
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Price Filter
        |--------------------------------------------------------------------------
        */
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        $minPrice = is_numeric($minPrice)
            ? max(0, (float) $minPrice)
            : null;

        $maxPrice = is_numeric($maxPrice)
            ? max(0, (float) $maxPrice)
            : null;


        /*
        |--------------------------------------------------------------------------
        | Jika minimum > maximum, tukar nilainya
        |--------------------------------------------------------------------------
        */
        if (
            $minPrice !== null &&
            $maxPrice !== null &&
            $minPrice > $maxPrice
        ) {
            [$minPrice, $maxPrice] = [
                $maxPrice,
                $minPrice,
            ];
        }


        if ($minPrice !== null) {
            $servicesQuery->where(
                'starting_price',
                '>=',
                $minPrice
            );
        }

        if ($maxPrice !== null) {
            $servicesQuery->where(
                'starting_price',
                '<=',
                $maxPrice
            );
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

        $sort = $request->string('sort')->toString();

        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'relevance';
        }


        /*
        |--------------------------------------------------------------------------
        | Apply Sorting
        |--------------------------------------------------------------------------
        */
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
                /*
                |--------------------------------------------------------------
                | Untuk kategori, relevansi menggunakan kombinasi popularitas
                | dan rating.
                |--------------------------------------------------------------
                */
                $servicesQuery
                    ->orderByDesc('is_featured')
                    ->orderByDesc('orders_count')
                    ->orderByDesc('rating')
                    ->orderByDesc('reviews_count');

                break;
        }


        /*
        |--------------------------------------------------------------------------
        | Services Pagination
        |--------------------------------------------------------------------------
        */
        $services = $servicesQuery
            ->paginate(12)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Category Statistics
        |--------------------------------------------------------------------------
        */
        $totalServices = Service::query()
            ->where('category_id', $category->id)
            ->where('status', 'published')
            ->count();


        $totalSubcategories = $subcategories->count();


        /*
        |--------------------------------------------------------------------------
        | Service Count Per Subcategory
        |--------------------------------------------------------------------------
        */
        $subcategoryServiceCounts = Service::query()
            ->where('category_id', $category->id)
            ->where('status', 'published')
            ->whereNotNull('subcategory_id')
            ->selectRaw('subcategory_id, COUNT(*) as aggregate')
            ->groupBy('subcategory_id')
            ->pluck('aggregate', 'subcategory_id');


        /*
        |--------------------------------------------------------------------------
        | Other Active Categories
        |--------------------------------------------------------------------------
        |
        | Dipakai untuk navigasi kecil di halaman kategori.
        |
        */
        $otherCategories = Category::query()
            ->where('is_active', true)
            ->where('id', '!=', $category->id)
            ->withCount([
                'services' => function ($query) {
                    $query->where('status', 'published');
                },
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->limit(8)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */
        return view('marketplace.category', [
            'category' => $category,
            'subcategories' => $subcategories,
            'selectedSubcategory' => $selectedSubcategory,
            'subcategorySlug' => $subcategorySlug,
            'subcategoryServiceCounts' => $subcategoryServiceCounts,

            'services' => $services,

            'keyword' => $keyword,

            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,

            'sort' => $sort,

            'totalServices' => $totalServices,
            'totalSubcategories' => $totalSubcategories,

            'otherCategories' => $otherCategories,
        ]);
    }
}