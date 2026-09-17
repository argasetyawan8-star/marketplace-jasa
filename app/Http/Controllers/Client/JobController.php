<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Job;
use App\Models\Subcategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::query()
            ->with(['category', 'subcategory'])
            ->withCount('proposals')
            ->where('client_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('client.jobs.index', compact('jobs'));
    }

    public function create()
    {
        $categories = Category::query()
            ->with('subcategories')
            ->orderBy('name')
            ->get();

        return view('client.jobs.create', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['nullable', 'integer', Rule::exists('categories', 'id')],
            'subcategory_id' => ['nullable', 'integer', Rule::exists('subcategories', 'id')],
            'title' => ['required', 'string', 'max:160'],
            'description' => ['required', 'string', 'min:20'],
            'budget_min' => ['nullable', 'numeric', 'min:0'],
            'budget_max' => ['nullable', 'numeric', 'gte:budget_min'],
            'duration_days' => ['nullable', 'integer', 'min:1', 'max:3650'],
            'deadline' => ['nullable', 'date', 'after_or_equal:today'],
            'location' => ['nullable', 'string', 'max:120'],
            'action' => ['required', Rule::in(['draft', 'publish'])],
        ]);

        if (!empty($validated['subcategory_id']) && !empty($validated['category_id'])) {
            $belongsToCategory = Subcategory::query()
                ->whereKey($validated['subcategory_id'])
                ->where('category_id', $validated['category_id'])
                ->exists();

            if (!$belongsToCategory) {
                return back()
                    ->withInput()
                    ->withErrors(['subcategory_id' => 'Subkategori tidak sesuai dengan kategori.']);
            }
        }

        $isPublished = $validated['action'] === 'publish';

        Job::create([
            'client_id' => auth()->id(),
            'category_id' => $validated['category_id'] ?? null,
            'subcategory_id' => $validated['subcategory_id'] ?? null,
            'title' => $validated['title'],
            'description' => $validated['description'],
            'budget_min' => $validated['budget_min'] ?? null,
            'budget_max' => $validated['budget_max'] ?? null,
            'duration_days' => $validated['duration_days'] ?? null,
            'deadline' => $validated['deadline'] ?? null,
            'location' => $validated['location'] ?? null,
            'status' => $isPublished ? 'open' : 'draft',
            'published_at' => $isPublished ? now() : null,
        ]);

        return redirect()
            ->route('client.jobs.index')
            ->with('success', $isPublished ? 'Job berhasil dipublikasikan.' : 'Job berhasil disimpan sebagai draft.');
    }

    public function show(Job $job)
    {
        $this->authorizeJob($job);

        $job->load([
            'category',
            'subcategory',
            'proposals.freelancerProfile.user',
        ]);

        return view('client.jobs.show', compact('job'));
    }

    public function edit(Job $job)
    {
        $this->authorizeJob($job);

        $categories = Category::query()
            ->with('subcategories')
            ->orderBy('name')
            ->get();

        return view('client.jobs.edit', compact('job', 'categories'));
    }

    public function update(Request $request, Job $job): RedirectResponse
    {
        $this->authorizeJob($job);

        if (in_array($job->status, ['closed', 'cancelled'], true)) {
            return back()->with('error', 'Job yang sudah ditutup atau dibatalkan tidak dapat diedit.');
        }

        $validated = $request->validate([
            'category_id' => ['nullable', 'integer', Rule::exists('categories', 'id')],
            'subcategory_id' => ['nullable', 'integer', Rule::exists('subcategories', 'id')],
            'title' => ['required', 'string', 'max:160'],
            'description' => ['required', 'string', 'min:20'],
            'budget_min' => ['nullable', 'numeric', 'min:0'],
            'budget_max' => ['nullable', 'numeric', 'gte:budget_min'],
            'duration_days' => ['nullable', 'integer', 'min:1', 'max:3650'],
            'deadline' => ['nullable', 'date', 'after_or_equal:today'],
            'location' => ['nullable', 'string', 'max:120'],
        ]);

        if (!empty($validated['subcategory_id']) && !empty($validated['category_id'])) {
            $belongsToCategory = Subcategory::query()
                ->whereKey($validated['subcategory_id'])
                ->where('category_id', $validated['category_id'])
                ->exists();

            if (!$belongsToCategory) {
                return back()
                    ->withInput()
                    ->withErrors(['subcategory_id' => 'Subkategori tidak sesuai dengan kategori.']);
            }
        }

        $job->update($validated);

        return redirect()
            ->route('client.jobs.show', $job)
            ->with('success', 'Job berhasil diperbarui.');
    }

    public function publish(Job $job): RedirectResponse
    {
        $this->authorizeJob($job);

        if ($job->status !== 'draft') {
            return back()->with('error', 'Job ini bukan draft.');
        }

        $job->update([
            'status' => 'open',
            'published_at' => now(),
        ]);

        return back()->with('success', 'Job berhasil dipublikasikan.');
    }

    public function close(Job $job): RedirectResponse
    {
        $this->authorizeJob($job);

        $job->update([
            'status' => 'closed',
        ]);

        return back()->with('success', 'Job berhasil ditutup.');
    }

    private function authorizeJob(Job $job): void
    {
        abort_unless($job->client_id === auth()->id(), 403);
    }
}
