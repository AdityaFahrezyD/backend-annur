<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\UpdateSchoolProfileRequest;
use App\Services\Api\Admin\SchoolProfileService;
use Illuminate\Http\JsonResponse;

class SchoolProfileController extends Controller
{
    public function __construct(private SchoolProfileService $schoolProfileService) {}

    public function show(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->schoolProfileService->show(),
        ]);
    }

    public function update(UpdateSchoolProfileRequest $request): JsonResponse
    {
        $profile = $this->schoolProfileService->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Profil dan identitas An-Nur berhasil diperbarui.',
            'data' => $profile,
        ]);
    }
}
