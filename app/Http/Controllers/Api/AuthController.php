<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ForgotPasswordRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\ResetPasswordRequest;
use App\Services\Api\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authService->login($request->validated());
        $user = $result['user'];

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil',
            'token' => $result['token'],
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'email_verified' => $user->hasVerifiedEmail(),
            ],
        ]);
    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $this->authService->sendPasswordResetLink($request->validated('email'));

        return response()->json([
            'success' => true,
            'message' => 'Jika email terdaftar, tautan reset password akan dikirim.',
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        if (! $this->authService->resetPassword($request->validated())) {
            return response()->json([
                'success' => false,
                'message' => 'Token reset password tidak valid atau sudah kedaluwarsa.',
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diperbarui. Silakan login kembali.',
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'user' => $this->authService->currentUser($request->user()),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil',
        ]);
    }

    public function sendEmailVerification(Request $request): JsonResponse
    {
        $sent = $this->authService->sendEmailVerification($request->user());

        return response()->json([
            'success' => true,
            'message' => $sent
                ? 'Tautan verifikasi telah dikirim ke email Anda.'
                : 'Alamat email sudah diverifikasi.',
        ]);
    }

    public function verifyEmail(string $id, string $hash): JsonResponse
    {
        $verified = $this->authService->verifyEmail($id, $hash);

        return response()->json([
            'success' => true,
            'message' => $verified
                ? 'Alamat email berhasil diverifikasi.'
                : 'Alamat email sudah diverifikasi.',
        ]);
    }

    public function verificationNotice(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Verifikasi email diperlukan untuk mengakses fitur admin.',
        ], 403);
    }
}
