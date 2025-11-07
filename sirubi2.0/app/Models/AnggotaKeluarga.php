<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaKeluarga extends Model
{
    protected $table = 'anggota_keluarga';
    protected $fillable = [
        'kepala_keluarga_id', 'nik', 'nama'
    ];

    public function kepalaKeluarga()
    {
        return $this->belongsTo(KepalaKeluarga::class, 'kepala_keluarga_id');
    }
}
