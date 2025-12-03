<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('i_aset_tanah_tempat_lain', function (Blueprint $table) {

            // tambahkan is_active jika tidak ada
            if (!Schema::hasColumn('i_aset_tanah_tempat_lain', 'is_active')) {
                $table->boolean('is_active')->default(1)->after('id_aset_tanah_tempat_lain');
            }

            // tambahkan timestamps jika belum ada
            if (!Schema::hasColumn('i_aset_tanah_tempat_lain', 'created_at') &&
                !Schema::hasColumn('i_aset_tanah_tempat_lain', 'updated_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('i_aset_tanah_tempat_lain', function (Blueprint $table) {

            if (Schema::hasColumn('i_aset_tanah_tempat_lain', 'is_active')) {
                $table->dropColumn('is_active');
            }

            if (Schema::hasColumn('i_aset_tanah_tempat_lain', 'created_at') &&
                Schema::hasColumn('i_aset_tanah_tempat_lain', 'updated_at')) {
                $table->dropTimestamps();
            }
        });
    }
};