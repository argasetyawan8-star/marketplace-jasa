<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Menampilkan profile user.
     */
    public function show(Request $request): View
    {
        $user = $request->user();

        $profile = Profile::firstOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => null,
                'bio' => null,
                'avatar' => null,
                'location' => null,
            ]
        );

        return view('profile.show', [
            'user' => $user,
            'profile' => $profile,
        ]);
    }

    /**
     * Menampilkan halaman edit profile.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        $profile = Profile::firstOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => null,
                'bio' => null,
                'avatar' => null,
                'location' => null,
            ]
        );

        return view('profile.edit', [
            'user' => $user,
            'profile' => $profile,
        ]);
    }

    /**
     * Update profile.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'phone' => [
                'nullable',
                'string',
                'max:30',
            ],

            'bio' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'location' => [
                'nullable',
                'string',
                'max:255',
            ],

            'avatar' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $profile = Profile::firstOrCreate([
            'user_id' => $user->id,
        ]);

        $profile->phone = $validated['phone'] ?? null;
        $profile->bio = $validated['bio'] ?? null;
        $profile->location = $validated['location'] ?? null;

        if ($request->hasFile('avatar')) {

            if (
                $profile->avatar &&
                Storage::disk('public')->exists($profile->avatar)
            ) {
                Storage::disk('public')->delete($profile->avatar);
            }

            $profile->avatar = $request
                ->file('avatar')
                ->store('avatars', 'public');
        }

        $profile->save();

        return redirect()
            ->route('profile.show')
            ->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Update password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => [
                'required',
                'current_password',
            ],

            'password' => [
                'required',
                'confirmed',
                'min:8',
            ],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with(
            'success',
            'Password berhasil diperbarui.'
        );
    }

    /**
     * Hapus akun.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => [
                'required',
                'current_password',
            ],
        ]);

        $user = $request->user();

        if ($user->profile?->avatar) {

            $avatar = $user->profile->avatar;

            if (Storage::disk('public')->exists($avatar)) {
                Storage::disk('public')->delete($avatar);
            }
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', 'Akun berhasil dihapus.');
    }
}
