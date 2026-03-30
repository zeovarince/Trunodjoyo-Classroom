<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up()
{
    Schema::table('submissions', function (Blueprint $table) {

        // 🔥 DROP FOREIGN KEY DULU
        $table->dropForeign(['student_id']);

        // 🔥 BARU HAPUS KOLOM
        $table->dropColumn('student_id');

        // 🔥 assignment_id jadi nullable
        $table->foreignId('assignment_id')->nullable()->change();

        // 🔥 pastikan user_id ada
        if (!Schema::hasColumn('submissions', 'user_id')) {
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
        }

        // 🔥 pastikan lpp_id ada
        if (!Schema::hasColumn('submissions', 'lpp_id')) {
            $table->foreignId('lpp_id')->nullable()->constrained()->onDelete('cascade');
        }
    });
}
};
