<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BKamarMandi extends Model
{
    protected $table = 'b_kamar_mandi';
    protected $primaryKey = 'id_kamar_mandi';
    protected $fillable = ['kamar_mandi'];
    public $timestamps = false;

    // ======================
    // 🔗 RELASI ANTAR TABEL
    // ======================

    /**
     * Relasi ke tabel sanitasi_rumah
     * Foreign key di sanitasi_rumah: kamar_mandi_id
     */
    public function sanitasiRumah()
    {
        return $this->hasMany(SanitasiRumah::class, 'kamar_mandi_id', 'id_kamar_mandi');
    }
}
