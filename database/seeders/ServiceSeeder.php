<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\FreelancerProfile;
use App\Models\Service;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'freelancer' => 'ardidesign',
                'category' => 'grafis-desain',
                'subcategory' => 'logo-branding',
                'title' => 'Saya akan membuat desain logo profesional untuk brand kamu',
                'description' => 'Desain logo profesional dan modern yang disesuaikan dengan karakter brand dan target audiens kamu.',
                'starting_price' => 250000,
                'delivery_days' => 3,
                'rating' => 4.90,
                'orders_count' => 86,
                'reviews_count' => 24,
                'status' => 'published',
                'is_featured' => true,
            ],

            [
                'freelancer' => 'ardidesign',
                'category' => 'grafis-desain',
                'subcategory' => 'social-media-design',
                'title' => 'Saya akan membuat desain feed Instagram yang modern',
                'description' => 'Desain konten Instagram yang konsisten, modern, dan sesuai dengan identitas visual brand.',
                'starting_price' => 200000,
                'delivery_days' => 3,
                'rating' => 4.80,
                'orders_count' => 62,
                'reviews_count' => 18,
                'status' => 'published',
                'is_featured' => false,
            ],

            [
                'freelancer' => 'devstudio',
                'category' => 'web-programming',
                'subcategory' => 'website-development',
                'title' => 'Saya akan membuat website modern dan responsive',
                'description' => 'Website modern, responsive, dan profesional untuk bisnis, portfolio, maupun kebutuhan personal.',
                'starting_price' => 750000,
                'delivery_days' => 7,
                'rating' => 5.00,
                'orders_count' => 57,
                'reviews_count' => 18,
                'status' => 'published',
                'is_featured' => true,
            ],

            [
                'freelancer' => 'devstudio',
                'category' => 'web-programming',
                'subcategory' => 'web-application',
                'title' => 'Saya akan membuat web application sesuai kebutuhan bisnis',
                'description' => 'Pengembangan web application dengan fitur dan alur yang disesuaikan dengan kebutuhan bisnis.',
                'starting_price' => 1500000,
                'delivery_days' => 14,
                'rating' => 4.90,
                'orders_count' => 31,
                'reviews_count' => 12,
                'status' => 'published',
                'is_featured' => true,
            ],

            [
                'freelancer' => 'nadiacreative',
                'category' => 'penulisan-penerjemahan',
                'subcategory' => 'seo-writing',
                'title' => 'Saya akan menulis artikel SEO berkualitas untuk website',
                'description' => 'Artikel SEO original dengan struktur yang mudah dibaca dan disesuaikan dengan keyword target.',
                'starting_price' => 150000,
                'delivery_days' => 2,
                'rating' => 4.80,
                'orders_count' => 48,
                'reviews_count' => 31,
                'status' => 'published',
                'is_featured' => true,
            ],

            [
                'freelancer' => 'nadiacreative',
                'category' => 'penulisan-penerjemahan',
                'subcategory' => 'copywriting',
                'title' => 'Saya akan membuat copywriting untuk kebutuhan marketing',
                'description' => 'Copywriting yang engaging untuk landing page, social media, campaign, dan kebutuhan pemasaran.',
                'starting_price' => 175000,
                'delivery_days' => 2,
                'rating' => 4.70,
                'orders_count' => 37,
                'reviews_count' => 16,
                'status' => 'published',
                'is_featured' => false,
            ],

            [
                'freelancer' => 'rakavisual',
                'category' => 'video-audio',
                'subcategory' => 'video-editing',
                'title' => 'Saya akan edit video profesional untuk YouTube dan social media',
                'description' => 'Video editing dengan pacing yang menarik, subtitle, transition, dan elemen visual sesuai kebutuhan.',
                'starting_price' => 300000,
                'delivery_days' => 4,
                'rating' => 4.90,
                'orders_count' => 52,
                'reviews_count' => 27,
                'status' => 'published',
                'is_featured' => true,
            ],

            [
                'freelancer' => 'rakavisual',
                'category' => 'video-audio',
                'subcategory' => 'motion-graphics',
                'title' => 'Saya akan membuat motion graphic modern untuk brand',
                'description' => 'Motion graphic yang menarik untuk kebutuhan promosi, social media, presentation, dan branding.',
                'starting_price' => 450000,
                'delivery_days' => 5,
                'rating' => 4.80,
                'orders_count' => 29,
                'reviews_count' => 14,
                'status' => 'published',
                'is_featured' => false,
            ],

            [
                'freelancer' => 'salsamarketing',
                'category' => 'marketing',
                'subcategory' => 'social-media-marketing',
                'title' => 'Saya akan membantu mengelola social media bisnis kamu',
                'description' => 'Strategi, content planning, dan pengelolaan social media untuk membantu brand berkembang secara konsisten.',
                'starting_price' => 500000,
                'delivery_days' => 7,
                'rating' => 4.70,
                'orders_count' => 21,
                'reviews_count' => 11,
                'status' => 'published',
                'is_featured' => false,
            ],
        ];

        foreach ($services as $serviceData) {

            $freelancer = FreelancerProfile::where(
                'username',
                $serviceData['freelancer']
            )->first();

            $category = Category::where(
                'slug',
                $serviceData['category']
            )->first();

            $subcategory = Subcategory::where(
                'slug',
                $serviceData['subcategory']
            )
                ->where('category_id', $category?->id)
                ->first();

            if (! $freelancer || ! $category) {
                continue;
            }

            Service::updateOrCreate(
                [
                    'slug' => Str::slug($serviceData['title']),
                ],
                [
                    'freelancer_profile_id' => $freelancer->id,
                    'category_id' => $category->id,
                    'subcategory_id' => $subcategory?->id,
                    'title' => $serviceData['title'],
                    'description' => $serviceData['description'],
                    'starting_price' => $serviceData['starting_price'],
                    'delivery_days' => $serviceData['delivery_days'],
                    'orders_count' => $serviceData['orders_count'],
                    'rating' => $serviceData['rating'],
                    'reviews_count' => $serviceData['reviews_count'],
                    'thumbnail' => null,
                    'status' => $serviceData['status'],
                    'is_featured' => $serviceData['is_featured'],
                ]
            );
        }
    }
}