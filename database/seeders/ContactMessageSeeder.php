<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use App\Models\ContactNote;
use App\Models\User;
use Illuminate\Database\Seeder;

class ContactMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactMessage::truncate();
        ContactNote::truncate();

        $admin = User::where('role', 'admin')->first();
        $staff = User::where('role', 'staff')->first() ?? $admin;

        $c1 = ContactMessage::create([
            'visitor_name' => 'H. Suherman Sasmita',
            'email' => 'suherman.sasmita@gmail.com',
            'phone' => '081298765432',
            'subject' => 'Informasi PPDB Kelas Takhasus Tahfidz Tahun Ajaran Baru',
            'message' => 'Assalamu\'alaikum wr wb. Saya ingin menanyakan jadwal pendaftaran dan syarat masuk untuk program takhasus tahfidz putra. Apakah ada tes seleksi khusus hafalan?',
            'ip_address' => '127.0.0.1',
            'crm_status' => 'in_progress',
            'priority' => 'high',
            'handled_by' => $admin ? $admin->id : null,
            'last_contacted_at' => now()->subHours(4),
        ]);

        ContactNote::create([
            'contact_message_id' => $c1->id,
            'user_id' => $admin ? $admin->id : null,
            'author_name' => $admin ? $admin->name : 'Administrator An-Nur',
            'note' => 'Sudah ditelepon via WhatsApp. Orang tua siswa sangat berminat, berkas brosur dan jadwal tes seleksi sudah dikirimkan via email.',
        ]);

        ContactNote::create([
            'contact_message_id' => $c1->id,
            'user_id' => $staff ? $staff->id : null,
            'author_name' => $staff ? $staff->name : 'Adit - Staff Humas & CRM',
            'note' => 'Follow up kedua: calon wali santri akan berkunjung ke sekolah hari Sabtu untuk survei asrama.',
        ]);

        $c2 = ContactMessage::create([
            'visitor_name' => 'Ibu Ratih Kusumaningrum',
            'email' => 'ratih.kusuma@perusahaan.co.id',
            'phone' => '081345678910',
            'subject' => 'Undangan Kerjasama Beasiswa CSR Pendidikan',
            'message' => 'Selamat siang, kami dari Divisi CSR ingin mendiskusikan peluang pemberian beasiswa penuh bagi 5 siswa berprestasi di SMA IT An-Nur. Mohon nomor kontak bagian humas yang dapat kami hubungi.',
            'ip_address' => '127.0.0.1',
            'crm_status' => 'contacted',
            'priority' => 'urgent',
            'handled_by' => $staff ? $staff->id : null,
            'last_contacted_at' => now()->subDay(),
        ]);

        ContactNote::create([
            'contact_message_id' => $c2->id,
            'user_id' => $staff ? $staff->id : null,
            'author_name' => $staff ? $staff->name : 'Adit - Staff Humas & CRM',
            'note' => 'Proposal profil sekolah dan data siswa berprestasi telah dikirimkan ke email Ibu Ratih. Menunggu jadwal rapat via Zoom.',
        ]);

        $c3 = ContactMessage::create([
            'visitor_name' => 'Budi Santoso',
            'email' => 'budisantoso99@yahoo.com',
            'phone' => '087812345678',
            'subject' => 'Pertanyaan Biaya Pendidikan & Asrama Boarding School',
            'message' => 'Halo admin, apakah bisa diberikan rincian biaya uang gedung dan SPP bulanan untuk siswa yang tinggal di asrama (boarding)? Terima kasih.',
            'ip_address' => '127.0.0.1',
            'crm_status' => 'new',
            'priority' => 'normal',
        ]);

        $c4 = ContactMessage::create([
            'visitor_name' => 'SMP Negeri 1 Pare',
            'email' => 'humas.smpn1pare@sch.id',
            'phone' => '085233445566',
            'subject' => 'Pendaftaran Lomba AISO 2026 Kategori Olimpiade Sains',
            'message' => 'Kami bermaksud mendaftarkan 3 tim siswa kami untuk mengikuti AISO 2026. Apakah pendaftaran kolektif sekolah mendapatkan potongan biaya pendaftaran?',
            'ip_address' => '127.0.0.1',
            'crm_status' => 'resolved',
            'priority' => 'normal',
            'handled_by' => $staff ? $staff->id : null,
            'last_contacted_at' => now()->subDays(2),
        ]);

        ContactNote::create([
            'contact_message_id' => $c4->id,
            'user_id' => $staff ? $staff->id : null,
            'author_name' => $staff ? $staff->name : 'Adit - Staff Humas & CRM',
            'note' => 'Penjelasan juknis pendaftaran kolektif sudah disampaikan dan bukti pendaftaran 3 tim sudah terverifikasi lunas.',
        ]);
    }
}
