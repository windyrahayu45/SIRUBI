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

class SheetKomponen implements
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
     *          FULL QUERY
     * ===========================
     */
    public function query()
    {
        return ($this->query ?? Rumah::query())
            ->select(['id_rumah'])
            ->with([

                'fisik:id,rumah_id,material_atap_terluas_id,kondisi_penutup_atap_id,material_dinding_terluas_id,kondisi_dinding_id,material_lantai_terluas_id,kondisi_lantai_id,akses_ke_jalan_id,bangunan_menghadap_jalan_id,bangunan_menghadap_sungai_id,bangunan_berada_sungai_id,bangunan_berada_limbah_id',

                'fisik.materialAtapTerluas:id_material_atap_terluas,material_atap_terluas',
                'fisik.kondisiPenutupAtap:id_kondisi_penutup_atap,kondisi_penutup_atap',
                'fisik.materialDindingTerluas:id_material_dinding_terluas,material_dinding_terluas',
                'fisik.kondisiDinding:id_kondisi_dinding,kondisi_dinding',
                'fisik.materialLantaiTerluas:id_material_lantai_terluas,material_lantai_terluas',
                'fisik.kondisiLantai:id_kondisi_lantai,kondisi_lantai',
                'fisik.aksesKeJalan:id_akses_ke_jalan,akses_ke_jalan',

                'fisik.bangunanMenghadapJalan:id_bangunan_menghadap_jalan,bangunan_menghadap_jalan',
                'fisik.bangunanMenghadapSungai:id_bangunan_menghadap_sungai,bangunan_menghadap_sungai',
                'fisik.bangunanBeradaSungai:id_bangunan_berada_sungai,bangunan_berada_sungai',
                'fisik.bangunanBeradaLimbah:id_bangunan_berada_limbah,bangunan_berada_limbah',

                // Nilai C (bahan bangunan termasuk aspek luas/ruang/komponen)
                'penilaian:id,rumah_id,nilai_c'
            ]);
    }

    /**
     * ===========================
     *          MAP DATA
     * ===========================
     */
    public function map($r): array
    {
        return [

            // Kolom dasar
            $r->id_rumah,

            // Komponen bahan bangunan
            $r->fisik->materialAtapTerluas->material_atap_terluas ?? '-',
            $r->fisik->kondisiPenutupAtap->kondisi_penutup_atap ?? '-',

            $r->fisik->materialDindingTerluas->material_dinding_terluas ?? '-',
            $r->fisik->kondisiDinding->kondisi_dinding ?? '-',

            $r->fisik->materialLantaiTerluas->material_lantai_terluas ?? '-',
            $r->fisik->kondisiLantai->kondisi_lantai ?? '-',

            $r->fisik->aksesKeJalan->akses_ke_jalan ?? '-',
            $r->fisik->bangunanMenghadapJalan->bangunan_menghadap_jalan ?? '-',
            $r->fisik->bangunanMenghadapSungai->bangunan_menghadap_sungai ?? '-',
            $r->fisik->bangunanBeradaSungai->bangunan_berada_sungai ?? '-',
            $r->fisik->bangunanBeradaLimbah->bangunan_berada_limbah ?? '-',

            // Nilai C
            $r->penilaian->nilai_c ?? '-',
        ];
    }

    /**
     * ===========================
     *          HEADINGS
     * ===========================
     */
    public function headings(): array
    {
        return [
            'ID Rumah',

            'Material Atap Terluas',
            'Kondisi Penutup Atap',

            'Material Dinding Terluas',
            'Kondisi Dinding',

            'Material Lantai Terluas',
            'Kondisi Lantai',

            'Akses Langsung ke Jalan',
            'Bangunan Menghadap Jalan',
            'Bangunan Menghadap Sungai',
            'Bangunan di Atas Sempadan Sungai',
            'Bangunan di Area Limbah / SUTET',

            'Nilai Komponen (C)' // Mengambil nilai C
        ];
    }

    public function title(): string
    {
        return 'Komponen Bahan Bangunan';
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    /**
     * ===========================
     *        HEADER + LOGO
     * ===========================
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $sheet = $event->sheet->getDelegate();

                // Sisip 4 baris awal
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

                $sheet->setCellValue('B4', 'Aspek Komponen Bahan Bangunan');
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

                // Style header baris 5
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
