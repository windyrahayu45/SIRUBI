<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('i_bukti_kepemilikan_tanah', function (Blueprint $table) {

            // tambahkan is_active jika tidak ada
            if (!Schema::hasColumn('i_bukti_kepemilikan_tanah', 'is_active')) {
                $table->boolean('is_active')->default(1)->after('id_bukti_kepemilikan_tanah');
            }

            // tambahkan timestamps jika belum ada
            if (!Schema::hasColumn('i_bukti_kepemilikan_tanah', 'created_at') &&
                !Schema::hasColumn('i_bukti_kepemilikan_tanah', 'updated_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('i_bukti_kepemilikan_tanah', function (Blueprint $table) {

            if (Schema::hasColumn('i_bukti_kepemilikan_tanah', 'is_active')) {
                $table->dropColumn('is_active');
            }

            if (Schema::hasColumn('i_bukti_kepemilikan_tanah', 'created_at') &&
                Schema::hasColumn('i_bukti_kepemilikan_tanah', 'updated_at')) {
                $table->dropTimestamps();
            }
        });
    }
};