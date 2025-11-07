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
        Schema::create('tbl_bantuan', function (Blueprint $table) {
            $table->integer('id_bantuan', true);
            $table->string('kk');
            $table->string('tahun');
            $table->string('nama');
            $table->string('nama_program');
            $table->string('nominal');
            $table->date('create_at')->nullable();
            $table->date('update_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_bantuan');
    }
};
