<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblJenisPondasi extends Model
{
    protected $table = 'tbl_jenis_pondasi';
    protected $fillable = ['id_jenis_pondasi', 'nama_jenis_pondasi'];
    public $timestamps = false;

    public function fisik()
    {
        return $this->hasMany(FisikRumah::class, 'jenis_pondasi_id', 'id_jenis_pondasi');
    }
}
