<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $fillable = [
        'judul', 'deskripsi', 'kategori', 'lokasi','nama_pelapor','no_hp',
        'status', 'user_id', 'handled_by', 'catatan_admin'
    ];

    public function photos()
    {
        return $this->hasMany(PengaduanPhoto::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function handler()
    {
        return $this->belongsTo(User::class, 'handled_by');
    }
}

