<?php

namespace Tests\Feature\Api;

use App\Models\Achievement;
use App\Models\Competition;
use App\Models\CurriculumPillar;
use App\Models\Gallery;
use App\Models\HeroSlide;
use App\Models\Phase;
use App\Models\Principal;
use App\Models\SchoolProfile;
use App\Models\Teacher;

class PublicApiRoutesTest extends ApiTestCase
{
    public function test_public_read_routes_return_published_content_and_school_profile(): void
    {
        Teacher::query()->create([
            'name' => 'Guru Aktif',
            'subject' => 'Fisika',
            'gender' => 'L',
            'certifications' => ['Sertifikasi Guru'],
            'experience' => '10 tahun',
            'is_leadership' => true,
            'is_active' => true,
        ]);
        Teacher::query()->create([
            'name' => 'Guru Nonaktif',
            'subject' => 'Kimia',
            'is_active' => false,
        ]);
        $principalTeacher = Teacher::query()->create([
            'name' => 'Kepala Sekolah Aktif',
            'subject' => 'Pimpinan',
            'education' => 'S1 Pendidikan',
            'experience' => '15 tahun',
            'bio' => 'Mendidik dengan kasih sayang.',
            'is_active' => true,
        ]);
        $formerPrincipalTeacher = Teacher::query()->create([
            'name' => 'Kepala Sekolah Sebelumnya',
            'subject' => 'Pimpinan',
            'is_active' => false,
        ]);
        Achievement::query()->create([
            'title' => 'Juara Sains',
            'category' => 'Akademik',
            'level' => 'Nasional',
            'year' => '2026',
            'recipient_name' => 'Tim An-Nur',
            'organizer' => 'Dinas Pendidikan',
            'status' => 'published',
        ]);
        Achievement::query()->create([
            'title' => 'Draft Sains',
            'year' => '2026',
            'recipient_name' => 'Tim Draft',
            'status' => 'draft',
        ]);
        Competition::query()->create([
            'title' => 'Olimpiade Sains',
            'organizer' => 'An-Nur',
            'category' => 'Akademik',
            'level' => 'Kabupaten',
            'display_status' => 'Pendaftaran Dibuka',
            'event_date' => '2026-11-01',
            'status' => 'published',
        ]);
        Competition::query()->create([
            'title' => 'Lomba Draft',
            'status' => 'draft',
        ]);
        CurriculumPillar::query()->create([
            'title' => 'Kurikulum Tahfiz',
            'subtitle' => 'Program inti',
            'description' => 'Program pembelajaran tahfiz.',
            'status' => 'published',
            'order' => 1,
        ]);
        Phase::query()->create([
            'title' => 'Fase A',
            'phase_name' => 'Kelas 1 - 2',
            'description' => 'Fase fondasi.',
            'status' => 'published',
            'order' => 2,
        ]);
        Gallery::query()->create([
            'title' => 'Kegiatan Kelas',
            'category' => 'Kegiatan',
            'image' => 'https://example.test/kegiatan.jpg',
            'status' => 'published',
        ]);
        Gallery::query()->create([
            'title' => 'Dokumentasi Draft',
            'image' => 'https://example.test/draft.jpg',
            'status' => 'draft',
        ]);

        $profile = SchoolProfile::query()->create([
            'name' => 'SD Plus An-Nur',
            'vision_title' => 'Visi Sekolah',
            'vision' => ['Sekolah dasar Islam unggul.'],
            'public_sections' => ['school_status' => 'Sekolah Dasar Swasta'],
        ]);
        Principal::query()->create([
            'school_profile_id' => $profile->id,
            'teacher_id' => $principalTeacher->id,
            'title' => 'Kepala Sekolah',
            'started_at' => '2025-07-01',
            'is_current' => true,
        ]);
        Principal::query()->create([
            'school_profile_id' => $profile->id,
            'teacher_id' => $formerPrincipalTeacher->id,
            'title' => 'Kepala Sekolah Sebelumnya',
            'started_at' => '2020-07-01',
            'ended_at' => '2025-06-30',
            'is_current' => false,
        ]);

        $this->getJson('/api/profile')
            ->assertOk()
            ->assertJsonPath('data.principal_name', 'Kepala Sekolah Aktif')
            ->assertJsonPath('data.principal_history.0.name', 'Kepala Sekolah Aktif')
            ->assertJsonPath('data.public_sections.school_status', 'Sekolah Dasar Swasta')
            ->assertJsonPath('data.current_principal.education', 'S1 Pendidikan')
            ->assertJsonPath('data.principal_history.1.name', 'Kepala Sekolah Sebelumnya');

        $this->getJson('/api/teachers?search=Aktif&subject=Fisika')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'Guru Aktif');

        $this->getJson('/api/achievements?category=Akademik&year=2026')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Juara Sains');

        $this->getJson('/api/competitions?category=Akademik')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Olimpiade Sains');

        $this->getJson('/api/curriculums')
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.title', 'Kurikulum Tahfiz')
            ->assertJsonPath('data.0.section', 'pillar')
            ->assertJsonPath('data.0.level', 'Program inti')
            ->assertJsonPath('data.1.section', 'level')
            ->assertJsonPath('data.1.level', 'Kelas 1 - 2');

        $this->getJson('/api/galleries?category=Kegiatan')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Kegiatan Kelas');

        $this->getJson('/api/stats')
            ->assertOk()
            ->assertJsonPath('data.total_teachers', 2)
            ->assertJsonPath('data.total_achievements', 1)
            ->assertJsonPath('data.total_competitions', 1)
            ->assertJsonPath('data.total_galleries', 1);
    }

    public function test_public_curriculum_and_hero_slide_routes_return_published_content_in_order(): void
    {
        CurriculumPillar::query()->create([
            'title' => 'Pilar Kedua',
            'description' => 'Pilar kedua.',
            'order' => 2,
            'status' => 'published',
        ]);
        CurriculumPillar::query()->create([
            'title' => 'Pilar Pertama',
            'description' => 'Pilar pertama.',
            'order' => 1,
            'status' => 'published',
        ]);
        CurriculumPillar::query()->create([
            'title' => 'Pilar Draft',
            'description' => 'Belum diterbitkan.',
            'order' => 0,
            'status' => 'draft',
        ]);
        Phase::query()->create([
            'title' => 'Fase A',
            'phase_name' => 'Kelas 1 - 2',
            'description' => 'Fase fondasi.',
            'order' => 1,
            'status' => 'published',
        ]);
        Phase::query()->create([
            'title' => 'Fase Draft',
            'phase_name' => 'Belum terbit',
            'description' => 'Belum diterbitkan.',
            'order' => 0,
            'status' => 'draft',
        ]);
        HeroSlide::query()->create([
            'image' => '/storage/hero-kedua.jpg',
            'heading' => 'Judul kedua',
            'subheading' => 'Subjudul kedua',
            'caption' => 'Caption kedua.',
            'order' => 2,
            'status' => 'published',
        ]);
        HeroSlide::query()->create([
            'image' => '/storage/hero-pertama.jpg',
            'heading' => 'Judul pertama',
            'subheading' => 'Subjudul pertama',
            'caption' => 'Caption pertama.',
            'button_label' => 'Daftar sekarang',
            'button_url' => '/pendaftaran',
            'order' => 1,
            'status' => 'published',
        ]);
        HeroSlide::query()->create([
            'image' => '/storage/hero-draft.jpg',
            'heading' => 'Judul draft',
            'subheading' => 'Subjudul draft',
            'caption' => 'Belum diterbitkan.',
            'order' => 0,
            'status' => 'draft',
        ]);

        $this->getJson('/api/curriculum-pillars')
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.title', 'Pilar Pertama')
            ->assertJsonPath('data.1.title', 'Pilar Kedua');

        $this->getJson('/api/phases')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.phase_name', 'Kelas 1 - 2');

        $this->getJson('/api/hero-slides')
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('data.0.heading', 'Judul pertama')
            ->assertJsonPath('data.0.button_label', 'Daftar sekarang')
            ->assertJsonPath('data.0.button_url', '/pendaftaran')
            ->assertJsonPath('data.1.heading', 'Judul kedua');
    }

    public function test_admin_updates_invalidate_cache_for_new_cms_resources(): void
    {
        config(['api-cache.public_ttl' => 300]);

        $pillar = CurriculumPillar::query()->create([
            'title' => 'Pilar Sebelum',
            'description' => 'Deskripsi pilar.',
            'order' => 1,
            'status' => 'published',
        ]);
        $phase = Phase::query()->create([
            'title' => 'Fase Sebelum',
            'phase_name' => 'Fase A',
            'description' => 'Deskripsi fase.',
            'order' => 2,
            'status' => 'published',
        ]);
        $slide = HeroSlide::query()->create([
            'image' => '/storage/hero.jpg',
            'heading' => 'Hero Sebelum',
            'subheading' => 'Subjudul',
            'caption' => 'Caption.',
            'status' => 'published',
        ]);

        $this->getJson('/api/curriculum-pillars')
            ->assertOk()
            ->assertJsonPath('data.0.title', 'Pilar Sebelum');
        $this->getJson('/api/phases')
            ->assertOk()
            ->assertJsonPath('data.0.title', 'Fase Sebelum');
        $this->getJson('/api/curriculums')
            ->assertOk()
            ->assertJsonPath('data.1.title', 'Fase Sebelum');
        $this->getJson('/api/hero-slides')
            ->assertOk()
            ->assertJsonPath('data.0.heading', 'Hero Sebelum');

        $this->authenticateApiUser();

        $this->putJson('/api/admin/curriculum-pillars/'.$pillar->id, [
            'title' => 'Pilar Sesudah',
            'description' => 'Deskripsi pilar.',
            'status' => 'published',
        ])->assertOk();
        $this->putJson('/api/admin/phases/'.$phase->id, [
            'title' => 'Fase Sesudah',
            'phase_name' => 'Fase A',
            'description' => 'Deskripsi fase.',
            'status' => 'published',
        ])->assertOk();
        $this->putJson('/api/admin/hero-slides/'.$slide->id, [
            'image' => '/storage/hero.jpg',
            'heading' => 'Hero Sesudah',
            'subheading' => 'Subjudul',
            'caption' => 'Caption.',
            'status' => 'published',
        ])->assertOk();

        $this->getJson('/api/curriculum-pillars')
            ->assertOk()
            ->assertJsonPath('data.0.title', 'Pilar Sesudah');
        $this->getJson('/api/phases')
            ->assertOk()
            ->assertJsonPath('data.0.title', 'Fase Sesudah');
        $this->getJson('/api/curriculums')
            ->assertOk()
            ->assertJsonPath('data.1.title', 'Fase Sesudah');
        $this->getJson('/api/hero-slides')
            ->assertOk()
            ->assertJsonPath('data.0.heading', 'Hero Sesudah');
    }

    public function test_contact_route_creates_a_message(): void
    {
        $payload = [
            'name' => 'Siti Aminah',
            'email' => 'siti@example.test',
            'phone' => '081234567890',
            'subject' => 'Informasi pendaftaran',
            'message' => 'Mohon informasi jadwal pendaftaran siswa baru.',
        ];

        $this->postJson('/api/contact', $payload)
            ->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.email', $payload['email']);

        $this->assertDatabaseHas('contact_messages', [
            'visitor_name' => $payload['name'],
            'email' => $payload['email'],
            'crm_status' => 'new',
        ]);
    }

    public function test_contact_route_returns_validation_errors_for_invalid_payload(): void
    {
        $this->postJson('/api/contact', [
            'name' => 'Siti Aminah',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['email', 'subject', 'message']);

        $this->postJson('/api/contact', [
            'name' => 'Siti Aminah',
            'email' => 'alamat-tidak-valid',
            'subject' => 'Informasi pendaftaran',
            'message' => 'Pendek',
        ])->assertUnprocessable()->assertJsonValidationErrors(['email', 'message']);

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_public_cache_separates_filters_and_refreshes_after_admin_updates(): void
    {
        config(['api-cache.public_ttl' => 300]);
        $teacher = Teacher::query()->create([
            'name' => 'Guru Matematika',
            'subject' => 'Matematika',
        ]);
        Teacher::query()->create([
            'name' => 'Guru Bahasa',
            'subject' => 'Bahasa',
        ]);

        $this->getJson('/api/teachers?search=Guru&subject=Matematika')
            ->assertOk()
            ->assertJsonPath('data.0.name', 'Guru Matematika');

        $this->getJson('/api/teachers?search=Guru&subject=Bahasa')
            ->assertOk()
            ->assertJsonPath('data.0.name', 'Guru Bahasa');

        Teacher::query()->whereKey($teacher->id)->update(['name' => 'Perubahan langsung']);

        $this->getJson('/api/teachers?search=Guru&subject=Matematika')
            ->assertOk()
            ->assertJsonPath('data.0.name', 'Guru Matematika');

        $this->authenticateApiUser();

        $this->putJson('/api/admin/teachers/'.$teacher->id, [
            'name' => 'Guru Baru',
            'subject' => 'Matematika',
        ])
            ->assertOk();

        $this->getJson('/api/teachers?search=Guru&subject=Matematika')
            ->assertOk()
            ->assertJsonPath('data.0.name', 'Guru Baru');
    }

    public function test_public_cache_can_be_disabled_with_zero_ttl(): void
    {
        config(['api-cache.public_ttl' => 0]);
        $teacher = Teacher::query()->create([
            'name' => 'Guru Sebelum',
            'subject' => 'Matematika',
        ]);

        $this->getJson('/api/teachers?search=Guru')
            ->assertOk()
            ->assertJsonPath('data.0.name', 'Guru Sebelum');

        $teacher->update(['name' => 'Guru Sesudah']);

        $this->getJson('/api/teachers?search=Guru')
            ->assertOk()
            ->assertJsonPath('data.0.name', 'Guru Sesudah');
    }
}
