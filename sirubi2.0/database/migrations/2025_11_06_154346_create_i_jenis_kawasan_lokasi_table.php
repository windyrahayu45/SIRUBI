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
        Schema::create('i_jenis_kawasan_lokasi', function (Blueprint $table) {
            $table->integer('id_jenis_kawasan_lokasi', true);
            $table->string('jenis_kawasan_lokasi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('i_jenis_kawasan_lokasi');
    }
};
