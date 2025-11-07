<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IBesarPenghasilan extends Model
{
    protected $table = 'i_besar_penghasilan';
    protected $fillable = ['id_besar_penghasilan', 'besar_penghasilan'];
    public $timestamps = false;

    public function kepemilikanRumah()
    {
        return $this->hasMany(KepemilikanRumah::class, 'besar_penghasilan_id', 'id_besar_penghasilan');     
    }
}
