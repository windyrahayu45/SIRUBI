<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyQuestionType extends Model
{
     protected $table = 'survey_question_types';

    protected $fillable = [
        'name',
        'label',
    ];

    // Jika nanti tipe punya relasi ke pertanyaan, bisa pakai ini:
    public function questions()
    {
        return $this->hasMany(SurveyQuestion::class, 'type', 'name');
    }
}
