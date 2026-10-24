<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Competition;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    public function index(Request $request)
    {
        $query = Competition::orderBy('event_date', 'asc');

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('title', 'like', "%{$s}%")
                  ->orWhere('category', 'like', "%{$s}%");
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
            'organizer' => 'required|string|max:150',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'registration_deadline' => 'nullable|date',
            'event_date' => 'nullable|date',
            'location' => 'nullable|string|max:200',
            'guide_book_url' => 'nullable|string',
            'banner_image' => 'nullable|string',
            'is_featured' => 'boolean',
            'status' => 'required|in:draft,published',
        ]);

        $competition = Competition::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Informasi lomba berhasil ditambahkan.',
            'data' => $competition
        ], 201);
    }

    public function show($id)
    {
        $competition = Competition::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $competition
        ]);
    }

    public function update(Request $request, $id)
    {
        $competition = Competition::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:200',
            'organizer' => 'required|string|max:150',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'registration_deadline' => 'nullable|date',
            'event_date' => 'nullable|date',
            'location' => 'nullable|string|max:200',
            'guide_book_url' => 'nullable|string',
            'banner_image' => 'nullable|string',
            'is_featured' => 'boolean',
            'status' => 'required|in:draft,published',
        ]);

        $competition->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Informasi lomba berhasil diperbarui.',
            'data' => $competition
        ]);
    }

    public function destroy($id)
    {
        $competition = Competition::findOrFail($id);
        $competition->delete();

        return response()->json([
            'success' => true,
            'message' => 'Informasi lomba berhasil dihapus.'
        ]);
    }
}
