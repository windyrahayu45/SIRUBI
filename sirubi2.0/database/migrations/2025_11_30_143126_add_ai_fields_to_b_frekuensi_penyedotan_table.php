<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('b_frekuensi_penyedotan', function (Blueprint $table) {

            // tambahkan is_active jika tidak ada
            if (!Schema::hasColumn('b_frekuensi_penyedotan', 'is_active')) {
                $table->boolean('is_active')->default(1)->after('id_frekuensi_penyedotan');
            }

            // tambahkan timestamps jika belum ada
            if (!Schema::hasColumn('b_frekuensi_penyedotan', 'created_at') &&
                !Schema::hasColumn('b_frekuensi_penyedotan', 'updated_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('b_frekuensi_penyedotan', function (Blueprint $table) {

            if (Schema::hasColumn('b_frekuensi_penyedotan', 'is_active')) {
                $table->dropColumn('is_active');
            }

            if (Schema::hasColumn('b_frekuensi_penyedotan', 'created_at') &&
                Schema::hasColumn('b_frekuensi_penyedotan', 'updated_at')) {
                $table->dropTimestamps();
            }
        });
    }
};