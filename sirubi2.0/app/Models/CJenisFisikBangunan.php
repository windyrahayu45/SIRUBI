<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CJenisFisikBangunan extends Model
{
    protected $table = 'c_jenis_fisik_bangunan';
    protected $primaryKey = 'id_jenis_fisik_bangunan';
    protected $fillable = ['id_jenis_fisik_bangunan', 'jenis_fisik_bangunan'];
    public $timestamps = false;

    public function kepemilikanRumah()
    {
        return $this->hasMany(KepemilikanRumah::class, 'jenis_fisik_bangunan_id', 'id_jenis_fisik_bangunan');
    }
}
