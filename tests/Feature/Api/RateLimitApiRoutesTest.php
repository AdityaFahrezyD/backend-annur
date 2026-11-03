<?php

namespace Tests\Feature\Api;

use App\Models\User;

class RateLimitApiRoutesTest extends ApiTestCase
{
    public function test_login_returns_429_after_five_attempts_from_the_same_ip(): void
    {
        $user = User::factory()->create([
            'email' => 'rate-limit@example.test',
            'password' => 'correct-password',
        ]);

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->postJson('/api/login', [
                'email' => $user->email,
                'password' => 'incorrect-password',
            ])->assertUnprocessable();
        }

        $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'incorrect-password',
        ])->assertStatus(429);
    }

    public function test_contact_returns_429_after_five_submissions_from_the_same_ip(): void
    {
        $payload = [
            'name' => 'Siti Aminah',
            'email' => 'siti@example.test',
            'phone' => '081234567890',
            'subject' => 'Informasi pendaftaran',
            'message' => 'Mohon informasi jadwal pendaftaran siswa baru.',
        ];

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->postJson('/api/contact', $payload)->assertCreated();
        }

        $this->assertDatabaseCount('contact_messages', 5);

        $this->postJson('/api/contact', $payload)->assertStatus(429);
    }

    public function test_public_reads_are_not_rate_limited(): void
    {
        for ($attempt = 0; $attempt < 6; $attempt++) {
            $this->getJson('/api/teachers')->assertOk();
        }
    }
}
