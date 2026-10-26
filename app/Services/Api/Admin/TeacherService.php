<?php

namespace App\Services\Api\Admin;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Collection;

class TeacherService
{
    /** @param array<string, mixed> $filters */
    public function index(array $filters): Collection
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

        return $query->get();
    }

    public function find(string $id): Teacher
    {
        return Teacher::query()->findOrFail($id);
    }

    /** @param array<string, mixed> $data */
    public function create(array $data): Teacher
    {
        return Teacher::query()->create($data);
    }

    /** @param array<string, mixed> $data */
    public function update(string $id, array $data): Teacher
    {
        $teacher = $this->find($id);
        $teacher->update($data);

        return $teacher;
    }

    public function delete(string $id): void
    {
        $this->find($id)->delete();
    }
}
