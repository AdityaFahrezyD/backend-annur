<?php

namespace App\Http\Requests\Api\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSchoolProfileRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:200'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'history' => ['nullable', 'string'],
            'vision' => ['nullable', 'string'],
            'missions' => ['nullable', 'array'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'whatsapp' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:100'],
            'maps_embed_url' => ['nullable', 'string'],
            'facebook_url' => ['nullable', 'string', 'max:255'],
            'instagram_url' => ['nullable', 'string', 'max:255'],
            'youtube_url' => ['nullable', 'string', 'max:255'],
            'principal_name' => ['nullable', 'string', 'max:150'],
            'principal_title' => ['nullable', 'string', 'max:150'],
            'principal_message' => ['nullable', 'string'],
            'principal_photo' => ['nullable', 'string'],
            'accreditation' => ['nullable', 'string', 'max:50'],
            'npsn' => ['nullable', 'string', 'max:50'],
            'stats' => ['nullable', 'array'],
        ];
    }
}
