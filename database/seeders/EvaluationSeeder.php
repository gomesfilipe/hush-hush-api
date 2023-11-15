<?php

namespace Database\Seeders;

use App\Models\Evaluation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EvaluationSeeder extends Seeder
{
    const COUNT_EVALUATIONS = 50;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Evaluation::factory()
            ->count(self::COUNT_EVALUATIONS)
            ->create();
    }
}
