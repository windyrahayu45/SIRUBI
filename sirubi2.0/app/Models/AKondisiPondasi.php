<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AKondisiPondasi extends Model
{
    protected $table = 'a_kondisi_pondasi';
    protected $primaryKey = 'id_kondisi_pondasi';
    protected $fillable = ['kondisi_pondasi'];
    public $timestamps = false;

    // ======================
    // 🔗 RELASI ANTAR TABEL
    // ======================

    /**
     * Relasi ke tabel fisik_rumah
     * Foreign key di fisik_rumah: kondisi_pondasi_id
     */
    public function fisikRumah()
    {
        return $this->hasMany(FisikRumah::class, 'kondisi_pondasi_id', 'id_kondisi_pondasi');
    }
}
