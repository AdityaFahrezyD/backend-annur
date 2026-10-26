<?php

namespace App\Http\Requests\Api\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SaveCurriculumRequest extends FormRequest
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
            'section' => ['required', 'in:pillar,level'],
            'code' => ['nullable', 'string', 'max:50'],
            'level' => ['nullable', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'features' => ['nullable', 'array'],
            'order' => ['integer'],
            'status' => ['required', 'in:draft,published'],
        ];
    }
}
