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
        Schema::create('survey_questions', function (Blueprint $table) {
            $table->id();
            $table->string('module');   // contoh: rumah, fisik, sanitasi, sosial, dll
            $table->string('label');    // teks pertanyaan
            $table->string('key');      // nama unik untuk identifikasi
            $table->string('type');     // text, number, select, radio, checkbox, file, dll
            $table->boolean('is_required')->default(false);
            $table->integer('order')->default(0); // urutan tampil
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_questions');
    }
};
