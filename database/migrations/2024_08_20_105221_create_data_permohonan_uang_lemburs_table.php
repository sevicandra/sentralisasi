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
        Schema::create('data_permohonan_uang_lemburs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id');
            $table->string('golongan', 2);
            $table->string('nip', 18);
            $table->string('nama');
            $table->date('tanggal');
            $table->enum('jenishari', ['kerja', 'libur']);
            $table->string('absensimasuk');
            $table->string('absensikeluar');
            $table->string('jumlahjam');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_permohonan_uang_lemburs');
    }
};
