<?php

namespace Database\Seeders;

use App\Models\Principal;
use App\Models\SchoolProfile;
use Illuminate\Database\Seeder;

class SchoolProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Principal::query()->delete();
        SchoolProfile::query()->delete();

        $profile = SchoolProfile::create([
            'name' => 'SMA Islam Terpadu An-Nur',
            'tagline' => 'Membentuk Generasi Berakhlak Mulia, Cerdas, dan Berprestasi Global',
            'description' => 'SMA IT An-Nur adalah institusi pendidikan menengah atas unggulan yang memadukan keunggulan akademik Kurikulum Nasional dengan penanaman nilai-nilai keislaman, penguasaan bahasa internasional, dan teknologi terkini untuk melahirkan calon pemimpin masa depan.',
            'history' => 'Didirikan pada tahun 2012 di Kediri, SMA IT An-Nur tumbuh menjadi pusat keunggulan pendidikan Islam modern di Jawa Timur. Dengan fasilitas terintegrasi dan pendidik berdedikasi, kami telah mengantarkan ribuan alumni menembus perguruan tinggi negeri terbaik dan kampus ternama di dalam maupun luar negeri.',
            'vision' => 'Menjadi institusi pendidikan menengah terkemuka yang melahirkan generasi beriman, berakhlak mulia, berwawasan global, dan unggul dalam ilmu pengetahuan dan teknologi.',
            'missions' => [
                'Menyelenggarakan proses pembelajaran berkualitas yang mengintegrasikan kurikulum nasional dengan nilai-nilai Islam.',
                'Membina karakter peserta didik melalui pembiasaan ibadah, adab, dan kepemimpinan yang berakhlakul karimah.',
                'Mengembangkan potensi intelektual dan keterampilan abad 21 melalui riset, teknologi, dan bahasa asing.',
                'Mempersiapkan lulusan yang kompetitif untuk melanjutkan pendidikan ke perguruan tinggi unggulan nasional dan global.',
                'Mewujudkan tata kelola sekolah yang profesional, transparan, dan berbasis teknologi informasi.',
            ],
            'address' => 'Jl. Pemuda No. 45, Mojoroto, Kota Kediri, Jawa Timur 64114',
            'phone' => '(0354) 778899',
            'whatsapp' => '+6281234567890',
            'email' => 'info@annur.sch.id',
            'maps_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.8854498328655!2d112.0118!3d-7.8242!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zN8KwNDknMjcuMSJTIDExMsKwMDAnNDIuNSJF!5e0!3m2!1sid!2sid!4v1600000000000!5m2!1sid!2sid',
            'facebook_url' => 'https://facebook.com/smaitannurkediri',
            'instagram_url' => 'https://instagram.com/smait_annurkediri',
            'youtube_url' => 'https://youtube.com/@smaitannurofficial',
            'accreditation' => 'A (Unggul) - BAN-S/M',
            'npsn' => '20539182',
            'stats' => [
                'students' => 720,
                'teachers' => 52,
                'achievements' => 148,
                'graduates_ptn' => '96%',
            ],
        ]);

        Principal::create([
            'school_profile_id' => $profile->id,
            'name' => 'Dr. H. Ahmad Fauzan, M.Pd.I.',
            'title' => 'Kepala Sekolah SMA IT An-Nur',
            'message' => 'Selamat datang di portal resmi SMA IT An-Nur. Kami berikhtiar mendidik para santri dan siswa dengan cinta, disiplin, dan ilmu pengetahuan. Di era globalisasi ini, keseimbangan antara keteguhan spiritual dan keunggulan intelektual adalah kunci mencetak pemimpin bangsa yang rahmatan lil alamin.',
            'photo' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?w=600&auto=format&fit=crop&q=80',
            'is_current' => true,
        ]);
    }
}
