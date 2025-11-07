<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BFrekuensiPenyedotan extends Model
{
    protected $table = 'b_frekuensi_penyedotan';
    protected $primaryKey = 'id_frekuensi_penyedotan';
    protected $fillable = ['frekuensi_penyedotan'];
    public $timestamps = false;

    // ======================
    // 🔗 RELASI ANTAR TABEL
    // ======================

    /**
     * Relasi ke tabel sanitasi_rumah
     * Foreign key di sanitasi_rumah: frekuensi_penyedotan_id
     */
    public function sanitasiRumah()
    {
        return $this->hasMany(SanitasiRumah::class, 'frekuensi_penyedotan_id', 'id_frekuensi_penyedotan');
    }
}
