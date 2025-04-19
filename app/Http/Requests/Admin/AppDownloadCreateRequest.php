<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AppDownloadCreateRequest extends FormRequest
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
            'image' => ['nullable', 'image', 'max:5048'],
            'background' => ['nullable', 'image', 'max:5048'],
            'title' => ['required', 'max:255'],
            'short_description' => ['required', 'max:1000'],
            'play_store_link' => ['nullable', 'url', 'max:255'],
            'app_store_link' => ['nullable', 'url', 'max:255']
        ];
    }
}
