<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IPekerjaanUtama extends Model
{
    protected $table = 'i_pekerjaan_utama';
    protected $fillable = ['id_pekerjaan_utama', 'pekerjaan_utama'];
    public $timestamps = false;

    public function sosialEkonomi()
    {
        return $this->hasMany(SosialEkonomiRumah::class, 'pekerjaan_utama_id', 'id_pekerjaan_utama');
    }
}
