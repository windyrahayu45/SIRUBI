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
        Schema::create('rumah_history', function (Blueprint $table) {
            $table->id();

            // ID rumah yang diubah
            $table->string('rumah_id');

            // Kategori perubahan (rumah, fisik, sanitasi, kk, anggota, bantuan, pertanyaan, dokumen, dll)
            $table->string('kategori')->nullable();

            // Field yang diubah
            $table->string('field');

            // Nilai sebelum & sesudah
            $table->text('old_value')->nullable();
            $table->text('new_value')->nullable();

            // Siapa yang ubah
            $table->unsignedBigInteger('changed_by')->nullable();

            // Kapan diubah
            $table->timestamp('changed_at')->useCurrent();

            $table->index('rumah_id');
            $table->index('kategori');
            $table->index('changed_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rumah_history');
    }
};
