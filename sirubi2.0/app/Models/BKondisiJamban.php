<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BKondisiJamban extends Model
{
    protected $table = 'b_kondisi_jamban';
    protected $primaryKey = 'id_kondisi_jamban';
    protected $fillable = ['kondisi_jamban'];
    public $timestamps = false;

    // ======================
    // 🔗 RELASI ANTAR TABEL
    // ======================

    /**
     * Relasi ke tabel sanitasi_rumah
     * Foreign key di sanitasi_rumah: kondisi_jamban_id
     */
    public function sanitasiRumah()
    {
        return $this->hasMany(SanitasiRumah::class, 'kondisi_jamban_id', 'id_kondisi_jamban');
    }
}
