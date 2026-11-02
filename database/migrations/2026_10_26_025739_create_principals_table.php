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
        Schema::create('principals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('school_profile_id');
            $table->uuid('teacher_id');
            $table->string('title')->nullable()->default('Kepala Sekolah An-Nur');
            $table->text('message')->nullable();
            $table->date('started_at')->nullable();
            $table->date('ended_at')->nullable();
            $table->boolean('is_current')->default(false);
            $table->timestamps();

        });

        Schema::table('principals', function (Blueprint $table) {
            $table->foreign('school_profile_id')->references('id')->on('school_profiles')->restrictOnDelete();
            $table->foreign('teacher_id')->references('id')->on('teachers')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('principals');
    }
};
