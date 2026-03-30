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
        Schema::table('lpps', function (Blueprint $table) {
            $table->string('type')->default('announcement')->after('classroom_id');
            $table->string('topic')->nullable()->after('type');
            $table->timestamp('publish_at')->nullable()->after('topic');
            $table->dateTime('deadline')->nullable()->after('description');
            $table->unsignedInteger('max_points')->nullable()->after('deadline');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lpps', function (Blueprint $table) {
            $table->dropColumn(['type', 'topic', 'publish_at', 'deadline', 'max_points']);
        });
    }
};
