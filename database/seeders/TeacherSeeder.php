<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    use EnsuresSafeDemoDatabase;

    public function run(): void
    {
        $this->ensureSafeDemoDatabase();
        Teacher::query()->whereDoesntHave('principals')->delete();

        $teachers = [
            ['Ustadz H. Ahmad Fauzi, S.Pd.I., M.Pd.', 'L', 'Pimpinan & PAI', 'Kepala Sekolah & Pembina Keagamaan', 'S1 Pendidikan Agama Islam & S2 Manajemen Pendidikan', '15 tahun pengabdian di pendidikan dasar Islam', ['Sertifikasi Pendidik Profesional', 'Penguji Tahsin Al-Qur\'an'], 'Membina karakter anak dengan keteladanan dan kasih sayang.', true],
            ['Ustadzah Siti Rahmawati, S.Pd.', 'P', 'Guru Kelas', 'Wakasek Kurikulum & Guru Kelas 1', 'S1 Pendidikan Guru Sekolah Dasar (PGSD)', '12 Tahun Mengajar', ['Pelatih Implementasi Kurikulum Merdeka', 'Fasilitator Literasi Awal'], 'Setiap anak adalah bintang yang unik, tugas kita membantunya bersinar cemerlang.', true],
            ['Ustadz Muhammad Ilham, S.Pd.I.', 'L', 'Tahfidz & PAI', 'Koordinator Program Tahfidz & Guru PAI', 'S1 Kependidikan Islam & Hafizh Al-Qur\'an', '10 Tahun Mengajar', ['Sertifikasi Metode Qira\'ati & Tilawati', 'Hafizh Juz 30 Bersanad'], 'Membimbing lisan mungil anak-anak melantunkan kalam Ilahi adalah anugerah terindah.', true],
            ['Dewi Anggraini, S.Pd.', 'P', 'Guru Kelas', 'Koordinator Kesiswaan & Guru Kelas 2', 'S1 Pendidikan Guru Sekolah Dasar (PGSD)', '8 Tahun Mengajar', ['Pembina Pramuka Siaga Mahir', 'Konselor Anak Usia Dini'], 'Karakter disiplin dan kemandirian dipupuk melalui keteladanan dan kasih sayang setiap hari.', true],
            ['Budi Santoso, S.Pd.', 'L', 'Guru Kelas', 'Guru Kelas 3 & Pembina Ekstrakurikuler Sains', 'S1 Pendidikan Matematika & IPA', '9 Tahun Mengajar', ['Pelatih Olimpiade Matematika SD', 'Instruktur Media Pembelajaran Digital'], 'Belajar sains di SD adalah petualangan seru menemukan keajaiban ciptaan Tuhan.', false],
            ['Nurul Hidayati, S.Pd.', 'P', 'Guru Kelas', 'Guru Kelas 4 & Pembimbing Lomba Baca Puisi', 'S1 Pendidikan Bahasa dan Sastra Indonesia', '7 Tahun Mengajar', ['Penggerak Literasi Sekolah', 'Juri Lomba Menulis Cerita Anak'], 'Membaca membuka jendela dunia, menulis mencatat jejak kebaikan generasi bangsa.', false],
            ['Ahmad Zaki Mubarok, S.Pd.', 'L', 'Guru Kelas', 'Guru Kelas 5 & Pembimbing Proyek Penguatan Profil Pelajar Pancasila (P5)', 'S1 Pendidikan Guru Sekolah Dasar (PGSD)', '11 Tahun Mengajar', ['Koordinator Projek P5', 'Pelatih Debat & Public Speaking Cilik'], 'Menempa siswa bergotong royong, bernalar kritis, dan mencintai tanah air.', false],
            ['Endang Sulistiyani, S.Pd.', 'P', 'Guru Kelas', 'Guru Kelas 6 & Koordinator Sukses Asesmen Standar Nasional', 'S1 Pendidikan Guru Sekolah Dasar (PGSD)', '14 Tahun Mengajar', ['Penyusun Modul Asesmen SD', 'Guru Berprestasi Tingkat Kecamatan/Kabupaten'], 'Mengantarkan siswa lulus dengan integritas moral tinggi dan bekal ilmu terbaik.', false],
            ['Rizki Pratama, S.Pd.', 'L', 'PJOK & Kesehatan', 'Guru Pendidikan Jasmani, Olahraga, & Kesehatan (PJOK)', 'S1 Pendidikan Kepelatihan Olahraga', '6 Tahun Mengajar', ['Pelatih Futsal Lisensi D Nasional', 'Pelatih Renang Dasar Anak'], 'Tubuh yang sehat dan bugar adalah sarana terbaik untuk beribadah dan giat belajar.', false],
            ['Sarah Fatimah, S.Pd.', 'P', 'Bahasa Inggris', 'Guru Bahasa Inggris (English Fun Club)', 'S1 Pendidikan Bahasa Inggris', '5 Tahun Mengajar', ['Certified English for Young Learners (TEYL)', 'IELTS Certified'], 'English is easy and fun when learned through songs, games, and daily stories.', false],
            ['Ustadz Lukman Hakim, S.Hum.', 'L', 'Bahasa Arab & Tahfidz', 'Guru Bahasa Arab Dasar & Tahsin Al-Qur\'an', 'S1 Bahasa dan Sastra Arab', '7 Tahun Mengajar', ['Instruktur Tartil Qur\'an', 'Pelatih Kaligrafi Islam Dasar'], 'Bahasa Arab mendekatkan hati anak-anak kepada pemahaman doa dan ayat Al-Qur\'an.', false],
            ['Fitri Handayani, S.Pd.', 'P', 'Seni Budaya & Prakarya', 'Guru SBdP & Pembina Sanggar Seni Siswa', 'S1 Pendidikan Seni Rupa & Desain', '6 Tahun Mengajar', ['Instruktur Seni Kriya Anak', 'Pelatih Menggambar & Mewarnai Kreatif'], 'Seni mengasah kelembutan rasa, melatih kesabaran, dan memancarkan estetika islami.', false],
            ['Wahyu Tri Utomo, S.Kom.', 'L', 'Teknologi & Literasi Digital', 'Guru Komputer, Dasar Koding & Pengelola Perpustakaan', 'S1 Sistem Informasi & Kependidikan Komputer', '8 Tahun Mengajar', ['Pelatih Coding for Kids (Scratch & Blockly)', 'Pustakawan Sekolah Bersertifikat'], 'Mengenalkan teknologi sejak dini secara bijak dan kreatif untuk kebaikan umat.', false],
        ];

        foreach ($teachers as $index => [$name, $gender, $subject, $role, $education, $experience, $certifications, $bio, $isLeadership]) {
            Teacher::query()->updateOrCreate(
                ['name' => $name],
                [
                    'gender' => $gender,
                    'subject' => $subject,
                    'role_title' => $role,
                    'education' => $education,
                    'experience' => $experience,
                    'certifications' => $certifications,
                    'bio' => $bio,
                    'photo' => $name === 'Ustadz H. Ahmad Fauzi, S.Pd.I., M.Pd.'
                        ? '/images/kepala-sekolah.jpg'
                        : null,
                    'is_leadership' => $isLeadership,
                    'is_active' => true,
                    'order' => $index + 1,
                ],
            );
        }

        foreach ([
            [
                'name' => 'Ustadz Drs. H. Maksum Ridwan',
                'title' => 'Perintis & Peletak Pondasi Kurikulum Islam Terpadu',
            ],
            [
                'name' => 'Ustadz Muhammad Syukron, S.Pd.I.',
                'title' => 'Mantan Kepala Sekolah SD Plus An-Nur',
            ],
        ] as $index => $formerPrincipal) {
            Teacher::query()->updateOrCreate(
                ['name' => $formerPrincipal['name']],
                [
                    'gender' => 'L',
                    'subject' => 'Pimpinan',
                    'role_title' => $formerPrincipal['title'],
                    'education' => null,
                    'experience' => null,
                    'certifications' => [],
                    'bio' => null,
                    'photo' => null,
                    'is_leadership' => true,
                    'is_active' => false,
                    'order' => -2 + $index,
                ],
            );
        }

    }
}