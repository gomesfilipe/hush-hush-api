<?php

namespace App\Http\Requests;

use App\Repositories\Interfaces\PostRepositoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Http\FormRequest;

class PostUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @throws BindingResolutionException
     */
    public function authorize(): bool
    {
        $user = $this->user();
        $postId = $this->route('postId');
        $postRepository = app()->make(PostRepositoryInterface::class);

        return $postRepository->postBelongsToUser($postId, $user['id']) && $postRepository->isActivePost($postId);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string'],
            'content' => ['sometimes', 'string'],
        ];
    }
}
