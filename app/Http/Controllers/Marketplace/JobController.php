<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $jobs = Job::query()
            ->with([
                'client',
                'category',
                'subcategory',
            ])
            ->withCount('proposals')
            ->where('status', 'open')
            ->when($request->filled('q'), function ($query) use ($request) {
                $q = trim(
                    $request->string('q')->toString()
                );

                $query->where(function ($builder) use ($q) {
                    $builder
                        ->where('title', 'like', "%{$q}%")
                        ->orWhere(
                            'description',
                            'like',
                            "%{$q}%"
                        );
                });
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->whereHas(
                    'category',
                    fn ($category) =>
                        $category->where(
                            'slug',
                            $request->string('category')->toString()
                        )
                );
            })
            ->latest('published_at')
            ->paginate(12)
            ->withQueryString();

        $categories = Category::query()
            ->orderBy('name')
            ->get();

        return view(
            'marketplace.jobs.index',
            compact('jobs', 'categories')
        );
    }

    public function show(Job $job)
    {
        abort_unless(
            $job->status === 'open'
                || (
                    auth()->check()
                    && auth()->id() === $job->client_id
                ),
            404
        );

        $job->load([
            'client',
            'category',
            'subcategory',

            'proposals' => function ($query) {
                $query
                    ->whereIn(
                        'status',
                        ['pending', 'accepted']
                    )
                    ->latest();
            },

            'proposals.freelancerProfile.user',
            'proposals.freelancerProfile.experiences',
            'proposals.freelancerProfile.skills',
            'proposals.freelancerProfile.languages',
            'proposals.selectedExperience',
            'proposals.portfolios',
        ]);

        return view(
            'marketplace.jobs.show',
            compact('job')
        );
    }
}