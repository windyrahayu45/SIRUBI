<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BSumberAirMinum extends Model
{
    protected $table = 'b_sumber_air_minum';
    protected $fillable = ['id_sumber_air_minum', 'sumber_air_minum'];
    public $timestamps = false;

    public function sanitasiRumah()
    {
        return $this->hasMany(SanitasiRumah::class, 'sumber_air_minum_id', 'id_sumber_air_minum');
    }
}
