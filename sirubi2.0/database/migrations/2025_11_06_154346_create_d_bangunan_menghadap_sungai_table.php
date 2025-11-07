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
        Schema::create('d_bangunan_menghadap_sungai', function (Blueprint $table) {
            $table->integer('id_bangunan_menghadap_sungai', true);
            $table->string('bangunan_menghadap_sungai');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('d_bangunan_menghadap_sungai');
    }
};
