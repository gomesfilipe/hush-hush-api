<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    const COUNT_COMMENTS = 20;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Comment::factory()
            ->count(self::COUNT_COMMENTS)
            ->create();
    }
}
