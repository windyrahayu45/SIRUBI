<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TblJenisPolygon extends Model
{
    protected $table = 'tbl_jenis_polygon';
    protected $primaryKey = 'id_jenis_polygon';
    protected $fillable = ['id_jenis_polygon', 'jenis_polygon'];
    public $timestamps = false;

    public function polygons()
    {
        return $this->hasMany(TblPolygon::class, 'jenis_id', 'id_jenis_polygon');
    }
}
