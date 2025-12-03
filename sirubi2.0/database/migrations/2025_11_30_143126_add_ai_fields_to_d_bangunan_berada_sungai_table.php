<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('d_bangunan_berada_sungai', function (Blueprint $table) {

            // tambahkan is_active jika tidak ada
            if (!Schema::hasColumn('d_bangunan_berada_sungai', 'is_active')) {
                $table->boolean('is_active')->default(1)->after('id_bangunan_berada_sungai');
            }

            // tambahkan timestamps jika belum ada
            if (!Schema::hasColumn('d_bangunan_berada_sungai', 'created_at') &&
                !Schema::hasColumn('d_bangunan_berada_sungai', 'updated_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('d_bangunan_berada_sungai', function (Blueprint $table) {

            if (Schema::hasColumn('d_bangunan_berada_sungai', 'is_active')) {
                $table->dropColumn('is_active');
            }

            if (Schema::hasColumn('d_bangunan_berada_sungai', 'created_at') &&
                Schema::hasColumn('d_bangunan_berada_sungai', 'updated_at')) {
                $table->dropTimestamps();
            }
        });
    }
};