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
        Schema::create('archived_classrooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('original_id');
            $table->foreignId('dosen_id')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->string('generate_code');
            $table->dateTime('deleted_at');
            $table->timestamps();

            $table->index('original_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archived_classrooms');
    }
};
