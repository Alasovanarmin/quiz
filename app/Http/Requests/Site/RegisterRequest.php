<?php

namespace App\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => "required|email|unique:site_users,email",
            'password' => "required",
            'photo' => "nullable|image|max:6000",
            'name' => "required|min:1|max:20",
            'surname' => "required|min:1|max:20",
        ];
    }
}
