<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\FreelancerCertificate;
use App\Models\FreelancerEducation;
use App\Models\FreelancerExperience;
use App\Models\FreelancerLanguage;
use App\Models\FreelancerProfile;
use App\Models\FreelancerSkill;
use Illuminate\Http\RedirectResponse;
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
                $query
                    ->where('status', 'published')
                    ->latest();
            },

            'experiences' => function ($query) {
                $query
                    ->orderByDesc('start_year')
                    ->latest();
            },

            'educations' => function ($query) {
                $query
                    ->orderByDesc('start_year')
                    ->latest();
            },

            'certificates' => function ($query) {
                $query
                    ->orderByDesc('year')
                    ->latest();
            },

            'skills' => function ($query) {
                $query
                    ->orderBy('name')
                    ->latest();
            },

            'languages' => function ($query) {
                $query
                    ->orderBy('language')
                    ->latest();
            },
        ]);

        return view(
            'freelancer.profile.show',
            compact(
                'user',
                'freelancerProfile'
            )
        );
    }

    /**
     * Menampilkan form edit profil.
     */
    public function edit()
    {
        $user = Auth::user();

        $freelancerProfile = $user->freelancerProfile;

        abort_unless($freelancerProfile, 404);

        return view(
            'freelancer.profile.edit',
            compact(
                'user',
                'freelancerProfile'
            )
        );
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
                ->store(
                    'freelancers/avatar',
                    'public'
                );
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
                ->store(
                    'freelancers/cover',
                    'public'
                );
        }

        /*
        |--------------------------------------------------------------------------
        | Username dibuat aman sebagai slug
        |--------------------------------------------------------------------------
        */

        $validated['username'] = Str::lower(
            Str::slug(
                $validated['username'],
                '-'
            )
        );

        /*
        |--------------------------------------------------------------------------
        | Status availability
        |--------------------------------------------------------------------------
        */

        $validated['is_available'] = $request->boolean(
            'is_available'
        );

        $freelancerProfile->update(
            $validated
        );

        return redirect()
            ->route('freelancer.profile.show')
            ->with(
                'success',
                'Profil freelancer berhasil diperbarui.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | EXPERIENCE
    |--------------------------------------------------------------------------
    */

    /**
     * Menambahkan pengalaman freelancer.
     */
    public function storeExperience(
        Request $request
    ): RedirectResponse {
        $profile = Auth::user()->freelancerProfile;

        abort_unless($profile, 403);

        $validated = $request->validate([
            'position' => [
                'required',
                'string',
                'max:150',
            ],

            'company' => [
                'nullable',
                'string',
                'max:150',
            ],

            'start_year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:2100',
            ],

            'end_year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:2100',
            ],

            'description' => [
                'nullable',
                'string',
                'max:3000',
            ],
        ]);

        if (
            filled($validated['start_year'] ?? null) &&
            filled($validated['end_year'] ?? null) &&
            $validated['end_year'] < $validated['start_year']
        ) {
            return back()
                ->withErrors([
                    'end_year' => 'Tahun selesai tidak boleh lebih kecil dari tahun mulai.',
                ])
                ->withInput();
        }

        $profile->experiences()->create(
            $validated
        );

        return back()->with(
            'success',
            'Pengalaman berhasil ditambahkan.'
        );
    }

    /**
     * Memperbarui pengalaman freelancer.
     */
    public function updateExperience(
        Request $request,
        FreelancerExperience $experience
    ): RedirectResponse {
        $profile = Auth::user()->freelancerProfile;

        abort_unless(
            $profile &&
            $experience->freelancer_profile_id === $profile->id,
            403
        );

        $validated = $request->validate([
            'position' => [
                'required',
                'string',
                'max:150',
            ],

            'company' => [
                'nullable',
                'string',
                'max:150',
            ],

            'start_year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:2100',
            ],

            'end_year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:2100',
            ],

            'description' => [
                'nullable',
                'string',
                'max:3000',
            ],
        ]);

        if (
            filled($validated['start_year'] ?? null) &&
            filled($validated['end_year'] ?? null) &&
            $validated['end_year'] < $validated['start_year']
        ) {
            return back()
                ->withErrors([
                    'end_year' => 'Tahun selesai tidak boleh lebih kecil dari tahun mulai.',
                ])
                ->withInput();
        }

        $experience->update(
            $validated
        );

        return back()->with(
            'success',
            'Pengalaman berhasil diperbarui.'
        );
    }

    /**
     * Menghapus pengalaman freelancer.
     */
    public function destroyExperience(
        FreelancerExperience $experience
    ): RedirectResponse {
        $profile = Auth::user()->freelancerProfile;

        abort_unless(
            $profile &&
            $experience->freelancer_profile_id === $profile->id,
            403
        );

        $experience->delete();

        return back()->with(
            'success',
            'Pengalaman berhasil dihapus.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EDUCATION
    |--------------------------------------------------------------------------
    */

    /**
     * Menambahkan pendidikan freelancer.
     */
    public function storeEducation(
        Request $request
    ): RedirectResponse {
        $profile = Auth::user()->freelancerProfile;

        abort_unless($profile, 403);

        $validated = $request->validate([
            'institution' => [
                'required',
                'string',
                'max:200',
            ],

            'field_of_study' => [
                'nullable',
                'string',
                'max:150',
            ],

            'start_year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:2100',
            ],

            'end_year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:2100',
            ],
        ]);

        if (
            filled($validated['start_year'] ?? null) &&
            filled($validated['end_year'] ?? null) &&
            $validated['end_year'] < $validated['start_year']
        ) {
            return back()
                ->withErrors([
                    'end_year' => 'Tahun selesai tidak boleh lebih kecil dari tahun mulai.',
                ])
                ->withInput();
        }

        $profile->educations()->create(
            $validated
        );

        return back()->with(
            'success',
            'Pendidikan berhasil ditambahkan.'
        );
    }

    /**
     * Memperbarui pendidikan freelancer.
     */
    public function updateEducation(
        Request $request,
        FreelancerEducation $education
    ): RedirectResponse {
        $profile = Auth::user()->freelancerProfile;

        abort_unless(
            $profile &&
            $education->freelancer_profile_id === $profile->id,
            403
        );

        $validated = $request->validate([
            'institution' => [
                'required',
                'string',
                'max:200',
            ],

            'field_of_study' => [
                'nullable',
                'string',
                'max:150',
            ],

            'start_year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:2100',
            ],

            'end_year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:2100',
            ],
        ]);

        if (
            filled($validated['start_year'] ?? null) &&
            filled($validated['end_year'] ?? null) &&
            $validated['end_year'] < $validated['start_year']
        ) {
            return back()
                ->withErrors([
                    'end_year' => 'Tahun selesai tidak boleh lebih kecil dari tahun mulai.',
                ])
                ->withInput();
        }

        $education->update(
            $validated
        );

        return back()->with(
            'success',
            'Pendidikan berhasil diperbarui.'
        );
    }

    /**
     * Menghapus pendidikan freelancer.
     */
    public function destroyEducation(
        FreelancerEducation $education
    ): RedirectResponse {
        $profile = Auth::user()->freelancerProfile;

        abort_unless(
            $profile &&
            $education->freelancer_profile_id === $profile->id,
            403
        );

        $education->delete();

        return back()->with(
            'success',
            'Pendidikan berhasil dihapus.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CERTIFICATE
    |--------------------------------------------------------------------------
    */

    /**
     * Menambahkan sertifikat freelancer.
     */
    public function storeCertificate(
        Request $request
    ): RedirectResponse {
        $profile = Auth::user()->freelancerProfile;

        abort_unless($profile, 403);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:200',
            ],

            'issuer' => [
                'nullable',
                'string',
                'max:200',
            ],

            'year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:2100',
            ],

            'credential_url' => [
                'nullable',
                'url',
                'max:500',
            ],
        ]);

        $profile->certificates()->create(
            $validated
        );

        return back()->with(
            'success',
            'Sertifikat berhasil ditambahkan.'
        );
    }

    /**
     * Memperbarui sertifikat freelancer.
     */
    public function updateCertificate(
        Request $request,
        FreelancerCertificate $certificate
    ): RedirectResponse {
        $profile = Auth::user()->freelancerProfile;

        abort_unless(
            $profile &&
            $certificate->freelancer_profile_id === $profile->id,
            403
        );

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:200',
            ],

            'issuer' => [
                'nullable',
                'string',
                'max:200',
            ],

            'year' => [
                'nullable',
                'integer',
                'min:1900',
                'max:2100',
            ],

            'credential_url' => [
                'nullable',
                'url',
                'max:500',
            ],
        ]);

        $certificate->update(
            $validated
        );

        return back()->with(
            'success',
            'Sertifikat berhasil diperbarui.'
        );
    }

    /**
     * Menghapus sertifikat freelancer.
     */
    public function destroyCertificate(
        FreelancerCertificate $certificate
    ): RedirectResponse {
        $profile = Auth::user()->freelancerProfile;

        abort_unless(
            $profile &&
            $certificate->freelancer_profile_id === $profile->id,
            403
        );

        $certificate->delete();

        return back()->with(
            'success',
            'Sertifikat berhasil dihapus.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SKILL
    |--------------------------------------------------------------------------
    */

    /**
     * Menambahkan skill freelancer.
     */
    public function storeSkill(
        Request $request
    ): RedirectResponse {
        $profile = Auth::user()->freelancerProfile;

        abort_unless($profile, 403);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],
        ]);

        $name = trim(
            $validated['name']
        );

        $exists = $profile->skills()
            ->whereRaw(
                'LOWER(name) = ?',
                [strtolower($name)]
            )
            ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'name' => 'Skill tersebut sudah ditambahkan.',
                ])
                ->withInput();
        }

        $profile->skills()->create([
            'name' => $name,
        ]);

        return back()->with(
            'success',
            'Skill berhasil ditambahkan.'
        );
    }

    /**
     * Memperbarui skill freelancer.
     */
    public function updateSkill(
        Request $request,
        FreelancerSkill $skill
    ): RedirectResponse {
        $profile = Auth::user()->freelancerProfile;

        abort_unless(
            $profile &&
            $skill->freelancer_profile_id === $profile->id,
            403
        );

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:100',
            ],
        ]);

        $name = trim(
            $validated['name']
        );

        $exists = $profile->skills()
            ->whereRaw(
                'LOWER(name) = ?',
                [strtolower($name)]
            )
            ->where(
                'id',
                '!=',
                $skill->id
            )
            ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'name' => 'Skill tersebut sudah ditambahkan.',
                ])
                ->withInput();
        }

        $skill->update([
            'name' => $name,
        ]);

        return back()->with(
            'success',
            'Skill berhasil diperbarui.'
        );
    }

    /**
     * Menghapus skill freelancer.
     */
    public function destroySkill(
        FreelancerSkill $skill
    ): RedirectResponse {
        $profile = Auth::user()->freelancerProfile;

        abort_unless(
            $profile &&
            $skill->freelancer_profile_id === $profile->id,
            403
        );

        $skill->delete();

        return back()->with(
            'success',
            'Skill berhasil dihapus.'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | LANGUAGE
    |--------------------------------------------------------------------------
    */

    /**
     * Menambahkan bahasa freelancer.
     */
    public function storeLanguage(
        Request $request
    ): RedirectResponse {
        $profile = Auth::user()->freelancerProfile;

        abort_unless($profile, 403);

        $validated = $request->validate([
            'language' => [
                'required',
                'string',
                'max:100',
            ],

            'level' => [
                'nullable',
                'string',
                'max:100',
            ],
        ]);

        $languageName = trim(
            $validated['language']
        );

        $exists = $profile->languages()
            ->whereRaw(
                'LOWER(language) = ?',
                [strtolower($languageName)]
            )
            ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'language' => 'Bahasa tersebut sudah ditambahkan.',
                ])
                ->withInput();
        }

        $profile->languages()->create([
            'language' => $languageName,
            'level' => $validated['level'] ?? null,
        ]);

        return back()->with(
            'success',
            'Bahasa berhasil ditambahkan.'
        );
    }

    /**
     * Memperbarui bahasa freelancer.
     */
    public function updateLanguage(
        Request $request,
        FreelancerLanguage $language
    ): RedirectResponse {
        $profile = Auth::user()->freelancerProfile;

        abort_unless(
            $profile &&
            $language->freelancer_profile_id === $profile->id,
            403
        );

        $validated = $request->validate([
            'language' => [
                'required',
                'string',
                'max:100',
            ],

            'level' => [
                'nullable',
                'string',
                'max:100',
            ],
        ]);

        $languageName = trim(
            $validated['language']
        );

        $exists = $profile->languages()
            ->whereRaw(
                'LOWER(language) = ?',
                [strtolower($languageName)]
            )
            ->where(
                'id',
                '!=',
                $language->id
            )
            ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'language' => 'Bahasa tersebut sudah ditambahkan.',
                ])
                ->withInput();
        }

        $language->update([
            'language' => $languageName,
            'level' => $validated['level'] ?? null,
        ]);

        return back()->with(
            'success',
            'Bahasa berhasil diperbarui.'
        );
    }

    /**
     * Menghapus bahasa freelancer.
     */
    public function destroyLanguage(
        FreelancerLanguage $language
    ): RedirectResponse {
        $profile = Auth::user()->freelancerProfile;

        abort_unless(
            $profile &&
            $language->freelancer_profile_id === $profile->id,
            403
        );

        $language->delete();

        return back()->with(
            'success',
            'Bahasa berhasil dihapus.'
        );
    }
}
