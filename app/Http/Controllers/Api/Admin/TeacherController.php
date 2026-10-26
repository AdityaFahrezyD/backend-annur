<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\ContentIndexRequest;
use App\Http\Requests\Api\Admin\SaveTeacherRequest;
use App\Services\Api\Admin\TeacherService;
use Illuminate\Http\JsonResponse;

class TeacherController extends Controller
{
    public function __construct(private TeacherService $teacherService) {}

    public function index(ContentIndexRequest $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->teacherService->index($request->validated()),
        ]);
    }

    public function store(SaveTeacherRequest $request): JsonResponse
    {
        $teacher = $this->teacherService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Data guru berhasil ditambahkan.',
            'data' => $teacher,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->teacherService->find($id),
        ]);
    }

    public function update(SaveTeacherRequest $request, string $id): JsonResponse
    {
        $teacher = $this->teacherService->update($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Data guru berhasil diperbarui.',
            'data' => $teacher,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->teacherService->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'Data guru berhasil dihapus.',
        ]);
    }
}
