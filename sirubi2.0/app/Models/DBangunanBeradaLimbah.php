<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DBangunanBeradaLimbah extends Model
{
    protected $table = 'd_bangunan_berada_limbah';
    protected $fillable = ['id_bangunan_berada_limbah', 'bangunan_berada_limbah'];
    public $timestamps = false;

    public function kepemilikanRumah()
    {
        return $this->hasMany(KepemilikanRumah::class, 'bangunan_berada_limbah_id', 'id_bangunan_berada_limbah');
    }
}
