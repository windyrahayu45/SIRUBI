<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SosialEkonomiRumah extends Model
{
    protected $table = 'sosial_ekonomi_rumah';

    protected $fillable = [
        'rumah_id',
        'jumlah_kk_id',
        'no_kk',
        'jenis_kelamin_id',
        'usia',
        'pendidikan_terakhir_id',
        'pekerjaan_utama_id',
        'besar_penghasilan_perbulan_id',
        'besar_pengeluaran_perbulan_id',
        'status_dtks_id',
    ];

    // ======================
    // 🔗 RELASI ANTAR TABEL
    // ======================

    public function rumah()
    {
        return $this->belongsTo(Rumah::class, 'rumah_id');
    }

    public function jumlahKK()
    {
        return $this->belongsTo(IJumlahKk::class, 'jumlah_kk_id', 'id_jumlah_kk');
    }

    public function jenisKelamin()
    {
        return $this->belongsTo(IJenisKelamin::class, 'jenis_kelamin_id', 'id_jenis_kelamin');
    }

    public function pendidikanTerakhir()
    {
        return $this->belongsTo(IPendidikanTerakhir::class, 'pendidikan_terakhir_id', 'id_pendidikan_terakhir');
    }

    public function pekerjaanUtama()
    {
        return $this->belongsTo(IPekerjaanUtama::class, 'pekerjaan_utama_id', 'id_pekerjaan_utama');
    }

    public function besarPenghasilan()
    {
        return $this->belongsTo(IBesarPenghasilan::class, 'besar_penghasilan_perbulan_id', 'id_besar_penghasilan');
    }

    public function besarPengeluaran()
    {
        return $this->belongsTo(IBesarPengeluaran::class, 'besar_pengeluaran_perbulan_id', 'id_besar_pengeluaran');
    }

    public function statusDtks()
    {
        return $this->belongsTo(CStatusDtks::class, 'status_dtks_id', 'id_status_dtks');
    }
}
