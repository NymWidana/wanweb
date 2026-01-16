<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Pool of 20 made-up users
        static $users = [
            ['name' => 'Ayu Pratama', 'email' => 'ayu.pratama@example.com'],
            ['name' => 'Made Santika', 'email' => 'made.santika@example.com'],
            ['name' => 'Kadek Wirawan', 'email' => 'kadek.wirawan@example.com'],
            ['name' => 'Komang Dewi', 'email' => 'komang.dewi@example.com'],
            ['name' => 'Nyoman Surya', 'email' => 'nyoman.surya@example.com'],
            ['name' => 'Wayan Putri', 'email' => 'wayan.putri@example.com'],
            ['name' => 'Ketut Adi', 'email' => 'ketut.adi@example.com'],
            ['name' => 'Rina Lestari', 'email' => 'rina.lestari@example.com'],
            ['name' => 'Budi Hartono', 'email' => 'budi.hartono@example.com'],
            ['name' => 'Sari Utami', 'email' => 'sari.utami@example.com'],
            ['name' => 'Agus Prabowo', 'email' => 'agus.prabowo@example.com'],
            ['name' => 'Dewi Kartika', 'email' => 'dewi.kartika@example.com'],
            ['name' => 'Rizky Ananda', 'email' => 'rizky.ananda@example.com'],
            ['name' => 'Putu Mahendra', 'email' => 'putu.mahendra@example.com'],
            ['name' => 'Luh Ayu', 'email' => 'luh.ayu@example.com'],
            ['name' => 'Gede Wiratma', 'email' => 'gede.wiratma@example.com'],
            ['name' => 'Cahya Permata', 'email' => 'cahya.permata@example.com'],
            ['name' => 'Darmawan Hadi', 'email' => 'darmawan.hadi@example.com'],
            ['name' => 'Intan Sari', 'email' => 'intan.sari@example.com'],
            ['name' => 'Yoga Prasetyo', 'email' => 'yoga.prasetyo@example.com'],
        ];

        // Pick one user from the pool based on a rotating index
        static $index = 0;
        $user = $users[$index % count($users)];
        $index++;

        return [
            'name' => $user['name'],
            // Ensure uniqueness by appending a random string to the base email
            'email' => $user['email'] . '+' . Str::random(5),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
