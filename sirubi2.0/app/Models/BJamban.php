<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BJamban extends Model
{
    protected $table = 'b_jamban';
    protected $primaryKey = 'id_jamban';
    protected $fillable = ['jamban'];
    public $timestamps = false;

    // ======================
    // 🔗 RELASI ANTAR TABEL
    // ======================

    /**
     * Relasi ke tabel sanitasi_rumah
     * Foreign key di sanitasi_rumah: jamban_id
     */
    public function sanitasiRumah()
    {
        return $this->hasMany(SanitasiRumah::class, 'jamban_id', 'id_jamban');
    }
}
