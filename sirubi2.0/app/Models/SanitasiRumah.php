<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SanitasiRumah extends Model
{
    protected $table = 'sanitasi_rumah';

    protected $fillable = [
        'rumah_id',
        'jendela_lubang_cahaya_id',
        'kondisi_jendela_lubang_cahaya_id',
        'ventilasi_id',
        'keterangan_ventilasi',
        'kondisi_ventilasi_id',
        'kamar_mandi_id',
        'kondisi_kamar_mandi_id',
        'jamban_id',
        'kondisi_jamban_id',
        'sistem_pembuangan_air_kotor_id',
        'kondisi_sistem_pembuangan_air_kotor_id',
        'frekuensi_penyedotan_id',
        'sumber_air_minum_id',
        'kondisi_sumber_air_minum_id',
        'sumber_listrik_id',
    ];

    // ======================
    // 🔗 RELASI ANTAR TABEL
    // ======================

    public function rumah()
    {
        return $this->belongsTo(Rumah::class, 'rumah_id');
    }

    public function jendelaLubangCahaya()
    {
        return $this->belongsTo(BJendelaLubangCahaya::class, 'jendela_lubang_cahaya_id','id_jendela_lubang_cahaya');
    }

    public function kondisiJendelaLubangCahaya()
    {
        return $this->belongsTo(BKondisiJendelaLubangCahaya::class, 'kondisi_jendela_lubang_cahaya_id','id_kondisi_jendela_lubang_cahaya');
    }

    public function ventilasi()
    {
        return $this->belongsTo(BVentilasi::class, 'ventilasi_id','id_ventilasi');
    }

    public function kondisiVentilasi()
    {
        return $this->belongsTo(BKondisiVentilasi::class, 'kondisi_ventilasi_id','id_kondisi_ventilasi');
    }

    public function kamarMandi()
    {
        return $this->belongsTo(BKamarMandi::class, 'kamar_mandi_id','id_kamar_mandi');
    }

    public function kondisiKamarMandi()
    {
        return $this->belongsTo(BKondisiKamarMandi::class, 'kondisi_kamar_mandi_id','id_kondisi_kamar_mandi');
    }

    public function jamban()
    {
        return $this->belongsTo(BJamban::class, 'jamban_id','id_jamban');
    }

    public function kondisiJamban()
    {
        return $this->belongsTo(BKondisiJamban::class, 'kondisi_jamban_id','id_kondisi_jamban');
    }

    public function sistemPembuanganAirKotor()
    {
        return $this->belongsTo(BSistemPembuanganAirKotor::class, 'sistem_pembuangan_air_kotor_id','id_sistem_pembuangan_air_kotor');
    }

    public function kondisiSistemPembuanganAirKotor()
    {
        return $this->belongsTo(BKondisiSistemPembuanganAirKotor::class, 'kondisi_sistem_pembuangan_air_kotor_id','id_kondisi_sistem_pembuangan_air_kotor');
    }

    public function frekuensiPenyedotan()
    {
        return $this->belongsTo(BFrekuensiPenyedotan::class, 'frekuensi_penyedotan_id','id_frekuensi_penyedotan');
    }

    public function sumberAirMinum()
    {
        return $this->belongsTo(BSumberAirMinum::class, 'sumber_air_minum_id','id_sumber_air_minum');
    }

    public function kondisiSumberAirMinum()
    {
        return $this->belongsTo(BKondisiSumberAirMinum::class, 'kondisi_sumber_air_minum_id','id_kondisi_sumber_air_minum');
    }

    public function sumberListrik()
    {
        return $this->belongsTo(BSumberListrik::class, 'sumber_listrik_id','id_sumber_listrik');
    }
}
