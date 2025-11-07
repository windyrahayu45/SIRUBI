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
        Schema::create('d_bangunan_berada_limbah', function (Blueprint $table) {
            $table->integer('id_bangunan_berada_limbah', true);
            $table->string('bangunan_berada_limbah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('d_bangunan_berada_limbah');
    }
};
