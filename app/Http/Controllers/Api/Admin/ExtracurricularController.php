<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\PaginatedContentIndexRequest;
use App\Http\Requests\Api\Admin\SaveExtracurricularRequest;
use App\Http\Requests\Api\PaginationRequest;
use App\Services\Api\Admin\ExtracurricularService;
use Illuminate\Http\JsonResponse;

class ExtracurricularController extends Controller
{
    public function __construct(private ExtracurricularService $extracurricularService) {}

    public function index(PaginatedContentIndexRequest $request): JsonResponse
    {
        return $this->paginatedResponse($this->extracurricularService->index($request->validated()));
    }

    public function images(string $id, PaginationRequest $request): JsonResponse
    {
        return $this->paginatedResponse(
            $this->extracurricularService->images($id, $request->validated()),
        );
    }

    public function store(SaveExtracurricularRequest $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Ekstrakurikuler berhasil ditambahkan.',
            'data' => $this->extracurricularService->create($request->validated()),
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->extracurricularService->find($id),
        ]);
    }

    public function update(SaveExtracurricularRequest $request, string $id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Ekstrakurikuler berhasil diperbarui.',
            'data' => $this->extracurricularService->update($id, $request->validated()),
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->extracurricularService->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'Ekstrakurikuler berhasil dihapus.',
        ]);
    }
}
