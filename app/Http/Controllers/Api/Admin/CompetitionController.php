<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\ContentIndexRequest;
use App\Http\Requests\Api\Admin\SaveCompetitionRequest;
use App\Services\Api\Admin\CompetitionService;
use Illuminate\Http\JsonResponse;

class CompetitionController extends Controller
{
    public function __construct(private CompetitionService $competitionService) {}

    public function index(ContentIndexRequest $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->competitionService->index($request->validated()),
        ]);
    }

    public function store(SaveCompetitionRequest $request): JsonResponse
    {
        $competition = $this->competitionService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Informasi lomba berhasil ditambahkan.',
            'data' => $competition,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->competitionService->find($id),
        ]);
    }

    public function update(SaveCompetitionRequest $request, string $id): JsonResponse
    {
        $competition = $this->competitionService->update($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Informasi lomba berhasil diperbarui.',
            'data' => $competition,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->competitionService->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'Informasi lomba berhasil dihapus.',
        ]);
    }
}
