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
        Schema::create('lpp_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lpp_id')->constrained()->cascadeOnDelete();
            $table->string('attachment_type'); // file | link
            $table->string('file_path')->nullable();
            $table->string('link_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lpp_attachments');
    }
};
