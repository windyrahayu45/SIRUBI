<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BKondisiSistemPembuanganAirKotor extends Model
{
    protected $table = 'b_kondisi_sistem_pembuangan_air_kotor';
    protected $primaryKey = 'id_kondisi_sistem_pembuangan_air_kotor';
    protected $fillable = ['kondisi_sistem_pembuangan_air_kotor'];
    public $timestamps = false;

    // ======================
    // 🔗 RELASI ANTAR TABEL
    // ======================

    /**
     * Relasi ke tabel sanitasi_rumah
     * Foreign key di sanitasi_rumah: kondisi_sistem_pembuangan_air_kotor_id
     */
    public function sanitasiRumah()
    {
        return $this->hasMany(SanitasiRumah::class, 'kondisi_sistem_pembuangan_air_kotor_id', 'id_kondisi_sistem_pembuangan_air_kotor');
    }
}
