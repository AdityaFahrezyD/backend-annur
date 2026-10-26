<?php

namespace App\Http\Requests\Api\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSchoolProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /** @return array<string, ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:200'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'history' => ['nullable', 'string'],
            'vision_title' => ['nullable', 'string', 'max:150'],
            'vision' => ['nullable', 'array'],
            'vision.*' => ['string', 'max:1000'],
            'mission_title' => ['nullable', 'string', 'max:150'],
            'missions' => ['nullable', 'array'],
            'missions.*' => ['string', 'max:1000'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'whatsapp' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:100'],
            'maps_embed_url' => ['nullable', 'string', 'max:1000'],
            'facebook_url' => ['nullable', 'string', 'max:255'],
            'instagram_url' => ['nullable', 'string', 'max:255'],
            'youtube_url' => ['nullable', 'string', 'max:255'],
            'principal_name' => ['nullable', 'string', 'max:150'],
            'principal_title' => ['nullable', 'string', 'max:150'],
            'principal_message' => ['nullable', 'string'],
            'principal_education' => ['nullable', 'string', 'max:255'],
            'principal_experience' => ['nullable', 'string', 'max:255'],
            'principal_bio' => ['nullable', 'string'],
            'principal_photo' => ['nullable', 'string', 'max:1000'],
            'accreditation' => ['nullable', 'string', 'max:50'],
            'npsn' => ['nullable', 'string', 'max:50'],
            'stats' => ['nullable', 'array'],
            'public_sections' => ['nullable', 'array'],
            'public_sections.school_status' => ['nullable', 'string', 'max:100'],
            'public_sections.education_level' => ['nullable', 'string', 'max:100'],
            'public_sections.semester' => ['nullable', 'string', 'max:100'],
            'public_sections.utilities' => ['nullable', 'array'],
            'public_sections.utilities.*' => ['nullable', 'string', 'max:255'],
            'public_sections.location' => ['nullable', 'array'],
            'public_sections.location.coordinates' => ['nullable', 'string', 'max:100'],
            'public_sections.location.maps_url' => ['nullable', 'url', 'max:1000'],
            'public_sections.location.full_address' => ['nullable', 'string', 'max:255'],
            'public_sections.core_values' => ['nullable', 'array'],
            'public_sections.core_values.*.code' => ['nullable', 'string', 'max:50'],
            'public_sections.core_values.*.title' => ['required_with:public_sections.core_values', 'string', 'max:150'],
            'public_sections.core_values.*.desc' => ['nullable', 'string'],
            'public_sections.facilities' => ['nullable', 'array'],
            'public_sections.facilities.*.name' => ['required_with:public_sections.facilities', 'string', 'max:150'],
            'public_sections.facilities.*.capacity' => ['nullable', 'string', 'max:150'],
            'public_sections.facilities.*.description' => ['nullable', 'string'],
            'public_sections.history' => ['nullable', 'array'],
            'public_sections.history.founding_year' => ['nullable', 'string', 'max:10'],
            'public_sections.history.founding_date' => ['nullable', 'string', 'max:50'],
            'public_sections.history.milestones' => ['nullable', 'array'],
            'public_sections.history.milestones.*.badge' => ['nullable', 'string', 'max:100'],
            'public_sections.history.milestones.*.date' => ['nullable', 'string', 'max:50'],
            'public_sections.history.milestones.*.title' => ['required_with:public_sections.history.milestones', 'string', 'max:200'],
            'public_sections.history.milestones.*.desc' => ['nullable', 'string'],
            'public_sections.curriculum' => ['nullable', 'array'],
            'public_sections.curriculum.overview' => ['nullable', 'string'],
            'public_sections.curriculum.utilities' => ['nullable', 'array'],
            'public_sections.curriculum.utilities.*' => ['nullable', 'string', 'max:255'],
            'public_sections.curriculum.daily_schedule' => ['nullable', 'array'],
            'public_sections.curriculum.daily_schedule.*.time' => ['required_with:public_sections.curriculum.daily_schedule', 'string', 'max:50'],
            'public_sections.curriculum.daily_schedule.*.activity' => ['required_with:public_sections.curriculum.daily_schedule', 'string', 'max:255'],
            'public_sections.leadership' => ['nullable', 'array'],
            'public_sections.leadership.*.name' => ['required_with:public_sections.leadership', 'string', 'max:150'],
            'public_sections.leadership.*.role' => ['required_with:public_sections.leadership', 'string', 'max:150'],
            'public_sections.leadership.*.gender' => ['nullable', 'in:L,P'],
            'public_sections.leadership.*.education' => ['nullable', 'string', 'max:255'],
            'public_sections.leadership.*.experience' => ['nullable', 'string', 'max:255'],
            'public_sections.leadership.*.bio' => ['nullable', 'string'],
        ];
    }
}