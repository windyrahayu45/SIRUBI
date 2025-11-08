<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DBangunanMenghadapJalan extends Model
{
    protected $table = 'd_bangunan_menghadap_jalan';
    protected $primaryKey = 'id_bangunan_menghadap_jalan';
    protected $fillable = ['id_bangunan_menghadap_jalan', 'bangunan_menghadap_jalan'];
    public $timestamps = false;

    public function kepemilikanRumah()
    {
        return $this->hasMany(KepemilikanRumah::class, 'bangunan_menghadap_jalan_id', 'id_bangunan_menghadap_jalan');
    }
}
