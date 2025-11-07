<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DBangunanMenghadapSungai extends Model
{
    protected $table = 'd_bangunan_menghadap_sungai';
    protected $fillable = ['id_bangunan_menghadap_sungai', 'bangunan_menghadap_sungai'];
    public $timestamps = false;

    public function kepemilikanRumah()
    {
        return $this->hasMany(KepemilikanRumah::class, 'bangunan_menghadap_sungai_id', 'id_bangunan_menghadap_sungai');
    }
}
