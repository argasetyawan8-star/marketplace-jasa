<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Menampilkan semua favorit client.
     */
    public function index()
    {
        $favorites = Favorite::query()
            ->where('client_id', Auth::id())
            ->with([
                'service.category',
                'service.freelancerProfile.user',
            ])
            ->latest()
            ->paginate(12);

        return view(
            'client.favorites.index',
            compact('favorites')
        );
    }

    /**
     * Menambahkan jasa ke favorit.
     */
    public function store(Service $service)
    {
        abort_unless(
            $service->status === 'published',
            404
        );

        Favorite::firstOrCreate([
            'client_id' => Auth::id(),
            'service_id' => $service->id,
        ]);

        return back()->with(
            'success',
            'Jasa berhasil ditambahkan ke favorit.'
        );
    }

    /**
     * Menghapus jasa dari favorit.
     */
    public function destroy(Service $service)
    {
        Favorite::query()
            ->where('client_id', Auth::id())
            ->where('service_id', $service->id)
            ->delete();

        return back()->with(
            'success',
            'Jasa berhasil dihapus dari favorit.'
        );
    }
}