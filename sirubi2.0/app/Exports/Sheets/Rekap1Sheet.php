<?php

namespace App\Exports\Sheets;

use App\Services\Rekap1Builder;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Rekap1Sheet implements 
    FromCollection, 
    WithHeadings, 
    WithMapping, 
    WithStyles, 
    WithTitle, 
    ShouldAutoSize
{
    protected $data;
    protected $totals;

    public function __construct(public $kecamatanId)
    {
        $this->data = Rekap1Builder::build($kecamatanId);

        // Hitung total semua kolom
        $this->totals = [
            'jumlah_rumah'    => $this->data->sum('jumlah_rumah'),
            'jumlah_kk'       => $this->data->sum('jumlah_kk'),
            'penduduk'        => $this->data->sum(fn($r) => $r['penghuni_laki'] + $r['penghuni_perempuan']),
            'rlh'             => $this->data->sum('rlh'),
            'rtlh'            => $this->data->sum('rtlh'),
            'kk_lebih_1'      => $this->data->sum('kk_lebih_1'),
            'kk_1'            => $this->data->sum('kk_1'),
            'prioritas_a1'    => $this->data->sum('prioritas_a1'),
            'prioritas_a2'    => $this->data->sum('prioritas_a2'),
            'prioritas_b1'    => $this->data->sum('prioritas_b1'),
            'prioritas_b2'    => $this->data->sum('prioritas_b2'),
            'prioritas_c1'    => $this->data->sum('prioritas_c1'),
            'prioritas_c2'    => $this->data->sum('prioritas_c2'),
        ];
    }

    public function collection()
    {
        // Ubah data ke collection numerik (dipakai map)
        $rows = new Collection($this->data);

        // Tambahkan row total
        $rows->push([
            'nama_kelurahan' => 'TOTAL',
            'jumlah_rumah'    => $this->totals['jumlah_rumah'],
            'jumlah_kk'       => $this->totals['jumlah_kk'],
            'penghuni_laki'   => 0, // tidak dipakai
            'penghuni_perempuan' => 0, // tidak dipakai
            'rlh'             => $this->totals['rlh'],
            'rtlh'            => $this->totals['rtlh'],
            'kk_lebih_1'      => $this->totals['kk_lebih_1'],
            'kk_1'            => $this->totals['kk_1'],
            'prioritas_a1'    => $this->totals['prioritas_a1'],
            'prioritas_a2'    => $this->totals['prioritas_a2'],
            'prioritas_b1'    => $this->totals['prioritas_b1'],
            'prioritas_b2'    => $this->totals['prioritas_b2'],
            'prioritas_c1'    => $this->totals['prioritas_c1'],
            'prioritas_c2'    => $this->totals['prioritas_c2'],
        ]);

        return $rows;
    }

    public function headings(): array
    {
        return [
            ["DATA REKAPITULASI #1 – DATA UMUM RUMAH"],

            // group header
            [
                "NO",
                "KELURAHAN",

                "Jumlah","Jumlah","Jumlah",
                "Kelayakan","Kelayakan",
                "Backlog","Backlog",
                "Aspek Keselamatan","Aspek Keselamatan",
                "Aspek Kesehatan","Aspek Kesehatan",
                "Aspek Komponen","Aspek Komponen"
            ],

            // sub header
            [
                "NO",
                "KELURAHAN",

                "Rumah","KK","Penduduk",
                "RLH","RTLH",
                "Iya","Tidak",
                "Prioritas","Tidak",
                "Prioritas","Tidak",
                "Prioritas","Tidak",
            ]
        ];
    }
    public static $rowNumber = 1;

    public function map($row): array
    {
        $isTotal = $row['nama_kelurahan'] === 'TOTAL';

        // jika row TOTAL → penduduk = TOTAL penduduk
        $penduduk = $isTotal
            ? $this->totals['penduduk']
            : $row['penghuni_laki'] + $row['penghuni_perempuan'];

        return [
            $isTotal ? null : self::$rowNumber++, // numbering biar kosong
            $row['nama_kelurahan'],

            $row['jumlah_rumah'],
            $row['jumlah_kk'],
            $penduduk,

            $row['rlh'],
            $row['rtlh'],

            $row['kk_lebih_1'],
            $row['kk_1'],

            $row['prioritas_a1'],
            $row['prioritas_a2'],

            $row['prioritas_b1'],
            $row['prioritas_b2'],

            $row['prioritas_c1'],
            $row['prioritas_c2'],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        
        $end = 'O';

        // Merge judul
        $sheet->mergeCells("A1:{$end}1");

        // Merge group header
        $sheet->mergeCells("A2:A3");
        $sheet->mergeCells("B2:B3");
        $sheet->mergeCells("C2:E2");
        $sheet->mergeCells("F2:G2");
        $sheet->mergeCells("H2:I2");
        $sheet->mergeCells("J2:K2");
        $sheet->mergeCells("L2:M2");
        $sheet->mergeCells("N2:O2");

        // Bold header
        $sheet->getStyle("A1:{$end}3")->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
            'borders' => ['allBorders' => ['borderStyle' => 'thin']]
        ]);

        // Border body
        $lastRow = $sheet->getHighestRow();
        $sheet->getStyle("A4:{$end}{$lastRow}")
            ->applyFromArray(['borders' => ['allBorders' => ['borderStyle' => 'thin']]]);

        // STYLE ROW TOTAL (BARIS TERAKHIR)
        $sheet->getStyle("A{$lastRow}:{$end}{$lastRow}")->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => ['horizontal' => 'center'],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => 'E0E0E0']
            ]
        ]);

        return [];
    }

    public function title(): string
    {
        return "Rekap 1";
    }
}
