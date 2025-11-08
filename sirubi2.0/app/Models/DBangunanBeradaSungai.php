<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DBangunanBeradaSungai extends Model
{
    protected $table = 'd_bangunan_berada_sungai';
    protected $primaryKey = 'id_bangunan_berada_sungai';
    protected $fillable = ['id_bangunan_berada_sungai', 'bangunan_berada_sungai'];
    public $timestamps = false;

    public function kepemilikanRumah()
    {
        return $this->hasMany(KepemilikanRumah::class, 'bangunan_berada_sungai_id', 'id_bangunan_berada_sungai');
    }
}
