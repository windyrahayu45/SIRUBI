<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyQuestionAnswer extends Model
{
    protected $fillable = [
        'rumah_id',
        'question_id',
        'answer_text',
        'answer_option_id',
        'answer_option_ids',
        'file_path'
    ];

    protected $primaryKey = 'id';

    protected $casts = [
        'answer_option_ids' => 'array'
    ];

    /**
     * Relasi ke pertanyaan
     * SurveyQuestionAnswer -> SurveyQuestion
     */
    public function question()
    {
        return $this->belongsTo(SurveyQuestion::class, 'question_id');
    }

    /**
     * Relasi ke Rumah
     * SurveyQuestionAnswer -> Rumah
     */
    public function rumah()
    {
        return $this->belongsTo(Rumah::class, 'rumah_id');
    }
}
