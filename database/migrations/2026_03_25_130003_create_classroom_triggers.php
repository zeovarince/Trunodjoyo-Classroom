<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


return new class extends Migration
{
    public function up(): void
    {
        // 1. TRIGGER: SINKRONISASI TOTAL SISWA (di tabel pivot 'classroom_user')
        // Menambah total_students di tabel classrooms saat ada siswa gabung
        DB::unprepared('
            CREATE TRIGGER after_student_join
            AFTER INSERT ON classroom_user
            FOR EACH ROW
            BEGIN
                UPDATE classrooms 
                SET total_students = total_students + 1 
                WHERE id = NEW.classroom_id;
            END
        ');

        // Mengurangi total_students saat ada siswa keluar/dihapus
        DB::unprepared('
            CREATE TRIGGER after_student_leave
            AFTER DELETE ON classroom_user
            FOR EACH ROW
            BEGIN
                UPDATE classrooms 
                SET total_students = total_students - 1 
                WHERE id = OLD.classroom_id;
            END
        ');

        // 2. TRIGGER: VALIDASI DEADLINE (di tabel 'assignments')
        // Mencegah pembuatan tugas dengan deadline di masa lalu
        DB::unprepared('
            CREATE TRIGGER before_assignment_insert
            BEFORE INSERT ON assignments
            FOR EACH ROW
            BEGIN
                IF NEW.deadline < NOW() THEN
                    SIGNAL SQLSTATE "45000" 
                    SET MESSAGE_TEXT = "Error: Tenggat waktu (deadline) tidak boleh di masa lalu!";
                END IF;
            END
        ');

        // 3. TRIGGER: ARSIP OTOMATIS SAAT KELAS DIHAPUS (di tabel 'classrooms')
        // Pastikan kamu sudah punya tabel 'archived_classrooms' yang strukturnya mirip
        DB::unprepared('
            CREATE TRIGGER before_classroom_delete
            BEFORE DELETE ON classrooms
            FOR EACH ROW
            BEGIN
                INSERT INTO archived_classrooms (original_id, dosen_id, name, generate_code, deleted_at)
                VALUES (OLD.id, OLD.dosen_id, OLD.name, OLD.generate_code, NOW());
            END
        ');
    }

    public function down(): void
    {
        // Menghapus trigger saat rollback
        DB::unprepared('DROP TRIGGER IF EXISTS after_student_join');
        DB::unprepared('DROP TRIGGER IF EXISTS after_student_leave');
        DB::unprepared('DROP TRIGGER IF EXISTS before_assignment_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS before_classroom_delete');
    }
};
