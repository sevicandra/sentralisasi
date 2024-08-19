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
        Schema::create('kops', function (Blueprint $table) {
            $table->id();
            $table->string('kdsatker', 6);
            $table->string('kdunit', 4);
            $table->string('eselon1');
            $table->string('eselon2');
            $table->string('eselon3')->nullable();
            $table->string('alamat');
            $table->string('kota');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kops');
    }
};
