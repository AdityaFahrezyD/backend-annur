<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    use EnsuresSafeDemoDatabase;

    public function run(): void
    {
        $this->ensureSafeDemoDatabase();
        Achievement::query()->delete();

        $items = [
            ['Juara 1 Olimpiade Sains Nasional (OSN) Matematika SD', 'Akademik (OSN)', 'Kabupaten', '2026', 'Muhammad Rayyan Al-Ghifari (Kelas 5)', 'Dinas Pendidikan Kabupaten Kediri', 'Meraih nilai tertinggi pada babak final olimpiade matematika sekolah dasar dalam pemecahan soal logika numerasi dan geometri.'],
            ['Juara 1 Musabaqah Hifdzil Qur\'an (MHQ) Juz 30 Tingkat SD', 'Keagamaan & Tahfidz', 'Kabupaten', '2026', 'Ahmad Zaidan Al-Fatih (Kelas 4)', 'Lembaga Pengembangan Tilawatil Qur\'an (LPTQ) & Kemenag', 'Menyelesaikan tasmi\' hafalan surat-surat Juz 30 dengan kelancaran sempurna, tartil, dan fashahah makharijul huruf prima.'],
            ['Juara 1 FLS2N Lomba Gambar Bercerita Tingkat SD', 'Seni & Literasi', 'Kabupaten', '2025', 'Aisyah Putri Humaira (Kelas 3)', 'Dinas Pendidikan Kabupaten Kediri', 'Karya gambar kreatif bertema \'Sekolah Ramah Anak dan Kebersihan Lingkungan\' dengan pewarnaan ekspresif dan makna mendalam.'],
            ['Juara 1 O2SN Catur Cepat Perorangan Putra Tingkat SD', 'Olahraga (O2SN)', 'Kabupaten', '2025', 'Faris Maulana Ibrahim (Kelas 5)', 'BAPOPSI & Dinas Pendidikan Kabupaten', 'Berhasil meraih rekor tak terkalahkan dalam 6 babak pertandingan catur cepat junior sekolah dasar.'],
            ['Juara 2 OSN IPA Sekolah Dasar Tingkat Kabupaten', 'Akademik (OSN)', 'Kabupaten', '2025', 'Nayla Safira Khairunnisa (Kelas 5)', 'Dinas Pendidikan Kabupaten Kediri', 'Menampilkan solusi ilmiah aplikatif dalam uji eksperimen sains sederhana tentang ekosistem dan energi terbarukan.'],
            ['Juara 1 Lomba Pildacil (Pemilihan Da\'i Cilik) Pentas PAI', 'Keagamaan & Tahfidz', 'Kecamatan & Finalis Kabupaten', '2025', 'Bilal Habibi Ramadhan (Kelas 4)', 'Kelompok Kerja Guru (KKG) PAI SD', 'Menyampaikan ceramah bertema \'Adab Anak Sholeh kepada Orang Tua dan Guru\' dengan tutur kata santun, lugas, dan percaya diri.'],
            ['Juara 1 Lomba Kaligrafi Khath Naskhi Pentas PAI SD', 'Seni & Literasi', 'Kabupaten', '2024', 'Fatimah Nurul Izzah (Kelas 5)', 'Dinas Pendidikan & Kemenag Kabupaten', 'Menulis ayat Al-Qur\'an dengan kaidah khath naskhi yang sangat rapi, bersih, dan berestetika tinggi.'],
            ['Juara 2 O2SN Cabang Bulutangkis Tunggal Usia Dini SD', 'Olahraga (O2SN)', 'Kabupaten', '2024', 'Raditya Dwi Pratama (Kelas 4)', 'Pengkab PBSI & Dinas Pendidikan', 'Meraih medali perak setelah perjuangan tangguh hingga babak final kejuaraan bulutangkis pelajar SD se-kabupaten.'],
        ];

        foreach ($items as [$title, $category, $level, $year, $recipient, $organizer, $description]) {
            Achievement::query()->create([
                'title' => $title,
                'category' => $category,
                'level' => $level,
                'year' => $year,
                'recipient_name' => $recipient,
                'organizer' => $organizer,
                'description' => $description,
                'status' => 'published',
            ]);
        }
    }
}