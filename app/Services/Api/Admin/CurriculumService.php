<?php

namespace App\Services\Api\Admin;

use App\Models\Curriculum;
use Illuminate\Database\Eloquent\Collection;

class CurriculumService
{
    /** @param array<string, mixed> $filters */
    public function index(array $filters): Collection
    {
        $query = Curriculum::query()->orderBy('order')->orderBy('id');

        if (($filters['status'] ?? null) !== null && $filters['status'] !== '' && $filters['status'] !== 'all') {
            $query->where('status', $filters['status']);
        }

        return $query->get();
    }

    public function find(string $id): Curriculum
    {
        return Curriculum::query()->findOrFail($id);
    }

    /** @param array<string, mixed> $data */
    public function create(array $data): Curriculum
    {
        return Curriculum::query()->create($data);
    }

    /** @param array<string, mixed> $data */
    public function update(string $id, array $data): Curriculum
    {
        $curriculum = $this->find($id);
        $curriculum->update($data);

        return $curriculum;
    }

    public function delete(string $id): void
    {
        $this->find($id)->delete();
    }
}
