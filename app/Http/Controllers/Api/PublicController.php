<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Competition;
use App\Models\ContactMessage;
use App\Models\Curriculum;
use App\Models\Gallery;
use App\Models\SchoolProfile;
use App\Models\Teacher;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function profile()
    {
        $profile = SchoolProfile::first();
        return response()->json([
            'success' => true,
            'data' => $profile
        ]);
    }

    public function teachers(Request $request)
    {
        $query = Teacher::where('is_active', true)->orderBy('order', 'asc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('role_title', 'like', "%{$search}%");
            });
        }

        if ($request->filled('subject')) {
            $query->where('subject', 'like', "%{$request->subject}%");
        }

        return response()->json([
            'success' => true,
            'data' => $query->get()
        ]);
    }

    public function achievements(Request $request)
    {
        $query = Achievement::where('status', 'published')->orderBy('year', 'desc')->orderBy('id', 'desc');

        if ($request->filled('category') && $request->category !== 'Semua') {
            $query->where('category', $request->category);
        }

        if ($request->filled('year')) {
            $query->where('year', $request->year);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('recipient_name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        return response()->json([
            'success' => true,
            'data' => $query->get()
        ]);
    }

    public function competitions(Request $request)
    {
        $query = Competition::where('status', 'published')->orderBy('event_date', 'asc');

        if ($request->filled('category') && $request->category !== 'Semua') {
            $query->where('category', $request->category);
        }

        return response()->json([
            'success' => true,
            'data' => $query->get()
        ]);
    }

    public function curriculums()
    {
        $data = Curriculum::where('status', 'published')->orderBy('order', 'asc')->get();
        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function galleries(Request $request)
    {
        $query = Gallery::where('status', 'published')->orderBy('event_date', 'desc')->orderBy('id', 'desc');

        if ($request->filled('category') && $request->category !== 'Semua') {
            $query->where('category', $request->category);
        }

        return response()->json([
            'success' => true,
            'data' => $query->get()
        ]);
    }

    public function submitContact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:150',
            'phone' => 'nullable|string|max:30',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|min:10|max:3000',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'subject.required' => 'Subjek pesan wajib diisi.',
            'message.required' => 'Pesan wajib diisi.',
            'message.min' => 'Pesan minimal terdiri dari 10 karakter.',
        ]);

        $contact = ContactMessage::create([
            'visitor_name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'ip_address' => $request->ip(),
            'crm_status' => 'new',
            'priority' => 'normal',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Terima kasih! Pesan Anda telah berhasil terkirim. Tim Humas & CRM An-Nur akan segera menindaklanjuti pesan Anda.',
            'data' => $contact
        ], 201);
    }

    public function stats()
    {
        $profile = SchoolProfile::first();
        return response()->json([
            'success' => true,
            'data' => [
                'total_teachers' => Teacher::where('is_active', true)->count(),
                'total_achievements' => Achievement::where('status', 'published')->count(),
                'total_competitions' => Competition::where('status', 'published')->count(),
                'total_galleries' => Gallery::where('status', 'published')->count(),
                'custom_stats' => $profile ? $profile->stats : null,
            ]
        ]);
    }
}
