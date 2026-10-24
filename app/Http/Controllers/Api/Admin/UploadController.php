<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:jpeg,png,jpg,webp,gif,pdf|max:5120', // max 5MB
        ], [
            'file.required' => 'Berkas belum dipilih.',
            'file.mimes' => 'Format berkas hanya boleh berupa JPG, PNG, WEBP, GIF, atau PDF.',
            'file.max' => 'Ukuran berkas maksimal adalah 5MB.',
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('uploads', $filename, 'public');

        $url = asset('storage/' . $path);

        return response()->json([
            'success' => true,
            'message' => 'Berkas berhasil diunggah.',
            'url' => $url,
            'path' => $path,
        ]);
    }
}
