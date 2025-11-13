<?php

namespace App\Services;

use App\Models\FisikRumah;
use App\Models\CRuangKeluargaDanTidur;
use App\Models\CJenisFisikBangunan;
use App\Models\CFungsiRumah;
use App\Models\CStatusDtks;
use App\Models\CTipeRumah;
use Illuminate\Support\Facades\DB;

class Rekap5Builder
{
    public static function build($kecamatanId)
    {
        // Ambil opsi master dari DB
        $ruangTidur  = CRuangKeluargaDanTidur::pluck('id_ruang_keluarga_dan_tidur');
        $fisik       = CJenisFisikBangunan::pluck('id_jenis_fisik_bangunan');
        $fungsi      = CFungsiRumah::pluck('id_fungsi_rumah');
        $tipe        = CTipeRumah::pluck('id_tipe_rumah');

        // Status DTKS (biasanya 1 = DTKS, 2 = NON-DTKS)
        $statusDtks = CStatusDtks::pluck('id_status_dtks');

        // Build select dasar
        $select = "
            rumah.kelurahan_id,
            kc.nama_kecamatan,
            kl.nama_kelurahan
        ";

        // RUANG TIDUR (A_x)
        foreach ($ruangTidur as $id) {
            $select .= ",
                COUNT(CASE WHEN ruang_keluarga_dan_ruang_tidur_id = {$id} THEN 1 END) AS a_{$id}";
        }

        // JENIS FISIK BANGUNAN (B_x)
        foreach ($fisik as $id) {
            $select .= ",
                COUNT(CASE WHEN jenis_fisik_bangunan_id = {$id} THEN 1 END) AS b_{$id}";
        }

        // JUMLAH LANTAI (C_1, C_2, C_3+)
        $select .= ",
            COUNT(CASE WHEN jumlah_lantai_bangunan = 1 THEN 1 END) AS c_1,
            COUNT(CASE WHEN jumlah_lantai_bangunan = 2 THEN 1 END) AS c_2,
            COUNT(CASE WHEN jumlah_lantai_bangunan >= 3 THEN 1 END) AS c_3
        ";

        // FUNGSI RUMAH (D_x)
        foreach ($fungsi as $id) {
            $select .= ",
                COUNT(CASE WHEN fungsi_rumah_id = {$id} THEN 1 END) AS d_{$id}";
        }

        // TIPE RUMAH (E_x)
        foreach ($tipe as $id) {
            $select .= ",
                COUNT(CASE WHEN tipe_rumah_id = {$id} THEN 1 END) AS e_{$id}";
        }

        // STATUS DTKS (F_x)
        foreach ($statusDtks as $id) {
            $select .= ",
                COUNT(CASE WHEN se.status_dtks_id = {$id} THEN 1 END) AS f_{$id}";
        }

        return FisikRumah::query()
            ->selectRaw($select)
            ->join('rumah', 'fisik_rumah.rumah_id', '=', 'rumah.id_rumah')
            ->join('sosial_ekonomi_rumah as se', 'fisik_rumah.rumah_id', '=', 'se.rumah_id')

            ->join('i_kecamatan as kc', 'rumah.kecamatan_id', '=', 'kc.id_kecamatan')
            ->join('i_kelurahan as kl', 'rumah.kelurahan_id', '=', 'kl.id_kelurahan')
            ->where('rumah.kecamatan_id', $kecamatanId)
            ->groupBy('rumah.kelurahan_id', 'kc.nama_kecamatan', 'kl.nama_kelurahan')
            ->get();
    }
}
