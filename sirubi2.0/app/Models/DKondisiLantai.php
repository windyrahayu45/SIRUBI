<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DKondisiLantai extends Model
{
    protected $table = 'd_kondisi_lantai';
    protected $fillable = ['id_kondisi_lantai', 'kondisi_lantai'];
    public $timestamps = false;

    public function kepemilikanRumah()
    {
        return $this->hasMany(KepemilikanRumah::class, 'kondisi_lantai_id', 'id_kondisi_lantai');
    }
}
