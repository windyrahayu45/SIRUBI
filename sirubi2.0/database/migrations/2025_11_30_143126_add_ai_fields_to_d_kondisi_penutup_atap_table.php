<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('d_kondisi_penutup_atap', function (Blueprint $table) {

            // tambahkan is_active jika tidak ada
            if (!Schema::hasColumn('d_kondisi_penutup_atap', 'is_active')) {
                $table->boolean('is_active')->default(1)->after('id_kondisi_penutup_atap');
            }

            // tambahkan timestamps jika belum ada
            if (!Schema::hasColumn('d_kondisi_penutup_atap', 'created_at') &&
                !Schema::hasColumn('d_kondisi_penutup_atap', 'updated_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('d_kondisi_penutup_atap', function (Blueprint $table) {

            if (Schema::hasColumn('d_kondisi_penutup_atap', 'is_active')) {
                $table->dropColumn('is_active');
            }

            if (Schema::hasColumn('d_kondisi_penutup_atap', 'created_at') &&
                Schema::hasColumn('d_kondisi_penutup_atap', 'updated_at')) {
                $table->dropTimestamps();
            }
        });
    }
};