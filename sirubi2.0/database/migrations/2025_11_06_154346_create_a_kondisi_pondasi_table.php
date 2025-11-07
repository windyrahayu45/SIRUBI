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
        Schema::create('a_kondisi_pondasi', function (Blueprint $table) {
            $table->integer('id_kondisi_pondasi', true);
            $table->string('kondisi_pondasi', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_kondisi_pondasi');
    }
};
