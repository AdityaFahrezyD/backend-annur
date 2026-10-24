<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Gallery::truncate();

        $galleries = [
            [
                'title' => 'Kegiatan Pembelajaran Aktif di Laboratorium Sains Modern',
                'category' => 'Kegiatan Belajar',
                'image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?w=800&auto=format&fit=crop&q=80',
                'description' => 'Siswa kelas XI MIPA melakukan praktikum analisis spektrofotometri dan bioteknologi.',
                'event_date' => '2026-10-12',
                'status' => 'published',
            ],
            [
                'title' => 'Upacara Peringatan Hari Santri & Apel Karakter Kebangsaan',
                'category' => 'Upacara & Apel',
                'image' => 'https://images.unsplash.com/photo-1577495508048-b635879837f1?w=800&auto=format&fit=crop&q=80',
                'description' => 'Khidmatnya seluruh dewan guru dan santri dalam balutan busana santri nasional.',
                'event_date' => '2026-10-22',
                'status' => 'published',
            ],
            [
                'title' => 'Tasmi\' Akbar Hafalan 30 Juz Al-Qur\'an',
                'category' => 'Kegiatan Belajar',
                'image' => 'https://images.unsplash.com/photo-1542816417-0983c9c9ad53?w=800&auto=format&fit=crop&q=80',
                'description' => 'Pelaksanaan Tasmi\' bil Ghoib sekali duduk 30 juz oleh santri Takhasus An-Nur.',
                'event_date' => '2026-09-30',
                'status' => 'published',
            ],
            [
                'title' => 'Kemenangan Tim Robotik pada Ajang National Robotic Expo',
                'category' => 'Lomba & Prestasi',
                'image' => 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=800&auto=format&fit=crop&q=80',
                'description' => 'Penyerahan trofi juara umum oleh juri kompetisi teknologi di Surabaya.',
                'event_date' => '2026-09-18',
                'status' => 'published',
            ],
            [
                'title' => 'Kegiatan Keputrian & Ekstrakurikuler Memanah (Archery)',
                'category' => 'Ekstrakurikuler',
                'image' => 'https://images.unsplash.com/photo-1511512578047-dfb367046420?w=800&auto=format&fit=crop&q=80',
                'description' => 'Latihan fokus dan ketangkasan olahraga sunnah memanah di lapangan utama sekolah.',
                'event_date' => '2026-08-25',
                'status' => 'published',
            ],
            [
                'title' => 'Fasilitas Perpustakaan Digital & Ruang Diskusi Kolaboratif',
                'category' => 'Fasilitas',
                'image' => 'https://images.unsplash.com/photo-1521587760476-6c12a4b040da?w=800&auto=format&fit=crop&q=80',
                'description' => 'Suasana belajar mandiri yang nyaman dan tenang dilengkapi ribuan e-book serta jurnal.',
                'event_date' => '2026-08-10',
                'status' => 'published',
            ]
        ];

        foreach ($galleries as $g) {
            Gallery::create($g);
        }
    }
}
