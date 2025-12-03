<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('b_kondisi_sistem_pembuangan_air_kotor', function (Blueprint $table) {

            // tambahkan is_active jika tidak ada
            if (!Schema::hasColumn('b_kondisi_sistem_pembuangan_air_kotor', 'is_active')) {
                $table->boolean('is_active')->default(1)->after('id_kondisi_sistem_pembuangan_air_kotor');
            }

            // tambahkan timestamps jika belum ada
            if (!Schema::hasColumn('b_kondisi_sistem_pembuangan_air_kotor', 'created_at') &&
                !Schema::hasColumn('b_kondisi_sistem_pembuangan_air_kotor', 'updated_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('b_kondisi_sistem_pembuangan_air_kotor', function (Blueprint $table) {

            if (Schema::hasColumn('b_kondisi_sistem_pembuangan_air_kotor', 'is_active')) {
                $table->dropColumn('is_active');
            }

            if (Schema::hasColumn('b_kondisi_sistem_pembuangan_air_kotor', 'created_at') &&
                Schema::hasColumn('b_kondisi_sistem_pembuangan_air_kotor', 'updated_at')) {
                $table->dropTimestamps();
            }
        });
    }
};