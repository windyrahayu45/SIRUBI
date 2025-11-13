<?php

namespace App\Exports\Sheets;

use App\Services\Rekap3Builder;
use App\Models\APondasi;
use App\Models\AKondisiPondasi;
use App\Models\AKondisiSloof;
use App\Models\AKondisiKolomTiang;
use App\Models\AKondisiBalok;
use App\Models\AKondisiStrukturAtap;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class Rekap3Sheet implements FromArray, ShouldAutoSize, WithTitle, WithStyles
{
    protected $kecamatanId;

    public function __construct($kecamatanId)
    {
        $this->kecamatanId = $kecamatanId;
    }

    public function title(): string
    {
        return "Rekap 3";
    }

    public function array(): array
    {
        // MASTER DATA
        $pondasi  = APondasi::all();
        $kPondasi = AKondisiPondasi::all();
        $sloof    = AKondisiSloof::all();
        $kolom    = AKondisiKolomTiang::all();
        $balok    = AKondisiBalok::all();
        $atap     = AKondisiStrukturAtap::all();

        $rows = Rekap3Builder::build($this->kecamatanId);

        // ============================
        // HEADER 1
        // ============================
        $header1 = ["DATA REKAPITULASI #3 - ASPEK KESELAMATAN"];

        // ============================
        // HEADER 2 (Group)
        // ============================
        $header2 = ["NO", "KELURAHAN"];

        // Add group headers with empty filler
        $groups = [
            "Pondasi"               => $pondasi->count(),
            "Kondisi Pondasi"       => $kPondasi->count(),
            "Kondisi Sloof"         => $sloof->count(),
            "Kondisi Kolom/Tiang"   => $kolom->count(),
            "Kondisi Balok"         => $balok->count(),
            "Kondisi Struktur Atap" => $atap->count(),
        ];

        foreach ($groups as $label => $count) {
            $header2[] = $label;
            $header2 = array_merge($header2, array_fill(0, $count - 1, ""));
        }

        // ============================
        // HEADER 3 (Subheader)
        // ============================
        $header3 = ["NO", "KELURAHAN"];

        foreach ($pondasi as $x)  $header3[] = $x->pondasi;
        foreach ($kPondasi as $x) $header3[] = $x->kondisi_pondasi;
        foreach ($sloof as $x)    $header3[] = $x->kondisi_sloof;
        foreach ($kolom as $x)    $header3[] = $x->kondisi_kolom_tiang;
        foreach ($balok as $x)    $header3[] = $x->kondisi_balok;
        foreach ($atap as $x)     $header3[] = $x->kondisi_struktur_atap;

        // ============================
        // BODY
        // ============================
        $body = [];
        $no   = 1;
        foreach ($rows as $r) {
            $line = [
                $no++,
                $r->nama_kelurahan,
            ];

            foreach ($pondasi as $p)    $line[] = $r->{'p_'.$p->id_pondasi} ?? 0;
            foreach ($kPondasi as $kp)  $line[] = $r->{'kp_'.$kp->id_kondisi_pondasi} ?? 0;
            foreach ($sloof as $sf)     $line[] = $r->{'ks_'.$sf->id_kondisi_sloof} ?? 0;
            foreach ($kolom as $kl)     $line[] = $r->{'kk_'.$kl->id_kondisi_kolom_tiang} ?? 0;
            foreach ($balok as $bk)     $line[] = $r->{'kb_'.$bk->id_kondisi_balok} ?? 0;
            foreach ($atap as $at)      $line[] = $r->{'ksa_'.$at->id_kondisi_struktur_atap} ?? 0;

            $body[] = $line;
        }

        // ============================
        // FOOTER TOTAL
        // ============================
        $footer = ["TOTAL", ""];
        for ($i = 2; $i < count($header3); $i++) {
            $footer[$i] = 0;
        }

        foreach ($body as $row) {
            for ($i = 2; $i < count($row); $i++) {
                $footer[$i] += $row[$i];
            }
        }

        return [
            $header1,
            $header2,
            $header3,
            ...$body,
            $footer,
        ];
    }

    // ============================================================
    // STYLE (MERGE HEADER LIKE SHEET 2)
    // ============================================================
    public function styles(Worksheet $sheet)
    {
        $lastCol = $sheet->getHighestColumn();
        $lastRow = $sheet->getHighestRow();

        // ========== MERGE JUDUL ==========
        $sheet->mergeCells("A1:{$lastCol}1");

        // Helper for next col
        $nextCol = function($col, $step) {
            return Coordinate::stringFromColumnIndex(
                Coordinate::columnIndexFromString($col) + $step
            );
        };

        // ========== MERGE HEADER 2 (GROUP HEADER) ==========
        // NO & KELURAHAN rowspan
        $sheet->mergeCells("A2:A3");
        $sheet->mergeCells("B2:B3");

        // mulai merge dari kolom C
        $col = "C";

        // Load jumlah kolom tiap group
        $groupCounts = [
            $GLOBALS['pondasiCount']  ?? APondasi::count(),
            $GLOBALS['kPondasiCount'] ?? AKondisiPondasi::count(),
            $GLOBALS['sloofCount']    ?? AKondisiSloof::count(),
            $GLOBALS['kolomCount']    ?? AKondisiKolomTiang::count(),
            $GLOBALS['balokCount']    ?? AKondisiBalok::count(),
            $GLOBALS['atapCount']     ?? AKondisiStrukturAtap::count(),
        ];

        foreach ($groupCounts as $count) {
            $endCol = $nextCol($col, $count - 1);
            $sheet->mergeCells("{$col}2:{$endCol}2");
            $col = $nextCol($col, $count);
        }

        // ========== STYLE HEADER ==========
        $sheet->getStyle("A1:{$lastCol}3")->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
            'borders' => ['allBorders' => ['borderStyle' => 'thin']],
        ]);

        // ========== STYLE BODY ==========
        $sheet->getStyle("A4:{$lastCol}{$lastRow}")
            ->applyFromArray([
                'borders' => ['allBorders' => ['borderStyle' => 'thin']]
            ]);

        // TOTAL Row Style
        $sheet->getStyle("A{$lastRow}:{$lastCol}{$lastRow}")
            ->applyFromArray([
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => 'D9D9D9']
                ]
            ]);

        return [];
    }
}
