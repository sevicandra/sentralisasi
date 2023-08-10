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
        Schema::create('sewa_rumah_dinas', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('kdsatker', 6);
            $table->string('nip', 18);
            $table->string('nama');
            $table->date('tmt');
            $table->string('nomor_sip');
            $table->date('tanggal_sip');
            $table->bigInteger('nilai_potongan');
            $table->date('tanggal_selesai')->nullable();
            $table->string('file');
            $table->enum('status', ['draft','pengajuan', 'aktif', 'usulan_non_aktif', 'non_aktif']);
            $table->string('catatan')->nullable();
            $table->string('alasan_penghentian')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sewa_rumah_dinas');
    }
};
