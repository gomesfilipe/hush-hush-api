<?php

namespace App\Http\Requests;

use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;

class CommentUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        $commentId = $this->route('commentId');
        $commentRepository = app()->make(CommentRepositoryInterface::class);
        return $commentRepository->commentBelongsToUser($commentId, $user['id']) && $commentRepository->commentIsInActivePost($commentId);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'content' => ['required', 'string'],
        ];
    }
}
