<?php

namespace App\Services\Api\Admin;

use App\Models\Teacher;
use App\Services\Api\PublicApiCache;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class TeacherService
{
    public function __construct(private PublicApiCache $publicApiCache) {}

    /** @param array<string, mixed> $filters */
    public function index(array $filters): LengthAwarePaginator
    {
        $query = Teacher::query()->orderBy('order')->orderBy('id');

        if (($filters['search'] ?? null) !== null && $filters['search'] !== '') {
            $search = $filters['search'];

            $query->where(function ($query) use ($search): void {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('role_title', 'like', "%{$search}%");
            });
        }

        $page = isset($filters['page']) ? (int) $filters['page'] : null;

        return $query->paginate((int) ($filters['per_page'] ?? 10), ['*'], 'page', $page)
            ->appends(Arr::except($filters, ['page']));
    }

    public function find(string $id): Teacher
    {
        return Teacher::query()->findOrFail($id);
    }

    /** @param array<string, mixed> $data */
    public function create(array $data): Teacher
    {
        $teacher = Teacher::query()->create($data);
        $this->invalidatePublicCache();

        return $teacher;
    }

    /** @param array<string, mixed> $data */
    public function update(string $id, array $data): Teacher
    {
        $teacher = $this->find($id);
        $teacher->update($data);
        $this->invalidatePublicCache();

        return $teacher;
    }

    public function delete(string $id): void
    {
        $teacher = $this->find($id);

        if ($teacher->principals()->exists()) {
            throw ValidationException::withMessages([
                'teacher' => 'Data guru yang memiliki riwayat kepala sekolah tidak dapat dihapus. Nonaktifkan guru untuk mengarsipkannya.',
            ]);
        }

        $teacher->delete();
        $this->invalidatePublicCache();
    }

    private function invalidatePublicCache(): void
    {
        $this->publicApiCache->invalidate('teachers', 'profile', 'stats');
    }
}
