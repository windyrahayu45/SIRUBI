<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblPolygonKelurahan extends Model
{
    protected $table = 'tbl_polygon_kelurahan';
    protected $fillable = ['id_polygon', 'kecamatan_id', 'kelurahan_id', 'luas', 'keterangan', 'polygon', 'create_at', 'update_at'];
    public $timestamps = false;
}
