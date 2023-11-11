<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    const COUNT_POSTS = 10;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory()
            ->count(self::COUNT_POSTS)
            ->create();
    }
}
