<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\ContentIndexRequest;
use App\Http\Requests\Api\Admin\SaveHeroSlideRequest;
use App\Services\Api\Admin\HeroSlideService;
use Illuminate\Http\JsonResponse;

class HeroSlideController extends Controller
{
    public function __construct(private HeroSlideService $heroSlideService) {}

    public function index(ContentIndexRequest $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->heroSlideService->index($request->validated()),
        ]);
    }

    public function store(SaveHeroSlideRequest $request): JsonResponse
    {
        $slide = $this->heroSlideService->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Slide beranda berhasil ditambahkan.',
            'data' => $slide,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->heroSlideService->find($id),
        ]);
    }

    public function update(SaveHeroSlideRequest $request, string $id): JsonResponse
    {
        $slide = $this->heroSlideService->update($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Slide beranda berhasil diperbarui.',
            'data' => $slide,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $this->heroSlideService->delete($id);

        return response()->json([
            'success' => true,
            'message' => 'Slide beranda berhasil dihapus.',
        ]);
    }
}
