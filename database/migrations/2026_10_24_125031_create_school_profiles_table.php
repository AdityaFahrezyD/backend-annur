<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('school_profiles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name')->default('SD Plus An-Nur');
            $table->string('tagline')->default('Membentuk Generasi Berakhlak Mulia, Cerdas, dan Berprestasi Global');
            $table->text('description')->nullable();
            $table->text('history')->nullable();
            $table->string('vision_title')->nullable();
            $table->json('vision')->nullable();
            $table->string('mission_title')->nullable();
            $table->json('missions')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->text('maps_embed_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('accreditation')->default('A (Unggul)');
            $table->string('npsn')->default('20512345');
            $table->json('stats')->nullable();
            $table->json('public_sections')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('school_profiles');
    }
};
