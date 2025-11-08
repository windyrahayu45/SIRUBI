<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IAsetTanahTempatLain extends Model
{
    protected $table = 'i_aset_tanah_tempat_lain';
    protected $primaryKey = 'id_aset_tanah_tempat_lain';
    protected $fillable = ['id_aset_tanah_tempat_lain', 'aset_tanah_tempat_lain'];
    public $timestamps = false;

    public function kepemilikanRumah()
    {
        return $this->hasMany(KepemilikanRumah::class, 'aset_tanah_tempat_lain_id', 'id_aset_tanah_tempat_lain');
    }
}
