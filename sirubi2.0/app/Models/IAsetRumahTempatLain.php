<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IAsetRumahTempatLain extends Model
{
    protected $table = 'i_aset_rumah_tempat_lain';
    protected $fillable = ['id_aset_rumah_tempat_lain', 'aset_rumah_tempat_lain'];
    public $timestamps = false;

    public function kepemilikanRumah()
    {
        return $this->hasMany(KepemilikanRumah::class, 'aset_rumah_tempat_lain_id', 'id_aset_rumah_tempat_lain');
    }
}
