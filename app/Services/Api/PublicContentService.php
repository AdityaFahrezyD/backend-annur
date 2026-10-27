<?php

namespace App\Services\Api;

use App\Models\Achievement;
use App\Models\Competition;
use App\Models\ContactMessage;
use App\Models\CurriculumPillar;
use App\Models\Gallery;
use App\Models\HeroSlide;
use App\Models\Phase;
use App\Models\SchoolProfile;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;

class PublicContentService
{
    public function profile(): ?SchoolProfile
    {
        return SchoolProfile::query()->with(['currentPrincipal.teacher', 'principalHistory.teacher'])->first();
    }

    /** @param array<string, mixed> $filters */
    public function teachers(array $filters): Collection
    {
        $query = Teacher::query()
            ->where('is_active', true)
            ->orderBy('order')
            ->orderBy('id');

        if (($filters['search'] ?? null) !== null && $filters['search'] !== '') {
            $search = $filters['search'];

            $query->where(function ($query) use ($search): void {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('role_title', 'like', "%{$search}%");
            });
        }

        if (($filters['subject'] ?? null) !== null && $filters['subject'] !== '') {
            $query->where('subject', 'like', "%{$filters['subject']}%");
        }

        return $query->get();
    }

    /** @param array<string, mixed> $filters */
    public function achievements(array $filters): Collection
    {
        $query = Achievement::query()
            ->where('status', 'published')
            ->orderByDesc('year')
            ->orderByDesc('id');

        if (($filters['category'] ?? null) !== null && $filters['category'] !== '' && $filters['category'] !== 'Semua') {
            $query->where('category', $filters['category']);
        }

        if (($filters['year'] ?? null) !== null && $filters['year'] !== '') {
            $query->where('year', $filters['year']);
        }

        if (($filters['search'] ?? null) !== null && $filters['search'] !== '') {
            $search = $filters['search'];

            $query->where(function ($query) use ($search): void {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('recipient_name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        return $query->get();
    }

    /** @param array<string, mixed> $filters */
    public function competitions(array $filters): Collection
    {
        $query = Competition::query()
            ->where('status', 'published')
            ->orderBy('event_date');

        if (($filters['category'] ?? null) !== null && $filters['category'] !== '' && $filters['category'] !== 'Semua') {
            $query->where('category', $filters['category']);
        }

        return $query->get();
    }

    public function curriculumPillars(): Collection
    {
        return CurriculumPillar::query()
            ->where('status', 'published')
            ->orderBy('order')
            ->orderBy('id')
            ->get();
    }

    public function phases(): Collection
    {
        return Phase::query()
            ->where('status', 'published')
            ->orderBy('order')
            ->orderBy('id')
            ->get();
    }

    public function heroSlides(): Collection
    {
        return HeroSlide::query()
            ->where('status', 'published')
            ->orderBy('order')
            ->orderBy('id')
            ->get();
    }

    public function curriculums(): SupportCollection
    {
        $pillars = $this->curriculumPillars()->map(fn (CurriculumPillar $pillar): array => [
            'id' => $pillar->id,
            'title' => $pillar->title,
            'section' => 'pillar',
            'code' => $pillar->code,
            'level' => $pillar->subtitle,
            'description' => $pillar->description,
            'features' => $pillar->features,
            'order' => $pillar->order,
            'status' => $pillar->status,
            'created_at' => $pillar->created_at,
            'updated_at' => $pillar->updated_at,
        ]);

        $phases = $this->phases()->map(fn (Phase $phase): array => [
            'id' => $phase->id,
            'title' => $phase->title,
            'section' => 'level',
            'code' => $phase->code,
            'level' => $phase->phase_name,
            'description' => $phase->description,
            'features' => $phase->features,
            'order' => $phase->order,
            'status' => $phase->status,
            'created_at' => $phase->created_at,
            'updated_at' => $phase->updated_at,
        ]);

        return collect($pillars->all())
            ->concat($phases->all())
            ->sort(fn (array $left, array $right): int => [$left['order'], $left['id']] <=> [$right['order'], $right['id']])
            ->values();
    }

    /** @param array<string, mixed> $filters */
    public function galleries(array $filters): Collection
    {
        $query = Gallery::query()
            ->where('status', 'published')
            ->orderByDesc('event_date')
            ->orderByDesc('id');

        if (($filters['category'] ?? null) !== null && $filters['category'] !== '' && $filters['category'] !== 'Semua') {
            $query->where('category', $filters['category']);
        }

        return $query->get();
    }

    /** @param array<string, mixed> $data */
    public function submitContact(array $data, ?string $ipAddress): ContactMessage
    {
        return ContactMessage::query()->create([
            'visitor_name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'subject' => $data['subject'],
            'message' => $data['message'],
            'ip_address' => $ipAddress,
            'crm_status' => 'new',
            'priority' => 'normal',
        ]);
    }

    /** @return array{total_teachers: int, total_achievements: int, total_competitions: int, total_galleries: int, custom_stats: array|null} */
    public function stats(): array
    {
        $profile = SchoolProfile::query()->first();

        return [
            'total_teachers' => Teacher::query()->where('is_active', true)->count(),
            'total_achievements' => Achievement::query()->where('status', 'published')->count(),
            'total_competitions' => Competition::query()->where('status', 'published')->count(),
            'total_galleries' => Gallery::query()->where('status', 'published')->count(),
            'custom_stats' => $profile?->stats,
        ];
    }
}
