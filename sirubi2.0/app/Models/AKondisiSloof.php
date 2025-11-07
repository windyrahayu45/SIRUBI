<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AKondisiSloof extends Model
{
    protected $table = 'a_kondisi_sloof';
    protected $primaryKey = 'id_kondisi_sloof';
    protected $fillable = ['kondisi_sloof'];
    public $timestamps = false;

    // ======================
    // 🔗 RELASI ANTAR TABEL
    // ======================

    /**
     * Relasi ke tabel fisik_rumah
     * Foreign key di fisik_rumah: kondisi_sloof_id
     */
    public function fisikRumah()
    {
        return $this->hasMany(FisikRumah::class, 'kondisi_sloof_id', 'id_kondisi_sloof');
    }
}
