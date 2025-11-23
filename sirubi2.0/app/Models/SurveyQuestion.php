<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    protected $table = 'survey_questions';

    protected $fillable = [
        'module', 'label', 'key', 'type', 
        'is_required', 'order', 'is_active'
    ];

    public function options()
    {
        
     return $this->hasMany(SurveyQuestionOption::class, 'question_id')
                ->where('is_active', 1)
                ->orderBy('order');
    }
}
