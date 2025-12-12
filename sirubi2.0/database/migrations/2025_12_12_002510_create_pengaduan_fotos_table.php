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
        Schema::create('pengaduan_fotos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pengaduan_id');

            $table->string('file_path');       // nama file di storage
            $table->string('deskripsi')->nullable();

            $table->timestamps();

            // RELATION KE MASTER
            $table->foreign('pengaduan_id')
                  ->references('id')->on('pengaduan_rumahs')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduan_fotos');
    }
};
