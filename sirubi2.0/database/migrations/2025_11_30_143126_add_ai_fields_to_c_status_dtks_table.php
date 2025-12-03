<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('c_status_dtks', function (Blueprint $table) {

            // tambahkan is_active jika tidak ada
            if (!Schema::hasColumn('c_status_dtks', 'is_active')) {
                $table->boolean('is_active')->default(1)->after('id_status_dtks');
            }

            // tambahkan timestamps jika belum ada
            if (!Schema::hasColumn('c_status_dtks', 'created_at') &&
                !Schema::hasColumn('c_status_dtks', 'updated_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        Schema::table('c_status_dtks', function (Blueprint $table) {

            if (Schema::hasColumn('c_status_dtks', 'is_active')) {
                $table->dropColumn('is_active');
            }

            if (Schema::hasColumn('c_status_dtks', 'created_at') &&
                Schema::hasColumn('c_status_dtks', 'updated_at')) {
                $table->dropTimestamps();
            }
        });
    }
};