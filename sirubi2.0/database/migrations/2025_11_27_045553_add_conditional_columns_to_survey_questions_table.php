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
        Schema::table('survey_questions', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_question_id')->nullable()->after('type');
            $table->unsignedBigInteger('trigger_option_id')->nullable()->after('parent_question_id');

            // optional: buat foreign key
            $table->foreign('parent_question_id')->references('id')->on('survey_questions')->onDelete('cascade');
            $table->foreign('trigger_option_id')->references('id')->on('survey_question_options')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('survey_questions', function (Blueprint $table) {
            $table->dropForeign(['parent_question_id']);
            $table->dropForeign(['trigger_option_id']);

            $table->dropColumn(['parent_question_id', 'trigger_option_id']);
        });
    }
};
