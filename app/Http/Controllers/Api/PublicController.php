<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ContactSubmissionRequest;
use App\Http\Requests\Api\PublicContentRequest;
use App\Services\Api\PublicContentService;
use Illuminate\Http\JsonResponse;

class PublicController extends Controller
{
    public function __construct(private PublicContentService $publicContentService) {}

    public function profile(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->publicContentService->profile(),
        ]);
    }

    public function teachers(PublicContentRequest $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->publicContentService->teachers($request->validated()),
        ]);
    }

    public function achievements(PublicContentRequest $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->publicContentService->achievements($request->validated()),
        ]);
    }

    public function competitions(PublicContentRequest $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->publicContentService->competitions($request->validated()),
        ]);
    }

    public function curriculums(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->publicContentService->curriculums(),
        ]);
    }

    public function curriculumPillars(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->publicContentService->curriculumPillars(),
        ]);
    }

    public function phases(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->publicContentService->phases(),
        ]);
    }

    public function heroSlides(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->publicContentService->heroSlides(),
        ]);
    }

    public function galleries(PublicContentRequest $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->publicContentService->galleries($request->validated()),
        ]);
    }

    public function submitContact(ContactSubmissionRequest $request): JsonResponse
    {
        $contact = $this->publicContentService->submitContact($request->validated(), $request->ip());

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih! Pesan Anda telah berhasil terkirim. Tim Humas & CRM An-Nur akan segera menindaklanjuti pesan Anda.',
            'data' => $contact,
        ], 201);
    }

    public function stats(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->publicContentService->stats(),
        ]);
    }
}
