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
        Schema::create('nomors', function (Blueprint $table) {
            $table->id();
            $table->string('kdsatker', 6);
            $table->string('kdunit', 4);
            $table->integer('nomor');
            $table->string('ext', 10);
            $table->year('tahun');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nomors');
    }
};
