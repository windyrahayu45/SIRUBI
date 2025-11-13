<?php

namespace App\Exports\Sheets;

use App\Services\Rekap6Builder;

// Master table
use App\Models\DMaterialAtapTerluas;
use App\Models\DKondisiPenutupAtap;
use App\Models\DMaterialDindingTerluas;
use App\Models\DKondisiDinding;
use App\Models\DMaterialLantaiTerluas;
use App\Models\DKondisiLantai;
use App\Models\DAksesKeJalan;
use App\Models\DBangunanMenghadapJalan;
use App\Models\DBangunanMenghadapSungai;
use App\Models\DBangunanBeradaLimbah;
use App\Models\DBangunanBeradaSungai;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Rekap6Sheet implements FromArray, ShouldAutoSize, WithTitle, WithStyles
{
    protected $kecamatanId;

    public function __construct($kecamatanId)
    {
        $this->kecamatanId = $kecamatanId;
    }

    public function title(): string
    {
        return "Rekap 6";
    }

    public function array(): array
    {
        // ============================== MASTER ==============================
        $mAtap           = DMaterialAtapTerluas::all();
        $mPenutup        = DKondisiPenutupAtap::all();
        $mDinding        = DMaterialDindingTerluas::all();
        $mKondDinding    = DKondisiDinding::all();
        $mLantai         = DMaterialLantaiTerluas::all();
        $mKondLantai     = DKondisiLantai::all();
        $mAkses          = DAksesKeJalan::all();
        $mMenghadapJalan = DBangunanMenghadapJalan::all();
        $mMenghadapSungai= DBangunanMenghadapSungai::all();
        $mLimbah         = DBangunanBeradaLimbah::all();
        $mSungai         = DBangunanBeradaSungai::all();

        // ============================== DATA ==============================
        $rows = Rekap6Builder::build($this->kecamatanId);

        // ============================== HEADER 1 ==============================
        $header1 = ["REKAPITULASI #6 – KOMPONEN MATERIAL & KONDISI BANGUNAN"];

        // ============================== HEADER 2 (GROUP) ==============================
        $header2 = ["No", "Kelurahan"];

        $makeGroup = function($label, $count) {
            return array_merge([$label], array_fill(0, $count - 1, ""));
        };

        $header2 = array_merge(
            $header2,
            $makeGroup("A. Material Atap Terluas", $mAtap->count()),
            $makeGroup("B. Kondisi Penutup Atap", $mPenutup->count()),
            $makeGroup("C. Material Dinding", $mDinding->count()),
            $makeGroup("D. Kondisi Dinding", $mKondDinding->count()),
            $makeGroup("E. Material Lantai", $mLantai->count()),
            $makeGroup("F. Kondisi Lantai", $mKondLantai->count()),
            $makeGroup("G. Akses ke Jalan", $mAkses->count()),
            $makeGroup("H. Menghadap Jalan", $mMenghadapJalan->count()),
            $makeGroup("I. Menghadap Sungai", $mMenghadapSungai->count()),
            $makeGroup("J. Berada Limbah", $mLimbah->count()),
            $makeGroup("K. Berada Sungai", $mSungai->count()),
        );

        // ============================== HEADER 3 (SUB HEADER) ==============================
        $header3 = ["No", "Kelurahan"];

        foreach ($mAtap as $m)           $header3[] = $m->material_atap_terluas;
        foreach ($mPenutup as $m)        $header3[] = $m->kondisi_penutup_atap;
        foreach ($mDinding as $m)        $header3[] = $m->material_dinding_terluas;
        foreach ($mKondDinding as $m)    $header3[] = $m->kondisi_dinding;
        foreach ($mLantai as $m)         $header3[] = $m->material_lantai_terluas;
        foreach ($mKondLantai as $m)     $header3[] = $m->kondisi_lantai;
        foreach ($mAkses as $m)          $header3[] = $m->akses_ke_jalan;
        foreach ($mMenghadapJalan as $m) $header3[] = $m->bangunan_menghadap_jalan;
        foreach ($mMenghadapSungai as $m)$header3[] = $m->bangunan_menghadap_sungai;
        foreach ($mLimbah as $m)         $header3[] = $m->bangunan_berada_limbah;
        foreach ($mSungai as $m)         $header3[] = $m->bangunan_berada_sungai;

        // ============================== BODY ==============================
        $body = [];
        $no = 1;

        foreach ($rows as $r) {
            $line = [$no++, $r->nama_kelurahan];

            foreach ($mAtap as $m)           $line[] = $r->{'a_'.$m->id_material_atap_terluas} ?? 0;
            foreach ($mPenutup as $m)        $line[] = $r->{'b_'.$m->id_kondisi_penutup_atap} ?? 0;
            foreach ($mDinding as $m)        $line[] = $r->{'c_'.$m->id_material_dinding_terluas} ?? 0;
            foreach ($mKondDinding as $m)    $line[] = $r->{'d_'.$m->id_kondisi_dinding} ?? 0;
            foreach ($mLantai as $m)         $line[] = $r->{'e_'.$m->id_material_lantai_terluas} ?? 0;
            foreach ($mKondLantai as $m)     $line[] = $r->{'f_'.$m->id_kondisi_lantai} ?? 0;
            foreach ($mAkses as $m)          $line[] = $r->{'g_'.$m->id_akses_ke_jalan} ?? 0;
            foreach ($mMenghadapJalan as $m) $line[] = $r->{'h_'.$m->id_bangunan_menghadap_jalan} ?? 0;
            foreach ($mMenghadapSungai as $m)$line[] = $r->{'i_'.$m->id_bangunan_menghadap_sungai} ?? 0;
            foreach ($mLimbah as $m)         $line[] = $r->{'j_'.$m->id_bangunan_berada_limbah} ?? 0;
            foreach ($mSungai as $m)         $line[] = $r->{'k_'.$m->id_bangunan_berada_sungai} ?? 0;

            $body[] = $line;
        }

        // ============================== Footer TOTAL ==============================
        $footer = ["TOTAL", ""];
        $sum = array_fill(0, count($header3) - 2, 0);

        foreach ($body as $row) {
            for ($i = 2; $i < count($row); $i++) {
                $sum[$i - 2] += (int)$row[$i];
            }
        }

        foreach ($sum as $v) $footer[] = $v;

        return [
            $header1,
            $header2,
            $header3,
            ...$body,
            $footer
        ];
    }

    // ============================== STYLING ==============================
    public function styles(Worksheet $sheet)
    {
        $lastCol = $sheet->getHighestColumn();
        $lastRow = $sheet->getHighestRow();

        // Merge Title
        $sheet->mergeCells("A1:{$lastCol}1");

        // Rowspan for NO & Kelurahan
        $sheet->mergeCells("A2:A3");
        $sheet->mergeCells("B2:B3");

        $groups = [
            DMaterialAtapTerluas::count(),
            DKondisiPenutupAtap::count(),
            DMaterialDindingTerluas::count(),
            DKondisiDinding::count(),
            DMaterialLantaiTerluas::count(),
            DKondisiLantai::count(),
            DAksesKeJalan::count(),
            DBangunanMenghadapJalan::count(),
            DBangunanMenghadapSungai::count(),
            DBangunanBeradaLimbah::count(),
            DBangunanBeradaSungai::count(),
        ];

        // Merge group headers
        $col = "C";
        foreach ($groups as $count) {
            $start = $col;
            $end = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(
                \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($col) + $count - 1
            );

            $sheet->mergeCells("{$start}2:{$end}2");

            // next group start
            $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(
                \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($end) + 1
            );
        }

        // Style Header
        $sheet->getStyle("A1:{$lastCol}3")->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => 'center',
                'vertical'   => 'center'
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin'
                ]
            ]
        ]);

        // Body border
        $sheet->getStyle("A4:{$lastCol}{$lastRow}")->applyFromArray([
            'borders' => [
                'allBorders' => ['borderStyle' => 'thin']
            ]
        ]);

        // Highlight TOTAL
        $sheet->getStyle("A{$lastRow}:{$lastCol}{$lastRow}")->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => 'D9D9D9']
            ]
        ]);

        return [];
    }
}
