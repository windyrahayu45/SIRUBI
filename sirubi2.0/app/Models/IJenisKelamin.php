<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IJenisKelamin extends Model
{
    protected $table = 'i_jenis_kelamin';
    protected $primaryKey = 'id_jenis_kelamin';
    protected $fillable = ['id_jenis_kelamin', 'jenis_kelamin'];
    public $timestamps = false;

    public function penduduk()
    {
        return $this->hasMany(SosialEkonomiRumah::class, 'jenis_kelamin_id', 'id_jenis_kelamin');
    }
}
