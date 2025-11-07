<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IKecamatan extends Model
{
    protected $table = 'i_kecamatan';
    protected $fillable = ['id_kecamatan', 'nama_kecamatan'];
    public $timestamps = false;

    public function kelurahan()
    {
        return $this->hasMany(IKelurahan::class, 'kecamatan_id', 'id_kecamatan');
    }

    public function rumah()
    {
        return $this->hasMany(Rumah::class, 'kecamatan_id', 'id_kecamatan');
    }
}
