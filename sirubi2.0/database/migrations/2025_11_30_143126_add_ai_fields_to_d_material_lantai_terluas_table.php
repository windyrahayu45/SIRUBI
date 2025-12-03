<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('d_material_lantai_terluas', function (Blueprint $table) {

            // tambahkan is_active jika tidak ada
            if (!Schema::hasColumn('d_material_lantai_terluas', 'is_active')) {
                $table->boolean('is_active')->default(1)->after('id_material_lantai_terluas');
            }

            // tambahkan timestamps jika belum ada
            if (!Schema::hasColumn('d_material_lantai_terluas', 'created_at') &&
                !Schema::hasColumn('d_material_lantai_terluas', 'updated_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('d_material_lantai_terluas', function (Blueprint $table) {

            if (Schema::hasColumn('d_material_lantai_terluas', 'is_active')) {
                $table->dropColumn('is_active');
            }

            if (Schema::hasColumn('d_material_lantai_terluas', 'created_at') &&
                Schema::hasColumn('d_material_lantai_terluas', 'updated_at')) {
                $table->dropTimestamps();
            }
        });
    }
};