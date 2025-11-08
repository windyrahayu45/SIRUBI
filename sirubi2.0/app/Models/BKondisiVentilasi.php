<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BKondisiVentilasi extends Model
{
    protected $table = 'b_kondisi_ventilasi';
    protected $primaryKey ='id_kondisi_ventilasi';
    protected $fillable = ['id_kondisi_ventilasi', 'kondisi_ventilasi'];
    public $timestamps = false;

    public function sanitasiRumah()
    {
        return $this->hasMany(SanitasiRumah::class, 'kondisi_ventilasi_id', 'id_kondisi_ventilasi');
    }
}
