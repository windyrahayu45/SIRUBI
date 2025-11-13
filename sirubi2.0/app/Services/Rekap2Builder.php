<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

// import semua model referensi
use App\Models\IPendidikanTerakhir;
use App\Models\IPekerjaanUtama;
use App\Models\IBesarPenghasilanPerbulan;
use App\Models\IBesarPengeluaranPerbulan;
use App\Models\IStatusKepemilikanTanah;
use App\Models\IBuktiKepemilikanTanah;
use App\Models\IStatusKepemilikanRumah;
use App\Models\IStatusImb;
use App\Models\IAsetRumahTempatLain;
use App\Models\IAsetTanahTempatLain;
use App\Models\IBesarPengeluaran;
use App\Models\IBesarPenghasilan;
use App\Models\IPernahMendapatkanBantuan;
use App\Models\IJenisKawasanLokasi;

class Rekap2Builder
{
    public static function getData($kecamatanId)
    {
        // 🔹 Ambil daftar referensi
        $pendidikan = IPendidikanTerakhir::all();
        $pekerjaan  = IPekerjaanUtama::all();
        $penghasilan = IBesarPenghasilan::all();
        $pengeluaran = IBesarPengeluaran::all();
        $statusTanah = IStatusKepemilikanTanah::all();
        $buktiTanah  = IBuktiKepemilikanTanah::all();
        $statusRumah = IStatusKepemilikanRumah::all();
        $statusImb   = IStatusImb::all();
        $asetRumah   = IAsetRumahTempatLain::all();
        $asetTanah   = IAsetTanahTempatLain::all();
        $bantuan     = IPernahMendapatkanBantuan::all();
        $kawasan     = IJenisKawasanLokasi::all();

        // 🔹 Siapkan array untuk selectRaw dinamis
        $select = [];

        foreach ($pendidikan as $item) {
            $select[] = "COUNT(CASE WHEN se.pendidikan_terakhir_id = {$item->id_pendidikan_terakhir} THEN 1 END) AS pt_{$item->id_pendidikan_terakhir}";
        }

        foreach ($pekerjaan as $item) {
            $select[] = "COUNT(CASE WHEN se.pekerjaan_utama_id = {$item->id_pekerjaan_utama} THEN 1 END) AS pu_{$item->id_pekerjaan_utama}";
        }

        foreach ($penghasilan as $item) {
            $select[] = "COUNT(CASE WHEN se.besar_penghasilan_perbulan_id = {$item->id_besar_penghasilan} THEN 1 END) AS penghasilan_{$item->id_besar_penghasilan}";
        }

        foreach ($pengeluaran as $item) {
            $select[] = "COUNT(CASE WHEN se.besar_pengeluaran_perbulan_id = {$item->id_besar_pengeluaran} THEN 1 END) AS pengeluaran_{$item->id_besar_pengeluaran}";
        }

        foreach ($statusTanah as $item) {
            $select[] = "COUNT(CASE WHEN kr.status_kepemilikan_tanah_id = {$item->id_status_kepemilikan_tanah} THEN 1 END) AS status_tanah_{$item->id_status_kepemilikan_tanah}";
        }

        foreach ($buktiTanah as $item) {
            $select[] = "COUNT(CASE WHEN kr.bukti_kepemilikan_tanah_id = {$item->id_bukti_kepemilikan_tanah} THEN 1 END) AS bukti_tanah_{$item->id_bukti_kepemilikan_tanah}";
        }

        foreach ($statusRumah as $item) {
            $select[] = "COUNT(CASE WHEN kr.status_kepemilikan_rumah_id = {$item->id_status_kepemilikan_rumah} THEN 1 END) AS status_rumah_{$item->id_status_kepemilikan_rumah}";
        }

        foreach ($statusImb as $item) {
            $select[] = "COUNT(CASE WHEN kr.status_imb_id = {$item->id_status_imb} THEN 1 END) AS imb_{$item->id_status_imb}";
        }

        foreach ($asetRumah as $item) {
            $select[] = "COUNT(CASE WHEN kr.aset_rumah_ditempat_lain_id = {$item->id_aset_rumah_tempat_lain} THEN 1 END) AS aset_rumah_{$item->id_aset_rumah_tempat_lain}";
        }

        foreach ($asetTanah as $item) {
            $select[] = "COUNT(CASE WHEN kr.aset_tanah_ditempat_lain_id = {$item->id_aset_tanah_tempat_lain} THEN 1 END) AS aset_tanah_{$item->id_aset_tanah_tempat_lain}";
        }

        foreach ($bantuan as $item) {
            $select[] = "COUNT(CASE WHEN br.pernah_mendapatkan_bantuan_id = {$item->id_pernah_mendapatkan_bantuan} THEN 1 END) AS bantuan_{$item->id_pernah_mendapatkan_bantuan}";
        }

        foreach ($kawasan as $item) {
            $select[] = "COUNT(CASE WHEN kr.jenis_kawasan_lokasi_rumah_id = {$item->id_jenis_kawasan_lokasi} THEN 1 END) AS kawasan_{$item->id_jenis_kawasan_lokasi}";
        }

        $selectRaw = implode(",\n", $select);

        // 🔹 Query utama
        return DB::table('rumah as r')
            ->join('i_kecamatan as kc', 'r.kecamatan_id', '=', 'kc.id_kecamatan')
            ->join('i_kelurahan as kl', 'r.kelurahan_id', '=', 'kl.id_kelurahan')
            ->leftJoin('sosial_ekonomi_rumah as se', 'r.id_rumah', '=', 'se.rumah_id')
            ->leftJoin('fisik_rumah as fs', 'r.id_rumah', '=', 'fs.rumah_id')
            ->leftJoin('kepemilikan_rumah as kr', 'r.id_rumah', '=', 'kr.rumah_id')
            ->leftJoin('bantuan_rumah as br', 'r.id_rumah', '=', 'br.rumah_id')
            ->selectRaw("
                r.kelurahan_id,
                kc.nama_kecamatan,
                kl.nama_kelurahan,
                SUM(fs.jumlah_penghuni_laki) as jumlah_laki,
                SUM(fs.jumlah_penghuni_perempuan) as jumlah_perempuan,
                SUM(fs.jumlah_abk) as jumlah_abk,
                COUNT(CASE WHEN se.usia BETWEEN 5 AND 11 THEN 1 END) as usia_1,
                COUNT(CASE WHEN se.usia BETWEEN 12 AND 25 THEN 1 END) as usia_2,
                COUNT(CASE WHEN se.usia BETWEEN 26 AND 45 THEN 1 END) as usia_3,
                COUNT(CASE WHEN se.usia BETWEEN 46 AND 65 THEN 1 END) as usia_4,
                $selectRaw
            ")
            ->where('r.kecamatan_id', $kecamatanId)
            ->groupBy('r.kelurahan_id', 'kc.nama_kecamatan', 'kl.nama_kelurahan')
            ->get();
    }
}
