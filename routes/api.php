<?php

use App\Http\Controllers\Api\Admin\AchievementController;
use App\Http\Controllers\Api\Admin\CompetitionController;
use App\Http\Controllers\Api\Admin\CrmContactController;
use App\Http\Controllers\Api\Admin\CurriculumController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\GalleryController;
use App\Http\Controllers\Api\Admin\SchoolProfileController;
use App\Http\Controllers\Api\Admin\TeacherController;
use App\Http\Controllers\Api\Admin\UploadController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PublicController;
use App\Http\Middleware\CachePublicApiResponse;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public API Routes (Direct tanpa prefix v1)
|--------------------------------------------------------------------------
*/
Route::middleware(CachePublicApiResponse::class)->group(function () {
    Route::get('/profile', [PublicController::class, 'profile']);
    Route::get('/teachers', [PublicController::class, 'teachers']);
    Route::get('/achievements', [PublicController::class, 'achievements']);
    Route::get('/competitions', [PublicController::class, 'competitions']);
    Route::get('/curriculums', [PublicController::class, 'curriculums']);
    Route::get('/galleries', [PublicController::class, 'galleries']);
    Route::get('/stats', [PublicController::class, 'stats']);
});
Route::post('/contact', [PublicController::class, 'submitContact']);

// Direct Login (tanpa prefix v1 atau auth)
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->middleware('throttle:5,1');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->middleware('throttle:5,1');
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

/*
|--------------------------------------------------------------------------
| Admin & CRM Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/email/verify', [AuthController::class, 'verificationNotice'])->name('verification.notice');
    Route::post('/email/verification-notification', [AuthController::class, 'sendEmailVerification'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::prefix('admin')->middleware('verified')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index']);

        // School Profile Settings
        Route::get('/profile', [SchoolProfileController::class, 'show']);
        Route::put('/profile', [SchoolProfileController::class, 'update']);

        // CMS Resources
        Route::apiResource('teachers', TeacherController::class);
        Route::apiResource('achievements', AchievementController::class);
        Route::apiResource('competitions', CompetitionController::class);
        Route::apiResource('curriculums', CurriculumController::class);
        Route::apiResource('galleries', GalleryController::class);

        // CRM Contact Management
        Route::get('/contacts', [CrmContactController::class, 'index']);
        Route::get('/contacts/{id}', [CrmContactController::class, 'show']);
        Route::patch('/contacts/{id}/status', [CrmContactController::class, 'updateStatus']);
        Route::post('/contacts/{id}/notes', [CrmContactController::class, 'addNote']);
        Route::delete('/contacts/{id}', [CrmContactController::class, 'destroy']);

        // Media & Asset Upload
        Route::post('/upload', [UploadController::class, 'upload']);
    });
});
