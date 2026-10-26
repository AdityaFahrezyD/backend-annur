<?php

namespace App\Services\Api\Admin;

use App\Models\SchoolProfile;
use App\Models\Teacher;
use App\Services\Api\PublicApiCache;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SchoolProfileService
{
    public function __construct(private PublicApiCache $publicApiCache) {}

    public function show(): SchoolProfile
    {
        $profile = SchoolProfile::query()->firstOrCreate([], [
            'name' => 'SD Plus An-Nur',
            'tagline' => 'Membentuk Generasi Berakhlak Mulia, Cerdas, dan Berprestasi Global',
        ]);

        if ($profile->wasRecentlyCreated) {
            $this->publicApiCache->invalidate('profile', 'stats');
        }

        return $profile->load(['currentPrincipal.teacher', 'principalHistory.teacher']);
    }

    /** @param array<string, mixed> $data */
    public function update(array $data): SchoolProfile
    {
        $profile = DB::transaction(function () use ($data): SchoolProfile {
            $profile = SchoolProfile::query()->firstOrCreate([]);
            $profile->update(Arr::except($data, [
                'principal_name',
                'principal_title',
                'principal_message',
                'principal_education',
                'principal_experience',
                'principal_bio',
                'principal_photo',
            ]));

            $this->syncPrincipal($profile, $data);

            return $profile->load(['currentPrincipal.teacher', 'principalHistory.teacher']);
        });

        $this->publicApiCache->invalidate('profile', 'stats');

        return $profile;
    }

    /** @param array<string, mixed> $data */
    private function syncPrincipal(SchoolProfile $profile, array $data): void
    {
        $teacherData = [];
        foreach ([
            'principal_education' => 'education',
            'principal_experience' => 'experience',
            'principal_bio' => 'bio',
            'principal_photo' => 'photo',
        ] as $input => $column) {
            if (array_key_exists($input, $data)) {
                $teacherData[$column] = $data[$input];
            }
        }

        $principalData = [];
        foreach ([
            'principal_title' => 'title',
            'principal_message' => 'message',
        ] as $input => $column) {
            if (array_key_exists($input, $data)) {
                $principalData[$column] = $data[$input];
            }
        }

        $currentPrincipal = $profile->principalHistory()
            ->with('teacher')
            ->where('is_current', true)
            ->orderByDesc('started_at')
            ->lockForUpdate()
            ->first();

        if (! array_key_exists('principal_name', $data)) {
            if ($teacherData !== []) {
                $currentPrincipal?->teacher?->update($teacherData);
            }
            if ($principalData !== []) {
                $currentPrincipal?->update($principalData);
            }

            return;
        }

        $name = is_string($data['principal_name']) ? trim($data['principal_name']) : '';

        if ($name === '') {
            $currentPrincipal?->update([
                'is_current' => false,
                'ended_at' => now()->toDateString(),
            ]);

            return;
        }

        $matchingTeachers = Teacher::query()
            ->where('name', $name)
            ->limit(2)
            ->get();

        if ($matchingTeachers->count() !== 1) {
            throw ValidationException::withMessages([
                'principal_name' => $matchingTeachers->isEmpty()
                    ? 'Nama kepala sekolah harus cocok dengan satu data Teacher yang sudah ada.'
                    : 'Nama kepala sekolah cocok dengan lebih dari satu data Teacher; rapikan data nama yang duplikat.',
            ]);
        }

        $teacher = $matchingTeachers->first();
        if ($teacherData !== []) {
            $teacher->update($teacherData);
        }

        if ($currentPrincipal?->teacher_id === $teacher->id) {
            if ($principalData !== []) {
                $currentPrincipal->update($principalData);
            }

            return;
        }

        $currentPrincipal?->update([
            'is_current' => false,
            'ended_at' => now()->toDateString(),
        ]);

        $profile->principalHistory()->create([
            'teacher_id' => $teacher->id,
            ...$principalData,
            'started_at' => now()->toDateString(),
            'is_current' => true,
        ]);
    }
}
