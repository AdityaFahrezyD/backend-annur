<?php

namespace App\Http\Requests\Api\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SaveExtracurricularRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:200'],
            'description' => ['nullable', 'string'],
            'order' => ['sometimes', 'integer', 'min:0'],
            'status' => ['required', 'in:draft,published'],
            'images' => ['sometimes', 'nullable', 'array'],
            'images.*.path' => ['required', 'string', 'max:2048'],
            'images.*.alt_text' => ['nullable', 'string', 'max:255'],
            'images.*.order' => ['sometimes', 'integer', 'min:0'],
        ];
    }
}
