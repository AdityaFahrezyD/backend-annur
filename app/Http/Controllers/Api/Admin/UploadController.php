<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Admin\UploadRequest;
use App\Services\Api\Admin\UploadService;
use Illuminate\Http\JsonResponse;

class UploadController extends Controller
{
    public function __construct(private UploadService $uploadService) {}

    public function upload(UploadRequest $request): JsonResponse
    {
        $upload = $this->uploadService->upload($request->file('file'));

        return response()->json([
            'success' => true,
            'message' => 'Berkas berhasil diunggah.',
            'url' => $upload['url'],
            'path' => $upload['path'],
        ]);
    }
}
