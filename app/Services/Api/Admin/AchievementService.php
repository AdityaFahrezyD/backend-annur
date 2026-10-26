<?php

namespace App\Services\Api\Admin;

use App\Models\Achievement;
use App\Services\Api\PublicApiCache;
use Illuminate\Database\Eloquent\Collection;

class AchievementService
{
    public function __construct(private PublicApiCache $publicApiCache) {}

    /** @param array<string, mixed> $filters */
    public function index(array $filters): Collection
    {
        $query = Achievement::query()->orderByDesc('year')->orderByDesc('id');

        if (($filters['category'] ?? null) !== null && $filters['category'] !== '' && $filters['category'] !== 'Semua') {
            $query->where('category', $filters['category']);
        }

        if (($filters['status'] ?? null) !== null && $filters['status'] !== '' && $filters['status'] !== 'all') {
            $query->where('status', $filters['status']);
        }

        if (($filters['search'] ?? null) !== null && $filters['search'] !== '') {
            $search = $filters['search'];

            $query->where(function ($query) use ($search): void {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('recipient_name', 'like', "%{$search}%");
            });
        }

        return $query->get();
    }

    public function find(string $id): Achievement
    {
        return Achievement::query()->findOrFail($id);
    }

    /** @param array<string, mixed> $data */
    public function create(array $data): Achievement
    {
        $achievement = Achievement::query()->create($data);
        $this->invalidatePublicCache();

        return $achievement;
    }

    /** @param array<string, mixed> $data */
    public function update(string $id, array $data): Achievement
    {
        $achievement = $this->find($id);
        $achievement->update($data);
        $this->invalidatePublicCache();

        return $achievement;
    }

    public function delete(string $id): void
    {
        $this->find($id)->delete();
        $this->invalidatePublicCache();
    }

    private function invalidatePublicCache(): void
    {
        $this->publicApiCache->invalidate('achievements', 'stats');
    }
}
