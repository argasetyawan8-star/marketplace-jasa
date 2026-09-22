<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $query = $user
            ->notifications()
            ->latest();

        $filter = $request->string('filter')->toString();

        if ($filter === 'unread') {
            $query->whereNull('read_at');
        }

        $notifications = $query
            ->paginate(20)
            ->withQueryString();

        $unreadCount = $user
            ->unreadNotifications()
            ->count();

        $role = (string) ($user->role ?? 'client');

        return view(
            'notifications.index',
            compact(
                'notifications',
                'unreadCount',
                'filter',
                'role'
            )
        );
    }

    public function unreadCount(Request $request)
    {
        return response()->json([
            'count' => $request
                ->user()
                ->unreadNotifications()
                ->count(),
        ]);
    }

    public function read(
        Request $request,
        string $notification
    ): RedirectResponse {
        $item = $request
            ->user()
            ->notifications()
            ->whereKey($notification)
            ->firstOrFail();

        $item->markAsRead();

        $url = data_get(
            $item->data,
            'action_url'
        );

        if (! is_string($url) || trim($url) === '') {
            return redirect()->route('notifications.index');
        }

        $url = trim($url);

        /*
        |--------------------------------------------------------------------------
        | RELATIVE URL
        |--------------------------------------------------------------------------
        */

        if (str_starts_with($url, '/')) {
            return redirect()->to($url);
        }

        /*
        |--------------------------------------------------------------------------
        | PARSE URL
        |--------------------------------------------------------------------------
        */

        $parsed = parse_url($url);

        if ($parsed === false) {
            return redirect()->route('notifications.index');
        }

        /*
        |--------------------------------------------------------------------------
        | INTERNAL APP URL
        |--------------------------------------------------------------------------
        |
        | Tinker kadang membuat URL berdasarkan APP_URL.
        | Contoh:
        |
        | APP_URL  = http://localhost:8000
        | Browser  = http://127.0.0.1:8000
        |
        | Kita tetap arahkan ke host yang sedang aktif agar
        | session login tidak hilang.
        |
        */

        $targetHost = $parsed['host'] ?? null;
        $targetPort = $parsed['port'] ?? null;

        $currentHost = $request->getHost();
        $currentPort = $request->getPort();

        $appUrl = config('app.url');

        $appParsed = is_string($appUrl)
            ? parse_url($appUrl)
            : null;

        $appHost = is_array($appParsed)
            ? ($appParsed['host'] ?? null)
            : null;

        $appPort = is_array($appParsed)
            ? ($appParsed['port'] ?? null)
            : null;

        $sameCurrentHost = $targetHost === $currentHost;

        $sameAppHost = $targetHost !== null
            && $appHost !== null
            && $targetHost === $appHost;

        $samePort =
            $targetPort === null
            || (int) $targetPort === (int) $currentPort
            || ($appPort !== null && (int) $targetPort === (int) $appPort);

        $isInternalUrl =
            $targetHost === null
            || (
                ($sameCurrentHost || $sameAppHost)
                && $samePort
            );

        /*
        |--------------------------------------------------------------------------
        | REDIRECT INTERNAL URL
        |--------------------------------------------------------------------------
        */

        if ($isInternalUrl) {
            $path = $parsed['path'] ?? '/';

            $query = isset($parsed['query'])
                ? '?' . $parsed['query']
                : '';

            $fragment = isset($parsed['fragment'])
                ? '#' . $parsed['fragment']
                : '';

            return redirect()->to(
                $path . $query . $fragment
            );
        }

        /*
        |--------------------------------------------------------------------------
        | EXTERNAL URL
        |--------------------------------------------------------------------------
        */

        $scheme = $parsed['scheme'] ?? null;

        if (
            in_array($scheme, ['http', 'https'], true)
            && filter_var($url, FILTER_VALIDATE_URL)
        ) {
            return redirect()->away($url);
        }

        return redirect()->route('notifications.index');
    }

    public function markAllRead(
        Request $request
    ): RedirectResponse {
        $request
            ->user()
            ->unreadNotifications()
            ->update([
                'read_at' => now(),
            ]);

        return back()->with(
            'success',
            'Semua notifikasi sudah ditandai sebagai dibaca.'
        );
    }
}