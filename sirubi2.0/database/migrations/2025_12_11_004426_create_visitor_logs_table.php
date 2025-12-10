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
        Schema::create('visitor_logs', function (Blueprint $table) {
            $table->id();
               // IP pengunjung
            $table->string('ip', 50)->nullable();

            // URL halaman yang dikunjungi
            $table->string('url', 255)->nullable();

            // Browser/device
            $table->text('user_agent')->nullable();

            // Waktu kunjungan
            $table->timestamp('visited_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitor_logs');
    }
};
