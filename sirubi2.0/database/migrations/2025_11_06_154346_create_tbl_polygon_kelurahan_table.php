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
        Schema::create('tbl_polygon_kelurahan', function (Blueprint $table) {
            $table->integer('id_polygon', true);
            $table->integer('kecamatan_id');
            $table->integer('kelurahan_id');
            $table->string('luas');
            $table->string('keterangan');
            $table->text('polygon');
            $table->date('create_at')->nullable();
            $table->date('update_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_polygon_kelurahan');
    }
};
