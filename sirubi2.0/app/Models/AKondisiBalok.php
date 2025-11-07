<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AKondisiBalok extends Model
{
    protected $table = 'a_kondisi_balok';
    protected $primaryKey = 'id_kondisi_balok';
    protected $fillable = ['kondisi_balok'];
    public $timestamps = false;

    // ======================
    // 🔗 RELASI ANTAR TABEL
    // ======================

    /**
     * Relasi ke tabel fisik_rumah
     * Kolom foreign key di fisik_rumah: kondisi_balok_id
     */
    public function fisikRumah()
    {
        return $this->hasMany(FisikRumah::class, 'kondisi_balok_id', 'id_kondisi_balok');
    }

    /**
     * Jika kamu punya tabel referensi atau detail lain (misal master kondisi), bisa ditambah di sini
     * Contoh: public function masterKategori() { ... }
     */
}
