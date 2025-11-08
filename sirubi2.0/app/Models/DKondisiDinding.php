<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DKondisiDinding extends Model
{
    protected $table = 'd_kondisi_dinding';
    protected $primaryKey = 'id_kondisi_dinding';
    protected $fillable = ['id_kondisi_dinding', 'kondisi_dinding'];
    public $timestamps = false;

    public function kepemilikanRumah()
    {
        return $this->hasMany(KepemilikanRumah::class, 'kondisi_dinding_id', 'id_kondisi_dinding');
    }
}
