<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\FreelancerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    /**
     * Menampilkan profil freelancer.
     */
    public function show()
    {
        $user = Auth::user();

        $freelancerProfile = $user->freelancerProfile;

        abort_unless($freelancerProfile, 404);

        $freelancerProfile->load([
            'user',
            'services' => function ($query) {
                $query->where('status', 'published')
                    ->latest();
            },
        ]);

        return view('freelancer.profile.show', compact(
            'user',
            'freelancerProfile'
        ));
    }

    /**
     * Menampilkan form edit profil.
     */
    public function edit()
    {
        $user = Auth::user();

        $freelancerProfile = $user->freelancerProfile;

        abort_unless($freelancerProfile, 404);

        return view('freelancer.profile.edit', compact(
            'user',
            'freelancerProfile'
        ));
    }

    /**
     * Menyimpan perubahan profil.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $freelancerProfile = $user->freelancerProfile;

        abort_unless($freelancerProfile, 404);

        $validated = $request->validate([
            'username' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'alpha_dash',
                'unique:freelancer_profiles,username,' . $freelancerProfile->id,
            ],
            'headline' => [
                'nullable',
                'string',
                'max:255',
            ],
            'bio' => [
                'nullable',
                'string',
                'max:5000',
            ],
            'location' => [
                'nullable',
                'string',
                'max:255',
            ],
            'website' => [
                'nullable',
                'url',
                'max:255',
            ],
            'avatar' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'cover_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
            ],
            'is_available' => [
                'nullable',
                'boolean',
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Avatar
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('avatar')) {
            if ($freelancerProfile->avatar) {
                Storage::disk('public')->delete(
                    $freelancerProfile->avatar
                );
            }

            $validated['avatar'] = $request
                ->file('avatar')
                ->store('freelancers/avatar', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Cover Image
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('cover_image')) {
            if ($freelancerProfile->cover_image) {
                Storage::disk('public')->delete(
                    $freelancerProfile->cover_image
                );
            }

            $validated['cover_image'] = $request
                ->file('cover_image')
                ->store('freelancers/cover', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Username dibuat aman sebagai slug
        |--------------------------------------------------------------------------
        */
        $validated['username'] = Str::lower(
            Str::slug($validated['username'], '-')
        );

        /*
        |--------------------------------------------------------------------------
        | Status availability
        |--------------------------------------------------------------------------
        */
        $validated['is_available'] = $request->boolean('is_available');

        $freelancerProfile->update($validated);

        return redirect()
            ->route('freelancer.profile.show')
            ->with('success', 'Profil freelancer berhasil diperbarui.');
    }
}