<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Template;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create the Admin first so you can log back in!
        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'System Admin',
                'password' => bcrypt('widanaArdiNingrat'), // Change this later!
                'role' => 'admin'
            ]
        );

        // 2. Create Services
        $services = [
            ['name' => 'E-Commerce Site', 'price' => 1200, 'type' => 'custom', 'image' => 'templates/ecommerce.jpg', 'description' => 'Full online store setup.'],
            ['name' => 'Portfolio Page', 'price' => 300, 'type' => 'template', 'image' => 'templates/portfolio.jpg', 'description' => 'Clean 1-page site.'],
            ['name' => 'Blog System', 'price' => 450, 'type' => 'template', 'image' => 'templates/blog.jpg', 'description' => 'WordPress-style blog.'],
        ];

        foreach ($services as $service) {
            Template::create($service);
        }

        $allTemplates = Template::all();

        // 3. Create Dummy Customers
        $users = User::factory(10)->create();

        // 4. Create 50 Orders spread over the last 6 months
        for ($i = 0; $i < 50; $i++) {
            $status = ['pending', 'processing', 'completed'][rand(0, 2)];
            $template = $allTemplates->random();

            // Random date within the last 6 months
            $randomDate = now()->subDays(rand(1, 180));

            Order::create([
                'user_id' => $users->random()->id,
                'template_id' => $template->id,
                'notes' => 'Sample requirements for ' . $template->name,
                'status' => $status,
                'delivery_link' => ($status == 'completed') ? 'https://google.com' : null,
                'created_at' => $randomDate,
                'updated_at' => $randomDate,
            ]);
        }
    }
}
