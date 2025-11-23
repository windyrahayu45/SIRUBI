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
        Schema::create('survey_question_answers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('rumah_id');      // Id data rumah
            $table->unsignedBigInteger('question_id');   // Id pertanyaan

            // Untuk text / textarea / number / date
            $table->text('answer_text')->nullable();

            // Untuk select & radio (menyimpan option_id)
            $table->unsignedBigInteger('answer_option_id')->nullable();

            // Untuk checkbox (multiple option_id)
            $table->json('answer_option_ids')->nullable();

            // Untuk file upload
            $table->string('file_path')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_question_answers');
    }
};
