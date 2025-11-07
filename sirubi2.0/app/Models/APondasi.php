<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class APondasi extends Model
{
    protected $table = 'a_pondasi';
    protected $primaryKey = 'id_pondasi';
    protected $fillable = ['pondasi'];
    public $timestamps = false;

    // ======================
    // 🔗 RELASI ANTAR TABEL
    // ======================

    /**
     * Relasi ke tabel fisik_rumah
     * Foreign key di fisik_rumah: pondasi_id
     */
    public function fisikRumah()
    {
        return $this->hasMany(FisikRumah::class, 'pondasi_id', 'id_pondasi');
    }
}
