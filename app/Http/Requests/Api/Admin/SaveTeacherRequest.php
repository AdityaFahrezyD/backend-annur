<?php

namespace App\Http\Requests\Api\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SaveTeacherRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:150'],
            'nip' => ['nullable', 'string', 'max:50'],
            'subject' => ['required', 'string', 'max:100'],
            'role_title' => ['nullable', 'string', 'max:100'],
            'education' => ['nullable', 'string', 'max:150'],
            'photo' => ['nullable', 'string'],
            'bio' => ['nullable', 'string'],
            'is_active' => ['boolean'],
            'order' => ['integer'],
        ];
    }
}
