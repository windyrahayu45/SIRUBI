<?php

namespace App\Services;

use App\Services\Rekap3Builder;
use App\Models\APondasi;
use App\Models\AKondisiPondasi;
use App\Models\AKondisiSloof;
use App\Models\AKondisiKolomTiang;
use App\Models\AKondisiBalok;
use App\Models\AKondisiStrukturAtap;

class Rekap3PdfBuilder
{
    public static function build($kecamatanId)
    {
        // Ambil master reference
        $masters = [
            'pondasi'        => APondasi::all(),
            'kondisiPondasi' => AKondisiPondasi::all(),
            'sloof'          => AKondisiSloof::all(),
            'kolom'          => AKondisiKolomTiang::all(),
            'balok'          => AKondisiBalok::all(),
            'atap'           => AKondisiStrukturAtap::all(),
        ];

        // Ambil data utama
        $data = Rekap3Builder::build($kecamatanId);

        // ============================
        // HEADER 2 (Group Header)
        // ============================
        $header2 = [
            "NO", "KELURAHAN"
        ];

        $header2 = array_merge(
            $header2,
            array_fill(0, count($masters['pondasi']), "PONDASI"),
            array_fill(0, count($masters['kondisiPondasi']), "KONDISI PONDASI"),
            array_fill(0, count($masters['sloof']), "SLOOF"),
            array_fill(0, count($masters['kolom']), "KOLOM/TIANG"),
            array_fill(0, count($masters['balok']), "BALOK"),
            array_fill(0, count($masters['atap']), "STRUKTUR ATAP")
        );

        // ============================
        // HEADER 3 (Sub-header)
        // ============================
        $header3 = [
            "NO", "KELURAHAN"
        ];

        foreach ($masters['pondasi'] as $m)
            $header3[] = $m->pondasi;

        foreach ($masters['kondisiPondasi'] as $m)
            $header3[] = $m->kondisi_pondasi;

        foreach ($masters['sloof'] as $m)
            $header3[] = $m->kondisi_sloof;

        foreach ($masters['kolom'] as $m)
            $header3[] = $m->kondisi_kolom_tiang;

        foreach ($masters['balok'] as $m)
            $header3[] = $m->kondisi_balok;

        foreach ($masters['atap'] as $m)
            $header3[] = $m->kondisi_struktur_atap;

        // ============================
        // TOTAL
        // ============================
        $rekap3Sum = [];

        foreach ($header3 as $col) {

            if (in_array($col, ["NO", "KELURAHAN"])) {
                continue;
            }

            // Cari key dinamis sesuai prefix
            $dynamicCol = null;

            foreach ($masters as $key => $collection) {
                foreach ($collection as $item) {

                    // Tentukan prefix berdasarkan master
                    $prefix = match ($key) {
                        'pondasi'        => "p_{$item->id_pondasi}",
                        'kondisiPondasi' => "kp_{$item->id_kondisi_pondasi}",
                        'sloof'          => "ks_{$item->id_kondisi_sloof}",
                        'kolom'          => "kk_{$item->id_kondisi_kolom_tiang}",
                        'balok'          => "kb_{$item->id_kondisi_balok}",
                        'atap'           => "ksa_{$item->id_kondisi_struktur_atap}",
                    };

                    if ($col === $item[array_keys($item->getAttributes())[1]]) {
                        $dynamicCol = $prefix;
                        break 2;
                    }
                }
            }

            if ($dynamicCol) {
                $rekap3Sum[] = $data->sum($dynamicCol);
            } else {
                $rekap3Sum[] = 0;
            }
        }

        return [
            'data'      => $data,
            'masters'   => $masters,
            'header2'   => $header2,
            'header3'   => $header3,
            'rekap3Sum' => $rekap3Sum,
        ];
    }
}
