<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    /**
     * Menampilkan semua jasa milik freelancer.
     */
    public function index()
    {
        $freelancerProfile = Auth::user()->freelancerProfile;

        abort_unless($freelancerProfile, 403);

        $services = Service::query()
            ->where('freelancer_profile_id', $freelancerProfile->id)
            ->with([
                'category',
                'subcategory',
            ])
            ->latest()
            ->get();

        return view('freelancer.services.index', compact(
            'services'
        ));
    }


    /**
     * Form tambah jasa.
     */
    public function create()
    {
        $categories = Category::query()
            ->orderBy('name')
            ->get();

        $subcategories = Subcategory::query()
            ->orderBy('name')
            ->get();

        return view('freelancer.services.create', compact(
            'categories',
            'subcategories'
        ));
    }


    /**
     * Menyimpan jasa baru.
     */
    public function store(Request $request)
    {
        $freelancerProfile = Auth::user()->freelancerProfile;

        abort_unless($freelancerProfile, 403);

        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'subcategory_id' => [
                'nullable',
                'exists:subcategories,id',
            ],

            'description' => [
                'required',
                'string',
            ],

            'starting_price' => [
                'required',
                'numeric',
                'min:1',
            ],

            'delivery_days' => [
                'required',
                'integer',
                'min:1',
                'max:365',
            ],

            'thumbnail' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Upload Thumbnail
        |--------------------------------------------------------------------------
        */

        $thumbnailPath = null;

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request
                ->file('thumbnail')
                ->store('services', 'public');
        }


        /*
        |--------------------------------------------------------------------------
        | Create Service
        |--------------------------------------------------------------------------
        */

        $service = Service::create([
            'freelancer_profile_id' => $freelancerProfile->id,

            'category_id' => $validated['category_id'],

            'subcategory_id' => $validated['subcategory_id'] ?? null,

            'title' => $validated['title'],

            'slug' => Str::slug($validated['title'])
                . '-'
                . Str::lower(Str::random(6)),

            'description' => $validated['description'],

            'starting_price' => $validated['starting_price'],

            'delivery_days' => $validated['delivery_days'],

            'orders_count' => 0,

            'rating' => 0,

            'reviews_count' => 0,

            'thumbnail' => $thumbnailPath,

            'status' => 'draft',

            'is_featured' => false,
        ]);


        return redirect()
            ->route('freelancer.services.index')
            ->with(
                'success',
                'Jasa berhasil dibuat dan disimpan sebagai draft.'
            );
    }


    /**
     * Menampilkan detail jasa.
     */
    public function show(Service $service)
    {
        $freelancerProfile = Auth::user()->freelancerProfile;

        abort_unless(
            $freelancerProfile &&
            $service->freelancer_profile_id === $freelancerProfile->id,
            403
        );

        $service->load([
            'category',
            'subcategory',
            'freelancerProfile.user',
        ]);

        return view(
            'freelancer.services.show',
            compact('service')
        );
    }


    /**
     * Form edit jasa.
     */
    public function edit(Service $service)
    {
        $freelancerProfile = Auth::user()->freelancerProfile;

        abort_unless(
            $freelancerProfile &&
            $service->freelancer_profile_id === $freelancerProfile->id,
            403
        );

        $categories = Category::query()
            ->orderBy('name')
            ->get();

        $subcategories = Subcategory::query()
            ->orderBy('name')
            ->get();

        return view(
            'freelancer.services.edit',
            compact(
                'service',
                'categories',
                'subcategories'
            )
        );
    }


    /**
     * Memperbarui jasa.
     */
    public function update(
        Request $request,
        Service $service
    ) {
        $freelancerProfile = Auth::user()->freelancerProfile;

        abort_unless(
            $freelancerProfile &&
            $service->freelancer_profile_id === $freelancerProfile->id,
            403
        );


        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'subcategory_id' => [
                'nullable',
                'exists:subcategories,id',
            ],

            'description' => [
                'required',
                'string',
            ],

            'starting_price' => [
                'required',
                'numeric',
                'min:1',
            ],

            'delivery_days' => [
                'required',
                'integer',
                'min:1',
                'max:365',
            ],

            'thumbnail' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'status' => [
                'nullable',
                'in:draft,pending,published,rejected,archived',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Data Update
        |--------------------------------------------------------------------------
        */

        $data = [
            'category_id' => $validated['category_id'],

            'subcategory_id' =>
                $validated['subcategory_id'] ?? null,

            'title' =>
                $validated['title'],

            'description' =>
                $validated['description'],

            'starting_price' =>
                $validated['starting_price'],

            'delivery_days' =>
                $validated['delivery_days'],
        ];


        /*
        |--------------------------------------------------------------------------
        | Slug
        |--------------------------------------------------------------------------
        */

        if ($service->title !== $validated['title']) {
            $data['slug'] = Str::slug($validated['title'])
                . '-'
                . Str::lower(Str::random(6));
        }


        /*
        |--------------------------------------------------------------------------
        | Status
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {
            $data['status'] = $validated['status'];
        }


        /*
        |--------------------------------------------------------------------------
        | Thumbnail
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('thumbnail')) {

            if ($service->thumbnail) {
                Storage::disk('public')
                    ->delete($service->thumbnail);
            }

            $data['thumbnail'] = $request
                ->file('thumbnail')
                ->store('services', 'public');
        }


        /*
        |--------------------------------------------------------------------------
        | Update
        |--------------------------------------------------------------------------
        */

        $service->update($data);


        return redirect()
            ->route(
                'freelancer.services.show',
                $service
            )
            ->with(
                'success',
                'Jasa berhasil diperbarui.'
            );
    }


    /**
     * Menghapus jasa.
     */
    public function destroy(Service $service)
    {
        $freelancerProfile = Auth::user()->freelancerProfile;

        abort_unless(
            $freelancerProfile &&
            $service->freelancer_profile_id === $freelancerProfile->id,
            403
        );


        /*
        |--------------------------------------------------------------------------
        | Delete Thumbnail
        |--------------------------------------------------------------------------
        */

        if ($service->thumbnail) {
            Storage::disk('public')
                ->delete($service->thumbnail);
        }


        /*
        |--------------------------------------------------------------------------
        | Delete Service
        |--------------------------------------------------------------------------
        */

        $service->delete();


        return redirect()
            ->route('freelancer.services.index')
            ->with(
                'success',
                'Jasa berhasil dihapus.'
            );
    }
}
