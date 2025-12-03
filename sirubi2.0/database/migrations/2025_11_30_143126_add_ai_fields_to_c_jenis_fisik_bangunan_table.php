<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('c_jenis_fisik_bangunan', function (Blueprint $table) {

            // tambahkan is_active jika tidak ada
            if (!Schema::hasColumn('c_jenis_fisik_bangunan', 'is_active')) {
                $table->boolean('is_active')->default(1)->after('id_jenis_fisik_bangunan');
            }

            // tambahkan timestamps jika belum ada
            if (!Schema::hasColumn('c_jenis_fisik_bangunan', 'created_at') &&
                !Schema::hasColumn('c_jenis_fisik_bangunan', 'updated_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('c_jenis_fisik_bangunan', function (Blueprint $table) {

            if (Schema::hasColumn('c_jenis_fisik_bangunan', 'is_active')) {
                $table->dropColumn('is_active');
            }

            if (Schema::hasColumn('c_jenis_fisik_bangunan', 'created_at') &&
                Schema::hasColumn('c_jenis_fisik_bangunan', 'updated_at')) {
                $table->dropTimestamps();
            }
        });
    }
};