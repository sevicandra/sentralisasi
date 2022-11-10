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
        Schema::create('admin_satkers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kdsatker', 6)->unique();
            $table->string('kdunit', 10)->unique();
            $table->string('role', 2)->default('02');
            $table->string('nmjabatan');
            $table->rememberToken();
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
        Schema::dropIfExists('admin_satkers');
    }
};
