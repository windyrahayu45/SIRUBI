<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('c_tipe_rumah', function (Blueprint $table) {

            // tambahkan is_active jika tidak ada
            if (!Schema::hasColumn('c_tipe_rumah', 'is_active')) {
                $table->boolean('is_active')->default(1)->after('id_tipe_rumah');
            }

            // tambahkan timestamps jika belum ada
            if (!Schema::hasColumn('c_tipe_rumah', 'created_at') &&
                !Schema::hasColumn('c_tipe_rumah', 'updated_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('c_tipe_rumah', function (Blueprint $table) {

            if (Schema::hasColumn('c_tipe_rumah', 'is_active')) {
                $table->dropColumn('is_active');
            }

            if (Schema::hasColumn('c_tipe_rumah', 'created_at') &&
                Schema::hasColumn('c_tipe_rumah', 'updated_at')) {
                $table->dropTimestamps();
            }
        });
    }
};