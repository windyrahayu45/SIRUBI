<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IPernahMendapatkanBantuan extends Model
{
    protected $table = 'i_pernah_mendapatkan_bantuan';
    protected $fillable = ['id_pernah_mendapatkan_bantuan', 'pernah_mendapatkan_bantuan'];
    public $timestamps = false;

    public function bantuan()
    {
        return $this->hasMany(BantuanRumah::class, 'pernah_mendapatkan_bantuan_id', 'id_pernah_mendapatkan_bantuan');
    }
}
