<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaKeluarga extends Model
{
    protected $table = 'anggota_keluarga';
    protected $primaryKey = 'id';
    protected $fillable = [
        'kepala_keluarga_id', 'nik', 'nama','kode_anggota'
    ];

    public function kepalaKeluarga()
    {
        return $this->belongsTo(KepalaKeluarga::class, 'kepala_keluarga_id');
    }
}
