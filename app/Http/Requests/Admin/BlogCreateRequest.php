<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BlogCreateRequest extends FormRequest
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
            'category' => ['required', 'integer'],
            'image' => ['required', 'image', 'max:5048'],
            'title' => ['required', 'max:255', 'unique:blogs,title'],
            'post' => ['required'],
            'seo_title' => ['nullable', 'max:255'],
            'seo_post' => ['nullable', 'max:255'],
            'status' => ['required', 'boolean']
        ];
    }
}
