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
        Schema::create('data_pembayaran_lainnyas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('bulan', 2);
            $table->string('nmbulan');
            $table->year('tahun');
            $table->string('kdsatker', 6);
            $table->string('jenis');
            $table->string('nama', 128);
            $table->string('nip', 18);
            $table->double('bruto', 15,0);
            $table->double('pph', 15,0)->default(0);
            $table->string('uraian');
            $table->integer('tanggal');
            $table->enum('sts', [0,1])->default(0);
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
        Schema::dropIfExists('data_pembayaran_lainnyas');
    }
};
