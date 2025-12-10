<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblDokumen extends Model
{
    protected $table = 'tbl_dokumen';
    protected $primaryKey = 'id_dokumen';
    protected $fillable = ['id_dokumen', 'nama_dokumen', 'source', 'date_upload'];
    public $timestamps = false;

    public function bantuans()
    {
        return $this->hasMany(TblBantuan::class, 'id_dokumen', 'id_dokumen');
    }
}
