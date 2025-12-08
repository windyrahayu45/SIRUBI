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
        Schema::create('pengaduans', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('kategori')->nullable(); // rumah, sanitasi, infrastruktur, dll
            $table->string('lokasi')->nullable();
            
            $table->enum('status', ['pending', 'diproses', 'selesai'])
                ->default('pending');

            $table->unsignedBigInteger('user_id')->nullable(); // pelapor
            $table->unsignedBigInteger('handled_by')->nullable(); // admin

            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduans');
    }
};
