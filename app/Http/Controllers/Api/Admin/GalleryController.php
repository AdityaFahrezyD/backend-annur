<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::orderBy('event_date', 'desc')->orderBy('id', 'desc');

        if ($request->filled('category') && $request->category !== 'Semua') {
            $query->where('category', $request->category);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        return response()->json([
            'success' => true,
            'data' => $query->get()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'category' => 'required|string|max:100',
            'image' => 'required|string',
            'description' => 'nullable|string',
            'event_date' => 'nullable|date',
            'status' => 'required|in:draft,published',
        ]);

        $gallery = Gallery::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Dokumentasi galeri berhasil ditambahkan.',
            'data' => $gallery
        ], 201);
    }

    public function show($id)
    {
        $gallery = Gallery::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $gallery
        ]);
    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'category' => 'required|string|max:100',
            'image' => 'required|string',
            'description' => 'nullable|string',
            'event_date' => 'nullable|date',
            'status' => 'required|in:draft,published',
        ]);

        $gallery->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Dokumentasi galeri berhasil diperbarui.',
            'data' => $gallery
        ]);
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        $gallery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Dokumentasi galeri berhasil dihapus.'
        ]);
    }
}
