<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BKondisiKamarMandi extends Model
{
    protected $table = 'b_kondisi_kamar_mandi';
    protected $primaryKey = 'id_kondisi_kamar_mandi';
    protected $fillable = ['kondisi_kamar_mandi'];
    public $timestamps = false;

    // ======================
    // 🔗 RELASI ANTAR TABEL
    // ======================

    /**
     * Relasi ke tabel sanitasi_rumah
     * Foreign key di sanitasi_rumah: kondisi_kamar_mandi_id
     */
    public function sanitasiRumah()
    {
        return $this->hasMany(SanitasiRumah::class, 'kondisi_kamar_mandi_id', 'id_kondisi_kamar_mandi');
    }
}
