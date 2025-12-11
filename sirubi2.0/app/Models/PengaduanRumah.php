<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaduanRumah extends Model
{
    protected $fillable = [
        'rumah_id',
        'nik',
        'kk',
        'alamat',
        'rt',
        'rw',
        'keterangan',
        'status',
        'catatan_admin',
    ];

    public function fotos()
    {
        return $this->hasMany(PengaduanFoto::class, 'pengaduan_id');
    }

    // Jika ingin tarik data rumah
    public function rumah()
    {
        return $this->belongsTo(Rumah::class, 'rumah_id');
    }
}
