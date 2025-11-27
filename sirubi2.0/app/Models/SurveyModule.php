<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyModule extends Model
{
    protected $table = 'survey_question_modules';

    protected $fillable = [
        'module',
        'label',
    ];

    // Jika nanti tipe punya relasi ke pertanyaan, bisa pakai ini:
    public function questions()
    {
        return $this->hasMany(SurveyQuestion::class, 'module', 'module');
    }
}
