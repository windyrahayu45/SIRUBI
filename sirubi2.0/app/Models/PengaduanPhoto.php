<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaduanPhoto extends Model
{
    protected $fillable = ['pengaduan_id', 'file_path'];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }
}

