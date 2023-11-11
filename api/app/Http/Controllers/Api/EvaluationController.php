<?php

namespace App\Http\Controllers\Api;

use App\Enums\EvaluationStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEvaluationRequest;
use App\Http\Requests\UpdateEvaluationRequest;
use App\Models\Evaluation;
use App\Repositories\Interfaces\EvaluationRepositoryInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EvaluationController extends Controller
{
    public function __construct(private readonly EvaluationRepositoryInterface $evaluationRepository)
    {

    }

    /**
     * Display a listing of the resource.
     */
    public function setLike(Request $request, int $commentId): Response
    {
        $user = $request->user();

        $attributes = [
            'user_id' => $user['id'],
            'comment_id' => $commentId,
            'status' => EvaluationStatusEnum::LIKE,
        ];

        $this->evaluationRepository->updateOrCreateEvaluation($attributes);

        return response()->noContent();
    }

    public function setDisLike(Request $request, int $commentId): Response
    {
        $user = $request->user();

        $attributes = [
            'user_id' => $user['id'],
            'comment_id' => $commentId,
            'status' => EvaluationStatusEnum::DISLIKE,
        ];

        $this->evaluationRepository->updateOrCreateEvaluation($attributes);

        return response()->noContent();
    }

    public function setNone(Request $request, int $commentId): Response
    {
        $user = $request->user();

        $attributes = [
            'user_id' => $user['id'],
            'comment_id' => $commentId,
            'status' => EvaluationStatusEnum::NONE,
        ];

        $this->evaluationRepository->updateOrCreateEvaluation($attributes);

        return response()->noContent();
    }
}
