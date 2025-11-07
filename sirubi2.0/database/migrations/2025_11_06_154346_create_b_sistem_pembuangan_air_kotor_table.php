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
        Schema::create('b_sistem_pembuangan_air_kotor', function (Blueprint $table) {
            $table->integer('id_sistem_pembuangan_air_kotor', true);
            $table->string('sistem_pembuangan_air_kotor', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b_sistem_pembuangan_air_kotor');
    }
};
