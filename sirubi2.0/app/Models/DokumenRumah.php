<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenRumah extends Model
{
    protected $table = 'dokumen_rumah';
    protected $fillable = [
        'rumah_id', 'foto_kk', 'foto_ktp', 'foto_imb',
        'foto_rumah_satu', 'foto_rumah_dua', 'foto_rumah_tiga',
        'uploaded_by', 'uploaded_at'
    ];

    public function rumah()
    {
        return $this->belongsTo(Rumah::class, 'rumah_id');
    }
}
