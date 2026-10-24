<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolProfile;
use Illuminate\Http\Request;

class SchoolProfileController extends Controller
{
    public function show()
    {
        $profile = SchoolProfile::firstOrCreate([], [
            'name' => 'SMA Islam Terpadu An-Nur',
            'tagline' => 'Membentuk Generasi Berakhlak Mulia, Cerdas, dan Berprestasi Global',
        ]);

        return response()->json([
            'success' => true,
            'data' => $profile
        ]);
    }

    public function update(Request $request)
    {
        $profile = SchoolProfile::firstOrCreate([]);

        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'tagline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'history' => 'nullable|string',
            'vision' => 'nullable|string',
            'missions' => 'nullable|array',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:100',
            'maps_embed_url' => 'nullable|string',
            'facebook_url' => 'nullable|string|max:255',
            'instagram_url' => 'nullable|string|max:255',
            'youtube_url' => 'nullable|string|max:255',
            'principal_name' => 'nullable|string|max:150',
            'principal_title' => 'nullable|string|max:150',
            'principal_message' => 'nullable|string',
            'principal_photo' => 'nullable|string',
            'accreditation' => 'nullable|string|max:50',
            'npsn' => 'nullable|string|max:50',
            'stats' => 'nullable|array',
        ]);

        $profile->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Profil dan identitas An-Nur berhasil diperbarui.',
            'data' => $profile
        ]);
    }
}
