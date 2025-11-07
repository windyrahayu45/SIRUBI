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
        Schema::create('i_pekerjaan_utama', function (Blueprint $table) {
            $table->integer('id_pekerjaan_utama', true);
            $table->string('pekerjaan_utama', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('i_pekerjaan_utama');
    }
};
