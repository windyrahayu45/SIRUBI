<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionTypeSeeder extends Seeder
{
    public function run()
    {
        DB::table('survey_question_types')->insert([
            ['name' => 'text', 'label' => 'Text'],
            ['name' => 'number', 'label' => 'Number'],
            ['name' => 'textarea', 'label' => 'Textarea'],
            ['name' => 'select', 'label' => 'Select'],
            ['name' => 'radio', 'label' => 'Radio Button'],
            ['name' => 'checkbox', 'label' => 'Checkbox'],
            ['name' => 'date', 'label' => 'Date'],
            ['name' => 'file', 'label' => 'File Upload'],
        ]);
    }
}
