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
        Schema::create('c_jenis_fisik_bangunan', function (Blueprint $table) {
            $table->integer('id_jenis_fisik_bangunan', true);
            $table->string('jenis_fisik_bangunan', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('c_jenis_fisik_bangunan');
    }
};
