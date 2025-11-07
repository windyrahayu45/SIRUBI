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
        Schema::create('i_aset_tanah_tempat_lain', function (Blueprint $table) {
            $table->integer('id_aset_tanah_tempat_lain', true);
            $table->string('aset_tanah_tempat_lain', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('i_aset_tanah_tempat_lain');
    }
};
