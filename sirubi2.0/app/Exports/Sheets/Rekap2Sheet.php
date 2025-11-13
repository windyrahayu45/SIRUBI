<?php

namespace App\Exports\Sheets;

use App\Services\Rekap2Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Rekap2Sheet implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
    ShouldAutoSize
{
    protected $data;
    protected $masters;
    protected $header2;
    protected $header3;
    protected $totals;

    public function __construct($kecamatanId)
    {
        // Load data builder
        $this->data = Rekap2Builder::getData($kecamatanId);

        // Load master referensi
        $this->masters = [
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

        // ======================
        // HITUNG TOTAL
        // ======================
        $this->totals = [
            'jumlah_laki' => $this->data->sum('jumlah_laki'),
            'jumlah_perempuan' => $this->data->sum('jumlah_perempuan'),
            'jumlah_abk' => $this->data->sum('jumlah_abk'),
            'usia_1' => $this->data->sum('usia_1'),
            'usia_2' => $this->data->sum('usia_2'),
            'usia_3' => $this->data->sum('usia_3'),
            'usia_4' => $this->data->sum('usia_4'),
        ];

        foreach ($this->masters as $key => $collection) {
            foreach ($collection as $item) {

                $col = match($key) {
                    'pendidikan' => "pt_{$item->id_pendidikan_terakhir}",
                    'pekerjaan' => "pu_{$item->id_pekerjaan_utama}",
                    'penghasilan' => "penghasilan_{$item->id_besar_penghasilan}",
                    'pengeluaran' => "pengeluaran_{$item->id_besar_pengeluaran}",
                    'statusTanah' => "status_tanah_{$item->id_status_kepemilikan_tanah}",
                    'buktiTanah' => "bukti_tanah_{$item->id_bukti_kepemilikan_tanah}",
                    'statusRumah' => "status_rumah_{$item->id_status_kepemilikan_rumah}",
                    'statusImb' => "imb_{$item->id_status_imb}",
                    'asetRumah' => "aset_rumah_{$item->id_aset_rumah_tempat_lain}",
                    'asetTanah' => "aset_tanah_{$item->id_aset_tanah_tempat_lain}",
                    'bantuan' => "bantuan_{$item->id_pernah_mendapatkan_bantuan}",
                    'kawasan' => "kawasan_{$item->id_jenis_kawasan_lokasi}",
                };

                $this->totals[$col] = $this->data->sum($col);
            }
        }

        // ======================
        // HEADER 2 (Group Header)
        // ======================
        $this->header2 = [
            "NO", "KELURAHAN",
            "JUMLAH", "JUMLAH", "JUMLAH",
            "USIA", "USIA", "USIA", "USIA",
        ];

        foreach ($this->masters as $group => $collection) {
            foreach ($collection as $x) {
                $this->header2[] = strtoupper($group);
            }
        }

        // ======================
        // HEADER 3 (Sub Header)
        // ======================
        $this->header3 = [
            "NO", "KELURAHAN",
            "L", "P", "ABK",
            "5–11", "12–25", "26–45", "46–65",
        ];

        foreach ($this->masters['pendidikan'] as $x)  $this->header3[] = $x->pendidikan_terakhir;
        foreach ($this->masters['pekerjaan'] as $x)   $this->header3[] = $x->pekerjaan_utama;
        foreach ($this->masters['penghasilan'] as $x) $this->header3[] = $x->besar_penghasilan;
        foreach ($this->masters['pengeluaran'] as $x) $this->header3[] = $x->besar_pengeluaran;
        foreach ($this->masters['statusTanah'] as $x) $this->header3[] = $x->status_kepemilikan_tanah;
        foreach ($this->masters['buktiTanah'] as $x)  $this->header3[] = $x->bukti_kepemilikan_tanah;
        foreach ($this->masters['statusRumah'] as $x) $this->header3[] = $x->status_kepemilikan_rumah;
        foreach ($this->masters['statusImb'] as $x)    $this->header3[] = $x->status_imb;
        foreach ($this->masters['asetRumah'] as $x)    $this->header3[] = $x->aset_rumah_tempat_lain;
        foreach ($this->masters['asetTanah'] as $x)    $this->header3[] = $x->aset_tanah_tempat_lain;
        foreach ($this->masters['bantuan'] as $x)      $this->header3[] = $x->pernah_mendapatkan_bantuan;
        foreach ($this->masters['kawasan'] as $x)      $this->header3[] = $x->jenis_kawasan_lokasi;
    }

    public function collection()
    {
        $rows = new Collection($this->data);

        // Tambahkan baris TOTAL
        $totalRow = [
            'nama_kelurahan' => 'TOTAL',
            'jumlah_laki' => $this->totals['jumlah_laki'],
            'jumlah_perempuan' => $this->totals['jumlah_perempuan'],
            'jumlah_abk' => $this->totals['jumlah_abk'],
            'usia_1' => $this->totals['usia_1'],
            'usia_2' => $this->totals['usia_2'],
            'usia_3' => $this->totals['usia_3'],
            'usia_4' => $this->totals['usia_4'],
        ];

        foreach ($this->totals as $k => $v) {
            if (!isset($totalRow[$k])) {
                $totalRow[$k] = $v;
            }
        }

        $rows->push((object)$totalRow);

        return $rows;
    }

    public function headings(): array
    {
        return [
            ["DATA REKAPITULASI #2 – IDENTITAS PENGHUNI RUMAH"],
            $this->header2,
            $this->header3,
        ];
    }

    protected static $rowNumber = 1;
    public function map($row): array
    {
        $isTotal = $row->nama_kelurahan === "TOTAL";

        $arr = [
           $isTotal ? null : self::$rowNumber++,   
            $row->nama_kelurahan,
            $row->jumlah_laki,
            $row->jumlah_perempuan,
            $row->jumlah_abk,
            $row->usia_1,
            $row->usia_2,
            $row->usia_3,
            $row->usia_4,
        ];

        foreach ($this->masters as $key => $collection) {
            foreach ($collection as $item) {

                $col = match($key) {
                    'pendidikan' => "pt_{$item->id_pendidikan_terakhir}",
                    'pekerjaan' => "pu_{$item->id_pekerjaan_utama}",
                    'penghasilan' => "penghasilan_{$item->id_besar_penghasilan}",
                    'pengeluaran' => "pengeluaran_{$item->id_besar_pengeluaran}",
                    'statusTanah' => "status_tanah_{$item->id_status_kepemilikan_tanah}",
                    'buktiTanah' => "bukti_tanah_{$item->id_bukti_kepemilikan_tanah}",
                    'statusRumah' => "status_rumah_{$item->id_status_kepemilikan_rumah}",
                    'statusImb' => "imb_{$item->id_status_imb}",
                    'asetRumah' => "aset_rumah_{$item->id_aset_rumah_tempat_lain}",
                    'asetTanah' => "aset_tanah_{$item->id_aset_tanah_tempat_lain}",
                    'bantuan' => "bantuan_{$item->id_pernah_mendapatkan_bantuan}",
                    'kawasan' => "kawasan_{$item->id_jenis_kawasan_lokasi}",
                };

                $arr[] = $row->$col ?? 0;
            }
        }

        return $arr;
    }

    public function styles(Worksheet $sheet)
    {
        $lastCol = $sheet->getHighestColumn();
        $lastRow = $sheet->getHighestRow();

        // ===== MERGE JUDUL =====
        $sheet->mergeCells("A1:{$lastCol}1");

        // Helper next column
        $nextCol = function($col, $step) {
            return \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(
                \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($col) + $step
            );
        };

        // ROWSPAN NO & KELURAHAN
        $sheet->mergeCells("A2:A3");
        $sheet->mergeCells("B2:B3");

        // Mulai dari kolom C
        $colPointer = "C";

        // ===== JUMLAH (3 kolom) =====
        $sheet->mergeCells("{$colPointer}2:" . $nextCol($colPointer, 2) . "2");
        $colPointer = $nextCol($colPointer, 3);

        // ===== USIA (4 kolom) =====
        $sheet->mergeCells("{$colPointer}2:" . $nextCol($colPointer, 3) . "2");
        $colPointer = $nextCol($colPointer, 4);

        // ===== MERGE DINAMIS =====
        $groups = [
            'pendidikan' => $this->masters['pendidikan']->count(),
            'pekerjaan' => $this->masters['pekerjaan']->count(),
            'penghasilan' => $this->masters['penghasilan']->count(),
            'pengeluaran' => $this->masters['pengeluaran']->count(),
            'statusTanah' => $this->masters['statusTanah']->count(),
            'buktiTanah' => $this->masters['buktiTanah']->count(),
            'statusRumah' => $this->masters['statusRumah']->count(),
            'statusImb' => $this->masters['statusImb']->count(),
            'asetRumah' => $this->masters['asetRumah']->count(),
            'asetTanah' => $this->masters['asetTanah']->count(),
            'bantuan' => $this->masters['bantuan']->count(),
            'kawasan' => $this->masters['kawasan']->count(),
        ];

        foreach ($groups as $group => $count) {
            if ($count > 0) {
                $endCol = $nextCol($colPointer, $count - 1);
                $sheet->mergeCells("{$colPointer}2:{$endCol}2");
                $colPointer = $nextCol($colPointer, $count);
            }
        }

        // ===== STYLE HEADER =====
        $sheet->getStyle("A1:{$lastCol}3")->applyFromArray([
            'font' => ['bold' => true],
            'alignment' => [
                'horizontal' => 'center',
                'vertical' => 'center'
            ],
            'borders' => [
                'allBorders' => ['borderStyle' => 'thin']
            ]
        ]);

        // ===== STYLE BODY =====
        $sheet->getStyle("A4:{$lastCol}{$lastRow}")->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => 'thin']]
        ]);

        // ===== TOTAL ROW STYLE =====
        $sheet->getStyle("A{$lastRow}:{$lastCol}{$lastRow}")->applyFromArray([
            'font' => ['bold' => true],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => ['rgb' => 'D9D9D9']
            ]
        ]);

        return [];
    }

    public function title(): string
    {
        return "Rekap 2";
    }
}
