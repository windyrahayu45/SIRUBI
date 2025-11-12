<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblPolygonKelurahan extends Model
{
    protected $table = 'tbl_polygon_kelurahan';
    protected $primaryKey = 'id_polygon';
    protected $fillable = [
        'id_polygon',
        'kecamatan_id',
        'kelurahan_id',
        'luas',
        'keterangan',
        'polygon',
        'create_at',
        'update_at'
    ];
    public $timestamps = false;

    // Relasi opsional (kalau tabelnya ada)
    public function kecamatan()
    {
        return $this->belongsTo(IKecamatan::class, 'kecamatan_id', 'id_kecamatan');
    }

    public function kelurahan()
    {
        return $this->belongsTo(IKelurahan::class, 'kelurahan_id', 'id_kelurahan');
    }
}
