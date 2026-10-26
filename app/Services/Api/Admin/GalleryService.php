<?php

namespace App\Services\Api\Admin;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Collection;

class GalleryService
{
    /** @param array<string, mixed> $filters */
    public function index(array $filters): Collection
    {
        $query = Gallery::query()->orderByDesc('event_date')->orderByDesc('id');

        if (($filters['category'] ?? null) !== null && $filters['category'] !== '' && $filters['category'] !== 'Semua') {
            $query->where('category', $filters['category']);
        }

        if (($filters['status'] ?? null) !== null && $filters['status'] !== '' && $filters['status'] !== 'all') {
            $query->where('status', $filters['status']);
        }

        return $query->get();
    }

    public function find(string $id): Gallery
    {
        return Gallery::query()->findOrFail($id);
    }

    /** @param array<string, mixed> $data */
    public function create(array $data): Gallery
    {
        return Gallery::query()->create($data);
    }

    /** @param array<string, mixed> $data */
    public function update(string $id, array $data): Gallery
    {
        $gallery = $this->find($id);
        $gallery->update($data);

        return $gallery;
    }

    public function delete(string $id): void
    {
        $this->find($id)->delete();
    }
}
