<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblBantuan extends Model
{
    protected $table = 'tbl_bantuan';
    protected $fillable = ['id_bantuan', 'kk', 'tahun', 'nama', 'nama_program', 'nominal', 'create_at', 'update_at'];
    public $timestamps = false;

   
    public function kepalaKeluarga()
    {
        return $this->belongsTo(KepalaKeluarga::class, 'kk', 'no_kk');
    }


}
