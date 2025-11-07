<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IJumlahKk extends Model
{
    protected $table = 'i_jumlah_kk';
    protected $fillable = ['id_jumlah_kk', 'jumlah_kk'];
    public $timestamps = false;
    public function kepemilikanRumah()
    {
        return $this->hasMany(KepemilikanRumah::class, 'jumlah_kk_id', 'id_jumlah_kk');
    }
}
