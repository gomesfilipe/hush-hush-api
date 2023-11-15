<?php

namespace App\Repositories;

use App\Models\Evaluation;
use App\Repositories\Interfaces\EvaluationRepositoryInterface;
use Illuminate\Support\Facades\DB;

class EvaluationRepository implements EvaluationRepositoryInterface
{

    public function updateOrCreateEvaluation(array $attributes): void
    {
        $matchAttributes = collect($attributes)
            ->only(['user_id', 'comment_id'])
            ->toArray();

        $values = collect($attributes)
            ->only('status')
            ->toArray();

        Evaluation::query()
            ->updateOrCreate($matchAttributes, $values);
    }

    public function countLikesDislikesByCommentId(int $commentId): array
    {
        return Evaluation::query()
            ->select('status', DB::raw('count(*) as count'))
            ->where('comment_id', '=', $commentId)
            ->groupBy('status')
            ->get()
            ->toArray();
    }
}
