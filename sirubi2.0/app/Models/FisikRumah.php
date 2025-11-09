<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FisikRumah extends Model
{
    protected $table = 'fisik_rumah';
    protected $fillable = [
        'rumah_id', 'pondasi_id', 'jenis_pondasi', 'kondisi_pondasi_id',
        'kondisi_sloof_id', 'kondisi_kolom_tiang_id', 'kondisi_balok_id',
        'kondisi_struktur_atap_id', 'material_atap_terluas_id', 'kondisi_penutup_atap_id',
        'material_dinding_terluas_id', 'kondisi_dinding_id', 'material_lantai_terluas_id',
        'kondisi_lantai_id', 'akses_ke_jalan_id', 'bangunan_menghadap_jalan_id',
        'bangunan_menghadap_sungai_id', 'bangunan_berada_limbah_id',
        'bangunan_berada_sungai_id', 'luas_rumah', 'tinggi_rata_rumah',
        'jumlah_penghuni_laki', 'jumlah_penghuni_perempuan', 'jumlah_abk',
        'ruang_keluarga_dan_ruang_tidur_id', 'jumlah_kamar_tidur', 'luas_rata_kamar_tidur',
        'jenis_fisik_bangunan_id', 'fungsi_rumah_id', 'tipe_rumah_id', 'jumlah_lantai_bangunan'
    ];

    public function rumah()
    {
        return $this->belongsTo(Rumah::class, 'rumah_id');
    }

    public function pondasi()
    {
        return $this->belongsTo(APondasi::class, 'pondasi_id', 'id_pondasi');
    }

    public function kondisiPondasi()
    {
        return $this->belongsTo(AKondisiPondasi::class, 'kondisi_pondasi_id', 'id_kondisi_pondasi');
    }

    public function jenisPondasi()
    {
        return $this->belongsTo(TblJenisPondasi::class, 'jenis_pondasi', 'id_jenis_pondasi');
    }

    public function kondisiSloof()
    {
        return $this->belongsTo(AKondisiSloof::class, 'kondisi_sloof_id', 'id_kondisi_sloof');
    }

    public function kondisiKolomTiang()
    {
        return $this->belongsTo(AKondisiKolomTiang::class, 'kondisi_kolom_tiang_id', 'id_kondisi_kolom_tiang');
    }

    public function kondisiBalok()
    {
        return $this->belongsTo(AKondisiBalok::class, 'kondisi_balok_id', 'id_kondisi_balok');
    }

    public function kondisiStrukturAtap()
    {
        return $this->belongsTo(AKondisiStrukturAtap::class, 'kondisi_struktur_atap_id', 'id_kondisi_struktur_atap');
    }

    public function materialAtapTerluas()
    {
        return $this->belongsTo(DMaterialAtapTerluas::class, 'material_atap_terluas_id', 'id_material_atap_terluas');
    }

    public function kondisiPenutupAtap()
    {
        return $this->belongsTo(DKondisiPenutupAtap::class, 'kondisi_penutup_atap_id', 'id_kondisi_penutup_atap');
    }

    public function materialDindingTerluas()
    {
        return $this->belongsTo(DMaterialDindingTerluas::class, 'material_dinding_terluas_id', 'id_material_dinding_terluas');
    }

    public function kondisiDinding()
    {
        return $this->belongsTo(DKondisiDinding::class, 'kondisi_dinding_id', 'id_kondisi_dinding');
    }

    public function materialLantaiTerluas()
    {
        return $this->belongsTo(DMaterialLantaiTerluas::class, 'material_lantai_terluas_id', 'id_material_lantai_terluas');
    }

    public function kondisiLantai()
    {
        return $this->belongsTo(DKondisiLantai::class, 'kondisi_lantai_id', 'id_kondisi_lantai');
    }

    public function aksesKeJalan()
    {
        return $this->belongsTo(DAksesKeJalan::class, 'akses_ke_jalan_id', 'id_akses_ke_jalan');
    }

    public function bangunanMenghadapJalan()
    {
        return $this->belongsTo(DBangunanMenghadapJalan::class, 'bangunan_menghadap_jalan_id', 'id_bangunan_menghadap_jalan');
    }

    public function bangunanMenghadapSungai()
    {
        return $this->belongsTo(DBangunanMenghadapSungai::class, 'bangunan_menghadap_sungai_id', 'id_bangunan_menghadap_sungai');
    }

    public function bangunanBeradaLimbah()
    {
        return $this->belongsTo(DBangunanBeradaLimbah::class, 'bangunan_berada_limbah_id', 'id_bangunan_berada_limbah');
    }

    public function bangunanBeradaSungai()
    {
        return $this->belongsTo(DBangunanBeradaSungai::class, 'bangunan_berada_sungai_id', 'id_bangunan_berada_sungai');
    }

    public function ruangKeluargaDanTidur()
    {
        return $this->belongsTo(CRuangKeluargaDanTidur::class, 'ruang_keluarga_dan_ruang_tidur_id', 'id_ruang_keluarga_dan_tidur');
    }

    public function jenisFisikBangunan()
    {
        return $this->belongsTo(CJenisFisikBangunan::class, 'jenis_fisik_bangunan_id', 'id_jenis_fisik_bangunan');
    }

    public function fungsiRumah()
    {
        return $this->belongsTo(CFungsiRumah::class, 'fungsi_rumah_id', 'id_fungsi_rumah');
    }

    public function tipeRumah()
    {
        return $this->belongsTo(CTipeRumah::class, 'tipe_rumah_id', 'id_tipe_rumah');
    }
}
