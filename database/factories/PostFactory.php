<?php

namespace Database\Factories;

use Database\Seeders\UserSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $date = fake()
            ->dateTimeBetween('-30 days')
            ->format('Y-m-d H:i:s');

        return [
            'title' => fake()->words(3, true),
            'content' => fake()->text(),
            'created_at' => $date,
            'updated_at' => $date,
//            'is_active' => fake()->boolean(70),
            'is_active' => true,
            'user_id' => rand(1, UserSeeder::COUNT_USERS),
        ];
    }
}
