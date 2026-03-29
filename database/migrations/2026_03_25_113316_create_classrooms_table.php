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
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            // Menghubungkan kelas dengan dosen yang membuatnya
            $table->foreignId('dosen_id')->constrained('users')->cascadeOnDelete();
            
            $table->string('name');      // Nama Mata Kuliah
            $table->string('section');   // Ruangan / Seksi (Tambahan baru)
            $table->string('code')->unique(); // Kode unik untuk gabung kelas
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};