<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblPolygon extends Model
{
    protected $table = 'tbl_polygon';
    protected $primaryKey = 'id_polygon';
    protected $fillable = [
        'id_polygon', 'nama_kawasan', 'luas', 'jenis_id',
        'keterangan', 'polygon', 'create_at', 'update_at'
    ];
    public $timestamps = false;

    public function jenis()
    {
        return $this->belongsTo(TblJenisPolygon::class, 'jenis_id', 'id_jenis_polygon');
    }
}
