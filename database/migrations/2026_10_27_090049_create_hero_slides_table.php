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
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('image');
            $table->string('heading');
            $table->string('subheading');
            $table->text('caption');
            $table->string('button_label')->nullable();
            $table->string('button_url')->nullable();
            $table->integer('order')->default(0);
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
