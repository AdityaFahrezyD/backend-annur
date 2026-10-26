<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;

class AuthApiRoutesTest extends ApiTestCase
{
    public function test_login_route_returns_a_token_and_rejects_invalid_credentials(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@example.test',
            'password' => 'correct-password',
        ]);

        $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'correct-password',
        ])
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('user.email', $user->email)
            ->assertJsonStructure(['token']);

        $this->assertDatabaseCount('personal_access_tokens', 1);

        $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['email']);
    }

    public function test_me_and_logout_routes_use_and_revoke_the_api_token(): void
    {
        $user = $this->authenticateApiUser();

        $this->getJson('/api/me')
            ->assertOk()
            ->assertJsonPath('user.id', $user->id)
            ->assertJsonPath('user.email', $user->email);

        $this->postJson('/api/logout')
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertDatabaseCount('personal_access_tokens', 0);
    }

    public function test_forgot_password_route_sends_a_reset_notification(): void
    {
        Notification::fake();
        $user = User::factory()->create();

        $this->postJson('/api/forgot-password', ['email' => $user->email])
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('message', 'Jika email terdaftar, tautan reset password akan dikirim.');

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_reset_password_route_updates_password_and_revokes_existing_tokens(): void
    {
        $user = User::factory()->create();
        $user->createToken('existing-token');
        $token = Password::createToken($user);

        $this->postJson('/api/reset-password', [
            'token' => $token,
            'email' => $user->email,
            'password' => 'new-password-123',
            'password_confirmation' => 'new-password-123',
        ])
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertTrue(Hash::check('new-password-123', $user->fresh()->password));
        $this->assertDatabaseCount('personal_access_tokens', 0);
    }

    public function test_verification_notification_and_signed_verification_routes_work(): void
    {
        Notification::fake();
        $user = $this->authenticateApiUser(verified: false);

        $this->postJson('/api/email/verification-notification')
            ->assertOk()
            ->assertJsonPath('success', true);

        Notification::assertSentTo($user, VerifyEmail::class);

        $signedUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(5),
            [
                'id' => $user->id,
                'hash' => sha1($user->getEmailForVerification()),
            ],
        );

        $this->getJson($signedUrl)
            ->assertOk()
            ->assertJsonPath('message', 'Alamat email berhasil diverifikasi.');

        $this->assertNotNull($user->fresh()->email_verified_at);

        $this->getJson($signedUrl)
            ->assertOk()
            ->assertJsonPath('message', 'Alamat email sudah diverifikasi.');
    }

    public function test_verification_routes_reject_missing_authentication_and_invalid_signature(): void
    {
        $user = User::factory()->unverified()->create();

        $this->getJson('/api/email/verify')
            ->assertUnauthorized();

        $this->withToken($user->createToken('test-token')->plainTextToken)
            ->getJson('/api/email/verify')
            ->assertForbidden()
            ->assertJsonPath('success', false);

        $this->getJson('/api/email/verify/'.$user->id.'/'.sha1($user->getEmailForVerification()))
            ->assertForbidden();
    }
}
