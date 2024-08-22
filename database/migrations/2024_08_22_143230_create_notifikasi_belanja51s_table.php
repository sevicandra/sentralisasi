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
        Schema::create('notifikasi_belanja51s', function (Blueprint $table) {
            $table->id();
            $table->string('kdsatker');
            $table->string('kdunit');
            $table->string('nomor');
            $table->string('catatan');
            $table->enum('status', ['read', 'unread']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi_belanja51s');
    }
};
