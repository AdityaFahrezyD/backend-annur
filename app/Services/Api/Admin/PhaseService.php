<?php

namespace App\Services\Api\Admin;

use App\Models\Phase;
use App\Services\Api\PublicApiCache;
use Illuminate\Database\Eloquent\Collection;

class PhaseService
{
    public function __construct(private PublicApiCache $publicApiCache) {}

    /** @param array<string, mixed> $filters */
    public function index(array $filters): Collection
    {
        $query = Phase::query()->orderBy('order')->orderBy('id');

        if (($filters['status'] ?? null) !== null && $filters['status'] !== '' && $filters['status'] !== 'all') {
            $query->where('status', $filters['status']);
        }

        return $query->get();
    }

    public function find(string $id): Phase
    {
        return Phase::query()->findOrFail($id);
    }

    /** @param array<string, mixed> $data */
    public function create(array $data): Phase
    {
        $phase = Phase::query()->create($data);
        $this->invalidatePublicCache();

        return $phase;
    }

    /** @param array<string, mixed> $data */
    public function update(string $id, array $data): Phase
    {
        $phase = $this->find($id);
        $phase->update($data);
        $this->invalidatePublicCache();

        return $phase;
    }

    public function delete(string $id): void
    {
        $this->find($id)->delete();
        $this->invalidatePublicCache();
    }

    private function invalidatePublicCache(): void
    {
        $this->publicApiCache->invalidate('phases', 'curriculums');
    }
}
