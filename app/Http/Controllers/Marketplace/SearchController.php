<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    /**
     * Marketplace search & discovery.
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Normalize input
        |--------------------------------------------------------------------------
        */

        $query = trim((string) $request->input('q', ''));

        $categorySlug = trim((string) $request->input('category', ''));

        $subcategorySlug = trim(
            (string) $request->input('subcategory', '')
        );

        $minPrice = $request->input('min_price');

        $maxPrice = $request->input('max_price');

        $allowedSorts = [
            'relevance',
            'popular',
            'rating',
            'price_low',
            'price_high',
        ];

        $sort = (string) $request->input('sort', 'relevance');

        if (! in_array($sort, $allowedSorts, true)) {
            $sort = 'relevance';
        }

        /*
        |--------------------------------------------------------------------------
        | Normalize price
        |--------------------------------------------------------------------------
        */

        $minPrice = is_numeric($minPrice)
            ? max(0, (float) $minPrice)
            : null;

        $maxPrice = is_numeric($maxPrice)
            ? max(0, (float) $maxPrice)
            : null;

        /*
        |--------------------------------------------------------------------------
        | Prevent invalid price range
        |--------------------------------------------------------------------------
        */

        if (
            $minPrice !== null &&
            $maxPrice !== null &&
            $minPrice > $maxPrice
        ) {
            [$minPrice, $maxPrice] = [$maxPrice, $minPrice];
        }

        /*
        |--------------------------------------------------------------------------
        | Categories
        |--------------------------------------------------------------------------
        */

        $categories = Category::query()
            ->withCount('subcategories')
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Resolve selected category
        |--------------------------------------------------------------------------
        */

        $selectedCategory = null;

        if ($categorySlug !== '') {
            $selectedCategory = Category::query()
                ->where('slug', $categorySlug)
                ->first();

            /*
            |--------------------------------------------------------------------------
            | Invalid category slug
            |--------------------------------------------------------------------------
            */

            if (! $selectedCategory) {
                $categorySlug = '';
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Subcategories
        |--------------------------------------------------------------------------
        */

        $subcategoriesQuery = Subcategory::query();

        if ($selectedCategory) {
            $subcategoriesQuery->where(
                'category_id',
                $selectedCategory->id
            );
        }

        $subcategories = $subcategoriesQuery
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Resolve selected subcategory
        |--------------------------------------------------------------------------
        */

        $selectedSubcategory = null;

        if ($subcategorySlug !== '') {
            $selectedSubcategory = Subcategory::query()
                ->where('slug', $subcategorySlug)
                ->first();

            /*
            |--------------------------------------------------------------------------
            | Invalid subcategory
            |--------------------------------------------------------------------------
            */

            if (! $selectedSubcategory) {
                $subcategorySlug = '';
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Category / subcategory consistency
        |--------------------------------------------------------------------------
        */

        if (
            $selectedCategory &&
            $selectedSubcategory &&
            (int) $selectedSubcategory->category_id !==
            (int) $selectedCategory->id
        ) {
            $selectedSubcategory = null;
            $subcategorySlug = '';
        }

        /*
        |--------------------------------------------------------------------------
        | Base service query
        |--------------------------------------------------------------------------
        */

        $servicesQuery = Service::query()
            ->where('status', 'published')
            ->with([
                'category',
                'subcategory',
                'freelancerProfile.user',
            ]);

        /*
        |--------------------------------------------------------------------------
        | Favorite state
        |--------------------------------------------------------------------------
        */

        if (
            Auth::check() &&
            Auth::user()->role === 'client'
        ) {
            $clientId = Auth::id();

            $servicesQuery->withExists([
                'favorites as is_favorited' => function ($favoriteQuery) use (
                    $clientId
                ) {
                    $favoriteQuery->where(
                        'client_id',
                        $clientId
                    );
                },
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Keyword search
        |--------------------------------------------------------------------------
        */

        if ($query !== '') {
            $servicesQuery->where(function (
                Builder $searchQuery
            ) use ($query) {
                $searchQuery
                    ->where('title', 'like', '%' . $query . '%')
                    ->orWhere(
                        'description',
                        'like',
                        '%' . $query . '%'
                    )
                    ->orWhereHas(
                        'category',
                        function (Builder $categoryQuery) use ($query) {
                            $categoryQuery->where(
                                'name',
                                'like',
                                '%' . $query . '%'
                            );
                        }
                    )
                    ->orWhereHas(
                        'subcategory',
                        function (Builder $subcategoryQuery) use ($query) {
                            $subcategoryQuery->where(
                                'name',
                                'like',
                                '%' . $query . '%'
                            );
                        }
                    )
                    ->orWhereHas(
                        'freelancerProfile',
                        function (Builder $freelancerQuery) use ($query) {
                            $freelancerQuery
                                ->where(
                                    'username',
                                    'like',
                                    '%' . $query . '%'
                                )
                                ->orWhere(
                                    'headline',
                                    'like',
                                    '%' . $query . '%'
                                )
                                ->orWhere(
                                    'bio',
                                    'like',
                                    '%' . $query . '%'
                                )
                                ->orWhereHas(
                                    'user',
                                    function (Builder $userQuery) use ($query) {
                                        $userQuery->where(
                                            'name',
                                            'like',
                                            '%' . $query . '%'
                                        );
                                    }
                                );
                        }
                    );
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Category filter
        |--------------------------------------------------------------------------
        */

        if ($selectedCategory) {
            $servicesQuery->where(
                'category_id',
                $selectedCategory->id
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Subcategory filter
        |--------------------------------------------------------------------------
        */

        if ($selectedSubcategory) {
            $servicesQuery->where(
                'subcategory_id',
                $selectedSubcategory->id
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Price filter
        |--------------------------------------------------------------------------
        */

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

        switch ($sort) {
            case 'popular':
                $servicesQuery
                    ->orderByDesc('orders_count')
                    ->orderByDesc('rating')
                    ->orderByDesc('reviews_count')
                    ->latest('id');

                break;

            case 'rating':
                $servicesQuery
                    ->orderByDesc('rating')
                    ->orderByDesc('reviews_count')
                    ->orderByDesc('orders_count')
                    ->latest('id');

                break;

            case 'price_low':
                $servicesQuery
                    ->orderBy('starting_price')
                    ->orderByDesc('rating')
                    ->latest('id');

                break;

            case 'price_high':
                $servicesQuery
                    ->orderByDesc('starting_price')
                    ->orderByDesc('rating')
                    ->latest('id');

                break;

            case 'relevance':
            default:

                /*
                |--------------------------------------------------------------------------
                | Lightweight relevance ranking
                |--------------------------------------------------------------------------
                |
                | Featured service remains important, while popular and
                | well-reviewed services receive additional priority.
                |
                */

                if ($query !== '') {
                    $searchTerm = addslashes(
                        strtolower($query)
                    );

                    $servicesQuery
                        ->orderByRaw(
                            "CASE
                                WHEN LOWER(title) LIKE '%{$searchTerm}%' THEN 0
                                WHEN LOWER(description) LIKE '%{$searchTerm}%' THEN 1
                                ELSE 2
                            END"
                        )
                        ->orderByDesc('is_featured')
                        ->orderByDesc('orders_count')
                        ->orderByDesc('rating')
                        ->latest('id');
                } else {
                    $servicesQuery
                        ->orderByDesc('is_featured')
                        ->orderByDesc('orders_count')
                        ->orderByDesc('rating')
                        ->latest('id');
                }

                break;
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $services = $servicesQuery
            ->paginate(12)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | View
        |--------------------------------------------------------------------------
        */

        return view(
            'marketplace.search',
            compact(
                'query',
                'categorySlug',
                'subcategorySlug',
                'minPrice',
                'maxPrice',
                'sort',
                'categories',
                'subcategories',
                'services'
            )
        );
    }
}
