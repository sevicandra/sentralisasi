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
        Schema::create('permohonan_belanja51s', function (Blueprint $table) {
            $table->id();
            $table->string('kdsatker', 6);
            $table->string('kdunit', 4);
            $table->string('bulan', 2);
            $table->string('tahun', 4);
            $table->string('nomor')->nullable();
            $table->enum('jenis', ['makan', 'lembur']);
            $table->date('tanggal')->nullable();
            $table->string('uraian');
            $table->string('nip', 18)->nullable();
            $table->string('nama')->nullable();
            $table->string('jabatan')->nullable();
            $table->string('file')->nullable();
            $table->enum('status', ['draft', 'proses', 'kirim', 'approve', 'reject']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonan_belanja51s');
    }
};
