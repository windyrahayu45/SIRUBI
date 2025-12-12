<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengaduanRumah extends Model
{
    protected $table = 'pengaduan_rumahs';

    protected $fillable = [
        'rumah_id',
        'nik',
        'kk',
        'alamat',
        'rt',
        'rw',
        'keterangan',
        'status',
        'catatan_admin',

        // tambahan baru
        'kecamatan_id',
        'kelurahan_id',
    ];

    protected $casts = [
        'kecamatan_id' => 'integer',
        'kelurahan_id' => 'integer',
        'rumah_id'     => 'integer',
    ];

    /** ============================
     *  RELASI FOTO-FOTO
     * ============================ */
    public function fotos()
    {
        return $this->hasMany(PengaduanFoto::class, 'pengaduan_id');
    }

    /** ============================
     *  RELASI RUMAH (opsional)
     * ============================ */
    public function rumah()
    {
        return $this->belongsTo(Rumah::class, 'rumah_id', 'id_rumah');
    }

    /** ============================
     *  RELASI KECAMATAN
     * ============================ */
    public function kecamatan()
    {
        return $this->belongsTo(IKecamatan::class, 'kecamatan_id', 'id_kecamatan');
    }

    /** ============================
     *  RELASI KELURAHAN
     * ============================ */
    public function kelurahan()
    {
        return $this->belongsTo(IKelurahan::class, 'kelurahan_id', 'id_kelurahan');
    }
}
