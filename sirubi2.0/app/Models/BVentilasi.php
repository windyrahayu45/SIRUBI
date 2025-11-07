<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BVentilasi extends Model
{
    protected $table = 'b_ventilasi';
    protected $fillable = ['id_ventilasi', 'ventilasi'];
    public $timestamps = false;

     public function sanitasiRumah()
    {
        return $this->hasMany(SanitasiRumah::class, 'ventilasi_id', 'id_ventilasi');
    }
}
