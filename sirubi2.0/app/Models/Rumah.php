<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rumah extends Model
{
    protected $table = 'rumah';
    protected $primaryKey = 'id_rumah';
   
    protected $fillable = [
        'id_rumah_lama',
        'alamat',
        'latitude',
        'longitude',
        'rt',
        'rw',
        'kecamatan_id',
        'kelurahan_id',
        'tahun_pembangunan_rumah',
    ];

    // ======================
    // 🔗 RELASI ANTAR TABEL
    // ======================

    public function getKeyName()
{
    return 'id_rumah';
}

    public function sosialEkonomi()
    {
        return $this->hasOne(SosialEkonomiRumah::class, 'rumah_id');
    }

    public function kepemilikan()
    {
        return $this->hasOne(KepemilikanRumah::class, 'rumah_id');
    }

    public function bantuan()
    {
        return $this->hasOne(BantuanRumah::class, 'rumah_id');
    }

    public function fisik()
    {
        return $this->hasOne(FisikRumah::class, 'rumah_id');
    }

    public function sanitasi()
    {
        return $this->hasOne(SanitasiRumah::class, 'rumah_id');
    }

    public function penilaian()
    {
        return $this->hasOne(PenilaianRumah::class, 'rumah_id');
    }

    public function dokumen()
    {
        return $this->hasOne(DokumenRumah::class, 'rumah_id');
    }

    public function kepalaKeluarga()
    {
        return $this->hasMany(KepalaKeluarga::class, 'rumah_id');
    }

    // Jika kamu punya master kecamatan & kelurahan
    public function kecamatan()
    {
        return $this->belongsTo(IKecamatan::class, 'kecamatan_id','id_kecamatan');
    }

    public function kelurahan()
    {
        return $this->belongsTo(IKelurahan::class, 'kelurahan_id','id_kelurahan');
    }

    public function surveyAnswers()
    {
        return $this->hasMany(SurveyQuestionAnswer::class, 'rumah_id');
    }
}
