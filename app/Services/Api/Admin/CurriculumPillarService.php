<?php

namespace App\Services\Api\Admin;

use App\Models\CurriculumPillar;
use App\Services\Api\PublicApiCache;
use Illuminate\Database\Eloquent\Collection;

class CurriculumPillarService
{
    public function __construct(private PublicApiCache $publicApiCache) {}

    /** @param array<string, mixed> $filters */
    public function index(array $filters): Collection
    {
        $query = CurriculumPillar::query()->orderBy('order')->orderBy('id');

        if (($filters['status'] ?? null) !== null && $filters['status'] !== '' && $filters['status'] !== 'all') {
            $query->where('status', $filters['status']);
        }

        return $query->get();
    }

    public function find(string $id): CurriculumPillar
    {
        return CurriculumPillar::query()->findOrFail($id);
    }

    /** @param array<string, mixed> $data */
    public function create(array $data): CurriculumPillar
    {
        $pillar = CurriculumPillar::query()->create($data);
        $this->invalidatePublicCache();

        return $pillar;
    }

    /** @param array<string, mixed> $data */
    public function update(string $id, array $data): CurriculumPillar
    {
        $pillar = $this->find($id);
        $pillar->update($data);
        $this->invalidatePublicCache();

        return $pillar;
    }

    public function delete(string $id): void
    {
        $this->find($id)->delete();
        $this->invalidatePublicCache();
    }

    private function invalidatePublicCache(): void
    {
        $this->publicApiCache->invalidate('curriculum-pillars', 'curriculums');
    }
}
