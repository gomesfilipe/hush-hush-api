<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userNameRegex = User::USERNAME_REGEX;

        return [
            'username' => ['required', 'string', 'min:1', "regex:$userNameRegex"],
            'password' => ['required', 'string', 'min:8'],
            'repeat_password' => ['required', 'string', 'same:password'],
        ];
    }
}
