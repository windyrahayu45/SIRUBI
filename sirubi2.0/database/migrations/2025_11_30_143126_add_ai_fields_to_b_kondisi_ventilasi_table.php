<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('b_kondisi_ventilasi', function (Blueprint $table) {

            // tambahkan is_active jika tidak ada
            if (!Schema::hasColumn('b_kondisi_ventilasi', 'is_active')) {
                $table->boolean('is_active')->default(1)->after('id_kondisi_ventilasi');
            }

            // tambahkan timestamps jika belum ada
            if (!Schema::hasColumn('b_kondisi_ventilasi', 'created_at') &&
                !Schema::hasColumn('b_kondisi_ventilasi', 'updated_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('b_kondisi_ventilasi', function (Blueprint $table) {

            if (Schema::hasColumn('b_kondisi_ventilasi', 'is_active')) {
                $table->dropColumn('is_active');
            }

            if (Schema::hasColumn('b_kondisi_ventilasi', 'created_at') &&
                Schema::hasColumn('b_kondisi_ventilasi', 'updated_at')) {
                $table->dropTimestamps();
            }
        });
    }
};