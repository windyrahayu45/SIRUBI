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
        Schema::create('survey_question_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');      // text, number, select, radio, checkbox, dll
            $table->string('label');     // Label untuk ditampilkan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::dropIfExists('survey_question_types');
    }
};
