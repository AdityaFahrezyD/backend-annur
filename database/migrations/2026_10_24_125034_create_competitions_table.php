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
        Schema::create('competitions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('organizer')->default('SMA IT An-Nur Kediri');
            $table->string('category')->default('Umum');
            $table->text('description')->nullable();
            $table->date('registration_deadline')->nullable();
            $table->date('event_date')->nullable();
            $table->string('location')->nullable();
            $table->string('guide_book_url')->nullable();
            $table->string('banner_image')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competitions');
    }
};
