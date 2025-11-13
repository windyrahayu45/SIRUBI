<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class Rekap2PdfBuilder
{
    public static function build($kecamatanId)
    {
        $data = Rekap2Builder::getData($kecamatanId);

        // Semua master (sama seperti Excel)
        $masters = [
            'pendidikan'  => DB::table('i_pendidikan_terakhir')->get(),
            'pekerjaan'   => DB::table('i_pekerjaan_utama')->get(),
            'penghasilan' => DB::table('i_besar_penghasilan')->get(),
            'pengeluaran' => DB::table('i_besar_pengeluaran')->get(),
            'statusTanah' => DB::table('i_status_kepemilikan_tanah')->get(),
            'buktiTanah'  => DB::table('i_bukti_kepemilikan_tanah')->get(),
            'statusRumah' => DB::table('i_status_kepemilikan_rumah')->get(),
            'statusImb'   => DB::table('i_status_imb')->get(),
            'asetRumah'   => DB::table('i_aset_rumah_tempat_lain')->get(),
            'asetTanah'   => DB::table('i_aset_tanah_tempat_lain')->get(),
            'bantuan'     => DB::table('i_pernah_mendapatkan_bantuan')->get(),
            'kawasan'     => DB::table('i_jenis_kawasan_lokasi')->get(),
        ];

        // HEADER 2
        $header2 = [
            "NO","KELURAHAN","L","P","ABK","5–11","12–25","26–45","46–65"
        ];

        // Tambahkan group header
        foreach ($masters as $key => $collection) {
            foreach ($collection as $x) {
                $header2[] = strtoupper($key);
            }
        }

        // HEADER 3
        $header3 = [
            "NO","KELURAHAN","L","P","ABK","5–11","12–25","26–45","46–65"
        ];

        foreach ($masters['pendidikan'] as $x)  $header3[] = $x->pendidikan_terakhir;
        foreach ($masters['pekerjaan'] as $x)   $header3[] = $x->pekerjaan_utama;
        foreach ($masters['penghasilan'] as $x) $header3[] = $x->besar_penghasilan;
        foreach ($masters['pengeluaran'] as $x) $header3[] = $x->besar_pengeluaran;
        foreach ($masters['statusTanah'] as $x) $header3[] = $x->status_kepemilikan_tanah;
        foreach ($masters['buktiTanah'] as $x)  $header3[] = $x->bukti_kepemilikan_tanah;
        foreach ($masters['statusRumah'] as $x) $header3[] = $x->status_kepemilikan_rumah;
        foreach ($masters['statusImb'] as $x)   $header3[] = $x->status_imb;
        foreach ($masters['asetRumah'] as $x)   $header3[] = $x->aset_rumah_tempat_lain;
        foreach ($masters['asetTanah'] as $x)   $header3[] = $x->aset_tanah_tempat_lain;
        foreach ($masters['bantuan'] as $x)     $header3[] = $x->pernah_mendapatkan_bantuan;
        foreach ($masters['kawasan'] as $x)     $header3[] = $x->jenis_kawasan_lokasi;

        // SUM
        $rekap2Sum = [];

        foreach ($header3 as $col) {
            if (!in_array($col, ["NO","KELURAHAN"])) {
                $rekap2Sum[] = $data->sum($col) ?? 0;
            }
        }

        return [
            'data'      => $data,
            'masters'   => $masters,
            'header2'   => $header2,
            'header3'   => $header3,
            'rekap2Sum' => $rekap2Sum
        ];
    }
}
