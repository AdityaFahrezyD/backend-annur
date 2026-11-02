<?php

namespace App\Services\Api\Admin;

use App\Models\OrganizationStructure;
use App\Services\Api\PublicApiCache;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class OrganizationStructureService
{
    public function __construct(private PublicApiCache $publicApiCache) {}

    /** @param array<string, mixed> $filters */
    public function index(array $filters): Collection
    {
        $query = OrganizationStructure::query()->orderBy('order')->orderBy('id');

        if (($filters['status'] ?? null) !== null && $filters['status'] !== '' && $filters['status'] !== 'all') {
            $query->where('status', $filters['status']);
        }

        if (($filters['search'] ?? null) !== null && $filters['search'] !== '') {
            $search = $filters['search'];
            $query->where(function ($query) use ($search): void {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('position', 'like', '%'.$search.'%');
            });
        }

        return $query->get();
    }

    public function find(string $id): OrganizationStructure
    {
        return OrganizationStructure::query()->findOrFail($id);
    }

    /** @param array<string, mixed> $data */
    public function create(array $data): OrganizationStructure
    {
        $structure = OrganizationStructure::query()->create($data);
        $this->invalidatePublicCache();

        return $structure;
    }

    /** @param array<string, mixed> $data */
    public function update(string $id, array $data): OrganizationStructure
    {
        $structure = $this->find($id);

        if (array_key_exists('parent_id', $data)) {
            $this->assertValidParent($structure->id, $data['parent_id']);
        }

        $structure->update($data);
        $this->invalidatePublicCache();

        return $structure;
    }

    public function delete(string $id): void
    {
        $this->find($id)->delete();
        $this->invalidatePublicCache();
    }

    private function invalidatePublicCache(): void
    {
        $this->publicApiCache->invalidate('organization-structures');
    }

    private function assertValidParent(string $structureId, ?string $parentId): void
    {
        $visitedIds = [];

        while ($parentId !== null) {
            if (strcasecmp($parentId, $structureId) === 0) {
                throw ValidationException::withMessages([
                    'parent_id' => ['Struktur tidak dapat menjadi induk bagi dirinya sendiri atau turunannya.'],
                ]);
            }

            $normalizedParentId = strtolower($parentId);

            if (isset($visitedIds[$normalizedParentId])) {
                throw ValidationException::withMessages([
                    'parent_id' => ['Relasi induk tidak boleh membentuk siklus.'],
                ]);
            }

            $visitedIds[$normalizedParentId] = true;
            $parentId = OrganizationStructure::query()->whereKey($parentId)->value('parent_id');
        }
    }
}
