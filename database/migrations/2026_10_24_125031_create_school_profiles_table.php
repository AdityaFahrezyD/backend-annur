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
            $table->id();
            $table->string('name')->default('SMA Islam Terpadu An-Nur');
            $table->string('tagline')->default('Membentuk Generasi Berakhlak Mulia, Cerdas, dan Berprestasi Global');
            $table->text('description')->nullable();
            $table->text('history')->nullable();
            $table->text('vision')->nullable();
            $table->json('missions')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('email')->nullable();
            $table->text('maps_embed_url')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('principal_name')->nullable();
            $table->string('principal_title')->default('Kepala Sekolah SMA IT An-Nur');
            $table->text('principal_message')->nullable();
            $table->string('principal_photo')->nullable();
            $table->string('accreditation')->default('A (Unggul)');
            $table->string('npsn')->default('20512345');
            $table->json('stats')->nullable();
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
