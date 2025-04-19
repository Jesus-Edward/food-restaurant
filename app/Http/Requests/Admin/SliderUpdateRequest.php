<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SliderUpdateRequest extends FormRequest
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
            'offer' => ['nullable', 'string', 'max:50'],
            'title' => ['required', 'string', 'max:200'],
            'sub_title' => ['required', 'string', 'max:200'],
            'short_description' => ['required', 'string', 'max:255'],
            'button_link' => ['nullable', 'string', 'max:200'],
            'status' => ['boolean']
        ];
    }
}
