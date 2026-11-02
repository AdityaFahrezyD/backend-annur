<?php

namespace App\Services\Api\Admin;

use App\Models\Extracurricular;
use App\Services\Api\PublicApiCache;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ExtracurricularService
{
    public function __construct(private PublicApiCache $publicApiCache) {}

    /** @param array<string, mixed> $filters */
    public function index(array $filters): Collection
    {
        $query = Extracurricular::query()->with('images')->orderBy('order')->orderBy('id');

        if (($filters['status'] ?? null) !== null && $filters['status'] !== '' && $filters['status'] !== 'all') {
            $query->where('status', $filters['status']);
        }

        if (($filters['search'] ?? null) !== null && $filters['search'] !== '') {
            $query->where('title', 'like', '%'.$filters['search'].'%');
        }

        return $query->get();
    }

    public function find(string $id): Extracurricular
    {
        return Extracurricular::query()->with('images')->findOrFail($id);
    }

    /** @param array<string, mixed> $data */
    public function create(array $data): Extracurricular
    {
        $images = $data['images'] ?? [];
        unset($data['images']);

        return DB::transaction(function () use ($data, $images): Extracurricular {
            $extracurricular = Extracurricular::query()->create($data);

            if ($images !== []) {
                $extracurricular->images()->createMany($images);
            }

            $this->invalidatePublicCache();

            return $extracurricular->load('images');
        });
    }

    /** @param array<string, mixed> $data */
    public function update(string $id, array $data): Extracurricular
    {
        $hasImages = array_key_exists('images', $data);
        $images = $data['images'] ?? [];
        unset($data['images']);

        return DB::transaction(function () use ($id, $data, $hasImages, $images): Extracurricular {
            $extracurricular = Extracurricular::query()->findOrFail($id);
            $extracurricular->update($data);

            if ($hasImages) {
                $extracurricular->images()->delete();

                if ($images !== []) {
                    $extracurricular->images()->createMany($images);
                }
            }

            $this->invalidatePublicCache();

            return $extracurricular->load('images');
        });
    }

    public function delete(string $id): void
    {
        DB::transaction(function () use ($id): void {
            $extracurricular = Extracurricular::query()->findOrFail($id);
            $extracurricular->images()->delete();
            $extracurricular->delete();

            $this->invalidatePublicCache();
        });
    }

    private function invalidatePublicCache(): void
    {
        $this->publicApiCache->invalidate('extracurriculars');
    }
}
