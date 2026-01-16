<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Basic Portfolio Template',
                'description' => 'A clean, 1-page site for freelancers.',
                'price' => 49.00,
                'type' => 'template'
            ],
            [
                'name' => 'E-commerce Starter',
                'description' => 'Full shop setup with product listings.',
                'price' => 199.00,
                'type' => 'template'
            ],
            [
                'name' => 'Custom SaaS Platform',
                'description' => 'Fully custom built software for your business.',
                'price' => 1500.00,
                'type' => 'custom'
            ],
        ];

        foreach ($services as $service) {
            \App\Models\Template::create($service);
        }
    }
}
