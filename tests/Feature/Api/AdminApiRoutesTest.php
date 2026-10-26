<?php

namespace Tests\Feature\Api;

use App\Models\Achievement;
use App\Models\Competition;
use App\Models\ContactMessage;
use App\Models\Curriculum;
use App\Models\Gallery;
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
            'curriculums' => [
                '/api/admin/curriculums',
                Curriculum::class,
                ['title' => 'Kurikulum Tahfiz', 'description' => 'Program tahfiz.', 'status' => 'published'],
                'title',
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

        foreach (['teachers', 'achievements', 'competitions', 'curriculums', 'galleries'] as $resource) {
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
        $this->travelTo('2026-10-01 12:00:00');

        $this->getJson('/api/admin/profile')
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->putJson('/api/admin/profile', [
            'name' => 'SMA Islam Terpadu An-Nur',
            'principal_name' => 'Principal Pertama',
            'principal_title' => 'Kepala Sekolah',
        ])
            ->assertOk()
            ->assertJsonPath('data.principal_name', 'Principal Pertama')
            ->assertJsonPath('data.principal_history.0.name', 'Principal Pertama');

        $this->travelTo('2026-10-10 12:00:00');

        $this->putJson('/api/admin/profile', [
            'name' => 'SMA Islam Terpadu An-Nur',
            'principal_name' => 'Principal Kedua',
            'principal_title' => 'Kepala Sekolah',
        ])
            ->assertOk()
            ->assertJsonPath('data.principal_name', 'Principal Kedua')
            ->assertJsonPath('data.principal_history.0.name', 'Principal Kedua')
            ->assertJsonPath('data.principal_history.1.name', 'Principal Pertama');

        $this->assertDatabaseHas('principals', [
            'name' => 'Principal Pertama',
            'is_current' => false,
            'started_at' => '2026-10-01',
            'ended_at' => '2026-10-10',
        ]);
        $this->assertDatabaseHas('principals', [
            'name' => 'Principal Kedua',
            'is_current' => true,
            'started_at' => '2026-10-10',
            'ended_at' => null,
        ]);
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
