<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IJumlahKk extends Model
{
    protected $table = 'i_jumlah_kk';
    protected $primaryKey = 'id_jumlah_kk'; // 🧩 wajib ditambahkan
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = ['id_jumlah_kk', 'jumlah_kk'];

    public function kepemilikanRumah()
    {
        return $this->hasMany(KepemilikanRumah::class, 'jumlah_kk_id', 'id_jumlah_kk');
    }
}
