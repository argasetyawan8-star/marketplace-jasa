<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = trim((string) $request->input('q', ''));

        $categorySlug = $request->input('category');
        $subcategorySlug = $request->input('subcategory');

        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        $sort = $request->input('sort', 'relevance');

        $categories = Category::query()
            ->withCount('subcategories')
            ->orderBy('name')
            ->get();

        $subcategoriesQuery = Subcategory::query();

        if ($categorySlug) {
            $category = Category::query()
                ->where('slug', $categorySlug)
                ->first();

            if ($category) {
                $subcategoriesQuery->where('category_id', $category->id);
            }
        }

        $subcategories = $subcategoriesQuery
            ->orderBy('name')
            ->get();

        $servicesQuery = Service::query()
    ->where('status', 'published')
    ->with([
        'category',
        'subcategory',
        'freelancerProfile.user',
    ]);

if (auth()->check() && auth()->user()->role === 'client') {
    $servicesQuery->withExists([
        'favorites as is_favorited' => function ($query) {
            $query->where('client_id', auth()->id());
        },
    ]);
}

        if ($query !== '') {
            $servicesQuery->where(function ($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%')
                    ->orWhere('description', 'like', '%' . $query . '%')
                    ->orWhereHas('category', function ($categoryQuery) use ($query) {
                        $categoryQuery->where('name', 'like', '%' . $query . '%');
                    })
                    ->orWhereHas('subcategory', function ($subcategoryQuery) use ($query) {
                        $subcategoryQuery->where('name', 'like', '%' . $query . '%');
                    })
                    ->orWhereHas('freelancerProfile', function ($freelancerQuery) use ($query) {
                        $freelancerQuery
                            ->where('username', 'like', '%' . $query . '%')
                            ->orWhere('headline', 'like', '%' . $query . '%')
                            ->orWhere('bio', 'like', '%' . $query . '%')
                            ->orWhereHas('user', function ($userQuery) use ($query) {
                                $userQuery->where('name', 'like', '%' . $query . '%');
                            });
                    });
            });
        }

        if ($categorySlug) {
            $servicesQuery->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        if ($subcategorySlug) {
            $servicesQuery->whereHas('subcategory', function ($q) use ($subcategorySlug) {
                $q->where('slug', $subcategorySlug);
            });
        }

        if ($minPrice !== null && $minPrice !== '') {
            $servicesQuery->where(
                'starting_price',
                '>=',
                (float) $minPrice
            );
        }

        if ($maxPrice !== null && $maxPrice !== '') {
            $servicesQuery->where(
                'starting_price',
                '<=',
                (float) $maxPrice
            );
        }

        switch ($sort) {
            case 'popular':
                $servicesQuery
                    ->orderByDesc('orders_count')
                    ->orderByDesc('rating');
                break;

            case 'rating':
                $servicesQuery
                    ->orderByDesc('rating')
                    ->orderByDesc('reviews_count');
                break;

            case 'price_low':
                $servicesQuery->orderBy('starting_price');
                break;

            case 'price_high':
                $servicesQuery->orderByDesc('starting_price');
                break;

            default:
                $servicesQuery
                    ->orderByDesc('is_featured')
                    ->orderByDesc('orders_count')
                    ->latest();
                break;
        }

        $services = $servicesQuery
            ->paginate(12)
            ->withQueryString();

        return view('marketplace.search', compact(
            'query',
            'categorySlug',
            'subcategorySlug',
            'minPrice',
            'maxPrice',
            'sort',
            'categories',
            'subcategories',
            'services'
        ));
    }
}