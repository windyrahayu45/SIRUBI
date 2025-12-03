<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('i_status_kepemilikan_rumah', function (Blueprint $table) {

            // tambahkan is_active jika tidak ada
            if (!Schema::hasColumn('i_status_kepemilikan_rumah', 'is_active')) {
                $table->boolean('is_active')->default(1)->after('id_status_kepemilikan_rumah');
            }

            // tambahkan timestamps jika belum ada
            if (!Schema::hasColumn('i_status_kepemilikan_rumah', 'created_at') &&
                !Schema::hasColumn('i_status_kepemilikan_rumah', 'updated_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('i_status_kepemilikan_rumah', function (Blueprint $table) {

            if (Schema::hasColumn('i_status_kepemilikan_rumah', 'is_active')) {
                $table->dropColumn('is_active');
            }

            if (Schema::hasColumn('i_status_kepemilikan_rumah', 'created_at') &&
                Schema::hasColumn('i_status_kepemilikan_rumah', 'updated_at')) {
                $table->dropTimestamps();
            }
        });
    }
};