<?php

namespace App\Exports\Prod;

use Illuminate\Support\Facades\DB;
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

class SheetKeselamatan implements
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
     * ============================
     * FAST QUERY
     * ============================
     */
    public function query()
    {
        return DB::table('rumah')
            ->select('id_rumah')
            ->when(!empty($this->rumahIds), fn($q) =>
                $q->whereIn('id_rumah', $this->rumahIds)
            )
            ->orderBy('id_rumah');
    }

    /**
     * ============================
     * FAST MAP (NO ELOQUENT)
     * ============================
     */
    public function map($r): array
    {
        $f = DB::table('fisik_rumah')
            ->where('rumah_id', $r->id_rumah)
            ->first() ?? (object)[];

        // Helper referensi
        $ref = fn($table, $idCol, $nameCol, $id) =>
            $id ? DB::table($table)->where($idCol, $id)->value($nameCol) : '-';

        return [
            $r->id_rumah,

            // Pondasi
            $ref('i_pondasi', 'id_pondasi', 'pondasi', $f->pondasi_id ?? null),
            $ref('i_jenis_pondasi', 'id_jenis_pondasi', 'nama_jenis_pondasi', $f->jenis_pondasi ?? null),
            $ref('a_kondisi_pondasi', 'id_kondisi_pondasi', 'kondisi_pondasi', $f->kondisi_pondasi_id ?? null),

            // Struktur
            $ref('a_kondisi_sloof', 'id_kondisi_sloof', 'kondisi_sloof', $f->kondisi_sloof_id ?? null),
            $ref('a_kondisi_kolom_tiang', 'id_kondisi_kolom_tiang', 'kondisi_kolom_tiang', $f->kondisi_kolom_tiang_id ?? null),
            $ref('a_kondisi_balok', 'id_kondisi_balok', 'kondisi_balok', $f->kondisi_balok_id ?? null),
            $ref('a_kondisi_struktur_atap', 'id_kondisi_struktur_atap', 'kondisi_struktur_atap', $f->kondisi_struktur_atap_id ?? null),

            // Penilaian A
            DB::table('penilaian_rumah')->where('rumah_id', $r->id_rumah)->value('nilai_a') ?? '-',
        ];
    }

    /**
     * ============================
     * HEADINGS
     * ============================
     */
    public function headings(): array
    {
        return [
            'ID Rumah',
            'Pondasi',
            'Jenis Pondasi',
            'Kondisi Pondasi',
            'Kondisi Sloof',
            'Kondisi Kolom/Tiang',
            'Kondisi Balok',
            'Kondisi Struktur Atap',
            'Nilai Keselamatan (A)',
        ];
    }

    public function title(): string
    {
        return 'Aspek Keselamatan';
    }

    public function chunkSize(): int
    {
        return 800; // shared hosting safe
    }

    /**
     * ============================
     * HEADER + LOGO
     * ============================
     */
    // public function registerEvents(): array
    // {
    //     return [
    //         AfterSheet::class => function (AfterSheet $event) {

    //             $s = $event->sheet->getDelegate();
    //             $s->insertNewRowBefore(1, 4);

    //             /** LOGO */
    //             $logoPath = public_path('assets/media/logos/logo.png');
    //             if (file_exists($logoPath)) {
    //                 $img = new Drawing();
    //                 $img->setPath($logoPath);
    //                 $img->setHeight(70);
    //                 $img->setCoordinates('A1');
    //                 $img->setWorksheet($s);
    //             }

    //             // Header 1
    //             $s->mergeCells('B1:I1');
    //             $s->setCellValue('B1', 'DINAS PERUMAHAN DAN KAWASAN PERMUKIMAN');
    //             $s->getStyle('B1')->getFont()->setBold(true)->setSize(20);
    //             $s->getStyle('B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    //             // Header 2
    //             $s->mergeCells('B2:I2');
    //             $s->setCellValue('B2', 'KOTA BUKITTINGGI');
    //             $s->getStyle('B2')->getFont()->setBold(true)->setSize(18);
    //             $s->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    //             /** HEADER GROUP */
    //             $s->setCellValue('A4', 'Identitas Dasar');
    //             $s->mergeCells('A4:A4');

    //             $s->setCellValue('B4', 'Aspek Keselamatan');
    //             $s->mergeCells('B4:I4');

    //             $s->getStyle('A4:I4')->applyFromArray([
    //                 'font' => ['bold' => true],
    //                 'alignment' => [
    //                     'horizontal' => Alignment::HORIZONTAL_CENTER,
    //                     'vertical'   => Alignment::VERTICAL_CENTER,
    //                 ],
    //                 'fill' => [
    //                     'fillType' => 'solid',
    //                     'color' => ['rgb' => 'E2EFDA']
    //                 ]
    //             ]);

    //             // Row heading
    //             $s->getStyle('A5:I5')->applyFromArray([
    //                 'font' => ['bold' => true],
    //                 'alignment' => [
    //                     'horizontal' => Alignment::HORIZONTAL_CENTER,
    //                     'vertical'   => Alignment::VERTICAL_CENTER,
    //                     'wrapText'   => true,
    //                 ],
    //             ]);
    //         }
    //     ];
    // }
}
