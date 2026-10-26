<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\ContentIndexRequest;
use App\Http\Requests\Api\Admin\SaveAchievementRequest;
use App\Services\Api\Admin\AchievementService;
use Illuminate\Http\JsonResponse;

class AchievementController extends Controller
{
    public function __construct(private AchievementService $achievementService) {}

    public function index(ContentIndexRequest $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->achievementService->index($request->validated()),
        ]);
    }

    public function store(SaveAchievementRequest $request): JsonResponse
    {
        $achievement = $this->achievementService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Prestasi berhasil ditambahkan.',
            'data' => $achievement,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->achievementService->find($id),
        ]);
    }

    public function update(SaveAchievementRequest $request, string $id): JsonResponse
    {
        $achievement = $this->achievementService->update($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Prestasi berhasil diperbarui.',
            'data' => $achievement,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->achievementService->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'Prestasi berhasil dihapus.',
        ]);
    }
}
