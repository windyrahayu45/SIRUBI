<?php

namespace App\Services;

use App\Models\SanitasiRumah;

// Master tabel sanitasi
use App\Models\BJendelaLubangCahaya;
use App\Models\BKondisiJendelaLubangCahaya;
use App\Models\BVentilasi;
use App\Models\BKondisiVentilasi;
use App\Models\BKamarMandi;
use App\Models\BKondisiKamarMandi;
use App\Models\BJamban;
use App\Models\BKondisiJamban;
use App\Models\BSistemPembuanganAirKotor;
use App\Models\BKondisiSistemPembuanganAirKotor;
use App\Models\BFrekuensiPenyedotan;
use App\Models\BSumberAirMinum;
use App\Models\BKondisiSumberAirMinum;
use App\Models\BSumberListrik;

class Rekap4Builder
{
    public static function build($kecamatanId)
    {
        // Semua ID dari master utk membuat kolom dinamis
        $jendela = BJendelaLubangCahaya::pluck('id_jendela_lubang_cahaya');
        $kondJendela = BKondisiJendelaLubangCahaya::pluck('id_kondisi_jendela_lubang_cahaya');

        $ventilasi = BVentilasi::pluck('id_ventilasi');
        $kondVentilasi = BKondisiVentilasi::pluck('id_kondisi_ventilasi');

        $kamarMandi = BKamarMandi::pluck('id_kamar_mandi');
        $kondKamarMandi = BKondisiKamarMandi::pluck('id_kondisi_kamar_mandi');

        $jamban = BJamban::pluck('id_jamban');
        $kondJamban = BKondisiJamban::pluck('id_kondisi_jamban');

        $spak = BSistemPembuanganAirKotor::pluck('id_sistem_pembuangan_air_kotor');
        $kondSpak = BKondisiSistemPembuanganAirKotor::pluck('id_kondisi_sistem_pembuangan_air_kotor');

        $frek = BFrekuensiPenyedotan::pluck('id_frekuensi_penyedotan');

        $sam = BSumberAirMinum::pluck('id_sumber_air_minum');
        $kondSam = BKondisiSumberAirMinum::pluck('id_kondisi_sumber_air_minum');

        $listrik = BSumberListrik::pluck('id_sumber_listrik');

        // Select awal
        $select = "
            rumah.kelurahan_id,
            kc.nama_kecamatan,
            kl.nama_kelurahan
        ";

        // Dynamic columns
        foreach ($jendela as $id) {
            $select .= ", COUNT(CASE WHEN jendela_lubang_cahaya_id = {$id} THEN 1 END) AS a_{$id}";
        }
        foreach ($kondJendela as $id) {
            $select .= ", COUNT(CASE WHEN kondisi_jendela_lubang_cahaya_id = {$id} THEN 1 END) AS b_{$id}";
        }
        foreach ($ventilasi as $id) {
            $select .= ", COUNT(CASE WHEN ventilasi_id = {$id} THEN 1 END) AS c_{$id}";
        }
        foreach ($kondVentilasi as $id) {
            $select .= ", COUNT(CASE WHEN kondisi_ventilasi_id = {$id} THEN 1 END) AS d_{$id}";
        }
        foreach ($kamarMandi as $id) {
            $select .= ", COUNT(CASE WHEN kamar_mandi_id = {$id} THEN 1 END) AS e_{$id}";
        }
        foreach ($kondKamarMandi as $id) {
            $select .= ", COUNT(CASE WHEN kondisi_kamar_mandi_id = {$id} THEN 1 END) AS f_{$id}";
        }
        foreach ($jamban as $id) {
            $select .= ", COUNT(CASE WHEN jamban_id = {$id} THEN 1 END) AS g_{$id}";
        }
        foreach ($kondJamban as $id) {
            $select .= ", COUNT(CASE WHEN kondisi_jamban_id = {$id} THEN 1 END) AS h_{$id}";
        }
        foreach ($spak as $id) {
            $select .= ", COUNT(CASE WHEN sistem_pembuangan_air_kotor_id = {$id} THEN 1 END) AS i_{$id}";
        }
        foreach ($kondSpak as $id) {
            $select .= ", COUNT(CASE WHEN kondisi_sistem_pembuangan_air_kotor_id = {$id} THEN 1 END) AS j_{$id}";
        }
        foreach ($frek as $id) {
            $select .= ", COUNT(CASE WHEN frekuensi_penyedotan_id = {$id} THEN 1 END) AS ia_{$id}";
        }
        foreach ($sam as $id) {
            $select .= ", COUNT(CASE WHEN sumber_air_minum_id = {$id} THEN 1 END) AS k_{$id}";
        }
        foreach ($kondSam as $id) {
            $select .= ", COUNT(CASE WHEN kondisi_sumber_air_minum_id = {$id} THEN 1 END) AS ka_{$id}";
        }
        foreach ($listrik as $id) {
            $select .= ", COUNT(CASE WHEN sumber_listrik_id = {$id} THEN 1 END) AS l_{$id}";
        }

        return SanitasiRumah::query()
            ->selectRaw($select)
            ->join('rumah', 'sanitasi_rumah.rumah_id', '=', 'rumah.id_rumah')
            ->join('i_kecamatan as kc', 'rumah.kecamatan_id', '=', 'kc.id_kecamatan')
            ->join('i_kelurahan as kl', 'rumah.kelurahan_id', '=', 'kl.id_kelurahan')
            ->where('rumah.kecamatan_id', $kecamatanId)
            ->groupBy('rumah.kelurahan_id', 'kc.nama_kecamatan', 'kl.nama_kelurahan')
            ->get();
    }
}
