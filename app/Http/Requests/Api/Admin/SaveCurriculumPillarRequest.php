<?php

namespace App\Http\Requests\Api\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SaveCurriculumPillarRequest extends FormRequest
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
            'subtitle' => ['nullable', 'string', 'max:200'],
            'code' => ['nullable', 'string', 'max:50'],
            'description' => ['required', 'string'],
            'features' => ['nullable', 'array'],
            'order' => ['sometimes', 'integer', 'min:0'],
            'status' => ['required', 'in:draft,published'],
        ];
    }
}
