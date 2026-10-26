<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\ContentIndexRequest;
use App\Http\Requests\Api\Admin\SaveGalleryRequest;
use App\Services\Api\Admin\GalleryService;
use Illuminate\Http\JsonResponse;

class GalleryController extends Controller
{
    public function __construct(private GalleryService $galleryService) {}

    public function index(ContentIndexRequest $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->galleryService->index($request->validated()),
        ]);
    }

    public function store(SaveGalleryRequest $request): JsonResponse
    {
        $gallery = $this->galleryService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Dokumentasi galeri berhasil ditambahkan.',
            'data' => $gallery,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->galleryService->find($id),
        ]);
    }

    public function update(SaveGalleryRequest $request, string $id): JsonResponse
    {
        $gallery = $this->galleryService->update($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Dokumentasi galeri berhasil diperbarui.',
            'data' => $gallery,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->galleryService->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'Dokumentasi galeri berhasil dihapus.',
        ]);
    }
}
