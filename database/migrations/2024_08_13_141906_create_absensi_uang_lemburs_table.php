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
        Schema::create('absensi_uang_lemburs', function (Blueprint $table) {
            $table->id();
            $table->string('kdsatker', 6);
            $table->string('kdunit', 4);
            $table->string('golongan', 2);
            $table->string('nip', 18);
            $table->string('nama');
            $table->date('tanggal');
            $table->string('absensimasuk');
            $table->string('absensikeluar');
            $table->enum('jenishari', ['kerja', 'libur']);
            $table->integer('jumlahjam');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_uang_lemburs');
    }
};
