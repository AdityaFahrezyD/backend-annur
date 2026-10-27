<?php

namespace App\Http\Requests\Api\Admin;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SaveHeroSlideRequest extends FormRequest
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
            'image' => ['required', 'string', 'max:2048'],
            'heading' => ['required', 'string', 'max:255'],
            'subheading' => ['required', 'string', 'max:255'],
            'caption' => ['required', 'string'],
            'button_label' => ['nullable', 'required_with:button_url', 'string', 'max:100'],
            'button_url' => [
                'nullable',
                'required_with:button_label',
                'string',
                'max:2048',
                function (string $attribute, mixed $value, Closure $fail): void {
                    if (! is_string($value) || ! $this->isAllowedButtonUrl($value)) {
                        $fail('URL tombol harus berupa path internal atau tautan HTTP(S).');
                    }
                },
            ],
            'order' => ['sometimes', 'integer', 'min:0'],
            'status' => ['required', 'in:draft,published'],
        ];
    }

    private function isAllowedButtonUrl(string $url): bool
    {
        if (str_starts_with($url, '/') && ! str_starts_with($url, '//')) {
            return true;
        }

        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            return false;
        }

        $scheme = parse_url($url, PHP_URL_SCHEME);

        return is_string($scheme) && in_array(strtolower($scheme), ['http', 'https'], true);
    }
}
