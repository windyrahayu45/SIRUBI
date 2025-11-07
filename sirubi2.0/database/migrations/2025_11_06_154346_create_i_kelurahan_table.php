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
        Schema::create('i_kelurahan', function (Blueprint $table) {
            $table->integer('id_kelurahan', true);
            $table->integer('kecamatan_id');
            $table->string('nama_kelurahan', 150);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('i_kelurahan');
    }
};
