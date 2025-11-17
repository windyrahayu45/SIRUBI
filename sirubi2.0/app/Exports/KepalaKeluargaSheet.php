<?php

namespace App\Exports;

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

class KepalaKeluargaSheet implements
    FromQuery,
    WithMapping,
    WithHeadings,
    WithTitle,
    WithChunkReading,
    ShouldAutoSize,
    WithEvents
{
    protected $filteredIds = [];
    protected $query;
    protected static $rowNumber = 1;

    public function __construct($query = null)
    {
        $this->query = $query;

        // Jika ada query rumah → ambil ID pada tahap awal (AMAN)
        if ($query) {
            $this->filteredIds = $query->pluck('id_rumah')->toArray();
        }
    }

    public function query()
    {
        // Jika sheet ini mengikuti filter RumahSheet
        if (!empty($this->filteredIds)) {
            return KepalaKeluarga::with(['anggota', 'rumah'])
                ->whereIn('rumah_id', $this->filteredIds)
                ->orderBy('id', 'asc');
        }

        // Default: semua KK
        return KepalaKeluarga::with(['anggota', 'rumah'])
            ->orderBy('id', 'asc');
    }

    public function map($kk): array
    {
        $first = $kk->anggota->first();

        $idRumah = $kk->rumah->id_rumah ?? $kk->rumah_id ?? '-';

        $noKK = $kk->no_kk ?? '-';
        if (is_string($noKK) && stripos($noKK, 'DUMMY') !== false) {
            $noKK = '-';
        }

        return [
            self::$rowNumber++,
            $idRumah,
            $noKK,
            $first->nik ?? '-',
            $first->nama ?? '-',
        ];
    }

    public function headings(): array
    {
        return ['No', 'ID Rumah', 'No KK', 'NIK', 'Nama Lengkap'];
    }

    public function title(): string
    {
        return 'Data KK & Anggota';
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

                // === Header Logo + Judul ===
                $s->insertNewRowBefore(1, 4);

                $logoPath = public_path('assets/media/logos/logo.png');
                if (file_exists($logoPath)) {
                    $drawing = new Drawing();
                    $drawing->setPath($logoPath);
                    $drawing->setCoordinates('B1');
                    $drawing->setHeight(60);
                    $drawing->setOffsetX(20)->setOffsetY(5);
                    $drawing->setWorksheet($s);
                }

                $s->mergeCells('C1:F1');
                $s->setCellValue('C1', 'DINAS PERUMAHAN DAN KAWASAN PERMUKIMAN');
                $s->getStyle('C1')->getFont()->setBold(true)->setSize(20);
                $s->getStyle('C1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $s->mergeCells('C2:F2');
                $s->setCellValue('C2', 'KOTA BUKITTINGGI');
                $s->getStyle('C2')->getFont()->setBold(true)->setSize(18);
                $s->getStyle('C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // === Header kategori ===
                $s->setCellValue('A4', 'Data Kepala Keluarga & Anggota Rumah Tangga');
                $s->mergeCells('A4:E4');
                $s->getStyle('A4:E4')->applyFromArray([
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

                // === Heading tabel ===
                $s->getStyle('A5:E5')->applyFromArray([
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

                // === Auto merge berdasarkan No KK ===
                $data = $s->toArray(null, true, true, true);
                $startRow = 6;
                $lastKK = null;
                $mergeStart = $startRow;

                foreach ($data as $i => $row) {
                    $rowNum = $startRow + $i - 1;
                    $kk = $row['C'] ?? null; // kolom C = No KK

                    if ($kk !== $lastKK && $lastKK !== null) {
                        if ($rowNum - $mergeStart > 1) {
                            foreach (['A', 'B', 'C'] as $col) {
                                $s->mergeCells("$col$mergeStart:$col" . ($rowNum - 1));
                                $s->getStyle("$col$mergeStart")
                                    ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                            }
                        }
                        $mergeStart = $rowNum;
                    }

                    $lastKK = $kk;
                }

                // Merge blok terakhir
                $maxRow = count($data) + $startRow - 1;
                if ($maxRow - $mergeStart >= 1) {
                    foreach (['A', 'B', 'C'] as $col) {
                        $s->mergeCells("$col$mergeStart:$col$maxRow");
                        $s->getStyle("$col$mergeStart")
                            ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
                    }
                }

                // === Lebar kolom ===
                $s->getColumnDimension('A')->setWidth(5);
                $s->getColumnDimension('B')->setWidth(10);
                $s->getColumnDimension('C')->setWidth(22);
                $s->getColumnDimension('D')->setWidth(22);
                $s->getColumnDimension('E')->setWidth(28);

                $s->getStyle('A6:E' . $maxRow)->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER);

                // === Tinggi baris heading ===
                $s->getRowDimension(1)->setRowHeight(40);
                $s->getRowDimension(2)->setRowHeight(30);
                $s->getRowDimension(4)->setRowHeight(25);
                $s->getRowDimension(5)->setRowHeight(22);
            }
        ];
    }
}
