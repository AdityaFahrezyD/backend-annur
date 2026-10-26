<?php

namespace App\Services\Api\Admin;

use App\Models\Competition;
use Illuminate\Database\Eloquent\Collection;

class CompetitionService
{
    /** @param array<string, mixed> $filters */
    public function index(array $filters): Collection
    {
        $query = Competition::query()->orderBy('event_date');

        if (($filters['status'] ?? null) !== null && $filters['status'] !== '' && $filters['status'] !== 'all') {
            $query->where('status', $filters['status']);
        }

        if (($filters['search'] ?? null) !== null && $filters['search'] !== '') {
            $search = $filters['search'];

            $query->where(function ($query) use ($search): void {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        return $query->get();
    }

    public function find(string $id): Competition
    {
        return Competition::query()->findOrFail($id);
    }

    /** @param array<string, mixed> $data */
    public function create(array $data): Competition
    {
        return Competition::query()->create($data);
    }

    /** @param array<string, mixed> $data */
    public function update(string $id, array $data): Competition
    {
        $competition = $this->find($id);
        $competition->update($data);

        return $competition;
    }

    public function delete(string $id): void
    {
        $this->find($id)->delete();
    }
}
