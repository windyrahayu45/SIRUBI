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
        Schema::table('users', function (Blueprint $table) {

            $table->string('nama_lengkap')->nullable()->after('name');
            $table->string('jabatan')->nullable()->after('nama_lengkap');
            $table->string('nik', 16)->nullable()->after('jabatan');
            $table->string('instansi')->nullable()->after('nik');
            $table->string('no_hp', 14)->nullable()->after('instansi');
            $table->text('alamat_user')->nullable()->after('no_hp');
            $table->integer('level')->nullable()->after('alamat_user');

        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropColumn([
                'nama_lengkap',
                'jabatan',
                'nik',
                'instansi',
                'no_hp',
                'alamat_user',
                'level',
            ]);

        });
    }
};
