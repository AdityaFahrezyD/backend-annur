<?php

namespace Database\Seeders;

use App\Models\Competition;
use Illuminate\Database\Seeder;

class CompetitionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Competition::truncate();

        $competitions = [
            [
                'title' => 'An-Nur Islamic & Science Olympiad (AISO) 2026',
                'organizer' => 'OSIS & SMA IT An-Nur Kediri',
                'category' => 'Akademik & Sains',
                'description' => 'Kompetisi tahunan bergengsi tingkat SMP/MTs sederajat se-Indonesia mencakup bidang Matematika Terintegrasi, IPA, IPS, dan Cerdas Cermat Islam.',
                'registration_deadline' => '2026-11-20',
                'event_date' => '2026-12-05',
                'location' => 'Kampus Utama SMA IT An-Nur Kediri & Daring',
                'guide_book_url' => 'https://annur.sch.id/files/juknis_aiso_2026.pdf',
                'banner_image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=80',
                'is_featured' => true,
                'status' => 'published',
            ],
            [
                'title' => 'Musabaqah Hifdzil Qur\'an & Tilawah Pelajar Nusantara 2026',
                'organizer' => 'Pusat Studi Al-Qur\'an SMA IT An-Nur',
                'category' => 'Keagamaan',
                'description' => 'Lomba MHQ kategori 3 Juz, 5 Juz, dan 10 Juz serta Tilawah Al-Qur\'an memperebutkan Piala Bergilir Walikota Kediri dan Beasiswa Pendidikan.',
                'registration_deadline' => '2026-11-15',
                'event_date' => '2026-11-28',
                'location' => 'Masjid Raya An-Nur Kediri',
                'guide_book_url' => 'https://annur.sch.id/files/juknis_mhq_2026.pdf',
                'banner_image' => 'https://images.unsplash.com/photo-1542816417-0983c9c9ad53?w=800&auto=format&fit=crop&q=80',
                'is_featured' => true,
                'status' => 'published',
            ],
            [
                'title' => 'An-Nur National Robotic & Coding Challenge (ANRCC) 2026',
                'organizer' => 'STEM Innovation Lab An-Nur',
                'category' => 'Teknologi & Robotik',
                'description' => 'Tantangan merancang Line Follower, Creative IoT, dan Game Development dengan Scratch & Python untuk pelajar tingkat SMP/MTs dan SMA/MA.',
                'registration_deadline' => '2026-12-01',
                'event_date' => '2026-12-15',
                'location' => 'Hall Serbaguna An-Nur',
                'guide_book_url' => 'https://annur.sch.id/files/juknis_robotik_2026.pdf',
                'banner_image' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?w=800&auto=format&fit=crop&q=80',
                'is_featured' => false,
                'status' => 'published',
            ]
        ];

        foreach ($competitions as $c) {
            Competition::create($c);
        }
    }
}
