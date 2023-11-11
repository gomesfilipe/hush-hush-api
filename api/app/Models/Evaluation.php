<?php

namespace App\Models;

use \App\Enums\EvaluationStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
class Evaluation extends Model
{
    use HasFactory;

    public static function statusEvaluationValues(): array
    {
        return EvaluationStatusEnum::values();
    }

    protected $fillable = [
        'status',
        'user_id',
        'comment_id',
    ];

    protected $casts = [
        'status' => EvaluationStatusEnum::class,
    ];

    public $timestamps = false;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comment(): BelongsTo
    {
        return $this->belongsTo(Comment::class);
    }
}
