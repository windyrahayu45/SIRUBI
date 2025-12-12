<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
    {
        Schema::table('pengaduan_rumahs', function (Blueprint $table) {
            $table->unsignedBigInteger('kecamatan_id')->nullable()->after('rw');
            $table->unsignedBigInteger('kelurahan_id')->nullable()->after('kecamatan_id');
        });
    }

    public function down(): void
    {
        Schema::table('pengaduan_rumahs', function (Blueprint $table) {
            $table->dropColumn(['kecamatan_id', 'kelurahan_id']);
        });
    }
};
