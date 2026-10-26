<?php

namespace Database\Seeders;

use App\Models\Principal;
use App\Models\SchoolProfile;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class SchoolProfileSeeder extends Seeder
{
    use EnsuresSafeDemoDatabase;

    public function run(): void
    {
        $this->ensureSafeDemoDatabase();
        Principal::query()->delete();
        SchoolProfile::query()->delete();

        $profile = SchoolProfile::query()->create([
            'name' => 'SD Plus An-Nur',
            'tagline' => 'Membentuk Generasi Cerdas, Qur’ani, Berkarakter, dan Mandiri',
            'description' => 'SD Plus An-Nur adalah Sekolah Dasar Swasta Islam yang mengintegrasikan Kurikulum SD Merdeka dengan nilai keislaman, tahfidz, pembiasaan ibadah, serta literasi sains dan teknologi.',
            'history' => 'SD Plus An-Nur didirikan pada 12 Juli 2012 di bawah naungan Yayasan Pendidikan Islam An-Nur Kediri. Sekolah tumbuh dengan memadukan kurikulum nasional, pembinaan adab, tahfidz, dan pembiasaan ibadah harian.',
            'vision_title' => 'Visi Sekolah',
            'vision' => ['Menjadi sekolah dasar Islam rujukan yang unggul dalam melahirkan generasi sholeh-sholehah, berprestasi, berakhlak mulia, dan siap menyongsong masa depan.'],
            'mission_title' => 'Misi Pendidikan',
            'missions' => [
                'Menyelenggarakan pembelajaran berkualitas berdasarkan Kurikulum SD Merdeka dengan penguatan nilai keislaman.',
                'Membimbing hafalan Al-Qur’an Juz 30 dan surat pilihan secara tartil dan berkesinambungan.',
                'Membudayakan adab islami, shalat berjamaah, dan kepedulian sosial sejak usia dini.',
                'Mengembangkan minat, bakat, dan kreativitas siswa melalui kegiatan intrakurikuler serta ekstrakurikuler.',
                'Menciptakan lingkungan sekolah yang aman, nyaman, ramah anak, dan kondusif untuk bertumbuh.',
            ],
            'address' => 'Kecamatan Kras, Kabupaten Kediri, Jawa Timur',
            'phone' => '0812-3456-7890',
            'whatsapp' => '+6281234567890',
            'email' => 'info@sdplusannur.sch.id',
            'maps_embed_url' => 'https://maps.google.com/maps?q=-7.8743,112.1076&hl=id&z=15&output=embed',
            'accreditation' => 'Terakreditasi A',
            'npsn' => 'SD Plus An-Nur',
            'stats' => [
                'teachers' => 13,
                'male_students' => 193,
                'female_students' => 205,
                'students' => 398,
                'class_groups' => 13,
                'classrooms' => 13,
                'library_count' => 1,
                'lab_count' => 0,
            ],
            'public_sections' => [
                'school_status' => 'Sekolah Dasar Swasta',
                'education_level' => 'Sekolah Dasar (SD)',
                'semester' => '2026/2027 Gasal',
                'location' => [
                    'coordinates' => '-7.8743, 112.1076',
                    'maps_url' => 'https://www.google.com/maps?q=-7.8743,112.1076',
                    'full_address' => 'SD Plus An-Nur, Kecamatan Kras, Kabupaten Kediri, Jawa Timur',
                ],
                'utilities' => [
                    'curriculum' => 'Kurikulum SD Merdeka',
                    'schedule' => 'Pagi / 6 hari',
                    'internet' => 'Shared',
                    'power_source' => 'PLN',
                    'power_capacity' => '3.500 VA',
                    'land_area' => '1.320 m²',
                    'library_count' => '1 Perpustakaan',
                    'lab_count' => '0 Laboratorium',
                    'service_hours' => 'Senin–Kamis 07.00–15.00 WIB; Jumat 07.00–11.30 WIB; Sabtu 07.00–13.00 WIB',
                ],
                'core_values' => [
                    ['code' => 'TAUHID', 'title' => 'Ketauhidan & Akhlak', 'desc' => 'Menanamkan kecintaan kepada Allah SWT dan Rasul-Nya serta membiasakan adab dalam keseharian.'],
                    ['code' => 'MERDEKA', 'title' => 'Merdeka Belajar', 'desc' => 'Mendorong nalar kritis, eksplorasi minat, dan kreativitas dengan pembelajaran yang berpusat pada anak.'],
                    ['code' => 'QUR’ANI', 'title' => 'Generasi Qur’ani', 'desc' => 'Membiasakan tilawah, tahsin, dan hafalan Al-Qur’an dengan pendampingan guru.'],
                    ['code' => 'PRESTASI', 'title' => 'Semangat Berprestasi', 'desc' => 'Memfasilitasi siswa berkompetisi secara sportif di bidang sains, seni, agama, dan olahraga.'],
                    ['code' => 'PEDULI', 'title' => 'Kebersamaan & Kemandirian', 'desc' => 'Menumbuhkan empati, kerja sama, dan kemandirian siswa.'],
                ],
                'facilities' => [
                    ['name' => '13 Ruang Kelas Representatif', 'capacity' => '13 rombongan belajar', 'description' => 'Ruang kelas dengan sirkulasi udara dan pencahayaan alami yang baik.'],
                    ['name' => 'Perpustakaan Sekolah Terpadu', 'capacity' => '1 unit perpustakaan', 'description' => 'Pusat literasi ramah anak dengan koleksi buku cerita dan ensiklopedia.'],
                    ['name' => 'Musholla Sekolah', 'capacity' => 'Ibadah harian siswa', 'description' => 'Sarana shalat berjamaah dan pembinaan ibadah.'],
                    ['name' => 'Area Bermain & Lapangan Olahraga', 'capacity' => 'Aktivitas olahraga dan upacara', 'description' => 'Area untuk kegiatan fisik, olahraga, dan bermain bersama.'],
                    ['name' => 'UKS & Ruang Bimbingan Siswa', 'capacity' => 'Pelayanan kesehatan pertama', 'description' => 'Sarana penanganan kesehatan dasar dan konseling siswa.'],
                    ['name' => 'Kantin Sehat & Halal', 'capacity' => 'Konsumsi harian siswa', 'description' => 'Penyedia makanan dan minuman sehat untuk warga sekolah.'],
                ],
                'history' => [
                    'founding_year' => '2012',
                    'founding_date' => '12 Juli 2012',
                    'milestones' => [
                        ['badge' => 'Awal Pendirian', 'date' => '12 Juli 2012', 'title' => 'Pembukaan Angkatan Pertama', 'desc' => 'Sekolah mulai beroperasi dengan pembelajaran dasar, tahfidz, dan pembiasaan shalat berjamaah.'],
                        ['badge' => 'Akreditasi', 'date' => '10 Agustus 2017', 'title' => 'Perolehan Akreditasi A', 'desc' => 'Sekolah meraih Akreditasi A dan mengembangkan sarana kelas, perpustakaan, serta musholla.'],
                        ['badge' => 'Kurikulum Merdeka', 'date' => '15 Juli 2022', 'title' => 'Penguatan Literasi dan Projek P5', 'desc' => 'Sekolah memperluas pembelajaran Kurikulum SD Merdeka dan kegiatan literasi digital.'],
                    ],
                ],
                'curriculum' => [
                    'overview' => 'Kurikulum SD Plus An-Nur menerapkan Kurikulum SD Merdeka yang diperkaya dengan Tahfidzul Qur’an, Tahsin Qira’ati, fiqih ibadah praktis, dan adab islami.',
                    'utilities' => ['schedule' => 'Pagi / 6 hari', 'semester' => '2026/2027 Gasal'],
                    'daily_schedule' => [
                        ['time' => '06.45 - 07.00', 'activity' => 'Penyambutan siswa oleh guru'],
                        ['time' => '07.00 - 07.30', 'activity' => 'Apel pagi, shalat Dhuha, dan tadarrus'],
                        ['time' => '07.30 - 09.15', 'activity' => 'Pembelajaran tematik dan Kurikulum SD Merdeka'],
                        ['time' => '09.15 - 09.45', 'activity' => 'Istirahat dan makan bersama'],
                        ['time' => '09.45 - 11.30', 'activity' => 'Program Tahfidz, Tahsin Qur’an, dan PAI'],
                        ['time' => '11.30 - 12.00', 'activity' => 'Shalat Zhuhur berjamaah'],
                        ['time' => '12.00 - 12.30', 'activity' => 'Istirahat siang'],
                        ['time' => '12.30 - 13.30', 'activity' => 'Projek P5 dan ekstrakurikuler'],
                        ['time' => '13.30', 'activity' => 'Doa penutup dan kepulangan siswa'],
                    ],
                ],
                'leadership' => [
                    ['name' => 'Ustadzah Siti Rahmawati, S.Pd.', 'role' => 'Wakil Kepala Sekolah Bidang Kurikulum', 'gender' => 'P', 'education' => 'S1 Pendidikan Guru Sekolah Dasar (PGSD)', 'experience' => '12 tahun mengembangkan Kurikulum Merdeka', 'bio' => 'Merancang pembelajaran berdiferensiasi serta penguatan literasi dan numerasi.'],
                    ['name' => 'Ustadz Muhammad Ilham, S.Pd.I.', 'role' => 'Koordinator Program Tahfidz & Keagamaan', 'gender' => 'L', 'education' => 'S1 Kependidikan Islam dan Hafizh Al-Qur’an', 'experience' => '10 tahun membimbing tahfidz anak', 'bio' => 'Membimbing siswa menghafal Al-Qur’an dengan metode yang menyenangkan.'],
                    ['name' => 'Dewi Anggraini, S.Pd.', 'role' => 'Koordinator Kesiswaan & Ekstrakurikuler', 'gender' => 'P', 'education' => 'S1 Pendidikan', 'experience' => '8 tahun mendampingi minat dan bakat siswa', 'bio' => 'Mengembangkan karakter kepemimpinan, disiplin, seni, dan olahraga.'],
                ],
            ],
        ]);

        Principal::query()->create([
            'school_profile_id' => $profile->id,
            'teacher_id' => $this->teacherId('Ustadz Drs. H. Maksum Ridwan'),
            'title' => 'Perintis & Peletak Pondasi Kurikulum Islam Terpadu',
            'started_at' => '2012-07-12',
            'ended_at' => '2016-06-30',
            'is_current' => false,
        ]);
        Principal::query()->create([
            'school_profile_id' => $profile->id,
            'teacher_id' => $this->teacherId('Ustadz Muhammad Syukron, S.Pd.I.'),
            'title' => 'Pengembangan Akreditasi A & Fasilitas Sekolah',
            'started_at' => '2016-07-01',
            'ended_at' => '2020-06-30',
            'is_current' => false,
        ]);
        Principal::query()->create([
            'school_profile_id' => $profile->id,
            'teacher_id' => $this->teacherId('Ustadz H. Ahmad Fauzi, S.Pd.I., M.Pd.'),
            'title' => 'Kepala Sekolah SD Plus An-Nur',
            'message' => 'Kami berikhtiar menjadikan SD Plus An-Nur sebagai rumah kedua yang membahagiakan dan membina karakter anak dengan keteladanan serta kasih sayang.',
            'started_at' => '2020-07-01',
            'is_current' => true,
        ]);
    }

    private function teacherId(string $name): string
    {
        return Teacher::query()->where('name', $name)->sole()->id;
    }
}