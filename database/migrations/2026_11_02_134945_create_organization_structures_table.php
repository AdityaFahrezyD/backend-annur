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
        Schema::create('organization_structures', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 200);
            $table->string('position', 200);
            $table->uuid('parent_id')->nullable();
            $table->integer('order')->default(0);
            $table->enum('status', ['draft', 'published'])->default('published');
            $table->timestamps();
        });

        Schema::table('organization_structures', function (Blueprint $table) {
            $table->foreign('parent_id')->references('id')->on('organization_structures')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_structures');
    }
};
