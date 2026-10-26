<?php

namespace App\Http\Requests\Api\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SaveCompetitionRequest extends FormRequest
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
            'organizer' => ['required', 'string', 'max:150'],
            'category' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'registration_deadline' => ['nullable', 'date'],
            'event_date' => ['nullable', 'date'],
            'location' => ['nullable', 'string', 'max:200'],
            'guide_book_url' => ['nullable', 'string'],
            'banner_image' => ['nullable', 'string'],
            'is_featured' => ['boolean'],
            'status' => ['required', 'in:draft,published'],
        ];
    }
}
