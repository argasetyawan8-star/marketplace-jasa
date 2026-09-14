<?php

namespace App\Http\Controllers\Marketplace;

use App\Http\Controllers\Controller;
use App\Models\FreelancerProfile;
use Illuminate\Http\Request;

class FreelancerController extends Controller
{
    public function show(string $username)
    {
        $freelancerProfile = FreelancerProfile::query()
            ->where('username', $username)
            ->with([
                'user',
                'services' => function ($query) {
                    $query->where('status', 'published')
                        ->with([
                            'category',
                            'subcategory',
                        ])
                        ->latest();
                },
            ])
            ->firstOrFail();

        return view(
            'marketplace.freelancer',
            compact('freelancerProfile')
        );
    }
}