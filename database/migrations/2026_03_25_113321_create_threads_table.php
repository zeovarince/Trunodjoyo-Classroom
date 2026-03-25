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
        Schema::create('threads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lpp_id')->constrained('lpps')->cascadeOnDelete(); // Nempel di modul mana
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // Siapa yang nanya
            $table->text('content'); // Isi pertanyaan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('threads');
    }
};
