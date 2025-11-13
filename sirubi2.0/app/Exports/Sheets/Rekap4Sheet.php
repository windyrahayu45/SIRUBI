<?php

namespace App\Exports\Sheets;

use App\Services\Rekap4Builder;

// master
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

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Rekap4Sheet implements FromArray, ShouldAutoSize, WithTitle, WithStyles
{
    protected $kecamatanId;

    public function __construct($kecamatanId)
    {
        $this->kecamatanId = $kecamatanId;
    }

    public function title(): string
    {
        return 'Rekap 4';
    }

    public function array(): array
    {
        // ========================== MASTER ==========================
        $jendela  = BJendelaLubangCahaya::all();
        $kJendela = BKondisiJendelaLubangCahaya::all();

        $ventilasi = BVentilasi::all();
        $kVentilasi = BKondisiVentilasi::all();

        $km = BKamarMandi::all();
        $kKm = BKondisiKamarMandi::all();

        $jamban = BJamban::all();
        $kJamban = BKondisiJamban::all();

        $spal = BSistemPembuanganAirKotor::all();
        $kSpal = BKondisiSistemPembuanganAirKotor::all();

        $frek = BFrekuensiPenyedotan::all();

        $air = BSumberAirMinum::all();
        $kAir = BKondisiSumberAirMinum::all();

        $listrik = BSumberListrik::all();

        // ========================== DATA ==========================
        $rows = Rekap4Builder::build($this->kecamatanId);

        // ========================== HEADER ==========================
        $header1 = ["DATA REKAPITULASI #4 – ASPEK KESEHATAN"];

        $header2 = ["No", "Kelurahan"];

        // group headers dengan kolspan otomatis
        $makeGroup = function($label, $count) {
            return array_merge([$label], array_fill(0, $count - 1, ""));
        };

        $header2 = array_merge(
            $header2,
            $makeGroup("Jendela", $jendela->count()),
            $makeGroup("Kondisi Jendela", $kJendela->count()),
            $makeGroup("Ventilasi", $ventilasi->count()),
            $makeGroup("Kondisi Ventilasi", $kVentilasi->count()),
            $makeGroup("Kamar Mandi", $km->count()),
            $makeGroup("Kondisi KM", $kKm->count()),
            $makeGroup("Jamban", $jamban->count()),
            $makeGroup("Kondisi Jamban", $kJamban->count()),
            $makeGroup("SPAL", $spal->count()),
            $makeGroup("Kondisi SPAL", $kSpal->count()),
            $makeGroup("Frekuensi Sedot", $frek->count()),
            $makeGroup("Air Minum", $air->count()),
            $makeGroup("Kondisi Air", $kAir->count()),
            $makeGroup("Listrik", $listrik->count())
        );

        // Subheader
        $header3 = ["No", "Kelurahan"];

        foreach ($jendela as $m)  $header3[] = $m->jendela_lubang_cahaya;
        foreach ($kJendela as $m) $header3[] = $m->kondisi_jendela_lubang_cahaya;

        foreach ($ventilasi as $m) $header3[] = $m->ventilasi;
        foreach ($kVentilasi as $m) $header3[] = $m->kondisi_ventilasi;

        foreach ($km as $m)  $header3[] = $m->kamar_mandi;
        foreach ($kKm as $m) $header3[] = $m->kondisi_kamar_mandi;

        foreach ($jamban as $m) $header3[] = $m->jamban;
        foreach ($kJamban as $m) $header3[] = $m->kondisi_jamban;

        foreach ($spal as $m) $header3[] = $m->sistem_pembuangan_air_kotor;
        foreach ($kSpal as $m) $header3[] = $m->kondisi_sistem_pembuangan_air_kotor;

        foreach ($frek as $m) $header3[] = $m->frekuensi_penyedotan;

        foreach ($air as $m) $header3[] = $m->sumber_air_minum;
        foreach ($kAir as $m) $header3[] = $m->kondisi_sumber_air_minum;

        foreach ($listrik as $m) $header3[] = $m->sumber_listrik;

        // ========================== BODY ==========================
        $body = [];
        $no = 1;

        foreach ($rows as $row) {
            $line = [$no++, $row->nama_kelurahan];

            foreach ($jendela as $m)  $line[] = $row->{'a_'.$m->id_jendela_lubang_cahaya} ?? 0;
            foreach ($kJendela as $m) $line[] = $row->{'b_'.$m->id_kondisi_jendela_lubang_cahaya} ?? 0;

            foreach ($ventilasi as $m) $line[] = $row->{'c_'.$m->id_ventilasi} ?? 0;
            foreach ($kVentilasi as $m) $line[] = $row->{'d_'.$m->id_kondisi_ventilasi} ?? 0;

            foreach ($km as $m)  $line[] = $row->{'e_'.$m->id_kamar_mandi} ?? 0;
            foreach ($kKm as $m) $line[] = $row->{'f_'.$m->id_kondisi_kamar_mandi} ?? 0;

            foreach ($jamban as $m) $line[] = $row->{'g_'.$m->id_jamban} ?? 0;
            foreach ($kJamban as $m) $line[] = $row->{'h_'.$m->id_kondisi_jamban} ?? 0;

            foreach ($spal as $m) $line[] = $row->{'i_'.$m->id_sistem_pembuangan_air_kotor} ?? 0;
            foreach ($kSpal as $m) $line[] = $row->{'j_'.$m->id_kondisi_sistem_pembuangan_air_kotor} ?? 0;

            foreach ($frek as $m) $line[] = $row->{'ia_'.$m->id_frekuensi_penyedotan} ?? 0;

            foreach ($air as $m) $line[] = $row->{'k_'.$m->id_sumber_air_minum} ?? 0;
            foreach ($kAir as $m) $line[] = $row->{'ka_'.$m->id_kondisi_sumber_air_minum} ?? 0;

            foreach ($listrik as $m) $line[] = $row->{'l_'.$m->id_sumber_listrik} ?? 0;

            $body[] = $line;
        }

        // ========================== FOOTER TOTAL ==========================
        $footer = ["TOTAL", ""];

        $colCount = count($header3) - 2;
        $sum = array_fill(0, $colCount, 0);

        foreach ($body as $r) {
            for ($c = 2; $c < count($r); $c++) {
                $sum[$c - 2] += (int)$r[$c];
            }
        }

        foreach ($sum as $s) $footer[] = $s;

        return [
            $header1,
            $header2,
            $header3,
            ...$body,
            $footer,
        ];
    }

    // ========================== STYLING (MERGE & TOTAL STYLE) ==========================
    public function styles(Worksheet $sheet)
    {
        $lastCol = $sheet->getHighestColumn();
        $lastRow = $sheet->getHighestRow();

        // Merge Title
        $sheet->mergeCells("A1:{$lastCol}1");

        // Merge NO & Kelurahan (rowspan)
        $sheet->mergeCells("A2:A3");
        $sheet->mergeCells("B2:B3");

        // ========= Dynamic Merge for Group Headers =========
        $col = "C"; // mulai kolom C

        $groupCounts = [
            BJendelaLubangCahaya::count(),
            BKondisiJendelaLubangCahaya::count(),
            BVentilasi::count(),
            BKondisiVentilasi::count(),
            BKamarMandi::count(),
            BKondisiKamarMandi::count(),
            BJamban::count(),
            BKondisiJamban::count(),
            BSistemPembuanganAirKotor::count(),
            BKondisiSistemPembuanganAirKotor::count(),
            BFrekuensiPenyedotan::count(),
            BSumberAirMinum::count(),
            BKondisiSumberAirMinum::count(),
            BSumberListrik::count(),
        ];

        foreach ($groupCounts as $count) {
            if ($count > 0) {
                $start = $col;
                $end = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(
                    \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($col) + $count - 1
                );

                $sheet->mergeCells("{$start}2:{$end}2");

                $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(
                    \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($end) + 1
                );
            }
        }

        // Header style
        $sheet->getStyle("A1:{$lastCol}3")->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
            'borders' => ['allBorders' => ['borderStyle' => 'thin']]
        ]);

        // Body border
        $sheet->getStyle("A4:{$lastCol}{$lastRow}")->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => 'thin']]
        ]);

        // TOTAL row style
        $sheet->getStyle("A{$lastRow}:{$lastCol}{$lastRow}")->applyFromArray([
            'font' => ['bold' => true],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'D9D9D9']]
        ]);

        return [];
    }
}
