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
        Schema::create('i_pendidikan_terakhir', function (Blueprint $table) {
            $table->integer('id_pendidikan_terakhir', true);
            $table->string('pendidikan_terakhir', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('i_pendidikan_terakhir');
    }
};
