<?php

namespace App\Services\Api\Admin;

use App\Models\SchoolProfile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SchoolProfileService
{
    public function show(): SchoolProfile
    {
        $profile = SchoolProfile::query()->firstOrCreate([], [
            'name' => 'SMA Islam Terpadu An-Nur',
            'tagline' => 'Membentuk Generasi Berakhlak Mulia, Cerdas, dan Berprestasi Global',
        ]);

        return $profile->load(['currentPrincipal', 'principalHistory']);
    }

    /** @param array<string, mixed> $data */
    public function update(array $data): SchoolProfile
    {
        return DB::transaction(function () use ($data): SchoolProfile {
            $profile = SchoolProfile::query()->firstOrCreate([]);
            $profile->update(Arr::except($data, [
                'principal_name',
                'principal_title',
                'principal_message',
                'principal_photo',
            ]));

            $this->syncPrincipal($profile, $data);

            return $profile->load(['currentPrincipal', 'principalHistory']);
        });
    }

    /** @param array<string, mixed> $data */
    private function syncPrincipal(SchoolProfile $profile, array $data): void
    {
        $principalData = Arr::only($data, [
            'principal_title',
            'principal_message',
            'principal_photo',
        ]);
        $currentPrincipal = $profile->principalHistory()->where('is_current', true)->first();

        if (! array_key_exists('principal_name', $data)) {
            if ($principalData !== []) {
                $currentPrincipal?->update($principalData);
            }

            return;
        }

        $name = $data['principal_name'];

        if ($name === null || trim($name) === '') {
            $currentPrincipal?->update([
                'is_current' => false,
                'ended_at' => now()->toDateString(),
            ]);

            return;
        }

        if ($currentPrincipal?->name === $name) {
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
            'name' => $name,
            ...$principalData,
            'started_at' => now()->toDateString(),
            'is_current' => true,
        ]);
    }
}
