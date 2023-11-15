<?php

namespace Database\Factories;

use App\Models\Evaluation;
use Database\Seeders\CommentSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evaluation>
 */
class EvaluationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $pairs = $this->generateArrayOfUniqueValues(
            range(1, UserSeeder::COUNT_USERS),
            range(1, CommentSeeder::COUNT_COMMENTS)
        );

        $pair = fake()->unique()->randomElement($pairs);
        $pair = explode(',', $pair);

        $userId = $pair[0];
        $commentId = $pair[1];

        return [
            'status' => fake()->randomElement(Evaluation::statusEvaluationValues()),
            'user_id' => $userId,
            'comment_id' => $commentId,
        ];
    }

    private function generateArrayOfUniqueValues(array $range1, array $range2): array
    {
        $uniques = [];

        foreach ($range1 as $i) {
            foreach ($range2 as $j) {
                $uniques[] = "$i,$j";
            }
        }

        return $uniques;
    }
}
