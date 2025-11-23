<?php

namespace App\Exports\All;

use App\Models\Rumah;
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

class SheetLuasRuang implements
    FromQuery,
    WithMapping,
    WithHeadings,
    WithTitle,
    WithChunkReading,
    ShouldAutoSize,
    WithEvents
{
    protected $query;

    public function __construct($query = null)
    {
        $this->query = $query;
    }

    /**
     * ===========================
     *       FULL QUERY RUANG
     * ===========================
     */
    public function query()
    {
        return ($this->query ?? Rumah::query())
            ->select(['id_rumah'])
            ->with([

                'fisik:id,rumah_id,luas_rumah,tinggi_rata_rumah,jumlah_penghuni_laki,jumlah_penghuni_perempuan,jumlah_abk,jumlah_kamar_tidur,luas_rata_kamar_tidur,ruang_keluarga_dan_ruang_tidur_id,jenis_fisik_bangunan_id,fungsi_rumah_id,tipe_rumah_id,jumlah_lantai_bangunan',

                'fisik.ruangKeluargaDanTidur:id_ruang_keluarga_dan_tidur,ruang_keluarga_dan_tidur',
                'fisik.jenisFisikBangunan:id_jenis_fisik_bangunan,jenis_fisik_bangunan',
                'fisik.fungsiRumah:id_fungsi_rumah,fungsi_rumah',
                'fisik.tipeRumah:id_tipe_rumah,tipe_rumah',

                // nilai C
                'penilaian:id,rumah_id,nilai'
            ]);
    }

    /**
     * ===========================
     *        MAPPING DATA
     * ===========================
     */
    public function map($r): array
    {
        return [

            // Kolom dasar
            $r->id_rumah,

            // Luas & ruang
            $r->fisik->luas_rumah ?? '-',
            $r->fisik->tinggi_rata_rumah ?? '-',
            $r->fisik->jumlah_penghuni_laki ?? '-',
            $r->fisik->jumlah_penghuni_perempuan ?? '-',
            $r->fisik->jumlah_abk ?? '-',
            $r->fisik->jumlah_kamar_tidur ?? '-',
            $r->fisik->luas_rata_kamar_tidur ?? '-',

            $r->fisik->ruangKeluargaDanTidur->ruang_keluarga_dan_tidur ?? '-',
            $r->fisik->jenisFisikBangunan->jenis_fisik_bangunan ?? '-',
            $r->fisik->fungsiRumah->fungsi_rumah ?? '-',
            $r->fisik->tipeRumah->tipe_rumah ?? '-',
            $r->fisik->jumlah_lantai_bangunan ?? '-',

            // Nilai C
            $r->penilaian->nilai ?? '-',
        ];
    }

    /**
     * ===========================
     *         HEADINGS
     * ===========================
     */
    public function headings(): array
    {
        return [
            'ID Rumah',

            'Luas Rumah (m²)',
            'Tinggi Rata-rata Rumah (m)',
            'Jumlah Penghuni Laki-laki',
            'Jumlah Penghuni Perempuan',
            'Jumlah ABK',
            'Jumlah Kamar Tidur',
            'Luas Rata-rata Kamar Tidur',

            'Ruang Keluarga & Tidur',
            'Jenis Fisik Bangunan',
            'Fungsi Rumah',
            'Tipe Rumah',
            'Jumlah Lantai Bangunan',

            'Nilai Akhir',
        ];
    }

    public function title(): string
    {
        return 'Aspek Luas & Ruang';
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    /**
     * ===========================
     *     HEADER SAMA DENGAN
     *     SHEET 1–4 (LOGO DLL)
     * ===========================
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                // Ruang 4 baris sebelum header
                $sheet->insertNewRowBefore(1, 4);

                // === LOGO ===
                $logoPath = public_path('assets/media/logos/logo.png');
                if (file_exists($logoPath)) {
                    $logo = new Drawing();
                    $logo->setPath($logoPath);
                    $logo->setHeight(70);
                    $logo->setCoordinates('A1');
                    $logo->setWorksheet($sheet);
                }

                // === Judul utama ===
                $sheet->mergeCells('B1:N1');
                $sheet->setCellValue('B1', 'DINAS PERUMAHAN DAN KAWASAN PERMUKIMAN');
                $sheet->getStyle('B1')->getFont()->setBold(true)->setSize(20);
                $sheet->getStyle('B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // === Subjudul ===
                $sheet->mergeCells('B2:N2');
                $sheet->setCellValue('B2', 'KOTA BUKITTINGGI');
                $sheet->getStyle('B2')->getFont()->setBold(true)->setSize(18);
                $sheet->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // === Header grouping ===
                $sheet->setCellValue('A4', 'Identitas Dasar');
                $sheet->mergeCells('A4:A4');

                $sheet->setCellValue('B4', 'Aspek Luas & Ruang');
                $sheet->mergeCells('B4:N4');

                // Style grouping
                $sheet->getStyle('A4:N4')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical' => Alignment::VERTICAL_CENTER
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'color' => ['rgb' => 'E2EFDA']
                    ]
                ]);

                // Style heading
                $sheet->getStyle('A5:N5')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                        'wrapText'   => true
                    ],
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN]
                    ]
                ]);

                // Tinggi header
                $sheet->getRowDimension(1)->setRowHeight(40);
                $sheet->getRowDimension(2)->setRowHeight(30);
                $sheet->getRowDimension(4)->setRowHeight(25);
                $sheet->getRowDimension(5)->setRowHeight(22);
            }
        ];
    }
}
