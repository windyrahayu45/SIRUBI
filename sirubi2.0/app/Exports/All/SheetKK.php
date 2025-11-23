<?php

namespace App\Exports\All;

use App\Models\KepalaKeluarga;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class SheetKK implements
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
        return KepalaKeluarga::query()
            ->select(['id', 'rumah_id', 'no_kk'])
            ->when(!empty($this->rumahIds), function ($q) {
                $q->whereIn('rumah_id', $this->rumahIds);
            })
            ->with([
                'anggota:id,kepala_keluarga_id,nik,nama',
                'rumah:id_rumah'
            ])
            ->orderBy('id', 'asc');
    }

    public function map($kk): array
    {
        $first = $kk->anggota->first();  // hanya ambil 1 anggota (KK kepala rumah)

         $noKK = $kk->no_kk ?? '-';
        if (is_string($noKK) && stripos($noKK, 'DUMMY') !== false) {
            $noKK = '-';
        }

        return [
            $kk->rumah->id_rumah ?? $kk->rumah_id ?? '-',
            $noKK,
            $first->nik ?? '-',
            $first->nama ?? '-',
        ];
    }

    public function headings(): array
    {
        return [
            'ID Rumah',
            'No KK',
            'NIK Kepala Keluarga',
            'Nama Kepala Keluarga',
        ];
    }

    public function title(): string
    {
        return 'Kepala Keluarga';
    }

    public function chunkSize(): int
    {
        return 1000; // aman untuk shared hosting
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                // Tambahkan baris kosong untuk header logo
                $sheet->insertNewRowBefore(1, 4);

                // Logo
                $logoPath = public_path('assets/media/logos/logo.png');
                if (file_exists($logoPath)) {
                    $drawing = new Drawing();
                    $drawing->setPath($logoPath);
                    $drawing->setCoordinates('A1');
                    $drawing->setHeight(55);
                    $drawing->setWorksheet($sheet);
                }

                // Judul
                $sheet->mergeCells('B1:E1');
                $sheet->setCellValue('B1', 'DINAS PERUMAHAN DAN KAWASAN PERMUKIMAN');
                $sheet->getStyle('B1')->getFont()->setBold(true)->setSize(18);
                $sheet->getStyle('B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $sheet->mergeCells('B2:E2');
                $sheet->setCellValue('B2', 'KOTA BUKITTINGGI');
                $sheet->getStyle('B2')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Heading style
                $sheet->getStyle('A5:D5')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                    ],
                ]);
            }
        ];
    }
}
