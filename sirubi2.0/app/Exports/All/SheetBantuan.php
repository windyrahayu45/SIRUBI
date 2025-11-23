<?php

namespace App\Exports\All;

use App\Models\Rumah;
use App\Models\TblBantuan;
use App\Models\KepalaKeluarga;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class SheetBantuan implements
    FromQuery,
    WithMapping,
    WithHeadings,
    WithTitle,
    WithChunkReading,
    ShouldAutoSize,
    WithEvents
{
    protected $rumahIds = [];

    public function __construct($query = null)
    {
        if ($query) {
            $this->rumahIds = $query->clone()
                ->select('id_rumah')
                ->pluck('id_rumah')
                ->toArray();
        }
    }

    public function query()
    {
        return Rumah::query()
            ->select(['id_rumah', 'alamat', 'kelurahan_id'])
            ->when(!empty($this->rumahIds), fn($q) =>
                $q->whereIn('id_rumah', $this->rumahIds)
            )
            ->with([
                'kelurahan:id_kelurahan,nama_kelurahan,kecamatan_id',
                'kelurahan.kecamatan:id_kecamatan,nama_kecamatan',
                'bantuan',
            ])
            ->orderBy('id_rumah');
    }

    public function map($rumah): array
    {
        $kkList = KepalaKeluarga::where('rumah_id', $rumah->id_rumah)
            ->pluck('no_kk')
            ->filter()
            ->toArray();

        $noKK = $kkList[0] ?? '-';
        if (stripos($noKK, 'DUMMY') !== false) $noKK = '-';

        $rows = [];

        // 1️⃣ Bantuan utama rumah
        if ($rumah->bantuan) {
            $rows[] = [
                'Bantuan Rumah',
                $rumah->id_rumah,
                $rumah->alamat,
                $rumah->kelurahan->kecamatan->nama_kecamatan ?? '-',
                $rumah->kelurahan->nama_kelurahan ?? '-',
                $rumah->bantuan->no_kk_penerima ?? $noKK,
                $rumah->bantuan->nama_program_bantuan ?? '-',
                $rumah->bantuan->nama_bantuan ?? '-',
                $rumah->bantuan->tahun_bantuan ?? '-',
                $rumah->bantuan->nominal_bantuan ?? '-',
                $rumah->bantuan->pernahMendapatkanBantuan->pernah_mendapatkan_bantuan ?? '-',
            ];
        }

        // 2️⃣ Riwayat bantuan KK
        if (!empty($kkList)) {
            $riwayat = TblBantuan::whereIn('kk', $kkList)
                ->orderBy('tahun', 'desc')
                ->get();

            foreach ($riwayat as $r) {
                $rows[] = [
                    'Riwayat Bantuan KK',
                    $rumah->id_rumah,
                    $rumah->alamat,
                    $rumah->kelurahan->kecamatan->nama_kecamatan ?? '-',
                    $rumah->kelurahan->nama_kelurahan ?? '-',
                    $r->kk ?? $noKK,
                    $r->nama_program ?? '-',
                    $r->nama ?? '-',
                    $r->tahun ?? '-',
                    $r->nominal ?? '-',
                    '-',
                ];
            }
        }

        if (empty($rows)) {
            $rows[] = [
                'Kosong',
                $rumah->id_rumah,
                $rumah->alamat,
                $rumah->kelurahan->kecamatan->nama_kecamatan ?? '-',
                $rumah->kelurahan->nama_kelurahan ?? '-',
                $noKK,
                '-','-','-','-','-'
            ];
        }

        return $rows[0];
    }

    public function headings(): array
    {
        return [
            'Tipe Data',
            'ID Rumah',
            'Alamat',
            'Kecamatan',
            'Kelurahan',
            'No KK Penerima',
            'Nama Program Bantuan',
            'Nama Bantuan',
            'Tahun Bantuan',
            'Nominal Bantuan (Rp)',
            'Pernah Mendapatkan Bantuan',
        ];
    }

    public function title(): string
    {
        return 'Bantuan';
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $s = $event->sheet->getDelegate();

                // INSERT 4 baris kosong di awal
                $s->insertNewRowBefore(1, 4);

                // ==== LOGO ====
                $logoPath = public_path('assets/media/logos/logo.png');
                if (file_exists($logoPath)) {
                    $drawing = new Drawing();
                    $drawing->setPath($logoPath);
                    $drawing->setCoordinates('B1');
                    $drawing->setHeight(60);
                    $drawing->setOffsetX(10)->setOffsetY(5);
                    $drawing->setWorksheet($s);
                }

                // ==== HEADER TEXT ====

                // DINAS PERUMAHAN DAN KAWASAN PERMUKIMAN
                $s->mergeCells('C1:L1');
                $s->setCellValue('C1', 'DINAS PERUMAHAN DAN KAWASAN PERMUKIMAN');
                $s->getStyle('C1')->getFont()->setBold(true)->setSize(20);
                $s->getStyle('C1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // KOTA BUKITTINGGI
                $s->mergeCells('C2:L2');
                $s->setCellValue('C2', 'KOTA BUKITTINGGI');
                $s->getStyle('C2')->getFont()->setBold(true)->setSize(18);
                $s->getStyle('C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // JUDUL SHEET
                $s->mergeCells('A4:K4');
                $s->setCellValue('A4', 'Data Rumah yang Pernah Menerima Bantuan & Riwayat Bantuan KK');
                $s->getStyle('A4:K4')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'color'    => ['rgb' => 'E2EFDA'],
                    ],
                ]);

                // STYLE HEADINGS
                $s->getStyle('A5:K5')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 10],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                        'wrapText'   => true,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color'       => ['rgb' => 'AAAAAA']
                        ]
                    ]
                ]);

                $s->getRowDimension(1)->setRowHeight(42);
                $s->getRowDimension(2)->setRowHeight(32);
                $s->getRowDimension(4)->setRowHeight(26);
                $s->getRowDimension(5)->setRowHeight(22);
            }
        ];
    }
}
