<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\Section;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CmsSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        if (!User::query()->where('email', 'admin@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
            ]);
        }

        // Settings
        Setting::updateOrCreate(['key' => 'site'], [
            'value' => [
                'name' => 'Nexitel',
                'logo' => null,
                'primary_color' => '#0ea5e9',
            ],
        ]);

        // Menus
        $header = Menu::updateOrCreate(['location' => 'header'], [
            'name' => 'Header Menu',
            'is_active' => true,
        ]);
        $footer = Menu::updateOrCreate(['location' => 'footer'], [
            'name' => 'Footer Menu',
            'is_active' => true,
        ]);

        // Pages
        $home = Page::updateOrCreate(['slug' => 'home'], [
            'title' => 'Experience Better Connectivity',
            'meta_title' => 'Nexitel - Better Connectivity',
            'meta_description' => 'Fast, reliable connectivity and communication services.',
            'is_published' => true,
            'published_at' => now(),
        ]);

        // Sections for homepage
        $sections = [
            [
                'type' => 'hero',
                'sort_order' => 1,
                'content' => [
                    'eyebrow' => 'Nexitel',
                    'title' => 'Experience Better Connectivity',
                    'subtitle' => 'Affordable, reliable, and fast communication services.',
                    'primary_cta' => ['label' => 'Get Started', 'url' => '/contact'],
                    'secondary_cta' => ['label' => 'View Plans', 'url' => '/pricing'],
                    'image' => null,
                ],
            ],
            [
                'type' => 'features',
                'sort_order' => 2,
                'content' => [
                    'items' => [
                        ['icon' => '⚡', 'title' => 'Fast Setup', 'text' => 'Get connected quickly with minimal downtime.'],
                        ['icon' => '🛡️', 'title' => 'Secure', 'text' => 'Enterprise-grade security baked in.'],
                        ['icon' => '📶', 'title' => 'Reliable', 'text' => 'Uptime and coverage you can count on.'],
                    ],
                ],
            ],
            [
                'type' => 'pricing',
                'sort_order' => 3,
                'content' => [
                    'plans' => [
                        ['name' => 'Starter', 'price' => '9', 'period' => 'mo', 'features' => ['100 mins', '1 GB data', 'Basic support']],
                        ['name' => 'Standard', 'price' => '19', 'period' => 'mo', 'features' => ['500 mins', '10 GB data', 'Priority support']],
                        ['name' => 'Pro', 'price' => '29', 'period' => 'mo', 'features' => ['Unlimited mins', 'Unlimited data', '24/7 support']],
                    ],
                    'note' => 'Prices shown are examples; customize via admin.',
                ],
            ],
            [
                'type' => 'testimonials',
                'sort_order' => 4,
                'content' => [
                    'items' => [
                        ['quote' => 'Exceptional service and speed.', 'author' => 'Alex'],
                        ['quote' => 'Switched from our old provider—best decision ever.', 'author' => 'Jordan'],
                    ],
                ],
            ],
            [
                'type' => 'contact',
                'sort_order' => 5,
                'content' => [
                    'title' => 'Speak to our team',
                    'subtitle' => 'We’ll help you choose the right plan.',
                    'email' => 'sales@nexitel.org',
                    'phone' => '+1 (555) 123-4567',
                    'address' => '123 Connectivity Way',
                ],
            ],
        ];

        foreach ($sections as $i => $data) {
            Section::updateOrCreate([
                'page_id' => $home->id,
                'type' => $data['type'],
            ], [
                'sort_order' => $data['sort_order'] ?? ($i + 1),
                'content' => $data['content'] ?? [],
            ]);
        }

        // Menu items
        MenuItem::updateOrCreate(['menu_id' => $header->id, 'label' => 'Home'], [
            'url' => '/', 'sort_order' => 1,
        ]);
        MenuItem::updateOrCreate(['menu_id' => $header->id, 'label' => 'Pricing'], [
            'url' => '/pricing', 'sort_order' => 2,
        ]);
        MenuItem::updateOrCreate(['menu_id' => $header->id, 'label' => 'Contact'], [
            'url' => '/contact', 'sort_order' => 3,
        ]);

        MenuItem::updateOrCreate(['menu_id' => $footer->id, 'label' => 'Privacy'], [
            'url' => '/privacy', 'sort_order' => 1,
        ]);
        MenuItem::updateOrCreate(['menu_id' => $footer->id, 'label' => 'Terms'], [
            'url' => '/terms', 'sort_order' => 2,
        ]);
    }
}