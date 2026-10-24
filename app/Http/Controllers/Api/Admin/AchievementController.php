<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function index(Request $request)
    {
        $query = Achievement::orderBy('year', 'desc')->orderBy('id', 'desc');

        if ($request->filled('category') && $request->category !== 'Semua') {
            $query->where('category', $request->category);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('recipient_name', 'like', "%{$s}%");
            });
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
            'level' => 'required|string|max:100',
            'year' => 'required|string|max:10',
            'recipient_name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'status' => 'required|in:draft,published',
        ]);

        $achievement = Achievement::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Prestasi berhasil ditambahkan.',
            'data' => $achievement
        ], 201);
    }

    public function show($id)
    {
        $achievement = Achievement::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $achievement
        ]);
    }

    public function update(Request $request, $id)
    {
        $achievement = Achievement::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'category' => 'required|string|max:100',
            'level' => 'required|string|max:100',
            'year' => 'required|string|max:10',
            'recipient_name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'status' => 'required|in:draft,published',
        ]);

        $achievement->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Prestasi berhasil diperbarui.',
            'data' => $achievement
        ]);
    }

    public function destroy($id)
    {
        $achievement = Achievement::findOrFail($id);
        $achievement->delete();

        return response()->json([
            'success' => true,
            'message' => 'Prestasi berhasil dihapus.'
        ]);
    }
}
