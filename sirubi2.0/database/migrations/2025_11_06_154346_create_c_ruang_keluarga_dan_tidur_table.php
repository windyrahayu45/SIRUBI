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
        Schema::create('c_ruang_keluarga_dan_tidur', function (Blueprint $table) {
            $table->integer('id_ruang_keluarga_dan_tidur', true);
            $table->string('ruang_keluarga_dan_tidur', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('c_ruang_keluarga_dan_tidur');
    }
};
