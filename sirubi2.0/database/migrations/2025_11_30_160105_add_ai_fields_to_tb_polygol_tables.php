<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ============================
        // TBL_PONDASI
        // ============================
        

        // ============================
        // TBL_POLYGON
        // ============================
        if (Schema::hasTable('tbl_jenis_polygon')) {
            Schema::table('tbl_jenis_polygon', function (Blueprint $table) {

                if (!Schema::hasColumn('tbl_jenis_polygon', 'is_active')) {
                    $table->boolean('is_active')->default(1)->after('id_jenis_polygon');
                }

                if (!Schema::hasColumn('tbl_jenis_polygon', 'created_at') &&
                    !Schema::hasColumn('tbl_jenis_polygon', 'updated_at')) {
                    $table->timestamps();
                }
            });
        }
    }

    public function down(): void
    {
        // Rollback tbl_pondasi
        

        // Rollback tbl_polygon
        if (Schema::hasTable('tbl_jenis_polygon')) {
            Schema::table('tbl_jenis_polygon', function (Blueprint $table) {

                if (Schema::hasColumn('tbl_jenis_polygon', 'is_active')) {
                    $table->dropColumn('is_active');
                }

                if (Schema::hasColumn('tbl_jenis_polygon', 'created_at') &&
                    Schema::hasColumn('tbl_jenis_polygon', 'updated_at')) {
                    $table->dropTimestamps();
                }
            });
        }
    }
};
