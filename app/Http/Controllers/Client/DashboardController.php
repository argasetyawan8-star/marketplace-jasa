<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Dashboard Client.
     */
    public function index()
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | Statistik Order
        |--------------------------------------------------------------------------
        */
        $totalOrders = Order::query()
            ->where('client_id', $user->id)
            ->count();

        $activeOrders = Order::query()
            ->where('client_id', $user->id)
            ->whereIn('status', [
                'pending_payment',
                'paid',
                'in_progress',
                'delivered',
                'revision',
            ])
            ->count();

        $completedOrders = Order::query()
            ->where('client_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $waitingOrders = Order::query()
            ->where('client_id', $user->id)
            ->whereIn('status', [
                'pending_payment',
                'paid',
            ])
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Pesanan Terbaru
        |--------------------------------------------------------------------------
        */
        $recentOrders = Order::query()
            ->where('client_id', $user->id)
            ->with([
                'items.service',
                'freelancerProfile.user',
            ])
            ->latest()
            ->limit(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Kategori
        |--------------------------------------------------------------------------
        */
        $categories = Category::query()
            ->orderBy('name')
            ->limit(6)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Jasa Terbaru / Populer
        |--------------------------------------------------------------------------
        */
        $services = Service::query()
            ->where('status', 'published')
            ->with([
                'freelancerProfile.user',
                'category',
            ])
            ->orderByDesc('orders_count')
            ->orderByDesc('rating')
            ->latest()
            ->limit(6)
            ->get();

        return view('client.dashboard', compact(
            'user',
            'totalOrders',
            'activeOrders',
            'completedOrders',
            'waitingOrders',
            'recentOrders',
            'categories',
            'services',
        ));
    }
}