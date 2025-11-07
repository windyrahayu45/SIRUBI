<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BJendelaLubangCahaya extends Model
{
    protected $table = 'b_jendela_lubang_cahaya';
    protected $primaryKey = 'id_jendela_lubang_cahaya';
    protected $fillable = ['jendela_lubang_cahaya'];
    public $timestamps = false;

    // ======================
    // 🔗 RELASI ANTAR TABEL
    // ======================

    /**
     * Relasi ke tabel sanitasi_rumah
     * Foreign key di sanitasi_rumah: jendela_lubang_cahaya_id
     */
    public function sanitasiRumah()
    {
        return $this->hasMany(SanitasiRumah::class, 'jendela_lubang_cahaya_id', 'id_jendela_lubang_cahaya');
    }
}
