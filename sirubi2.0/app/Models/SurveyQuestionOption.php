<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyQuestionOption extends Model
{
    protected $fillable = ['question_id', 'label', 'value', 'order', 'is_active'];

    public function question()
    {
        return $this->belongsTo(SurveyQuestion::class);
    }
}
