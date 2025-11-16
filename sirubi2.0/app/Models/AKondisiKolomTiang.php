<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AKondisiKolomTiang extends Model
{
    protected $table = 'a_kondisi_kolom_tiang';
    protected $primaryKey = 'id_kondisi_kolom_tiang';
    protected $fillable = ['kondisi_kolom_tiang'];
    public $timestamps = false;

  
    public function fisikRumah()
    {
        return $this->hasMany(FisikRumah::class, 'kondisi_kolom_tiang_id', 'id_kondisi_kolom_tiang');
    }
}
