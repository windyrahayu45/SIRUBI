<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AKondisiSloof extends Model
{
    protected $table = 'a_kondisi_sloof';
    protected $primaryKey = 'id_kondisi_sloof';
    protected $fillable = ['kondisi_sloof'];
    public $timestamps = false;

   
    public function fisikRumah()
    {
        return $this->hasMany(FisikRumah::class, 'kondisi_sloof_id', 'id_kondisi_sloof');
    }
}
