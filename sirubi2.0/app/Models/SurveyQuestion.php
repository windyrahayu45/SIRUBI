<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
     protected $table = 'survey_questions';

    protected $fillable = [
        'module',
        'label',
        'key',
        'type',
        'is_required',
        'order',
        'is_active',
        'parent_question_id',   // pertanyaan induk
        'trigger_option_id',    // opsi yang memicu
    ];

    // ========================
    // 🔗 Relasi
    // ========================

    /** daftar opsi jawaban */
    public function options()
    {
        return $this->hasMany(SurveyQuestionOption::class, 'question_id')
            ->where('is_active', 1)
            ->orderBy('order');
    }

    /** pertanyaan induk */
    public function parent()
    {
        return $this->belongsTo(SurveyQuestion::class, 'parent_question_id');
    }

    /** opsi pemicu */
    public function triggerOption()
    {
        return $this->belongsTo(SurveyQuestionOption::class, 'trigger_option_id');
    }

    /** pertanyaan turunan */
    public function children()
    {
        return $this->hasMany(SurveyQuestion::class, 'parent_question_id')
            ->orderBy('order');
    }

    // ========================
    // ✅ Scope untuk list hanya aktif
    // ========================
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
