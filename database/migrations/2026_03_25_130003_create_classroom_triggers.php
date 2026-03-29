<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Pastikan nama kolom di sini sinkron menjadi 'code'
        DB::unprepared("
            CREATE TRIGGER before_classroom_delete
            BEFORE DELETE ON classrooms
            FOR EACH ROW
            BEGIN
                INSERT INTO archived_classrooms (original_id, dosen_id, name, code, deleted_at)
                VALUES (OLD.id, OLD.dosen_id, OLD.name, OLD.code, NOW());
            END
        ");
    }

    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS before_classroom_delete");
    }
};