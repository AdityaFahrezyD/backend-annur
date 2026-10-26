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
        Schema::create('teachers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('nip')->nullable();
            $table->string('subject');
            $table->string('role_title')->default('Guru Mata Pelajaran');
            $table->string('education')->nullable();
            $table->string('photo')->nullable();
            $table->text('bio')->nullable();
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->json('certifications')->nullable();
            $table->string('experience')->nullable();
            $table->boolean('is_leadership')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
