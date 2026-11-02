<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\ContentIndexRequest;
use App\Http\Requests\Api\Admin\SaveOrganizationStructureRequest;
use App\Services\Api\Admin\OrganizationStructureService;
use Illuminate\Http\JsonResponse;

class OrganizationStructureController extends Controller
{
    public function __construct(private OrganizationStructureService $organizationStructureService) {}

    public function index(ContentIndexRequest $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->organizationStructureService->index($request->validated()),
        ]);
    }

    public function store(SaveOrganizationStructureRequest $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Struktur organisasi berhasil ditambahkan.',
            'data' => $this->organizationStructureService->create($request->validated()),
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->organizationStructureService->find($id),
        ]);
    }

    public function update(SaveOrganizationStructureRequest $request, string $id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Struktur organisasi berhasil diperbarui.',
            'data' => $this->organizationStructureService->update($id, $request->validated()),
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->organizationStructureService->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'Struktur organisasi berhasil dihapus.',
        ]);
    }
}
