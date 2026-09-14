<?php

namespace Database\Seeders;

use App\Models\FreelancerProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FreelancerSeeder extends Seeder
{
    public function run(): void
    {
        $freelancers = [
            [
                'name' => 'Ardi Pratama',
                'email' => 'ardi@example.com',
                'username' => 'ardidesign',
                'headline' => 'Graphic Designer & Brand Specialist',
                'bio' => 'Membantu bisnis membangun identitas visual yang profesional melalui desain logo, branding, dan kebutuhan visual lainnya.',
                'location' => 'Bandung, Jawa Barat',
                'rating' => 4.90,
                'completed_orders' => 128,
                'is_available' => true,
                'is_verified' => true,
            ],
            [
                'name' => 'Dimas Wijaya',
                'email' => 'dimas@example.com',
                'username' => 'devstudio',
                'headline' => 'Full Stack Web Developer',
                'bio' => 'Spesialis pengembangan website dan aplikasi web menggunakan teknologi modern untuk kebutuhan bisnis.',
                'location' => 'Jakarta, Indonesia',
                'rating' => 5.00,
                'completed_orders' => 96,
                'is_available' => true,
                'is_verified' => true,
            ],
            [
                'name' => 'Nadia Putri',
                'email' => 'nadia@example.com',
                'username' => 'nadiacreative',
                'headline' => 'Content Writer & SEO Specialist',
                'bio' => 'Menulis konten informatif dan SEO-friendly untuk membantu brand meningkatkan jangkauan digital.',
                'location' => 'Yogyakarta, Indonesia',
                'rating' => 4.80,
                'completed_orders' => 74,
                'is_available' => true,
                'is_verified' => true,
            ],
            [
                'name' => 'Raka Visual',
                'email' => 'raka@example.com',
                'username' => 'rakavisual',
                'headline' => 'Video Editor & Motion Designer',
                'bio' => 'Mengerjakan video editing, motion graphic, short-form content, dan kebutuhan visual untuk bisnis maupun creator.',
                'location' => 'Surabaya, Jawa Timur',
                'rating' => 4.90,
                'completed_orders' => 83,
                'is_available' => true,
                'is_verified' => true,
            ],
            [
                'name' => 'Salsa Marketing',
                'email' => 'salsa@example.com',
                'username' => 'salsamarketing',
                'headline' => 'Digital Marketing Specialist',
                'bio' => 'Membantu brand mengembangkan strategi marketing digital, social media, dan campaign.',
                'location' => 'Semarang, Jawa Tengah',
                'rating' => 4.70,
                'completed_orders' => 61,
                'is_available' => true,
                'is_verified' => false,
            ],
        ];

        foreach ($freelancers as $freelancer) {

            $user = User::updateOrCreate(
                [
                    'email' => $freelancer['email'],
                ],
                [
                    'name' => $freelancer['name'],
                    'role' => 'freelancer',
                    'password' => Hash::make('password'),
                ]
            );

            FreelancerProfile::updateOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'username' => $freelancer['username'],
                    'headline' => $freelancer['headline'],
                    'bio' => $freelancer['bio'],
                    'location' => $freelancer['location'],
                    'rating' => $freelancer['rating'],
                    'completed_orders' => $freelancer['completed_orders'],
                    'is_available' => $freelancer['is_available'],
                    'is_verified' => $freelancer['is_verified'],
                ]
            );
        }
    }
}