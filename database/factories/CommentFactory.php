<?php

namespace Database\Factories;

use Database\Seeders\PostSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
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
            'content' => fake()->text(),
            'created_at' => $date,
            'updated_at' => $date,
            'post_id' => rand(1, PostSeeder::COUNT_POSTS),
            'user_id' => rand(1, UserSeeder::COUNT_USERS),
        ];
    }
}
