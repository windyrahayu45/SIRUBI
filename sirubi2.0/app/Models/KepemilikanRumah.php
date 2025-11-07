<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KepemilikanRumah extends Model
{
    protected $table = 'kepemilikan_rumah';
    protected $fillable = [
        'rumah_id', 'status_kepemilikan_tanah_id', 'bukti_kepemilikan_tanah_id',
        'status_kepemilikan_rumah_id', 'nik_kepemilikan_rumah', 'status_imb_id',
        'nomor_imb', 'aset_rumah_ditempat_lain_id', 'aset_tanah_ditempat_lain_id',
        'jenis_kawasan_lokasi_rumah_id'
    ];

    public function rumah()
    {
        return $this->belongsTo(Rumah::class, 'rumah_id');
    }

    public function statusKepemilikanTanah()
    {
        return $this->belongsTo(IStatusKepemilikanTanah::class, 'status_kepemilikan_tanah_id','id_status_kepemilikan_tanah');
    }

    public function buktiKepemilikanTanah()
    {
        return $this->belongsTo(IBuktiKepemilikanTanah::class, 'bukti_kepemilikan_tanah_id','id_bukti_kepemilikan_tanah');
    }

    public function statusKepemilikanRumah()
    {
        return $this->belongsTo(IStatusKepemilikanRumah::class, 'status_kepemilikan_rumah_id','id_status_kepemilikan_rumah');
    }

    public function statusImb()
    {
        return $this->belongsTo(IStatusImb::class, 'status_imb_id','id_status_imb');
    }

    public function asetRumahDitempatLain()
    {
        return $this->belongsTo(IAsetRumahTempatLain::class, 'aset_rumah_ditempat_lain_id','id_aset_rumah_tempat_lain');
    }

    public function asetTanahDitempatLain()
    {
        return $this->belongsTo(IAsetTanahTempatLain::class, 'aset_tanah_ditempat_lain_id','id_aset_tanah_tempat_lain');
    }

    public function jenisKawasanLokasiRumah()
    {
        return $this->belongsTo(IJenisKawasanLokasi::class, 'jenis_kawasan_lokasi_rumah_id','id_jenis_kawasan_lokasi');
    }
}
