<?php

namespace Tests\Feature\Api;

use App\Models\Achievement;
use App\Models\Competition;
use App\Models\Curriculum;
use App\Models\Gallery;
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
            'is_active' => true,
        ]);
        Teacher::query()->create([
            'name' => 'Guru Nonaktif',
            'subject' => 'Kimia',
            'is_active' => false,
        ]);
        Achievement::query()->create([
            'title' => 'Juara Sains',
            'category' => 'Akademik',
            'level' => 'Nasional',
            'year' => '2026',
            'recipient_name' => 'Tim An-Nur',
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
            'event_date' => '2026-11-01',
            'status' => 'published',
        ]);
        Competition::query()->create([
            'title' => 'Lomba Draft',
            'status' => 'draft',
        ]);
        Curriculum::query()->create([
            'title' => 'Kurikulum Tahfiz',
            'description' => 'Program pembelajaran tahfiz.',
            'status' => 'published',
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

        $profile = SchoolProfile::query()->create(['name' => 'SMA Islam Terpadu An-Nur']);
        Principal::query()->create([
            'school_profile_id' => $profile->id,
            'name' => 'Kepala Sekolah Aktif',
            'title' => 'Kepala Sekolah',
            'started_at' => '2025-07-01',
            'is_current' => true,
        ]);

        $this->getJson('/api/profile')
            ->assertOk()
            ->assertJsonPath('data.principal_name', 'Kepala Sekolah Aktif')
            ->assertJsonPath('data.principal_history.0.name', 'Kepala Sekolah Aktif');

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
            ->assertJsonPath('data.0.title', 'Kurikulum Tahfiz');

        $this->getJson('/api/galleries?category=Kegiatan')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Kegiatan Kelas');

        $this->getJson('/api/stats')
            ->assertOk()
            ->assertJsonPath('data.total_teachers', 1)
            ->assertJsonPath('data.total_achievements', 1)
            ->assertJsonPath('data.total_competitions', 1)
            ->assertJsonPath('data.total_galleries', 1);
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

        $this->assertDatabaseCount('contact_messages', 0);
    }
}
