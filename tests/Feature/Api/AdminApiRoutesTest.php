<?php

namespace Tests\Feature\Api;

use App\Models\Achievement;
use App\Models\Competition;
use App\Models\ContactMessage;
use App\Models\CurriculumPillar;
use App\Models\Gallery;
use App\Models\HeroSlide;
use App\Models\Phase;
use App\Models\Principal;
use App\Models\SchoolProfile;
use App\Models\Teacher;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProvider;

class AdminApiRoutesTest extends ApiTestCase
{
    public static function contentRoutes(): array
    {
        return [
            'teachers' => [
                '/api/admin/teachers',
                Teacher::class,
                ['name' => 'Guru Matematika', 'subject' => 'Matematika', 'is_active' => true, 'order' => 1],
                'name',
            ],
            'achievements' => [
                '/api/admin/achievements',
                Achievement::class,
                [
                    'title' => 'Juara Sains',
                    'category' => 'Akademik',
                    'level' => 'Nasional',
                    'year' => '2026',
                    'recipient_name' => 'Tim An-Nur',
                    'status' => 'published',
                ],
                'title',
            ],
            'competitions' => [
                '/api/admin/competitions',
                Competition::class,
                [
                    'title' => 'Olimpiade Sains',
                    'organizer' => 'SMA IT An-Nur',
                    'category' => 'Akademik',
                    'status' => 'published',
                ],
                'title',
            ],
            'curriculum-pillars' => [
                '/api/admin/curriculum-pillars',
                CurriculumPillar::class,
                ['title' => 'Kurikulum Tahfiz', 'subtitle' => 'Program inti', 'description' => 'Program tahfiz.', 'status' => 'published'],
                'title',
            ],
            'phases' => [
                '/api/admin/phases',
                Phase::class,
                ['title' => 'Fase Fondasi', 'phase_name' => 'Fase A', 'description' => 'Fase belajar.', 'status' => 'published'],
                'title',
            ],
            'hero-slides' => [
                '/api/admin/hero-slides',
                HeroSlide::class,
                [
                    'image' => '/storage/hero.jpg',
                    'heading' => 'Selamat Datang',
                    'subheading' => 'SD Plus An-Nur',
                    'caption' => 'Pendidikan berkarakter.',
                    'status' => 'published',
                ],
                'heading',
            ],
            'galleries' => [
                '/api/admin/galleries',
                Gallery::class,
                [
                    'title' => 'Kegiatan Belajar',
                    'category' => 'Kegiatan',
                    'image' => 'https://example.test/kegiatan.jpg',
                    'status' => 'published',
                ],
                'title',
            ],
        ];
    }

    #[DataProvider('contentRoutes')]
    public function test_verified_admin_can_use_each_content_crud_route(
        string $path,
        string $modelClass,
        array $payload,
        string $field,
    ): void {
        $this->authenticateApiUser();
        $table = (new $modelClass)->getTable();

        $this->getJson($path)
            ->assertOk()
            ->assertJsonCount(0, 'data');

        $created = $this->postJson($path, $payload)
            ->assertCreated()
            ->assertJsonPath('success', true);
        $id = $created->json('data.id');

        $this->assertIsString($id);
        $this->assertDatabaseHas($table, [
            'id' => $id,
            $field => $payload[$field],
        ]);

        $this->getJson($path.'/'.$id)
            ->assertOk()
            ->assertJsonPath('data.id', $id);

        $putValue = 'Diperbarui '.$payload[$field];
        $putPayload = array_replace($payload, [$field => $putValue]);

        $this->putJson($path.'/'.$id, $putPayload)
            ->assertOk()
            ->assertJsonPath('data.'.$field, $putValue);

        $this->assertDatabaseHas($table, [
            'id' => $id,
            $field => $putValue,
        ]);

        $patchValue = 'Diubah parsial '.$payload[$field];
        $patchPayload = array_replace($putPayload, [$field => $patchValue]);

        $this->patchJson($path.'/'.$id, $patchPayload)
            ->assertOk()
            ->assertJsonPath('data.'.$field, $patchValue);

        $record = $modelClass::query()->findOrFail($id);

        $this->deleteJson($path.'/'.$id)
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertModelMissing($record);
    }

    public function test_verified_admin_can_save_extended_public_content_fields(): void
    {
        $this->authenticateApiUser();

        $teacher = $this->postJson('/api/admin/teachers', [
            'name' => 'Guru An-Nur',
            'subject' => 'Guru Kelas',
            'gender' => 'P',
            'certifications' => ['Sertifikasi Guru'],
            'experience' => '10 tahun',
            'is_leadership' => true,
        ])->assertCreated()
            ->assertJsonPath('data.gender', 'P')
            ->assertJsonPath('data.certifications.0', 'Sertifikasi Guru')
            ->assertJsonPath('data.experience', '10 tahun')
            ->assertJsonPath('data.is_leadership', true);
        $this->assertDatabaseHas('teachers', [
            'id' => $teacher->json('data.id'),
            'gender' => 'P',
            'experience' => '10 tahun',
        ]);

        $achievement = $this->postJson('/api/admin/achievements', [
            'title' => 'Juara Sains',
            'category' => 'Akademik',
            'level' => 'Kabupaten',
            'year' => '2026',
            'recipient_name' => 'Siswa An-Nur',
            'organizer' => 'Dinas Pendidikan',
            'status' => 'published',
        ])->assertCreated()->assertJsonPath('data.organizer', 'Dinas Pendidikan');
        $this->assertDatabaseHas('achievements', [
            'id' => $achievement->json('data.id'),
            'organizer' => 'Dinas Pendidikan',
        ]);

        $competition = $this->postJson('/api/admin/competitions', [
            'title' => 'Festival Sains',
            'organizer' => 'SD Plus An-Nur',
            'category' => 'Sains',
            'level' => 'Kabupaten',
            'display_status' => 'Pendaftaran Dibuka',
            'status' => 'published',
        ])->assertCreated()
            ->assertJsonPath('data.level', 'Kabupaten')
            ->assertJsonPath('data.display_status', 'Pendaftaran Dibuka');
        $this->assertDatabaseHas('competitions', [
            'id' => $competition->json('data.id'),
            'level' => 'Kabupaten',
            'display_status' => 'Pendaftaran Dibuka',
        ]);
    }

    public function test_hero_slide_button_fields_must_be_complete_and_use_safe_urls(): void
    {
        $this->authenticateApiUser();

        $payload = [
            'image' => '/storage/hero.jpg',
            'heading' => 'Selamat Datang',
            'subheading' => 'SD Plus An-Nur',
            'caption' => 'Pendidikan berkarakter.',
            'status' => 'published',
        ];

        $this->postJson('/api/admin/hero-slides', [...$payload, 'button_label' => 'Daftar'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['button_url']);

        $this->postJson('/api/admin/hero-slides', [...$payload, 'button_url' => '/pendaftaran'])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['button_label']);

        $this->postJson('/api/admin/hero-slides', [
            ...$payload,
            'button_label' => 'Daftar',
            'button_url' => 'javascript:alert(1)',
        ])->assertUnprocessable()->assertJsonValidationErrors(['button_url']);

        $this->postJson('/api/admin/hero-slides', [
            ...$payload,
            'button_label' => 'Daftar',
            'button_url' => '/pendaftaran',
        ])->assertCreated()
            ->assertJsonPath('data.button_label', 'Daftar')
            ->assertJsonPath('data.button_url', '/pendaftaran');

        $this->postJson('/api/admin/hero-slides', [
            ...$payload,
            'button_label' => 'Daftar',
            'button_url' => 'https://annur.example/pendaftaran',
        ])->assertCreated()
            ->assertJsonPath('data.button_url', 'https://annur.example/pendaftaran');
    }

    public function test_new_cms_resources_reject_invalid_status_and_order(): void
    {
        $this->authenticateApiUser();

        $resources = [
            ['/api/admin/curriculum-pillars', ['title' => 'Pilar', 'description' => 'Deskripsi.']],
            ['/api/admin/phases', ['title' => 'Fase', 'phase_name' => 'Fase A', 'description' => 'Deskripsi.']],
            ['/api/admin/hero-slides', [
                'image' => '/storage/hero.jpg',
                'heading' => 'Judul',
                'subheading' => 'Subjudul',
                'caption' => 'Caption.',
            ]],
        ];

        foreach ($resources as [$path, $payload]) {
            $this->postJson($path, [...$payload, 'status' => 'archived'])
                ->assertUnprocessable()
                ->assertJsonValidationErrors(['status']);

            $this->postJson($path, [...$payload, 'status' => 'draft', 'order' => -1])
                ->assertUnprocessable()
                ->assertJsonValidationErrors(['order']);
        }
    }

    public function test_all_protected_api_routes_return_401_without_a_token(): void
    {
        $routes = [
            ['GET', '/api/me'],
            ['POST', '/api/logout'],
            ['GET', '/api/email/verify'],
            ['POST', '/api/email/verification-notification'],
            ['GET', '/api/admin/dashboard'],
            ['GET', '/api/admin/profile'],
            ['PUT', '/api/admin/profile'],
            ['GET', '/api/admin/contacts'],
            ['GET', '/api/admin/contacts/not-found'],
            ['PATCH', '/api/admin/contacts/not-found/status'],
            ['POST', '/api/admin/contacts/not-found/notes'],
            ['DELETE', '/api/admin/contacts/not-found'],
            ['POST', '/api/admin/upload'],
        ];

        foreach (['teachers', 'achievements', 'competitions', 'curriculum-pillars', 'phases', 'hero-slides', 'galleries'] as $resource) {
            $path = '/api/admin/'.$resource;
            $routes[] = ['GET', $path];
            $routes[] = ['POST', $path];
            $routes[] = ['GET', $path.'/not-found'];
            $routes[] = ['PUT', $path.'/not-found'];
            $routes[] = ['PATCH', $path.'/not-found'];
            $routes[] = ['DELETE', $path.'/not-found'];
        }

        foreach ($routes as [$method, $path]) {
            $response = match ($method) {
                'GET' => $this->getJson($path),
                'POST' => $this->postJson($path, []),
                'PUT' => $this->putJson($path, []),
                'PATCH' => $this->patchJson($path, []),
                'DELETE' => $this->deleteJson($path),
            };

            $response->assertUnauthorized();
        }
    }

    public function test_legacy_admin_curriculum_route_is_removed(): void
    {
        $this->authenticateApiUser();

        $this->getJson('/api/admin/curriculums')->assertNotFound();
    }

    public function test_unverified_user_cannot_access_admin_routes(): void
    {
        $this->authenticateApiUser(verified: false);

        $this->getJson('/api/admin/dashboard')
            ->assertForbidden();

        $this->getJson('/api/admin/profile')
            ->assertForbidden();
    }

    public function test_verified_admin_can_read_dashboard_statistics(): void
    {
        $this->authenticateApiUser();
        Teacher::query()->create(['name' => 'Guru', 'subject' => 'IPA']);
        Achievement::query()->create([
            'title' => 'Juara',
            'year' => '2026',
            'recipient_name' => 'Siswa',
        ]);
        Competition::query()->create(['title' => 'Lomba']);
        Gallery::query()->create(['title' => 'Kegiatan', 'image' => 'kegiatan.jpg']);
        ContactMessage::query()->create([
            'visitor_name' => 'Pengunjung',
            'email' => 'pengunjung@example.test',
            'subject' => 'Informasi',
            'message' => 'Mohon informasi sekolah.',
            'crm_status' => 'new',
        ]);

        $this->getJson('/api/admin/dashboard')
            ->assertOk()
            ->assertJsonPath('data.crm_stats.total', 1)
            ->assertJsonPath('data.crm_stats.new', 1)
            ->assertJsonPath('data.content_stats.teachers', 1)
            ->assertJsonPath('data.content_stats.achievements', 1)
            ->assertJsonPath('data.content_stats.competitions', 1)
            ->assertJsonPath('data.content_stats.galleries', 1)
            ->assertJsonPath('data.recent_inquiries.0.visitor_name', 'Pengunjung');
    }

    public function test_admin_profile_routes_return_profile_and_record_principal_history(): void
    {
        $this->authenticateApiUser();
        $firstTeacher = Teacher::query()->create([
            'name' => 'Principal Pertama',
            'subject' => 'Pimpinan',
        ]);
        $secondTeacher = Teacher::query()->create([
            'name' => 'Principal Kedua',
            'subject' => 'Pimpinan',
        ]);
        $this->travelTo('2026-10-01 12:00:00');

        $this->getJson('/api/admin/profile')
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->putJson('/api/admin/profile', [
            'name' => 'SD Plus An-Nur',
            'principal_name' => 'Principal Pertama',
            'principal_title' => 'Kepala Sekolah',
            'principal_education' => 'S1 Pendidikan',
            'principal_experience' => '15 tahun',
            'principal_bio' => 'Mendidik dengan kasih sayang.',
            'principal_photo' => '/images/principal-pertama.jpg',
            'public_sections' => ['school_status' => 'Sekolah Dasar Swasta', 'utilities' => ['schedule' => 'Pagi / 6 hari']],
        ])
            ->assertOk()
            ->assertJsonPath('data.principal_name', 'Principal Pertama')
            ->assertJsonPath('data.current_principal.education', 'S1 Pendidikan')
            ->assertJsonPath('data.current_principal.photo', '/images/principal-pertama.jpg')
            ->assertJsonPath('data.public_sections.school_status', 'Sekolah Dasar Swasta')
            ->assertJsonPath('data.principal_history.0.name', 'Principal Pertama');

        $this->assertDatabaseHas('teachers', [
            'id' => $firstTeacher->id,
            'education' => 'S1 Pendidikan',
            'experience' => '15 tahun',
            'bio' => 'Mendidik dengan kasih sayang.',
            'photo' => '/images/principal-pertama.jpg',
        ]);

        $this->travelTo('2026-10-10 12:00:00');

        $this->putJson('/api/admin/profile', [
            'name' => 'SD Plus An-Nur',
            'principal_name' => 'Principal Kedua',
            'principal_title' => 'Kepala Sekolah',
        ])
            ->assertOk()
            ->assertJsonPath('data.principal_name', 'Principal Kedua')
            ->assertJsonPath('data.principal_history.0.name', 'Principal Kedua')
            ->assertJsonPath('data.principal_history.1.name', 'Principal Pertama');

        $this->assertDatabaseHas('principals', [
            'teacher_id' => $firstTeacher->id,
            'is_current' => false,
            'started_at' => '2026-10-01',
            'ended_at' => '2026-10-10',
        ]);
        $this->assertDatabaseHas('principals', [
            'teacher_id' => $secondTeacher->id,
            'is_current' => true,
            'started_at' => '2026-10-10',
            'ended_at' => null,
        ]);
    }

    public function test_admin_profile_legacy_principal_name_requires_one_matching_teacher(): void
    {
        $this->authenticateApiUser();

        $this->putJson('/api/admin/profile', [
            'name' => 'SD Plus An-Nur',
            'principal_name' => 'Guru yang belum ada',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['principal_name']);

        Teacher::query()->create(['name' => 'Nama Ganda', 'subject' => 'Pimpinan']);
        Teacher::query()->create(['name' => 'Nama Ganda', 'subject' => 'Pimpinan']);

        $this->putJson('/api/admin/profile', [
            'name' => 'SD Plus An-Nur',
            'principal_name' => 'Nama Ganda',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['principal_name']);

        $this->assertDatabaseCount('principals', 0);
    }

    public function test_teacher_with_principal_history_cannot_be_deleted(): void
    {
        $this->authenticateApiUser();
        $profile = SchoolProfile::query()->create(['name' => 'SD Plus An-Nur']);
        $teacher = Teacher::query()->create([
            'name' => 'Kepala Sekolah',
            'subject' => 'Pimpinan',
        ]);
        Principal::query()->create([
            'school_profile_id' => $profile->id,
            'teacher_id' => $teacher->id,
            'is_current' => true,
        ]);

        $this->deleteJson('/api/admin/teachers/'.$teacher->id)
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['teacher']);

        $this->assertDatabaseHas('teachers', ['id' => $teacher->id]);
    }

    public function test_crm_routes_list_update_note_and_delete_a_contact(): void
    {
        $user = $this->authenticateApiUser();
        $contact = ContactMessage::query()->create([
            'visitor_name' => 'Budi Santoso',
            'email' => 'budi@example.test',
            'subject' => 'Pendaftaran',
            'message' => 'Mohon info pendaftaran siswa.',
        ]);

        $this->getJson('/api/admin/contacts?status=new')
            ->assertOk()
            ->assertJsonPath('data.data.0.id', $contact->id);

        $this->getJson('/api/admin/contacts/'.$contact->id)
            ->assertOk()
            ->assertJsonPath('data.visitor_name', 'Budi Santoso');

        $this->patchJson('/api/admin/contacts/'.$contact->id.'/status', [
            'crm_status' => 'contacted',
            'priority' => 'high',
        ])
            ->assertOk()
            ->assertJsonPath('data.crm_status', 'contacted')
            ->assertJsonPath('data.handled_by', $user->id);

        $this->assertDatabaseHas('contact_messages', [
            'id' => $contact->id,
            'crm_status' => 'contacted',
            'priority' => 'high',
            'handled_by' => $user->id,
        ]);

        $noteResponse = $this->postJson('/api/admin/contacts/'.$contact->id.'/notes', [
            'note' => 'Sudah menghubungi melalui telepon.',
        ])
            ->assertCreated()
            ->assertJsonPath('data.user_id', $user->id);
        $noteId = $noteResponse->json('data.id');

        $this->assertDatabaseHas('contact_notes', [
            'id' => $noteId,
            'contact_message_id' => $contact->id,
            'user_id' => $user->id,
        ]);

        $this->deleteJson('/api/admin/contacts/'.$contact->id)
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertModelMissing($contact);
        $this->assertDatabaseMissing('contact_notes', ['id' => $noteId]);
    }

    public function test_upload_route_stores_a_valid_file_on_the_public_disk(): void
    {
        Storage::fake('public');
        $this->authenticateApiUser();

        $response = $this->postJson('/api/admin/upload', [
            'file' => UploadedFile::fake()->createWithContent('brosur.pdf', "%PDF-1.4\n"),
        ])
            ->assertOk()
            ->assertJsonPath('success', true);
        $path = $response->json('path');

        $this->assertIsString($path);
        Storage::disk('public')->assertExists($path);
        $this->assertStringContainsString('/storage/'.$path, $response->json('url'));
    }
}
