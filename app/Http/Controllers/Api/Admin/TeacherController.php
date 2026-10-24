<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::orderBy('order', 'asc')->orderBy('id', 'asc');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('subject', 'like', "%{$s}%")
                  ->orWhere('role_title', 'like', "%{$s}%");
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
            'name' => 'required|string|max:150',
            'nip' => 'nullable|string|max:50',
            'subject' => 'required|string|max:100',
            'role_title' => 'nullable|string|max:100',
            'education' => 'nullable|string|max:150',
            'photo' => 'nullable|string',
            'bio' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'integer',
        ]);

        $teacher = Teacher::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data guru berhasil ditambahkan.',
            'data' => $teacher
        ], 201);
    }

    public function show($id)
    {
        $teacher = Teacher::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $teacher
        ]);
    }

    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'nip' => 'nullable|string|max:50',
            'subject' => 'required|string|max:100',
            'role_title' => 'nullable|string|max:100',
            'education' => 'nullable|string|max:150',
            'photo' => 'nullable|string',
            'bio' => 'nullable|string',
            'is_active' => 'boolean',
            'order' => 'integer',
        ]);

        $teacher->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Data guru berhasil diperbarui.',
            'data' => $teacher
        ]);
    }

    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data guru berhasil dihapus.'
        ]);
    }
}
