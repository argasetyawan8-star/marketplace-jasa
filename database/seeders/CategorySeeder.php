<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'AI & Automation',
                'slug' => 'ai-automation',
                'description' => 'Jasa AI, automation, chatbot, prompt engineering, dan solusi berbasis kecerdasan buatan.',
                'icon' => 'sparkles',
                'sort_order' => 1,
            ],
            [
                'name' => 'Grafis & Desain',
                'slug' => 'grafis-desain',
                'description' => 'Logo, branding, UI/UX, ilustrasi, desain media sosial, dan kebutuhan visual lainnya.',
                'icon' => 'palette',
                'sort_order' => 2,
            ],
            [
                'name' => 'Web & Programming',
                'slug' => 'web-programming',
                'description' => 'Website, web application, mobile app, backend, frontend, dan programming.',
                'icon' => 'code',
                'sort_order' => 3,
            ],
            [
                'name' => 'Penulisan & Penerjemahan',
                'slug' => 'penulisan-penerjemahan',
                'description' => 'Artikel, copywriting, proofreading, penerjemahan, dan kebutuhan tulisan.',
                'icon' => 'pen-tool',
                'sort_order' => 4,
            ],
            [
                'name' => 'Video & Audio',
                'slug' => 'video-audio',
                'description' => 'Video editing, motion graphics, voice over, podcast, dan produksi audio visual.',
                'icon' => 'video',
                'sort_order' => 5,
            ],
            [
                'name' => 'Marketing',
                'slug' => 'marketing',
                'description' => 'Social media marketing, SEO, iklan digital, content marketing, dan strategi pemasaran.',
                'icon' => 'megaphone',
                'sort_order' => 6,
            ],
            [
                'name' => 'Bisnis & Konsultasi',
                'slug' => 'bisnis-konsultasi',
                'description' => 'Business consulting, finance, legal, strategy, HR, dan berbagai kebutuhan bisnis.',
                'icon' => 'briefcase',
                'sort_order' => 7,
            ],
            [
                'name' => 'Lifestyle',
                'slug' => 'lifestyle',
                'description' => 'Fotografi, event, travel, voice talent, gaming, dan kebutuhan gaya hidup.',
                'icon' => 'heart',
                'sort_order' => 8,
            ],
            [
                'name' => 'Learning & Development',
                'slug' => 'learning-development',
                'description' => 'Les, mentoring, training, konsultasi belajar, dan pengembangan kemampuan.',
                'icon' => 'book-open',
                'sort_order' => 9,
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }
    }
}