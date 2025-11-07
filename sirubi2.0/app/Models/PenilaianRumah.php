<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianRumah extends Model
{
    protected $table = 'penilaian_rumah';
    protected $fillable = [
        'rumah_id', 'nilai_a', 'prioritas_a', 'nilai_b', 'prioritas_b',
        'nilai_c', 'prioritas_c', 'nilai', 'status_rumah', 'status_luas'
    ];

    public function rumah()
    {
        return $this->belongsTo(Rumah::class, 'rumah_id');
    }
}
