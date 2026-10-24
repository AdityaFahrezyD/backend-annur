<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Curriculum;
use Illuminate\Http\Request;

class CurriculumController extends Controller
{
    public function index(Request $request)
    {
        $query = Curriculum::orderBy('order', 'asc')->orderBy('id', 'asc');

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
            'code' => 'nullable|string|max:50',
            'level' => 'nullable|string|max:100',
            'description' => 'required|string',
            'features' => 'nullable|array',
            'order' => 'integer',
            'status' => 'required|in:draft,published',
        ]);

        $curriculum = Curriculum::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Program kurikulum berhasil ditambahkan.',
            'data' => $curriculum
        ], 201);
    }

    public function show($id)
    {
        $curriculum = Curriculum::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $curriculum
        ]);
    }

    public function update(Request $request, $id)
    {
        $curriculum = Curriculum::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'code' => 'nullable|string|max:50',
            'level' => 'nullable|string|max:100',
            'description' => 'required|string',
            'features' => 'nullable|array',
            'order' => 'integer',
            'status' => 'required|in:draft,published',
        ]);

        $curriculum->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Program kurikulum berhasil diperbarui.',
            'data' => $curriculum
        ]);
    }

    public function destroy($id)
    {
        $curriculum = Curriculum::findOrFail($id);
        $curriculum->delete();

        return response()->json([
            'success' => true,
            'message' => 'Program kurikulum berhasil dihapus.'
        ]);
    }
}
