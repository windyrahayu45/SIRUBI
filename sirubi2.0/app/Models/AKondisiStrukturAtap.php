<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AKondisiStrukturAtap extends Model
{
    protected $table = 'a_kondisi_struktur_atap';
    protected $primaryKey = 'id_kondisi_struktur_atap';
    protected $fillable = ['kondisi_struktur_atap'];
    public $timestamps = false;

    
    public function fisikRumah()
    {
        return $this->hasMany(FisikRumah::class, 'kondisi_struktur_atap_id', 'id_kondisi_struktur_atap');
    }
}
