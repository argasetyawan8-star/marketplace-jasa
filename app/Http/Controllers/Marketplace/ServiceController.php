<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function show(string $slug): View
    {
        $service = Service::query()
            ->with([
                'freelancerProfile.user',
                'category',
                'subcategory',
            ])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $relatedServices = Service::query()
            ->with([
                'freelancerProfile.user',
                'category',
            ])
            ->where('status', 'published')
            ->where('id', '!=', $service->id)
            ->where(function ($query) use ($service) {
                $query
                    ->where('category_id', $service->category_id)
                    ->orWhere('subcategory_id', $service->subcategory_id);
            })
            ->orderByDesc('orders_count')
            ->limit(4)
            ->get();

        return view('marketplace.service-detail', [
            'service' => $service,
            'relatedServices' => $relatedServices,
        ]);
    }
}