<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('c_ruang_keluarga_dan_tidur', function (Blueprint $table) {

            // tambahkan is_active jika tidak ada
            if (!Schema::hasColumn('c_ruang_keluarga_dan_tidur', 'is_active')) {
                $table->boolean('is_active')->default(1)->after('id_ruang_keluarga_dan_tidur');
            }

            // tambahkan timestamps jika belum ada
            if (!Schema::hasColumn('c_ruang_keluarga_dan_tidur', 'created_at') &&
                !Schema::hasColumn('c_ruang_keluarga_dan_tidur', 'updated_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('c_ruang_keluarga_dan_tidur', function (Blueprint $table) {

            if (Schema::hasColumn('c_ruang_keluarga_dan_tidur', 'is_active')) {
                $table->dropColumn('is_active');
            }

            if (Schema::hasColumn('c_ruang_keluarga_dan_tidur', 'created_at') &&
                Schema::hasColumn('c_ruang_keluarga_dan_tidur', 'updated_at')) {
                $table->dropTimestamps();
            }
        });
    }
};