<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JobController extends Controller
{
    /**
     * Daftar job publik.
     */
    public function index(Request $request): View
    {
        /*
        |--------------------------------------------------------------------------
        | Filter dasar
        |--------------------------------------------------------------------------
        */

        $search = trim(
            $request->string('q')->toString()
        );

        $categorySlug = trim(
            $request->string('category')->toString()
        );

        $minBudget = $request->input('min_budget');
        $maxBudget = $request->input('max_budget');

        /*
        |--------------------------------------------------------------------------
        | Kategori
        |--------------------------------------------------------------------------
        */

        $categories = Category::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Query jobs
        |--------------------------------------------------------------------------
        */

        $jobsQuery = Job::query()
            ->with([
                'client',
                'category',
                'subcategory',
            ])
            ->withCount('proposals')
            ->where('status', 'open')
            ->whereNotNull('published_at')
            ->where(function ($query) {
                $query
                    ->whereNull('deadline')
                    ->orWhereDate('deadline', '>=', today());
            });

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {
            $jobsQuery->where(function ($query) use ($search) {
                $query
                    ->where('title', 'like', '%' . $search . '%')
                    ->orWhere(
                        'description',
                        'like',
                        '%' . $search . '%'
                    )
                    ->orWhere(
                        'location',
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
                    )
                    ->orWhereHas(
                        'client',
                        function ($clientQuery) use ($search) {
                            $clientQuery
                                ->where(
                                    'name',
                                    'like',
                                    '%' . $search . '%'
                                )
                                ->orWhere(
                                    'email',
                                    'like',
                                    '%' . $search . '%'
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

        $selectedCategory = null;

        if ($categorySlug !== '') {
            $selectedCategory = $categories->firstWhere(
                'slug',
                $categorySlug
            );

            if ($selectedCategory) {
                $jobsQuery->where(
                    'category_id',
                    $selectedCategory->id
                );
            } else {
                $categorySlug = '';
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Minimum budget
        |--------------------------------------------------------------------------
        */

        if (
            $minBudget !== null
            && $minBudget !== ''
            && is_numeric($minBudget)
        ) {
            $minBudget = (float) $minBudget;

            $jobsQuery->where(function ($query) use ($minBudget) {
                $query
                    ->whereNotNull('budget_max')
                    ->where(
                        'budget_max',
                        '>=',
                        $minBudget
                    );
            });
        } else {
            $minBudget = '';
        }

        /*
        |--------------------------------------------------------------------------
        | Maximum budget
        |--------------------------------------------------------------------------
        */

        if (
            $maxBudget !== null
            && $maxBudget !== ''
            && is_numeric($maxBudget)
        ) {
            $maxBudget = (float) $maxBudget;

            $jobsQuery->where(function ($query) use ($maxBudget) {
                $query
                    ->whereNotNull('budget_min')
                    ->where(
                        'budget_min',
                        '<=',
                        $maxBudget
                    );
            });
        } else {
            $maxBudget = '';
        }

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

        $allowedSorts = [
            'relevance',
            'newest',
            'deadline',
            'budget_low',
            'budget_high',
            'proposals',
        ];

        $sort = $request
            ->string('sort')
            ->toString();

        if (! in_array($sort, $allowedSorts, true)) {
            $sort = 'relevance';
        }

        switch ($sort) {
            case 'newest':
                $jobsQuery
                    ->orderByDesc('published_at')
                    ->orderByDesc('id');
                break;

            case 'deadline':
                $jobsQuery
                    ->orderByRaw(
                        'CASE WHEN deadline IS NULL THEN 1 ELSE 0 END ASC'
                    )
                    ->orderBy('deadline')
                    ->orderByDesc('published_at');
                break;

            case 'budget_low':
                $jobsQuery
                    ->orderByRaw(
                        'CASE WHEN budget_min IS NULL THEN 1 ELSE 0 END ASC'
                    )
                    ->orderBy('budget_min')
                    ->orderByDesc('published_at');
                break;

            case 'budget_high':
                $jobsQuery
                    ->orderByRaw(
                        'CASE WHEN budget_max IS NULL THEN 1 ELSE 0 END ASC'
                    )
                    ->orderByDesc('budget_max')
                    ->orderByDesc('published_at');
                break;

            case 'proposals':
                $jobsQuery
                    ->orderByDesc('proposals_count')
                    ->orderByDesc('published_at');
                break;

            case 'relevance':
            default:
                $jobsQuery
                    ->orderByDesc('published_at')
                    ->orderByDesc('proposals_count')
                    ->orderByDesc('id');
                break;
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $jobs = $jobsQuery
            ->paginate(12)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Total job aktif
        |--------------------------------------------------------------------------
        */

        $totalOpenJobs = Job::query()
            ->where('status', 'open')
            ->whereNotNull('published_at')
            ->where(function ($query) {
                $query
                    ->whereNull('deadline')
                    ->orWhereDate(
                        'deadline',
                        '>=',
                        today()
                    );
            })
            ->count();

        return view(
            'marketplace.jobs.index',
            [
                'jobs' => $jobs,
                'categories' => $categories,
                'selectedCategory' => $selectedCategory,
                'categorySlug' => $categorySlug,
                'search' => $search,
                'minBudget' => $minBudget,
                'maxBudget' => $maxBudget,
                'sort' => $sort,
                'totalOpenJobs' => $totalOpenJobs,
            ]
        );
    }

    /**
     * Detail job publik.
     */
    public function show(Job $job): View
    {
        abort_unless(
            $job->status === 'open'
            || (
                auth()->check()
                && auth()->id() === $job->client_id
            ),
            404
        );

        /*
        |--------------------------------------------------------------------------
        | Data utama
        |--------------------------------------------------------------------------
        */

        $job->load([
            'client',
            'category',
            'subcategory',
        ]);

        $job->loadCount('proposals');

        /*
        |--------------------------------------------------------------------------
        | Related jobs
        |--------------------------------------------------------------------------
        */

        $relatedJobs = Job::query()
            ->with([
                'client',
                'category',
                'subcategory',
            ])
            ->withCount('proposals')
            ->where('status', 'open')
            ->whereNotNull('published_at')
            ->whereKeyNot($job->id)
            ->where(function ($query) {
                $query
                    ->whereNull('deadline')
                    ->orWhereDate(
                        'deadline',
                        '>=',
                        today()
                    );
            })
            ->when(
                $job->category_id,
                function ($query) use ($job) {
                    $query->where(
                        'category_id',
                        $job->category_id
                    );
                }
            )
            ->latest('published_at')
            ->limit(4)
            ->get();

        return view(
            'marketplace.jobs.show',
            [
                'job' => $job,
                'relatedJobs' => $relatedJobs,
            ]
        );
    }
}
