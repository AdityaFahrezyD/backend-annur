<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

abstract class ApiTestCase extends TestCase
{
    use LazilyRefreshDatabase;

    protected function authenticateApiUser(bool $verified = true): User
    {
        $user = User::factory()->create([
            'role' => 'admin',
            'email_verified_at' => $verified ? now() : null,
        ]);

        $this->withToken($user->createToken('test-token')->plainTextToken);

        return $user;
    }
}
