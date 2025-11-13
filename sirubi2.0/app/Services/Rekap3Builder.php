<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Models\FisikRumah;
use App\Models\APondasi;
use App\Models\AKondisiPondasi;
use App\Models\AKondisiSloof;
use App\Models\AKondisiKolomTiang;
use App\Models\AKondisiBalok;
use App\Models\AKondisiStrukturAtap;

class Rekap3Builder
{
    public static function build($kecamatanId)
    {
        // Ambil opsi dari tabel master
        $pondasi        = APondasi::pluck('id_pondasi');
        $kondPondasi    = AKondisiPondasi::pluck('id_kondisi_pondasi');
        $sloof          = AKondisiSloof::pluck('id_kondisi_sloof');
        $kolom          = AKondisiKolomTiang::pluck('id_kondisi_kolom_tiang');
        $balok          = AKondisiBalok::pluck('id_kondisi_balok');
        $atap           = AKondisiStrukturAtap::pluck('id_kondisi_struktur_atap');

        // --- Build SELECT dinamis ---
        $select = "
            rumah.kelurahan_id,
            kc.nama_kecamatan,
            kl.nama_kelurahan
        ";

        // PONDASI (dynamic)
        foreach ($pondasi as $id) {
            $select .= ",
                COUNT(CASE WHEN pondasi_id = {$id} THEN 1 END) AS p_{$id}";
        }

        // KONDISI PONDASI (dynamic)
        foreach ($kondPondasi as $id) {
            $select .= ",
                COUNT(CASE WHEN kondisi_pondasi_id = {$id} THEN 1 END) AS kp_{$id}";
        }

        // SLOOF (dynamic)
        foreach ($sloof as $id) {
            $select .= ",
                COUNT(CASE WHEN kondisi_sloof_id = {$id} THEN 1 END) AS ks_{$id}";
        }

        // KOLOM (dynamic)
        foreach ($kolom as $id) {
            $select .= ",
                COUNT(CASE WHEN kondisi_kolom_tiang_id = {$id} THEN 1 END) AS kk_{$id}";
        }

        // BALOK (dynamic)
        foreach ($balok as $id) {
            $select .= ",
                COUNT(CASE WHEN kondisi_balok_id = {$id} THEN 1 END) AS kb_{$id}";
        }

        // ATAP (dynamic)
        foreach ($atap as $id) {
            $select .= ",
                COUNT(CASE WHEN kondisi_struktur_atap_id = {$id} THEN 1 END) AS ksa_{$id}";
        }

        // Eksekusi query
        return FisikRumah::query()
            ->selectRaw($select)
            ->join('rumah', 'fisik_rumah.rumah_id', '=', 'rumah.id_rumah')
            ->join('i_kecamatan as kc', 'rumah.kecamatan_id', '=', 'kc.id_kecamatan')
            ->join('i_kelurahan as kl', 'rumah.kelurahan_id', '=', 'kl.id_kelurahan')
            ->where('rumah.kecamatan_id', $kecamatanId)
            ->groupBy('rumah.kelurahan_id', 'kc.nama_kecamatan', 'kl.nama_kelurahan')
            ->get();
    }
}
