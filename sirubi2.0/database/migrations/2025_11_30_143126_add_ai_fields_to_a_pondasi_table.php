<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('a_pondasi', function (Blueprint $table) {

            // tambahkan is_active jika tidak ada
            if (!Schema::hasColumn('a_pondasi', 'is_active')) {
                $table->boolean('is_active')->default(1)->after('id_pondasi');
            }

            // tambahkan timestamps jika belum ada
            if (!Schema::hasColumn('a_pondasi', 'created_at') &&
                !Schema::hasColumn('a_pondasi', 'updated_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('a_pondasi', function (Blueprint $table) {

            if (Schema::hasColumn('a_pondasi', 'is_active')) {
                $table->dropColumn('is_active');
            }

            if (Schema::hasColumn('a_pondasi', 'created_at') &&
                Schema::hasColumn('a_pondasi', 'updated_at')) {
                $table->dropTimestamps();
            }
        });
    }
};