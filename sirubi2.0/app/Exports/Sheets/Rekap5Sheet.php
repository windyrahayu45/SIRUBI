<?php

namespace App\Exports\Sheets;

use App\Services\Rekap5Builder;

use App\Models\CRuangKeluargaDanTidur;
use App\Models\CJenisFisikBangunan;
use App\Models\CFungsiRumah;
use App\Models\CTipeRumah;
use App\Models\CStatusDtks;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Rekap5Sheet implements FromArray, ShouldAutoSize, WithTitle, WithStyles
{
    protected $kecamatanId;

    public function __construct($kecamatanId)
    {
        $this->kecamatanId = $kecamatanId;
    }

    public function title(): string
    {
        return "Rekap 5";
    }

    public function array(): array
    {
        // ===================== MASTER =====================
        $ruangTidur  = CRuangKeluargaDanTidur::all();
        $jenisFisik  = CJenisFisikBangunan::all();
        $fungsiRumah = CFungsiRumah::all();
        $tipeRumah   = CTipeRumah::all();
        $statusDtks  = CStatusDtks::all();

        // ===================== DATA =====================
        $rows = Rekap5Builder::build($this->kecamatanId);

        // ===================== HEADER 1 =====================
        $header1 = ["REKAPITULASI #5 – FISIK BANGUNAN & KEBUTUHAN RUANG"];

        // ===================== HEADER 2 (GROUP HEADER) =====================
        $header2 = ["No", "Kelurahan"];

        $makeGroup = function($label, $count) {
            return array_merge([$label], array_fill(0, $count - 1, ""));
        };

        $header2 = array_merge(
            $header2,
            $makeGroup("Ruang Keluarga & Tidur", $ruangTidur->count()),
            $makeGroup("Jenis Fisik Bangunan", $jenisFisik->count()),
            $makeGroup("Jumlah Lantai", 3), // fixed 3 kolom
            $makeGroup("Fungsi Rumah", $fungsiRumah->count()),
            $makeGroup("Tipe Rumah", $tipeRumah->count()),
            $makeGroup("Status DTKS", $statusDtks->count()),
        );

        // ===================== HEADER 3 (SUB HEADER) =====================
        $header3 = ["No", "Kelurahan"];

        foreach ($ruangTidur as $m)  $header3[] = $m->ruang_keluarga_dan_tidur;
        foreach ($jenisFisik as $m)  $header3[] = $m->jenis_fisik_bangunan;

        $header3[] = "1 Lantai";
        $header3[] = "2 Lantai";
        $header3[] = "≥3 Lantai";

        foreach ($fungsiRumah as $m) $header3[] = $m->fungsi_rumah;
        foreach ($tipeRumah as $m)   $header3[] = $m->tipe_rumah;
        foreach ($statusDtks as $m)  $header3[] = $m->status_dtks;

        // ===================== BODY =====================
        $body = [];
        $no = 1;

        foreach ($rows as $row) {
            $line = [$no++, $row->nama_kelurahan];

            foreach ($ruangTidur as $m)  $line[] = $row->{'a_'.$m->id_ruang_keluarga_dan_tidur} ?? 0;
            foreach ($jenisFisik as $m)  $line[] = $row->{'b_'.$m->id_jenis_fisik_bangunan} ?? 0;

            $line[] = $row->c_1 ?? 0;
            $line[] = $row->c_2 ?? 0;
            $line[] = $row->c_3 ?? 0;

            foreach ($fungsiRumah as $m) $line[] = $row->{'d_'.$m->id_fungsi_rumah} ?? 0;
            foreach ($tipeRumah as $m)   $line[] = $row->{'e_'.$m->id_tipe_rumah} ?? 0;
            foreach ($statusDtks as $m)  $line[] = $row->{'f_'.$m->id_status_dtks} ?? 0;

            $body[] = $line;
        }

        // ===================== FOOTER TOTAL =====================
        $footer = ["TOTAL", ""];
        $totalColumns = count($header3) - 2;
        $sum = array_fill(0, $totalColumns, 0);

        foreach ($body as $row) {
            for ($i = 2; $i < count($row); $i++) {
                $sum[$i - 2] += (int) $row[$i];
            }
        }

        foreach ($sum as $v) {
            $footer[] = $v;
        }

        return [
            $header1,
            $header2,
            $header3,
            ...$body,
            $footer
        ];
    }

    // ===================== STYLING (MERGE + BORDER + TOTAL) =====================
    public function styles(Worksheet $sheet)
    {
        $lastCol = $sheet->getHighestColumn();
        $lastRow = $sheet->getHighestRow();

        // Merge title
        $sheet->mergeCells("A1:{$lastCol}1");

        // Rowspan No & Kelurahan
        $sheet->mergeCells("A2:A3");
        $sheet->mergeCells("B2:B3");

        // Dynamic merge group header
        $col = "C"; 

        $groupCounts = [
            CRuangKeluargaDanTidur::count(),
            CJenisFisikBangunan::count(),
            3, // jumlah lantai
            CFungsiRumah::count(),
            CTipeRumah::count(),
            CStatusDtks::count(),
        ];

        foreach ($groupCounts as $count) {
            $start = $col;
            $end = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(
                \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($col) + $count - 1
            );

            $sheet->mergeCells("{$start}2:{$end}2");

            $col = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(
                \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($end) + 1
            );
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

        // TOTAL style
        $sheet->getStyle("A{$lastRow}:{$lastCol}{$lastRow}")->applyFromArray([
            'font' => ['bold' => true],
            'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'D9D9D9']]
        ]);

        return [];
    }
}
