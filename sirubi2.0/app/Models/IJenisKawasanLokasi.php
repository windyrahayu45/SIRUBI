<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IJenisKawasanLokasi extends Model
{
    protected $table = 'i_jenis_kawasan_lokasi';
    protected $fillable = ['id_jenis_kawasan_lokasi', 'jenis_kawasan_lokasi'];
    public $timestamps = false;

    public function kepemilikanRumah()
    {
        return $this->hasMany(KepemilikanRumah::class, 'jenis_kawasan_lokasi_id', 'id_jenis_kawasan_lokasi');
    }
}
