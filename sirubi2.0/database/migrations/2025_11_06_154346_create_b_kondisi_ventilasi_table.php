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
        Schema::create('b_kondisi_ventilasi', function (Blueprint $table) {
            $table->integer('id_kondisi_ventilasi', true);
            $table->string('kondisi_ventilasi', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b_kondisi_ventilasi');
    }
};
