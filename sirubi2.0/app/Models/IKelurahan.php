<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IKelurahan extends Model
{
    protected $table = 'i_kelurahan';
    protected $fillable = ['id_kelurahan', 'kecamatan_id', 'nama_kelurahan'];
    public $timestamps = false;

    public function kecamatan()
    {
        return $this->belongsTo(IKecamatan::class, 'kecamatan_id', 'id_kecamatan');
    }

    public function rumah()
    {
        return $this->hasMany(Rumah::class, 'kelurahan_id', 'id_kelurahan');
    }
}
