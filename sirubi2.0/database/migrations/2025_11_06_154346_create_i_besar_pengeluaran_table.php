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
        Schema::create('i_besar_pengeluaran', function (Blueprint $table) {
            $table->integer('id_besar_pengeluaran', true);
            $table->string('besar_pengeluaran', 50);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('i_besar_pengeluaran');
    }
};
