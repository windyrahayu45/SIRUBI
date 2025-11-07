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
        Schema::create('b_kondisi_sumber_air_minum', function (Blueprint $table) {
            $table->integer('id_kondisi_sumber_air_minum', true);
            $table->string('kondisi_sumber_air_minum', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b_kondisi_sumber_air_minum');
    }
};
