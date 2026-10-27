<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\ContentIndexRequest;
use App\Http\Requests\Api\Admin\SaveCurriculumPillarRequest;
use App\Services\Api\Admin\CurriculumPillarService;
use Illuminate\Http\JsonResponse;

class CurriculumPillarController extends Controller
{
    public function __construct(private CurriculumPillarService $curriculumPillarService) {}

    public function index(ContentIndexRequest $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->curriculumPillarService->index($request->validated()),
        ]);
    }

    public function store(SaveCurriculumPillarRequest $request): JsonResponse
    {
        $pillar = $this->curriculumPillarService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Pilar kurikulum berhasil ditambahkan.',
            'data' => $pillar,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->curriculumPillarService->find($id),
        ]);
    }

    public function update(SaveCurriculumPillarRequest $request, string $id): JsonResponse
    {
        $pillar = $this->curriculumPillarService->update($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Pilar kurikulum berhasil diperbarui.',
            'data' => $pillar,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->curriculumPillarService->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'Pilar kurikulum berhasil dihapus.',
        ]);
    }
}
