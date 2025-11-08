<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IPendidikanTerakhir extends Model
{
    protected $table = 'i_pendidikan_terakhir';
    protected $primaryKey = 'id_pendidikan_terakhir';
    protected $fillable = ['id_pendidikan_terakhir', 'pendidikan_terakhir'];
    public $timestamps = false;

    public function penduduk()
    {
        return $this->hasMany(SosialEkonomiRumah::class, 'pendidikan_terakhir_id', 'id_pendidikan_terakhir');
    }
}
