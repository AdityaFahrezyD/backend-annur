<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    use EnsuresSafeDemoDatabase;

    public function run(): void
    {
        $this->ensureSafeDemoDatabase();
        Gallery::query()->delete();
        $items = [
            ['Pembelajaran Aktif Kurikulum SD Merdeka di Ruang Kelas', 'Kegiatan Belajar', '2026-10-12'],
            ['Gelar Karya Projek Penguatan Profil Pelajar Pancasila (P5)', 'Projek P5', '2026-10-10'],
            ['Bimbingan Tahfidz Juz 30 & Tahsin Al-Qur’an Pagi', 'Hafalan Qur’an', '2026-10-08'],
            ['Shalat Dhuha & Zhuhur Berjamaah di Musholla', 'Hafalan Qur’an', '2026-10-06'],
            ['Aktivitas Literasi di Perpustakaan Sekolah', 'Sarana Sekolah', '2026-10-04'],
            ['Kegiatan Pramuka Siaga & Senam Sehat', 'Kegiatan Belajar', '2026-10-02'],
        ];
        $photos = [
            'https://images.unsplash.com/photo-1580582932707-520aed937b7b?w=800&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1509062522246-3755977927d7?w=800&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1609599006353-e629aaabfeae?w=800&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1603126857599-f6e157fa2fe6?w=800&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1507842217343-583bb7270b66?w=800&auto=format&fit=crop&q=80',
            'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=80',
        ];
        foreach ($items as $index => [$title, $category, $date]) {
            Gallery::query()->create([
                'title' => $title,
                'category' => $category,
                'image' => $photos[$index],
                'description' => $title,
                'event_date' => $date,
                'status' => 'published',
            ]);
        }
    }
}