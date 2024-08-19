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
        Schema::create('history_permohonan_belanja51s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permohonan_id');
            $table->string('nip', 18);
            $table->string('nama');
            $table->string('action');
            $table->string('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_permohonan_belanja51s');
    }
};
