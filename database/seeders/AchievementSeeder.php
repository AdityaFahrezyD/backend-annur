<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Achievement::truncate();

        $achievements = [
            [
                'title' => 'Medali Emas Olimpiade Sains Nasional (OSN) Bidang Matematika',
                'category' => 'Akademik',
                'level' => 'Nasional',
                'year' => '2026',
                'recipient_name' => 'Muhammad Azka Pratama (Kelas XII MIPA 1)',
                'description' => 'Meraih peringkat 1 nasional dalam ajang OSN yang diselenggarakan oleh Puspresnas Kemendikbudristek di Jakarta.',
                'image' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?w=800&auto=format&fit=crop&q=80',
                'status' => 'published',
            ],
            [
                'title' => 'Juara 1 Musabaqah Hifdzil Qur\'an (MHQ) 30 Juz Tingkat Provinsi Jawa Timur',
                'category' => 'Keagamaan',
                'level' => 'Provinsi',
                'year' => '2026',
                'recipient_name' => 'Fatimah Az-Zahra (Kelas XI Agama)',
                'description' => 'Menampilkan hafalan Al-Qur\'an yang tartil, tajwid mutqin, dan fashahah pada MTQ Pelajar se-Jawa Timur.',
                'image' => 'https://images.unsplash.com/photo-1609599006353-e629aaabfeae?w=800&auto=format&fit=crop&q=80',
                'status' => 'published',
            ],
            [
                'title' => 'Best Innovation Award - International Youth Robot Competition (IYRC)',
                'category' => 'Sains',
                'level' => 'Internasional',
                'year' => '2025',
                'recipient_name' => 'Tim Robotic An-Nur (Rayhan & Ilham)',
                'description' => 'Menciptakan prototipe robot pemilah sampah otomatis berbasis AI dan Computer Vision di Daejeon, Korea Selatan.',
                'image' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?w=800&auto=format&fit=crop&q=80',
                'status' => 'published',
            ],
            [
                'title' => 'Juara 1 National English Debate Championship (NEDC)',
                'category' => 'Akademik',
                'level' => 'Nasional',
                'year' => '2025',
                'recipient_name' => 'An-Nur Debate Club (Nadia, Kevin, Aulia)',
                'description' => 'Memenangkan babak grand final debat bahasa Inggris sistem Parliamentary di Universitas Indonesia.',
                'image' => 'https://images.unsplash.com/photo-1577495508048-b635879837f1?w=800&auto=format&fit=crop&q=80',
                'status' => 'published',
            ],
            [
                'title' => 'Juara Umum Kejuaraan Panahan Tradisional Pelajar se-Jawa Timur',
                'category' => 'Olahraga',
                'level' => 'Provinsi',
                'year' => '2025',
                'recipient_name' => 'Tim Panahan Jemparingan An-Nur',
                'description' => 'Meraih 4 medali emas dan 2 medali perak dalam kejuaraan panahan tradisional sunnah.',
                'image' => 'https://images.unsplash.com/photo-1511512578047-dfb367046420?w=800&auto=format&fit=crop&q=80',
                'status' => 'published',
            ],
            [
                'title' => 'Medali Perak Olimpiade Penelitian Siswa Indonesia (OPSI)',
                'category' => 'Sains',
                'level' => 'Nasional',
                'year' => '2025',
                'recipient_name' => 'Siti Khadijah & Sarah Bella',
                'description' => 'Penelitian formulasi pestisida nabati ramah lingkungan berbahan ekstrak daun mimba dan tembakau lokal.',
                'image' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?w=800&auto=format&fit=crop&q=80',
                'status' => 'published',
            ]
        ];

        foreach ($achievements as $a) {
            Achievement::create($a);
        }
    }
}
