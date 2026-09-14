<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;

class SubcategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'ai-automation' => [
                ['name' => 'AI Chatbot', 'slug' => 'ai-chatbot'],
                ['name' => 'AI Content', 'slug' => 'ai-content'],
                ['name' => 'Prompt Engineering', 'slug' => 'prompt-engineering'],
                ['name' => 'Automation', 'slug' => 'automation'],
                ['name' => 'AI Integration', 'slug' => 'ai-integration'],
            ],

            'grafis-desain' => [
                ['name' => 'Logo & Branding', 'slug' => 'logo-branding'],
                ['name' => 'UI/UX Design', 'slug' => 'ui-ux-design'],
                ['name' => 'Social Media Design', 'slug' => 'social-media-design'],
                ['name' => 'Illustration', 'slug' => 'illustration'],
                ['name' => 'Presentation Design', 'slug' => 'presentation-design'],
            ],

            'web-programming' => [
                ['name' => 'Website Development', 'slug' => 'website-development'],
                ['name' => 'Web Application', 'slug' => 'web-application'],
                ['name' => 'Mobile App', 'slug' => 'mobile-app'],
                ['name' => 'Frontend Development', 'slug' => 'frontend-development'],
                ['name' => 'Backend Development', 'slug' => 'backend-development'],
                ['name' => 'Bug Fixing', 'slug' => 'bug-fixing'],
            ],

            'penulisan-penerjemahan' => [
                ['name' => 'Article Writing', 'slug' => 'article-writing'],
                ['name' => 'Copywriting', 'slug' => 'copywriting'],
                ['name' => 'SEO Writing', 'slug' => 'seo-writing'],
                ['name' => 'Translation', 'slug' => 'translation'],
                ['name' => 'Proofreading', 'slug' => 'proofreading'],
            ],

            'video-audio' => [
                ['name' => 'Video Editing', 'slug' => 'video-editing'],
                ['name' => 'Motion Graphics', 'slug' => 'motion-graphics'],
                ['name' => 'Voice Over', 'slug' => 'voice-over'],
                ['name' => 'Podcast Production', 'slug' => 'podcast-production'],
                ['name' => 'Audio Editing', 'slug' => 'audio-editing'],
            ],

            'marketing' => [
                ['name' => 'Social Media Marketing', 'slug' => 'social-media-marketing'],
                ['name' => 'SEO', 'slug' => 'seo'],
                ['name' => 'Digital Advertising', 'slug' => 'digital-advertising'],
                ['name' => 'Content Marketing', 'slug' => 'content-marketing'],
                ['name' => 'Influencer Marketing', 'slug' => 'influencer-marketing'],
            ],

            'bisnis-konsultasi' => [
                ['name' => 'Business Consulting', 'slug' => 'business-consulting'],
                ['name' => 'Finance', 'slug' => 'finance'],
                ['name' => 'Human Resources', 'slug' => 'human-resources'],
                ['name' => 'Legal Consulting', 'slug' => 'legal-consulting'],
                ['name' => 'Business Strategy', 'slug' => 'business-strategy'],
            ],

            'lifestyle' => [
                ['name' => 'Photography', 'slug' => 'photography'],
                ['name' => 'Event', 'slug' => 'event'],
                ['name' => 'Travel', 'slug' => 'travel'],
                ['name' => 'Gaming', 'slug' => 'gaming'],
                ['name' => 'Voice Talent', 'slug' => 'voice-talent'],
            ],

            'learning-development' => [
                ['name' => 'Private Tutoring', 'slug' => 'private-tutoring'],
                ['name' => 'Mentoring', 'slug' => 'mentoring'],
                ['name' => 'Training', 'slug' => 'training'],
                ['name' => 'Career Development', 'slug' => 'career-development'],
                ['name' => 'Skill Development', 'slug' => 'skill-development'],
            ],
        ];

        foreach ($categories as $categorySlug => $subcategories) {

            $category = Category::where('slug', $categorySlug)->first();

            if (! $category) {
                continue;
            }

            foreach ($subcategories as $index => $subcategory) {
                Subcategory::updateOrCreate(
                    [
                        'category_id' => $category->id,
                        'slug' => $subcategory['slug'],
                    ],
                    [
                        'name' => $subcategory['name'],
                        'description' => null,
                        'is_active' => true,
                        'sort_order' => $index + 1,
                    ]
                );
            }
        }
    }
}