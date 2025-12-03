<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('i_pekerjaan_utama', function (Blueprint $table) {

            // tambahkan is_active jika tidak ada
            if (!Schema::hasColumn('i_pekerjaan_utama', 'is_active')) {
                $table->boolean('is_active')->default(1)->after('id_pekerjaan_utama');
            }

            // tambahkan timestamps jika belum ada
            if (!Schema::hasColumn('i_pekerjaan_utama', 'created_at') &&
                !Schema::hasColumn('i_pekerjaan_utama', 'updated_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('i_pekerjaan_utama', function (Blueprint $table) {

            if (Schema::hasColumn('i_pekerjaan_utama', 'is_active')) {
                $table->dropColumn('is_active');
            }

            if (Schema::hasColumn('i_pekerjaan_utama', 'created_at') &&
                Schema::hasColumn('i_pekerjaan_utama', 'updated_at')) {
                $table->dropTimestamps();
            }
        });
    }
};