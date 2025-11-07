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
        Schema::create('b_jendela_lubang_cahaya', function (Blueprint $table) {
            $table->integer('id_jendela_lubang_cahaya', true);
            $table->string('jendela_lubang_cahaya', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b_jendela_lubang_cahaya');
    }
};
