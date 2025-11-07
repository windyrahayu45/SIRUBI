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
        Schema::create('d_kondisi_penutup_atap', function (Blueprint $table) {
            $table->integer('id_kondisi_penutup_atap', true);
            $table->string('kondisi_penutup_atap', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('d_kondisi_penutup_atap');
    }
};
