<?php

namespace App\Http\Controllers\Freelancer;

use App\Http\Controllers\Controller;
use App\Models\FreelancerCertificate;
use App\Models\FreelancerEducation;
use App\Models\FreelancerExperience;
use App\Models\FreelancerLanguage;
use App\Models\FreelancerSkill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileDetailController extends Controller
{
    private function profile()
    {
        $profile = auth()->user()->freelancerProfile;

        abort_unless($profile, 403);

        return $profile;
    }

    public function index(): View
    {
        $profile = $this->profile();

        $profile->load([
            'experiences',
            'educations',
            'certificates',
            'skills',
            'languages',
        ]);

        return view('freelancer.profile.details', compact('profile'));
    }

    /*
    |--------------------------------------------------------------------------
    | EXPERIENCE
    |--------------------------------------------------------------------------
    */

    public function storeExperience(Request $request): RedirectResponse
    {
        $profile = $this->profile();

        $validated = $request->validate([
            'position' => ['required', 'string', 'max:150'],
            'company' => ['nullable', 'string', 'max:150'],
            'start_year' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'end_year' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'description' => ['nullable', 'string', 'max:3000'],
        ]);

        if (
            !empty($validated['start_year']) &&
            !empty($validated['end_year']) &&
            $validated['end_year'] < $validated['start_year']
        ) {
            return back()
                ->withErrors([
                    'end_year' => 'Tahun selesai tidak boleh lebih kecil dari tahun mulai.',
                ])
                ->withInput();
        }

        $profile->experiences()->create($validated);

        return back()->with('success', 'Pengalaman berhasil ditambahkan.');
    }

    public function updateExperience(
        Request $request,
        FreelancerExperience $experience
    ): RedirectResponse {
        $profile = $this->profile();

        abort_unless(
            $experience->freelancer_profile_id === $profile->id,
            403
        );

        $validated = $request->validate([
            'position' => ['required', 'string', 'max:150'],
            'company' => ['nullable', 'string', 'max:150'],
            'start_year' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'end_year' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'description' => ['nullable', 'string', 'max:3000'],
        ]);

        if (
            !empty($validated['start_year']) &&
            !empty($validated['end_year']) &&
            $validated['end_year'] < $validated['start_year']
        ) {
            return back()
                ->withErrors([
                    'end_year' => 'Tahun selesai tidak boleh lebih kecil dari tahun mulai.',
                ])
                ->withInput();
        }

        $experience->update($validated);

        return back()->with('success', 'Pengalaman berhasil diperbarui.');
    }

    public function destroyExperience(
        FreelancerExperience $experience
    ): RedirectResponse {
        $profile = $this->profile();

        abort_unless(
            $experience->freelancer_profile_id === $profile->id,
            403
        );

        $experience->delete();

        return back()->with('success', 'Pengalaman berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | EDUCATION
    |--------------------------------------------------------------------------
    */

    public function storeEducation(Request $request): RedirectResponse
    {
        $profile = $this->profile();

        $validated = $request->validate([
            'institution' => ['required', 'string', 'max:200'],
            'field_of_study' => ['nullable', 'string', 'max:150'],
            'start_year' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'end_year' => ['nullable', 'integer', 'min:1900', 'max:2100'],
        ]);

        if (
            !empty($validated['start_year']) &&
            !empty($validated['end_year']) &&
            $validated['end_year'] < $validated['start_year']
        ) {
            return back()
                ->withErrors([
                    'end_year' => 'Tahun selesai tidak boleh lebih kecil dari tahun mulai.',
                ])
                ->withInput();
        }

        $profile->educations()->create($validated);

        return back()->with('success', 'Pendidikan berhasil ditambahkan.');
    }

    public function updateEducation(
        Request $request,
        FreelancerEducation $education
    ): RedirectResponse {
        $profile = $this->profile();

        abort_unless(
            $education->freelancer_profile_id === $profile->id,
            403
        );

        $validated = $request->validate([
            'institution' => ['required', 'string', 'max:200'],
            'field_of_study' => ['nullable', 'string', 'max:150'],
            'start_year' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'end_year' => ['nullable', 'integer', 'min:1900', 'max:2100'],
        ]);

        if (
            !empty($validated['start_year']) &&
            !empty($validated['end_year']) &&
            $validated['end_year'] < $validated['start_year']
        ) {
            return back()
                ->withErrors([
                    'end_year' => 'Tahun selesai tidak boleh lebih kecil dari tahun mulai.',
                ])
                ->withInput();
        }

        $education->update($validated);

        return back()->with('success', 'Pendidikan berhasil diperbarui.');
    }

    public function destroyEducation(
        FreelancerEducation $education
    ): RedirectResponse {
        $profile = $this->profile();

        abort_unless(
            $education->freelancer_profile_id === $profile->id,
            403
        );

        $education->delete();

        return back()->with('success', 'Pendidikan berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | CERTIFICATE
    |--------------------------------------------------------------------------
    */

    public function storeCertificate(Request $request): RedirectResponse
    {
        $profile = $this->profile();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'issuer' => ['nullable', 'string', 'max:200'],
            'year' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'credential_url' => ['nullable', 'url', 'max:500'],
        ]);

        $profile->certificates()->create($validated);

        return back()->with('success', 'Sertifikat berhasil ditambahkan.');
    }

    public function updateCertificate(
        Request $request,
        FreelancerCertificate $certificate
    ): RedirectResponse {
        $profile = $this->profile();

        abort_unless(
            $certificate->freelancer_profile_id === $profile->id,
            403
        );

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'issuer' => ['nullable', 'string', 'max:200'],
            'year' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'credential_url' => ['nullable', 'url', 'max:500'],
        ]);

        $certificate->update($validated);

        return back()->with('success', 'Sertifikat berhasil diperbarui.');
    }

    public function destroyCertificate(
        FreelancerCertificate $certificate
    ): RedirectResponse {
        $profile = $this->profile();

        abort_unless(
            $certificate->freelancer_profile_id === $profile->id,
            403
        );

        $certificate->delete();

        return back()->with('success', 'Sertifikat berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | SKILL
    |--------------------------------------------------------------------------
    */

    public function storeSkill(Request $request): RedirectResponse
    {
        $profile = $this->profile();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
        ]);

        $exists = $profile->skills()
            ->whereRaw('LOWER(name) = ?', [strtolower($validated['name'])])
            ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'name' => 'Keahlian tersebut sudah ditambahkan.',
                ])
                ->withInput();
        }

        $profile->skills()->create($validated);

        return back()->with('success', 'Keahlian berhasil ditambahkan.');
    }

    public function updateSkill(
        Request $request,
        FreelancerSkill $skill
    ): RedirectResponse {
        $profile = $this->profile();

        abort_unless(
            $skill->freelancer_profile_id === $profile->id,
            403
        );

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
        ]);

        $exists = $profile->skills()
            ->whereRaw('LOWER(name) = ?', [strtolower($validated['name'])])
            ->where('id', '!=', $skill->id)
            ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'name' => 'Keahlian tersebut sudah ditambahkan.',
                ])
                ->withInput();
        }

        $skill->update($validated);

        return back()->with('success', 'Keahlian berhasil diperbarui.');
    }

    public function destroySkill(
        FreelancerSkill $skill
    ): RedirectResponse {
        $profile = $this->profile();

        abort_unless(
            $skill->freelancer_profile_id === $profile->id,
            403
        );

        $skill->delete();

        return back()->with('success', 'Keahlian berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | LANGUAGE
    |--------------------------------------------------------------------------
    */

    public function storeLanguage(Request $request): RedirectResponse
    {
        $profile = $this->profile();

        $validated = $request->validate([
            'language' => ['required', 'string', 'max:100'],
            'level' => ['nullable', 'string', 'max:100'],
        ]);

        $exists = $profile->languages()
            ->whereRaw('LOWER(language) = ?', [strtolower($validated['language'])])
            ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'language' => 'Bahasa tersebut sudah ditambahkan.',
                ])
                ->withInput();
        }

        $profile->languages()->create($validated);

        return back()->with('success', 'Bahasa berhasil ditambahkan.');
    }

    public function updateLanguage(
        Request $request,
        FreelancerLanguage $language
    ): RedirectResponse {
        $profile = $this->profile();

        abort_unless(
            $language->freelancer_profile_id === $profile->id,
            403
        );

        $validated = $request->validate([
            'language' => ['required', 'string', 'max:100'],
            'level' => ['nullable', 'string', 'max:100'],
        ]);

        $exists = $profile->languages()
            ->whereRaw('LOWER(language) = ?', [strtolower($validated['language'])])
            ->where('id', '!=', $language->id)
            ->exists();

        if ($exists) {
            return back()
                ->withErrors([
                    'language' => 'Bahasa tersebut sudah ditambahkan.',
                ])
                ->withInput();
        }

        $language->update($validated);

        return back()->with('success', 'Bahasa berhasil diperbarui.');
    }

    public function destroyLanguage(
        FreelancerLanguage $language
    ): RedirectResponse {
        $profile = $this->profile();

        abort_unless(
            $language->freelancer_profile_id === $profile->id,
            403
        );

        $language->delete();

        return back()->with('success', 'Bahasa berhasil dihapus.');
    }
}