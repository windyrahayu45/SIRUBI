<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BKondisiSumberAirMinum extends Model
{
    protected $table = 'b_kondisi_sumber_air_minum';
    protected $fillable = ['id_kondisi_sumber_air_minum', 'kondisi_sumber_air_minum'];
    public $timestamps = false;

     public function sanitasiRumah()
    {
        return $this->hasMany(SanitasiRumah::class, 'kondisi_sumber_air_minum_id', 'id_kondisi_sumber_air_minum');
    }
}
