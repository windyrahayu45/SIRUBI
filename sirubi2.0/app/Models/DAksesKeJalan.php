<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DAksesKeJalan extends Model
{
    protected $table = 'd_akses_ke_jalan';
    protected $fillable = ['id_akses_ke_jalan', 'akses_ke_jalan'];
    public $timestamps = false;

    public function kepemilikanRumah()
    {
        return $this->hasMany(KepemilikanRumah::class, 'akses_ke_jalan_id', 'id_akses_ke_jalan');
    }
}
