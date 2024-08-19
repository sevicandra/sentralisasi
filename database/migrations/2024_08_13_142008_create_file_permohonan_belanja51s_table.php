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
        Schema::create('file_permohonan_belanja51s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id');
            $table->string('nama');
            $table->string('file');
            $table->string('id_dokumen')->nullable();
            $table->string('date')->nullable();
            $table->enum('status', ['draft', 'proses', 'success', 'failed'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_permohonan_belanja51s');
    }
};
