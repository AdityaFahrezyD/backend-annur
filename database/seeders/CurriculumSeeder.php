<?php

namespace Database\Seeders;

use App\Models\Curriculum;
use Illuminate\Database\Seeder;

class CurriculumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Curriculum::truncate();

        $curriculums = [
            [
                'title' => 'Kurikulum Merdeka Mandiri Berbagi',
                'code' => 'KUR-MERDEKA',
                'level' => 'Tingkat Nasional Unggulan',
                'description' => 'Penerapan kurikulum nasional yang berpusat pada minat dan bakat murid, didukung dengan pembelajaran berbasis proyek (P5) dan penguatan kompetensi esensial penalaran kritis serta literasi teknologi.',
                'features' => [
                    'Pilihan mata pelajaran fleksibel sesuai peminatan jenjang karir dan jurusan kuliah',
                    'Asesmen diagnostik bakat dan minat sejak kelas X',
                    'Proyek Penguatan Profil Pelajar Pancasila yang aplikatif bagi masyarakat',
                    'Bimbingan intensif persiapan UTBK-SNBT dan seleksi PTN sejak dini'
                ],
                'order' => 1,
                'status' => 'published',
            ],
            [
                'title' => 'Program Unggulan Tahfidz Al-Qur\'an Bersanad',
                'code' => 'KUR-TAHFIDZ',
                'level' => 'Keislaman & Karakter',
                'description' => 'Program pembinaan hafalan Al-Qur\'an dengan metode talaqqi dan muroja\'ah terstruktur, dibimbing langsung oleh huffazh bersanad dengan target minimal hafalan 5 juz hingga 30 juz bagi kelas khusus takhasus.',
                'features' => [
                    'Target hafalan terukur dan berjenjang (Reguler: 5 Juz, Takhasus: 30 Juz)',
                    'Sertifikasi tashih tajwid dan makhraj bersanad muttashil',
                    'Halaqah Qur\'an harian pada waktu Subuh dan Ashar',
                    'Ujian Tasmi\' Terbuka di hadapan orang tua dan asatidz'
                ],
                'order' => 2,
                'status' => 'published',
            ],
            [
                'title' => 'Bilingual & International Competency Program',
                'code' => 'KUR-INTL',
                'level' => 'Global Readiness',
                'description' => 'Pengembangan kemampuan komunikasi aktif dalam Bahasa Arab dan Bahasa Inggris melalui kurikulum terapan, pendampingan native speaker, serta sertifikasi TOEFL/IELTS dan TOAFL.',
                'features' => [
                    'English & Arabic Speaking Zone di lingkungan sekolah dan asrama',
                    'Persiapan dan simulasi ujian IELTS/TOEFL resmi',
                    'Program pertukaran budaya dan International Student Camp',
                    'Pelatihan Public Speaking dan International Debate'
                ],
                'order' => 3,
                'status' => 'published',
            ],
            [
                'title' => 'STEM & Riset Terapan (Science, Tech, Engineering & Math)',
                'code' => 'KUR-STEM',
                'level' => 'Inovasi & Teknologi',
                'description' => 'Program pembelajaran kontekstual berbasis riset laboratorium, robotika, coding kecerdasan buatan, dan karya ilmiah remaja untuk mempersiapkan generasi inovator masa depan.',
                'features' => [
                    'Laboratorium Terpadu: Biologi, Kimia, Fisika, Komputer AI, dan Robotika',
                    'Wajib Karya Ilmiah Remaja (KIR) sebagai syarat kelulusan',
                    'Mentoring riset bersama dosen dan praktisi perguruan tinggi mitra',
                    'Akses ke jurnal ilmiah dan kompetisi inovasi teknologi internasional'
                ],
                'order' => 4,
                'status' => 'published',
            ]
        ];

        foreach ($curriculums as $cu) {
            Curriculum::create($cu);
        }
    }
}
