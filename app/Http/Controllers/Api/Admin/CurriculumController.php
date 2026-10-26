<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\ContentIndexRequest;
use App\Http\Requests\Api\Admin\SaveCurriculumRequest;
use App\Services\Api\Admin\CurriculumService;
use Illuminate\Http\JsonResponse;

class CurriculumController extends Controller
{
    public function __construct(private CurriculumService $curriculumService) {}

    public function index(ContentIndexRequest $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->curriculumService->index($request->validated()),
        ]);
    }

    public function store(SaveCurriculumRequest $request): JsonResponse
    {
        $curriculum = $this->curriculumService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Program kurikulum berhasil ditambahkan.',
            'data' => $curriculum,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->curriculumService->find($id),
        ]);
    }

    public function update(SaveCurriculumRequest $request, string $id): JsonResponse
    {
        $curriculum = $this->curriculumService->update($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Program kurikulum berhasil diperbarui.',
            'data' => $curriculum,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->curriculumService->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'Program kurikulum berhasil dihapus.',
        ]);
    }
}
