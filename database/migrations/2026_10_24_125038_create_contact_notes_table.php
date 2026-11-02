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
        Schema::create('contact_notes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('contact_message_id');
            $table->uuid('user_id')->nullable();
            $table->string('author_name')->default('Admin');
            $table->text('note');
            $table->timestamps();

            $table->foreign('contact_message_id')->references('id')->on('contact_messages')->cascadeOnDelete();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_notes');
    }
};
