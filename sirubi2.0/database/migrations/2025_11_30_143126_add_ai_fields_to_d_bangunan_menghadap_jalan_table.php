<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('d_bangunan_menghadap_jalan', function (Blueprint $table) {

            // tambahkan is_active jika tidak ada
            if (!Schema::hasColumn('d_bangunan_menghadap_jalan', 'is_active')) {
                $table->boolean('is_active')->default(1)->after('id_bangunan_menghadap_jalan');
            }

            // tambahkan timestamps jika belum ada
            if (!Schema::hasColumn('d_bangunan_menghadap_jalan', 'created_at') &&
                !Schema::hasColumn('d_bangunan_menghadap_jalan', 'updated_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('d_bangunan_menghadap_jalan', function (Blueprint $table) {

            if (Schema::hasColumn('d_bangunan_menghadap_jalan', 'is_active')) {
                $table->dropColumn('is_active');
            }

            if (Schema::hasColumn('d_bangunan_menghadap_jalan', 'created_at') &&
                Schema::hasColumn('d_bangunan_menghadap_jalan', 'updated_at')) {
                $table->dropTimestamps();
            }
        });
    }
};