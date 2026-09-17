<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $jobs = Job::query()
            ->with(['client.profile', 'category', 'subcategory'])
            ->withCount('proposals')
            ->where('status', 'open')
            ->when($request->filled('q'), function ($query) use ($request) {
                $q = trim($request->string('q')->toString());
                $query->where(function ($builder) use ($q) {
                    $builder->where('title', 'like', "%{$q}%")
                        ->orWhere('description', 'like', "%{$q}%");
                });
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->whereHas('category', fn ($category) =>
                    $category->where('slug', $request->string('category')->toString())
                );
            })
            ->latest('published_at')
            ->paginate(12)
            ->withQueryString();

        $categories = Category::query()->orderBy('name')->get();

        return view('freelancer.jobs.index', compact('jobs', 'categories'));
    }

    public function show(Job $job)
    {
        abort_unless($job->status === 'open', 404);

        $job->load([
            'client.profile',
            'category',
            'subcategory',
        ]);

        $freelancerProfile = auth()->user()->freelancerProfile;

        $existingProposal = $freelancerProfile
            ? $job->proposals()->where('freelancer_profile_id', $freelancerProfile->id)->first()
            : null;

        return view('freelancer.jobs.show', compact('job', 'existingProposal'));
    }
}
