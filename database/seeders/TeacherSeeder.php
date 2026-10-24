<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Teacher::truncate();

        $teachers = [
            [
                'name' => 'Dr. H. Ahmad Fauzan, M.Pd.I.',
                'nip' => '19750812 200212 1 003',
                'subject' => 'Pendidikan Agama Islam & Hadits',
                'role_title' => 'Kepala Sekolah',
                'education' => 'S3 Manajemen Pendidikan Islam UIN Maliki',
                'photo' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?w=600&auto=format&fit=crop&q=80',
                'bio' => 'Penggagas kurikulum integrasi sains dan Al-Qur\'an dengan pengalaman kepemimpinan pendidikan lebih dari 20 tahun.',
                'order' => 1,
            ],
            [
                'name' => 'Ustazah Siti Aminah, S.Si., M.Pd.',
                'nip' => '19820315 200801 2 006',
                'subject' => 'Matematika Peminatan & Olimpiade',
                'role_title' => 'Wakil Kepala Sekolah Bidang Kurikulum',
                'education' => 'S2 Pendidikan Matematika Universitas Gadjah Mada',
                'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=600&auto=format&fit=crop&q=80',
                'bio' => 'Pembimbing tim olimpiade matematika nasional dengan puluhan medali OSN dan KSM tingkat nasional.',
                'order' => 2,
            ],
            [
                'name' => 'Ustaz Muhammad Rifqi, Lc., M.Ag.',
                'nip' => '19860721 201204 1 004',
                'subject' => 'Tahfidz Qur\'an & Bahasa Arab',
                'role_title' => 'Koordinator Program Tahfidz',
                'education' => 'Al-Azhar University Cairo & S2 UIN Sunan Kalijaga',
                'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=600&auto=format&fit=crop&q=80',
                'bio' => 'Hafizh 30 Juz bersanad muttashil, aktif membina santriwan dan santriwati dalam musabaqah hifdzil quran.',
                'order' => 3,
            ],
            [
                'name' => 'Bambang Kusuma, S.Pd., M.T.',
                'nip' => '19841109 201001 1 012',
                'subject' => 'Fisika & Robotika',
                'role_title' => 'Kepala Laboratorium Sains & STEM',
                'education' => 'S2 Teknik Elektro Institut Teknologi Sepuluh Nopember (ITS)',
                'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=600&auto=format&fit=crop&q=80',
                'bio' => 'Instruktur club robotika sekolah yang berhasil membawa tim An-Nur menjuarai International Robot Olympiad.',
                'order' => 4,
            ],
            [
                'name' => 'Dra. Hj. Nurul Hidayati, M.Pd.',
                'nip' => '19790418 200502 2 003',
                'subject' => 'Bahasa Inggris & TOEFL Prep',
                'role_title' => 'Wakil Kepala Sekolah Bidang Kesiswaan',
                'education' => 'S2 Pendidikan Bahasa Inggris Universitas Negeri Malang',
                'photo' => 'https://images.unsplash.com/photo-1580894732444-8ecded7900cd?w=600&auto=format&fit=crop&q=80',
                'bio' => 'Aktif membina debat bahasa Inggris, speech contest, dan program immersion study ke luar negeri.',
                'order' => 5,
            ],
            [
                'name' => 'Ahmad Zainuddin, S.Kom., M.Cs.',
                'nip' => '19900914 201601 1 007',
                'subject' => 'Informatika & Kecerdasan Buatan',
                'role_title' => 'Koordinator IT & Digital Campus',
                'education' => 'S2 Ilmu Komputer Universitas Indonesia',
                'photo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=600&auto=format&fit=crop&q=80',
                'bio' => 'Pengembang sistem digital sekolah, melatih siswa coding, IoT, dan algoritma olimpiade informatika.',
                'order' => 6,
            ],
            [
                'name' => 'Dewi Rahmawati, S.Pd., M.Biotech.',
                'nip' => '19880226 201402 2 005',
                'subject' => 'Biologi & Karya Ilmiah Remaja (KIR)',
                'role_title' => 'Pembina Riset & Inovasi Siswa',
                'education' => 'S2 Bioteknologi Universitas Brawijaya',
                'photo' => 'https://images.unsplash.com/photo-1567532939604-b6b5b0db2604?w=600&auto=format&fit=crop&q=80',
                'bio' => 'Membimbing penelitian ilmiah siswa menjuarai berbagai kompetisi sains nasional (LPIR, OPSI, dan NYS).',
                'order' => 7,
            ],
            [
                'name' => 'Farhan Maulana, S.Or.',
                'nip' => '19930510 201803 1 009',
                'subject' => 'Pendidikan Jasmani & Olahraga',
                'role_title' => 'Koordinator Ekstrakurikuler Olahraga',
                'education' => 'S1 Ilmu Keolahragaan UNY',
                'photo' => 'https://images.unsplash.com/photo-1492562080023-ab3db95bfbce?w=600&auto=format&fit=crop&q=80',
                'bio' => 'Pelatih tim futsal, basket, dan panahan sekolah yang rutin menyabet gelar juara di tingkat regional.',
                'order' => 8,
            ]
        ];

        foreach ($teachers as $t) {
            Teacher::create($t);
        }
    }
}
