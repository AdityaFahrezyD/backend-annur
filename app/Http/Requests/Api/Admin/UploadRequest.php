<?php

namespace App\Http\Requests\Api\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
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
            'file' => ['required', 'file', 'mimes:jpeg,png,jpg,webp,avif,gif,pdf', 'max:5120'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'file.required' => 'Berkas belum dipilih.',
            'file.mimes' => 'Format berkas hanya boleh berupa JPG, PNG, WEBP, AVIF, GIF, atau PDF.',
            'file.max' => 'Ukuran berkas maksimal adalah 5MB.',
        ];
    }
}
