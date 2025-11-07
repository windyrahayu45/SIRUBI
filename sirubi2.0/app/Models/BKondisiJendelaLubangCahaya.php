<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BKondisiJendelaLubangCahaya extends Model
{
    protected $table = 'b_kondisi_jendela_lubang_cahaya';
    protected $primaryKey = 'id_kondisi_jendela_lubang_cahaya';
    protected $fillable = ['kondisi_jendela_lubang_cahaya'];
    public $timestamps = false;

    // ======================
    // 🔗 RELASI ANTAR TABEL
    // ======================

    /**
     * Relasi ke tabel sanitasi_rumah
     * Foreign key di sanitasi_rumah: kondisi_jendela_lubang_cahaya_id
     */
    public function sanitasiRumah()
    {
        return $this->hasMany(SanitasiRumah::class, 'kondisi_jendela_lubang_cahaya_id', 'id_kondisi_jendela_lubang_cahaya');
    }
}
