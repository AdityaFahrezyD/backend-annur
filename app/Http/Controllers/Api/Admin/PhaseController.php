<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\ContentIndexRequest;
use App\Http\Requests\Api\Admin\SavePhaseRequest;
use App\Services\Api\Admin\PhaseService;
use Illuminate\Http\JsonResponse;

class PhaseController extends Controller
{
    public function __construct(private PhaseService $phaseService) {}

    public function index(ContentIndexRequest $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->phaseService->index($request->validated()),
        ]);
    }

    public function store(SavePhaseRequest $request): JsonResponse
    {
        $phase = $this->phaseService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Fase berhasil ditambahkan.',
            'data' => $phase,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->phaseService->find($id),
        ]);
    }

    public function update(SavePhaseRequest $request, string $id): JsonResponse
    {
        $phase = $this->phaseService->update($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Fase berhasil diperbarui.',
            'data' => $phase,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->phaseService->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'Fase berhasil dihapus.',
        ]);
    }
}
