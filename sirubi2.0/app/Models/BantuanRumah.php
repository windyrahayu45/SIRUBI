<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BantuanRumah extends Model
{
    protected $table = 'bantuan_rumah';

    protected $fillable = [
        'rumah_id', 'pernah_mendapatkan_bantuan_id', 'no_kk_penerima',
        'tahun_bantuan', 'nama_bantuan', 'nama_program_bantuan', 'nominal_bantuan'
    ];

    public function rumah()
    {
        return $this->belongsTo(Rumah::class, 'rumah_id');
    }

     public function pernahMendapatkanBantuan()
    {
        return $this->belongsTo(IPernahMendapatkanBantuan::class, 'pernah_mendapatkan_bantuan_id','id_pernah_mendapatkan_bantuan');
    }
}
