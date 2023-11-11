<?php

namespace App\Http\Requests;

use App\Repositories\Interfaces\CommentRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;

class CommentDeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        $commentRepository = app()->make(CommentRepositoryInterface::class);
        $commentId = $this->route('commentId');

        return $commentRepository->commentBelongsToUser($commentId, $user['id']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
        ];
    }
}
