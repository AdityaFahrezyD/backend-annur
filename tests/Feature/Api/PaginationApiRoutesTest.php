<?php

namespace Tests\Feature\Api;

use App\Models\Achievement;
use App\Models\Extracurricular;
use App\Models\Gallery;
use App\Models\Teacher;

class PaginationApiRoutesTest extends ApiTestCase
{
    public function test_public_content_lists_return_paged_results_and_keep_filters(): void
    {
        $this->createContentRecords();

        $defaultPage = $this->getJson('/api/teachers')
            ->assertOk()
            ->assertJsonCount(10, 'data')
            ->assertJsonPath('meta.current_page', 1)
            ->assertJsonPath('meta.per_page', 10)
            ->assertJsonPath('meta.total', 21)
            ->assertJsonStructure([
                'links' => ['first', 'last', 'prev', 'next'],
                'meta' => ['current_page', 'from', 'last_page', 'path', 'per_page', 'to', 'total'],
            ]);

        $this->assertNotNull($defaultPage->json('links.next'));

        $teachers = $this->getJson('/api/teachers?subject=Matematika&page=2&per_page=10')
            ->assertOk()
            ->assertJsonCount(10, 'data')
            ->assertJsonPath('meta.current_page', 2)
            ->assertJsonPath('meta.total', 21);

        $nextUrl = $teachers->json('links.next');
        $this->assertIsString($nextUrl);
        $this->assertStringContainsString('subject=Matematika', $nextUrl);
        $this->assertStringContainsString('per_page=10', $nextUrl);

        $this->getJson('/api/achievements?category=Akademik&year=2026&page=2&per_page=10')
            ->assertOk()
            ->assertJsonCount(10, 'data')
            ->assertJsonPath('meta.current_page', 2)
            ->assertJsonPath('meta.total', 21);

        $this->getJson('/api/galleries?category=Kegiatan&page=2&per_page=10')
            ->assertOk()
            ->assertJsonCount(10, 'data')
            ->assertJsonPath('meta.current_page', 2)
            ->assertJsonPath('meta.total', 21);

        $this->getJson('/api/extracurriculars?page=2&per_page=10')
            ->assertOk()
            ->assertJsonCount(10, 'data')
            ->assertJsonPath('meta.current_page', 2)
            ->assertJsonPath('meta.total', 21)
            ->assertJsonStructure(['data' => [0 => ['images' => [0 => ['path']]]]]);
    }

    public function test_admin_content_lists_return_paged_results(): void
    {
        $this->createContentRecords();
        $this->authenticateApiUser();

        foreach ([
            '/api/admin/teachers',
            '/api/admin/achievements',
            '/api/admin/galleries',
            '/api/admin/extracurriculars',
        ] as $path) {
            $this->getJson($path)
                ->assertOk()
                ->assertJsonCount(10, 'data')
                ->assertJsonPath('meta.per_page', 10)
                ->assertJsonPath('meta.total', 21);

            $this->getJson($path.'?page=2&per_page=10')
                ->assertOk()
                ->assertJsonCount(10, 'data')
                ->assertJsonPath('meta.current_page', 2)
                ->assertJsonPath('meta.per_page', 10)
                ->assertJsonPath('meta.total', 21);
        }
    }

    public function test_extracurricular_image_pages_are_scoped_and_invalidated(): void
    {
        config(['api-cache.public_ttl' => 300]);

        $published = Extracurricular::factory()->create([
            'title' => 'Pramuka',
            'order' => 1,
            'status' => 'published',
        ]);
        $otherPublished = Extracurricular::factory()->create([
            'title' => 'Futsal',
            'order' => 2,
            'status' => 'published',
        ]);
        $draft = Extracurricular::factory()->create([
            'title' => 'Robotik Draft',
            'order' => 3,
            'status' => 'draft',
        ]);

        $published->images()->createMany([
            ['path' => '/storage/pramuka-1.jpg', 'alt_text' => 'Pramuka 1', 'order' => 1],
            ['path' => '/storage/pramuka-2.jpg', 'alt_text' => 'Pramuka 2', 'order' => 2],
        ]);
        $otherPublished->images()->create([
            'path' => '/storage/futsal.jpg',
            'alt_text' => 'Futsal',
            'order' => 1,
        ]);
        $draft->images()->create([
            'path' => '/storage/robotik.jpg',
            'alt_text' => 'Robotik',
            'order' => 1,
        ]);

        $this->getJson('/api/extracurriculars/'.$published->id.'/images')
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('meta.per_page', 10);

        $this->getJson('/api/extracurriculars/'.$published->id.'/images?page=1&per_page=1')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.path', '/storage/pramuka-1.jpg')
            ->assertJsonPath('meta.total', 2);

        $this->getJson('/api/extracurriculars/'.$published->id.'/images?page=2&per_page=1')
            ->assertOk()
            ->assertJsonPath('data.0.path', '/storage/pramuka-2.jpg');

        $this->getJson('/api/extracurriculars/'.$otherPublished->id.'/images?per_page=1')
            ->assertOk()
            ->assertJsonPath('data.0.path', '/storage/futsal.jpg');

        $this->getJson('/api/extracurriculars/'.$draft->id.'/images')->assertNotFound();

        $this->getJson('/api/extracurriculars')
            ->assertOk()
            ->assertJsonCount(2, 'data')
            ->assertJsonPath('meta.per_page', 10)
            ->assertJsonCount(2, 'data.0.images');

        $this->getJson('/api/extracurriculars?per_page=1')
            ->assertOk()
            ->assertJsonCount(2, 'data.0.images');

        $this->getJson('/api/admin/extracurriculars/'.$draft->id.'/images')->assertUnauthorized();
        $this->authenticateApiUser();

        $this->getJson('/api/admin/extracurriculars/'.$draft->id.'/images')
            ->assertOk()
            ->assertJsonPath('meta.per_page', 10)
            ->assertJsonPath('meta.total', 1);

        $this->getJson('/api/admin/extracurriculars/'.$draft->id.'/images?per_page=1')
            ->assertOk()
            ->assertJsonPath('meta.total', 1);

        $this->putJson('/api/admin/extracurriculars/'.$published->id, [
            'title' => 'Pramuka',
            'description' => null,
            'order' => 1,
            'status' => 'published',
            'images' => [
                ['path' => '/storage/pramuka-updated.jpg', 'alt_text' => 'Pramuka terbaru', 'order' => 1],
            ],
        ])->assertOk();

        $this->assertDatabaseHas('extracurricular_images', [
            'imageable_id' => $published->id,
            'path' => '/storage/pramuka-updated.jpg',
        ]);

        $this->getJson('/api/extracurriculars/'.$published->id.'/images?page=1&per_page=1')
            ->assertOk()
            ->assertJsonPath('data.0.path', '/storage/pramuka-updated.jpg');
    }

    public function test_pagination_rejects_invalid_page_and_page_size(): void
    {
        $this->getJson('/api/teachers?per_page=100')
            ->assertOk()
            ->assertJsonPath('meta.per_page', 100);

        $this->getJson('/api/teachers?page=0')
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['page']);

        $this->getJson('/api/achievements?per_page=101')
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['per_page']);

        $this->authenticateApiUser();

        $this->getJson('/api/admin/teachers?page=0')
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['page']);

        $this->getJson('/api/admin/extracurriculars/00000000-0000-0000-0000-000000000001/images?per_page=101')
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['per_page']);
    }

    private function createContentRecords(): void
    {
        for ($index = 1; $index <= 21; $index++) {
            Teacher::query()->create([
                'name' => 'Guru '.$index,
                'subject' => 'Matematika',
                'is_active' => true,
                'order' => $index,
            ]);

            Achievement::query()->create([
                'title' => 'Prestasi '.$index,
                'category' => 'Akademik',
                'year' => '2026',
                'recipient_name' => 'Tim '.$index,
                'status' => 'published',
            ]);

            Gallery::query()->create([
                'title' => 'Galeri '.$index,
                'category' => 'Kegiatan',
                'image' => '/storage/gallery-'.$index.'.jpg',
                'status' => 'published',
            ]);

            $extracurricular = Extracurricular::factory()->create([
                'title' => 'Ekstrakurikuler '.$index,
                'order' => $index,
                'status' => 'published',
            ]);

            $extracurricular->images()->create([
                'path' => '/storage/extracurricular-'.$index.'.jpg',
                'alt_text' => 'Gambar '.$index,
                'order' => 1,
            ]);
        }
    }
}
