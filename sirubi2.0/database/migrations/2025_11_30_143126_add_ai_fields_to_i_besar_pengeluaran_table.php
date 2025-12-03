<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('i_besar_pengeluaran', function (Blueprint $table) {

            // tambahkan is_active jika tidak ada
            if (!Schema::hasColumn('i_besar_pengeluaran', 'is_active')) {
                $table->boolean('is_active')->default(1)->after('id_besar_pengeluaran');
            }

            // tambahkan timestamps jika belum ada
            if (!Schema::hasColumn('i_besar_pengeluaran', 'created_at') &&
                !Schema::hasColumn('i_besar_pengeluaran', 'updated_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('i_besar_pengeluaran', function (Blueprint $table) {

            if (Schema::hasColumn('i_besar_pengeluaran', 'is_active')) {
                $table->dropColumn('is_active');
            }

            if (Schema::hasColumn('i_besar_pengeluaran', 'created_at') &&
                Schema::hasColumn('i_besar_pengeluaran', 'updated_at')) {
                $table->dropTimestamps();
            }
        });
    }
};