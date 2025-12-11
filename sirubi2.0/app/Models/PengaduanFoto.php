<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaduanFoto extends Model
{
      protected $fillable = [
        'pengaduan_id',
        'file_path',
        'deskripsi',
    ];

    public function pengaduan()
    {
        return $this->belongsTo(PengaduanRumah::class, 'pengaduan_id');
    }
}
