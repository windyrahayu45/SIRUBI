<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblAnggotaKk extends Model
{
    protected $table = 'tbl_anggota_kk';
    protected $fillable = ['id_anggota_kk', 'anggota_kk'];
    public $timestamps = false;
        
}
