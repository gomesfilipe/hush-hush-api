<?php

namespace App\Repositories\Interfaces;

interface EvaluationRepositoryInterface
{
    public function updateOrCreateEvaluation(array $attributes): void;
}
