<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BlogUpdateRequest extends FormRequest
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
        $id = $this->blog;
        return [
            'image' => ['nullable', 'image', 'max:5048'],
            'category' => ['required', 'integer'],
            'title' => ['nullable', 'max:255', 'unique:blogs,title,'. $id],
            'post' => ['required'],
            'seo_title' => ['nullable', 'max:255'],
            'seo_post' => ['nullable', 'max:255'],
            'status' => ['required', 'boolean']
        ];
    }
}
