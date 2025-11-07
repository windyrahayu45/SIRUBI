<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // 1️⃣ Kepala Keluarga (KK per rumah)
        Schema::create('kepala_keluarga', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rumah_id');
            $table->foreign('rumah_id')->references('id_rumah')->on('rumah')->onDelete('cascade');

            $table->string('kode_kk', 1)->nullable(); // A-F
            $table->string('no_kk', 50)->nullable();
            $table->timestamps();
        });

        // 2️⃣ Anggota Keluarga (A-J per KK)
        Schema::create('anggota_keluarga', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kepala_keluarga_id');
            $table->foreign('kepala_keluarga_id')->references('id')->on('kepala_keluarga')->onDelete('cascade');

            $table->string('kode_anggota', 2)->nullable(); // a-j
            $table->string('nik', 50)->nullable();
            $table->string('nama', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('anggota_keluarga');
        Schema::dropIfExists('kepala_keluarga');
    }
};
