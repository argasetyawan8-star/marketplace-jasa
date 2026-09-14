<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Menampilkan semua jasa.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search'));
        $status = $request->input('status');

        $services = Service::query()
            ->with([
                'freelancerProfile.user',
                'category',
                'subcategory',
            ])
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                        ->orWhere('description', 'like', '%' . $search . '%');
                });
            })
            ->when(
                in_array($status, ['draft', 'published', 'paused', 'rejected'], true),
                fn ($query) => $query->where('status', $status)
            )
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.services.index', compact(
            'services',
            'search',
            'status'
        ));
    }

    /**
     * Menampilkan detail jasa.
     */
    public function show(Service $service)
    {
        $service->load([
            'freelancerProfile.user',
            'category',
            'subcategory',
        ]);

        return view('admin.services.show', compact('service'));
    }

    /**
     * Form edit jasa.
     */
    public function edit(Service $service)
    {
        $service->load([
            'freelancerProfile.user',
            'category',
            'subcategory',
        ]);

        return view('admin.services.edit', compact('service'));
    }

    /**
     * Update jasa dari sisi admin.
     */
    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'status' => [
                'required',
                'in:draft,published,paused,rejected',
            ],
            'is_featured' => [
                'nullable',
                'boolean',
            ],
        ]);

        $service->update([
            'status' => $validated['status'],
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return redirect()
            ->route('admin.services.show', $service)
            ->with('success', 'Jasa berhasil diperbarui.');
    }

    /**
     * Menghapus jasa.
     */
    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Jasa berhasil dihapus.');
    }
}