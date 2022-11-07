<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dokumen_uang_makans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kdsatker', 6);
            $table->string('bulan', 2);
            $table->string('nmbulan');
            $table->year('tahun');
            $table->integer('jmlpegawai');
            $table->string('keterangan');
            $table->string('file');
            $table->boolean('terkirim')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dokumen_uang_makans');
    }
};
