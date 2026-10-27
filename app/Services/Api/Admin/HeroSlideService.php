<?php

namespace App\Services\Api\Admin;

use App\Models\HeroSlide;
use App\Services\Api\PublicApiCache;
use Illuminate\Database\Eloquent\Collection;

class HeroSlideService
{
    public function __construct(private PublicApiCache $publicApiCache) {}

    /** @param array<string, mixed> $filters */
    public function index(array $filters): Collection
    {
        $query = HeroSlide::query()->orderBy('order')->orderBy('id');

        if (($filters['status'] ?? null) !== null && $filters['status'] !== '' && $filters['status'] !== 'all') {
            $query->where('status', $filters['status']);
        }

        return $query->get();
    }

    public function find(string $id): HeroSlide
    {
        return HeroSlide::query()->findOrFail($id);
    }

    /** @param array<string, mixed> $data */
    public function create(array $data): HeroSlide
    {
        $slide = HeroSlide::query()->create($data);
        $this->invalidatePublicCache();

        return $slide;
    }

    /** @param array<string, mixed> $data */
    public function update(string $id, array $data): HeroSlide
    {
        $slide = $this->find($id);
        $slide->update($data);
        $this->invalidatePublicCache();

        return $slide;
    }

    public function delete(string $id): void
    {
        $this->find($id)->delete();
        $this->invalidatePublicCache();
    }

    private function invalidatePublicCache(): void
    {
        $this->publicApiCache->invalidate('hero-slides');
    }
}
