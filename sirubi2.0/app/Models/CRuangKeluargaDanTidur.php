<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CRuangKeluargaDanTidur extends Model
{
    protected $table = 'c_ruang_keluarga_dan_tidur';
    protected $primaryKey = 'id_ruang_keluarga_dan_tidur';
    protected $fillable = ['id_ruang_keluarga_dan_tidur', 'ruang_keluarga_dan_tidur'];
    public $timestamps = false;

    public function kepemilikanRumah()
    {
        return $this->hasMany(KepemilikanRumah::class, 'ruang_keluarga_dan_tidur_id', 'id_ruang_keluarga_dan_tidur');
    }
}
