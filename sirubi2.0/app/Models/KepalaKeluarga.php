<?php

namespace App\Models;

use App\Models\AnggotaKeluarga as ModelsAnggotaKeluarga;
use App\Models\Models\AnggotaKeluarga;
use Illuminate\Database\Eloquent\Model;

class KepalaKeluarga extends Model
{
    protected $table = 'kepala_keluarga';
    protected $primaryKey = 'id';
    protected $fillable = [
        'rumah_id', 'no_kk', 'kode_kk'
    ];

    public function rumah()
    {
        return $this->belongsTo(Rumah::class, 'rumah_id');
    }

    public function anggota()
    {
        return $this->hasMany(ModelsAnggotaKeluarga::class, 'kepala_keluarga_id');
    }
}
