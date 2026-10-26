<?php

namespace Database\Seeders;

use App\Models\Competition;
use Illuminate\Database\Seeder;

class CompetitionSeeder extends Seeder
{
    use EnsuresSafeDemoDatabase;

    public function run(): void
    {
        $this->ensureSafeDemoDatabase();
        Competition::query()->delete();
        $items = [
            ['An-Nur Kids Science & Islamic Festival 2026', 'Panitia SD Plus An-Nur', 'Sains & Tahfidz', 'Tingkat Kabupaten & Provinsi', 'Pendaftaran Dibuka', '2026-11-18', '2026-11-15', 'Kampus SD Plus An-Nur, Kediri', 'Kompetisi MHQ Juz 30, olimpiade matematika, serta lomba menggambar tingkat SD/MI.'],
            ['Seleksi Olimpiade Sains Nasional Tingkat SD', 'SD Plus An-Nur', 'Matematika & IPA SD', 'Tingkat Kabupaten', 'Pembinaan Khusus', '2026-12-01', null, 'SD Plus An-Nur, Kediri', 'Bimbingan intensif bagi delegasi siswa dalam mata pelajaran Matematika dan IPA.'],
            ['Pentas Seni & Gelar Karya Projek P5', 'SD Plus An-Nur', 'Kreativitas & Seni', 'Tingkat Sekolah', 'Segera Hadir', '2027-01-15', null, 'SD Plus An-Nur, Kediri', 'Pameran karya siswa, market day, serta penampilan tari dan puisi islami.'],
        ];
        foreach ($items as [$title, $organizer, $category, $level, $displayStatus, $eventDate, $deadline, $location, $description]) {
            Competition::query()->create([
                'title' => $title,
                'organizer' => $organizer,
                'category' => $category,
                'level' => $level,
                'display_status' => $displayStatus,
                'event_date' => $eventDate,
                'registration_deadline' => $deadline,
                'location' => $location,
                'description' => $description,
                'is_featured' => true,
                'status' => 'published',
            ]);
        }
    }
}