<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdatePassword extends FormRequest
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
        return [
            'avatar' => ['nullable', 'image', 'image:5048'],
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:5'],
        ];
    }

    public function messages(): array{
        return [
            'current_password.current_password' => 'Current Password is invalid!',
        ];
    }
}
