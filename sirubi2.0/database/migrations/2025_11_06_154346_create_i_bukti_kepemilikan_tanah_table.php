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
        Schema::create('i_bukti_kepemilikan_tanah', function (Blueprint $table) {
            $table->integer('id_bukti_kepemilikan_tanah', true);
            $table->string('bukti_kepemilikan_tanah', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('i_bukti_kepemilikan_tanah');
    }
};
