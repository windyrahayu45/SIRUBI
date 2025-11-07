<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DKondisiPenutupAtap extends Model
{
    protected $table = 'd_kondisi_penutup_atap';
    protected $fillable = ['id_kondisi_penutup_atap', 'kondisi_penutup_atap'];
    public $timestamps = false;

    public function kepemilikanRumah()
    {
        return $this->hasMany(KepemilikanRumah::class, 'kondisi_penutup_atap_id', 'id_kondisi_penutup_atap');
    }
}
