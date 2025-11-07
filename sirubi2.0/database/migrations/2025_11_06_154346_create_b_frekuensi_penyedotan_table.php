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
        Schema::create('b_frekuensi_penyedotan', function (Blueprint $table) {
            $table->integer('id_frekuensi_penyedotan', true);
            $table->string('frekuensi_penyedotan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b_frekuensi_penyedotan');
    }
};
