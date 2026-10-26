<?php

namespace App\Http\Requests\Api\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContactStatusRequest extends FormRequest
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
            'crm_status' => ['required', 'in:new,contacted,in_progress,resolved,closed'],
            'priority' => ['nullable', 'in:low,normal,high,urgent'],
            'handled_by' => ['nullable', 'exists:users,id'],
        ];
    }
}
