<?php

namespace Database\Seeders;

use App\Models\CurriculumPillar;
use App\Models\Phase;
use Illuminate\Database\Seeder;

class CurriculumContentSeeder extends Seeder
{
    use EnsuresSafeDemoDatabase;

    public function run(): void
    {
        $this->ensureSafeDemoDatabase();
        CurriculumPillar::query()->delete();
        Phase::query()->delete();

        $pillars = [
            ['Kurikulum SD Merdeka', 'Standar Kemendikbudristek', 'Pembelajaran intrakurikuler berdiferensiasi yang memfasilitasi setiap siswa mengeksplorasi konsep sesuai tahap pencapaian perkembangan belajarnya.', ['iconName' => 'BookOpen', 'points' => ['Fokus pada materi esensial literasi membaca dan numerasi kontekstual', 'Pembelajaran mendalam (deep learning) dan bermakna ramah anak', 'Penilaian berkala berbasis asesmen diagnostik dan formatif', 'Waktu belajar pagi / 6 hari kerja sekolah teratur dan efektif']], 1],
            ['Projek Penguatan Profil Pelajar Pancasila (P5)', 'Karakter & Kebangsaan', 'Kegiatan kokurikuler berbasis projek nyata untuk menumbuhkan karakter beriman, bertaqwa, berakhlak mulia, bernalar kritis, dan gotong royong.', ['iconName' => 'Sparkles', 'points' => ['Tema Kearifan Lokal dan Cinta Lingkungan Hidup', 'Projek Kewirausahaan Cilik & Market Day Siswa', 'Tema Bhinneka Tunggal Ika & Kepedulian Sosial Siswa', 'Gelar Karya & Pameran Kreativitas Siswa setiap semester']], 2],
            ['Program Tahfidz & Keislaman Plus', 'Ciri Khas Keislaman', 'Program pembinaan keagamaan intensif mencakup hafalan Al-Qur\'an Juz 30, tahsin metode teruji, hafalan doa harian, dan praktik ibadah.', ['iconName' => 'Award', 'points' => ['Target hafalan tuntas Juz 30 dan surat-surat pilihan dengan tartil', 'Pembimbingan tahsin makharijul huruf bersama ustadz/ustadzah kompeten', 'Pembiasaan shalat Dhuha, shalat Zhuhur berjamaah, dan dzikir bersama', 'Munaqasyah dan Tasmi\' Hafalan Juz 30 berkala']], 3],
            ['Literasi Digital & Bahasa Dasar', 'Kecakapan Abad 21', 'Pengenalan dasar percakapan bahasa Inggris dan bahasa Arab sederhana, serta pengenalan literasi komputer ramah anak.', ['iconName' => 'Building', 'points' => ['English Fun Club: kosakata harian, bernyanyi, dan percakapan sederhana', 'Bahasa Arab Dasar untuk memahami bacaan shalat dan doa harian', 'Literasi komputer dasar & koding logika logika ramah anak di perpustakaan', 'Ekstrakurikuler Pramuka Siaga/Penggalang, Futsal, Seni Kriya, dan Beladiri']], 4],
        ];

        foreach ($pillars as [$title, $subtitle, $description, $features, $order]) {
            CurriculumPillar::query()->create([
                'title' => $title,
                'subtitle' => $subtitle,
                'code' => strtolower(str_replace(' ', '-', $title)),
                'description' => $description,
                'features' => $features,
                'order' => $order,
                'status' => 'published',
            ]);
        }

        $phases = [
            ['Fase Transisi & Literasi Fondasi', 'Fase A (Kelas 1 - 2)', 'Membantu anak beradaptasi dari TK ke jenjang SD dengan pendekatan belajar menyenangkan, menguatkan fondasi calistung kontekstual, dan pembiasaan adab.', ['ageRange' => 'Usia 6 - 8 Tahun', 'focus' => 'Adaptasi Sekolah Menyenangkan, Membaca Lancar, & Hafalan Surat Pendek', 'key_competencies' => ['Lancar membaca kalimat sederhana dan berhitung dasar', 'Hafalan Surat An-Nas sampai dengan Surat Al-Kafirun', 'Hafalan doa-doa harian (makan, tidur, masuk masjid, orang tua)', 'Kemandirian merapikan perlengkapan sekolah dan bersosialisasi'], 'hours' => 'Pagi (07.00 - 12.00 WIB)'], 5],
            ['Fase Pengembangan Nalar & Kemandirian', 'Fase B (Kelas 3 - 4)', 'Mengembangkan nalar logis matematika, rasa ingin tahu sains alam, memperdalam kemampuan tahsin tilawah, dan kerja sama kelompok.', ['ageRange' => 'Usia 8 - 10 Tahun', 'focus' => 'Literasi-Numerasi Lanjutan, Tahfidz Juz 30 Pertengahan, & Eksplorasi Sains', 'key_competencies' => ['Pemecahan soal cerita matematika dan literasi paragraf panjang', 'Hafalan Surat Al-Ma\'un sampai dengan Surat Ad-Dhuha', 'Praktik wudhu dan shalat fardhu secara mandiri dan tertib', 'Keaktifan dalam kegiatan projek kelompok P5 dan kepramukaan'], 'hours' => 'Pagi (07.00 - 13.00 WIB)'], 6],
            ['Fase Pemantapan & Kepemimpinan', 'Fase C (Kelas 5 - 6)', 'Memantapkan kompetensi akademik asesmen nasional, penyelesaian target hafalan Juz 30, serta pembentukan karakter kepemimpinan dan kematangan akhlak.', ['ageRange' => 'Usia 10 - 12 Tahun', 'focus' => 'Tuntas Hafalan Juz 30, Sukses Asesmen Standar, & Kesiapan Melanjutkan ke SMP/MTs', 'key_competencies' => ['Khatam dan tuntas tasmi\' hafalan Juz 30 berpredikat baik', 'Kesiapan optimal menghadapi Asesmen Standar Pendidikan', 'Kepemimpinan regu pramuka dan petugas upacara bendera', 'Kesiapan matang melanjutkan ke SMP/MTs atau pondok pesantren'], 'hours' => 'Pagi (07.00 - 13.30 WIB)'], 7],
        ];

        foreach ($phases as [$title, $phaseName, $description, $features, $order]) {
            Phase::query()->create([
                'title' => $title,
                'phase_name' => $phaseName,
                'code' => strtolower(str_replace(' ', '-', $title)),
                'description' => $description,
                'features' => $features,
                'order' => $order,
                'status' => 'published',
            ]);
        }
    }
}
