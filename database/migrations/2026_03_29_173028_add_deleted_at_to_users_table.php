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
        // Cek dulu, kalau belum ada kolom deleted_at, baru tambahkan
        if (!Schema::hasColumn('users', 'deleted_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->softDeletes(); 
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cek dulu, kalau ada kolom deleted_at, baru hapus
        if (Schema::hasColumn('users', 'deleted_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropSoftDeletes(); 
            });
        }
    }
};