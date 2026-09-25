<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BannerController extends Controller
{
    private const PLACEMENTS = [
        'hero',
        'middle',
        'bottom',
    ];

    /**
     * Daftar banner.
     */
    public function index(): View
    {
        $banners = Banner::query()
            ->orderByRaw("
                CASE placement
                    WHEN 'hero' THEN 1
                    WHEN 'middle' THEN 2
                    WHEN 'bottom' THEN 3
                    ELSE 4
                END
            ")
            ->orderBy('sort_order')
            ->orderByDesc('created_at')
            ->paginate(20);

        $heroCount = Banner::where('placement', 'hero')->count();
        $middleCount = Banner::where('placement', 'middle')->count();
        $bottomCount = Banner::where('placement', 'bottom')->count();
        $activeCount = Banner::where('is_active', true)->count();

        return view('admin.banners.index', compact(
            'banners',
            'heroCount',
            'middleCount',
            'bottomCount',
            'activeCount'
        ));
    }

    /**
     * Form tambah.
     */
    public function create(): View
    {
        $banner = new Banner([
            'placement' => 'hero',
            'sort_order' => 0,
            'is_active' => true,
            'open_new_tab' => false,
        ]);

        return view('admin.banners.form', [
            'banner' => $banner,
            'mode' => 'create',
        ]);
    }

    /**
     * Simpan banner.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateBanner($request);

        $validated['image_path'] = $request
            ->file('image')
            ->store('banners', 'public');

        if ($request->hasFile('mobile_image')) {
            $validated['mobile_image_path'] = $request
                ->file('mobile_image')
                ->store('banners/mobile', 'public');
        }

        $validated['open_new_tab'] = $request->boolean('open_new_tab');
        $validated['is_active'] = $request->boolean('is_active');

        unset(
            $validated['image'],
            $validated['mobile_image']
        );

        Banner::create($validated);

        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Banner berhasil ditambahkan.');
    }

    /**
     * Form edit.
     */
    public function edit(Banner $banner): View
    {
        return view('admin.banners.form', [
            'banner' => $banner,
            'mode' => 'edit',
        ]);
    }

    /**
     * Update banner.
     */
    public function update(
        Request $request,
        Banner $banner
    ): RedirectResponse {
        $validated = $this->validateBanner(
            $request,
            $banner->id
        );

        if ($request->hasFile('image')) {
            if ($banner->image_path) {
                Storage::disk('public')->delete(
                    $banner->image_path
                );
            }

            $validated['image_path'] = $request
                ->file('image')
                ->store('banners', 'public');
        }

        if ($request->hasFile('mobile_image')) {
            if ($banner->mobile_image_path) {
                Storage::disk('public')->delete(
                    $banner->mobile_image_path
                );
            }

            $validated['mobile_image_path'] = $request
                ->file('mobile_image')
                ->store('banners/mobile', 'public');
        }

        $validated['open_new_tab'] = $request->boolean('open_new_tab');
        $validated['is_active'] = $request->boolean('is_active');

        unset(
            $validated['image'],
            $validated['mobile_image']
        );

        $banner->update($validated);

        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Banner berhasil diperbarui.');
    }

    /**
     * Toggle status banner.
     */
    public function toggleStatus(Banner $banner): RedirectResponse
    {
        $banner->update([
            'is_active' => !$banner->is_active,
        ]);

        return redirect()
            ->route('admin.banners.index')
            ->with(
                'success',
                $banner->is_active
                    ? 'Banner berhasil diaktifkan.'
                    : 'Banner berhasil dinonaktifkan.'
            );
    }

    /**
     * Hapus banner.
     */
    public function destroy(Banner $banner): RedirectResponse
    {
        if ($banner->image_path) {
            Storage::disk('public')->delete(
                $banner->image_path
            );
        }

        if ($banner->mobile_image_path) {
            Storage::disk('public')->delete(
                $banner->mobile_image_path
            );
        }

        $banner->delete();

        return redirect()
            ->route('admin.banners.index')
            ->with('success', 'Banner berhasil dihapus.');
    }

    /**
     * Validasi banner.
     */
    private function validateBanner(
        Request $request,
        ?int $bannerId = null
    ): array {
        $imageRule = $bannerId === null
            ? 'required'
            : 'nullable';

        return $request->validate([
            'name' => [
                'required',
                'string',
                'max:150',
            ],

            'placement' => [
                'required',
                Rule::in(self::PLACEMENTS),
            ],

            'image' => [
                $imageRule,
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
            ],

            'mobile_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
            ],

            'alt_text' => [
                'nullable',
                'string',
                'max:255',
            ],

            'link_url' => [
                'nullable',
                'string',
                'max:2048',
                'regex:/^(https?:\/\/|\/)/i',
            ],

            'open_new_tab' => [
                'nullable',
                'boolean',
            ],

            'sort_order' => [
                'required',
                'integer',
                'min:0',
                'max:9999',
            ],

            'is_active' => [
                'nullable',
                'boolean',
            ],

            'starts_at' => [
                'nullable',
                'date',
            ],

            'ends_at' => [
                'nullable',
                'date',
                'after_or_equal:starts_at',
            ],
        ]);
    }
}