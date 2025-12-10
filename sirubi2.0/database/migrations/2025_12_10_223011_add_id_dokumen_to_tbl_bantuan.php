<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tbl_bantuan', function (Blueprint $table) {
            // Tambah kolom nullable agar data lama tidak error
            $table->integer('id_dokumen')->nullable()->after('nominal');

            // Tambah foreign key (opsional, bisa diaktifkan jika ingin relasi ketat)
            $table->foreign('id_dokumen')
                  ->references('id_dokumen')->on('tbl_dokumen')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('tbl_bantuan', function (Blueprint $table) {
            $table->dropForeign(['id_dokumen']);
            $table->dropColumn('id_dokumen');
        });
    }
};
