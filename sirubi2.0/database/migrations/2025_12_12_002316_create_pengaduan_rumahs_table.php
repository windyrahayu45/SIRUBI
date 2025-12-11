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
        Schema::create('pengaduan_rumahs', function (Blueprint $table) {
            $table->id();
             // Jika rumah ditemukan saat cek NIK + KK
            $table->unsignedBigInteger('rumah_id')->nullable();

            $table->string('nik', 20);
            $table->string('kk', 20);

            // Alamat hanya wajib kalau rumah_id null
            $table->string('alamat')->nullable();
            $table->string('rt', 5)->nullable();
            $table->string('rw', 5)->nullable();
            $table->text('keterangan')->nullable();

            $table->enum('status', ['pending', 'proses', 'selesai'])
                  ->default('pending');

            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduan_rumahs');
    }
};
