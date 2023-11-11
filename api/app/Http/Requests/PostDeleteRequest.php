<?php

namespace App\Http\Requests;

use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Foundation\Http\FormRequest;

class PostDeleteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = $this->user();
        $postRepository = app()->make(PostRepositoryInterface::class);
        $postId = $this->route('postId');

        return $postRepository->postBelongsToUser($postId, $user['id']);
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
