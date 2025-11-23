<?php

namespace App\Exports\Prod;

use Illuminate\Support\Facades\DB;
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
    ShouldAutoSize
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

    /**
     * ====================
     * FAST QUERY
     * ====================
     */
    public function query()
    {
        return DB::table('kepala_keluarga')
            ->select('id', 'rumah_id', 'no_kk')
            ->when(!empty($this->rumahIds), fn($q) =>
                $q->whereIn('rumah_id', $this->rumahIds)
            )
            ->orderBy('id');
    }

    /**
     * ====================
     * FAST MAP (NO ELOQUENT)
     * ====================
     */
    public function map($kk): array
    {
        // Ambil anggota pertama KK (kepala keluarga)
        $anggota = DB::table('anggota_keluarga')
            ->where('kepala_keluarga_id', $kk->id)
            ->select('nik', 'nama')
            ->first();

        // Validasi DUMMY
        $noKK = $kk->no_kk ?? '-';
        if (is_string($noKK) && stripos($noKK, 'DUMMY') !== false) {
            $noKK = '-';
        }

        $nik  = $anggota->nik  ?? '-';
        $nama = $anggota->nama ?? '-';

        return [
            $kk->rumah_id ?? '-',
            $noKK,
            $nik,
            $nama,
        ];
    }

    /**
     * ====================
     * HEADINGS
     * ====================
     */
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
        return 800; // aman untuk shared hosting
    }

    /**
     * ====================
     * HEADER + LOGO
     * ====================
     */
    // public function registerEvents(): array
    // {
    //     return [
    //         AfterSheet::class => function (AfterSheet $event) {

    //             $sheet = $event->sheet->getDelegate();
    //             $sheet->insertNewRowBefore(1, 4);

    //             // LOGO
    //             $logo = public_path('assets/media/logos/logo.png');
    //             if (file_exists($logo)) {
    //                 $img = new Drawing();
    //                 $img->setPath($logo);
    //                 $img->setHeight(55);
    //                 $img->setCoordinates('A1');
    //                 $img->setWorksheet($sheet);
    //             }

    //             // JUDUL
    //             $sheet->mergeCells('B1:E1');
    //             $sheet->setCellValue('B1', 'DINAS PERUMAHAN DAN KAWASAN PERMUKIMAN');
    //             $sheet->getStyle('B1')->getFont()->setBold(true)->setSize(18);
    //             $sheet->getStyle('B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    //             // SUB JUDUL
    //             $sheet->mergeCells('B2:E2');
    //             $sheet->setCellValue('B2', 'KOTA BUKITTINGGI');
    //             $sheet->getStyle('B2')->getFont()->setBold(true)->setSize(16);
    //             $sheet->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    //             // HEADING STYLE
    //             $sheet->getStyle('A5:D5')->applyFromArray([
    //                 'font' => ['bold' => true],
    //                 'alignment' => [
    //                     'horizontal' => Alignment::HORIZONTAL_CENTER,
    //                 ],
    //             ]);
    //         }
    //     ];
    // }
}
