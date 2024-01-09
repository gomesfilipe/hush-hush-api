<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    const COUNT_USERS = 10; // UserTest and more two users.

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Test User
        User::factory()
            ->testUser()
            ->verified()
            ->create();

        // Random Users
        User::factory()
            ->count(self::COUNT_USERS - 1)
            ->verified()
            ->create();
    }
}
