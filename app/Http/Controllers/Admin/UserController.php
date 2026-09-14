<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Menampilkan daftar seluruh pengguna.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->input('search'));
        $role = $request->input('role');

        $users = User::query()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                });
            })
            ->when(
                in_array($role, ['client', 'freelancer', 'admin'], true),
                fn ($query) => $query->where('role', $role)
            )
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', compact(
            'users',
            'search',
            'role'
        ));
    }

    /**
     * Menampilkan detail pengguna.
     */
    public function show(User $user)
    {
        $user->load([
            'profile',
            'freelancerProfile',
        ]);

        return view('admin.users.show', compact('user'));
    }
}