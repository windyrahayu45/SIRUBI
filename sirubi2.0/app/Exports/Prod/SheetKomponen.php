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
use PhpOffice\PhpSpreadsheet\Style\Border;

class SheetKomponen implements
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
     * =====================================
     *           FAST QUERY MODE
     * =====================================
     */
    public function query()
    {
        return DB::table('rumah AS r')
            ->select([
                'r.id_rumah',

                // fisik
                'f.material_atap_terluas_id',
                'f.kondisi_penutup_atap_id',
                'f.material_dinding_terluas_id',
                'f.kondisi_dinding_id',
                'f.material_lantai_terluas_id',
                'f.kondisi_lantai_id',
                'f.akses_ke_jalan_id',
                'f.bangunan_menghadap_jalan_id',
                'f.bangunan_menghadap_sungai_id',
                'f.bangunan_berada_sungai_id',
                'f.bangunan_berada_limbah_id',

                // nilai C
                'p.nilai_c'
            ])
            ->leftJoin('fisik_rumah AS f', 'f.rumah_id', '=', 'r.id_rumah')
            ->leftJoin('penilaian AS p', 'p.rumah_id', '=', 'r.id_rumah')
            ->when(!empty($this->rumahIds), fn($q) =>
                $q->whereIn('r.id_rumah', $this->rumahIds)
            )
            ->orderBy('r.id_rumah');
    }

    /**
     * =====================================
     *           FAST MAPPING
     * =====================================
     */
    public function map($r): array
    {
        // LOOKUP TEXT (tanpa Eloquent) via cached table
        static $ref = null;
        if (!$ref) {
            $ref = [
                'material_atap'   => DB::table('i_material_atap_terluas')->pluck('material_atap_terluas', 'id_material_atap_terluas'),
                'kondisi_atap'    => DB::table('i_kondisi_penutup_atap')->pluck('kondisi_penutup_atap', 'id_kondisi_penutup_atap'),
                'material_dinding'=> DB::table('i_material_dinding_terluas')->pluck('material_dinding_terluas', 'id_material_dinding_terluas'),
                'kondisi_dinding' => DB::table('i_kondisi_dinding')->pluck('kondisi_dinding', 'id_kondisi_dinding'),
                'material_lantai' => DB::table('i_material_lantai_terluas')->pluck('material_lantai_terluas', 'id_material_lantai_terluas'),
                'kondisi_lantai'  => DB::table('i_kondisi_lantai')->pluck('kondisi_lantai', 'id_kondisi_lantai'),
                'akses_jalan'     => DB::table('i_akses_ke_jalan')->pluck('akses_ke_jalan', 'id_akses_ke_jalan'),
                'hadap_jalan'     => DB::table('i_bangunan_menghadap_jalan')->pluck('bangunan_menghadap_jalan', 'id_bangunan_menghadap_jalan'),
                'hadap_sungai'    => DB::table('i_bangunan_menghadap_sungai')->pluck('bangunan_menghadap_sungai', 'id_bangunan_menghadap_sungai'),
                'di_sungai'       => DB::table('i_bangunan_berada_sungai')->pluck('bangunan_berada_sungai', 'id_bangunan_berada_sungai'),
                'di_limbah'       => DB::table('i_bangunan_berada_limbah')->pluck('bangunan_berada_limbah', 'id_bangunan_berada_limbah'),
            ];
        }

        return [
            $r->id_rumah,

            // Lookup cepat dari cached array
            $ref['material_atap'][$r->material_atap_terluas_id]    ?? '-',
            $ref['kondisi_atap'][$r->kondisi_penutup_atap_id]       ?? '-',

            $ref['material_dinding'][$r->material_dinding_terluas_id] ?? '-',
            $ref['kondisi_dinding'][$r->kondisi_dinding_id]           ?? '-',

            $ref['material_lantai'][$r->material_lantai_terluas_id] ?? '-',
            $ref['kondisi_lantai'][$r->kondisi_lantai_id]           ?? '-',

            $ref['akses_jalan'][$r->akses_ke_jalan_id]                  ?? '-',
            $ref['hadap_jalan'][$r->bangunan_menghadap_jalan_id]        ?? '-',
            $ref['hadap_sungai'][$r->bangunan_menghadap_sungai_id]      ?? '-',
            $ref['di_sungai'][$r->bangunan_berada_sungai_id]            ?? '-',
            $ref['di_limbah'][$r->bangunan_berada_limbah_id]            ?? '-',

            $r->nilai_c ?? '-'
        ];
    }

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

            'Akses ke Jalan',
            'Bangunan Menghadap Jalan',
            'Bangunan Menghadap Sungai',
            'Bangunan di Atas Sempadan Sungai',
            'Bangunan di Area Limbah / SUTET',

            'Nilai Komponen (C)',
        ];
    }

    public function title(): string
    {
        return 'Komponen Bahan Bangunan';
    }

    public function chunkSize(): int
    {
        return 1000; // aman untuk 30–50 ribu data
    }

    /**
     * HEADER LOGO
     */
    // public function registerEvents(): array
    // {
    //     return [
    //         AfterSheet::class => function (AfterSheet $event) {

    //             $s = $event->sheet->getDelegate();

    //             $s->insertNewRowBefore(1, 4);

    //             $logoPath = public_path('assets/media/logos/logo.png');
    //             if (file_exists($logoPath)) {
    //                 $logo = new Drawing();
    //                 $logo->setPath($logoPath);
    //                 $logo->setCoordinates('A1');
    //                 $logo->setHeight(70);
    //                 $logo->setWorksheet($s);
    //             }

    //             $s->mergeCells('B1:N1');
    //             $s->setCellValue('B1', 'DINAS PERUMAHAN DAN KAWASAN PERMUKIMAN');
    //             $s->getStyle('B1')->getFont()->setBold(true)->setSize(20);
    //             $s->getStyle('B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    //             $s->mergeCells('B2:N2');
    //             $s->setCellValue('B2', 'KOTA BUKITTINGGI');
    //             $s->getStyle('B2')->getFont()->setBold(true)->setSize(18);
    //             $s->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    //             // Header group
    //             $s->setCellValue('A4', 'Identitas Dasar');
    //             $s->mergeCells('A4:A4');

    //             $s->setCellValue('B4', 'Aspek Komponen Bahan Bangunan');
    //             $s->mergeCells('B4:N4');

    //             $s->getStyle('A4:N4')->applyFromArray([
    //                 'font' => ['bold' => true],
    //                 'alignment' => [
    //                     'horizontal' => Alignment::HORIZONTAL_CENTER,
    //                     'vertical'   => Alignment::VERTICAL_CENTER,
    //                 ],
    //                 'fill' => [
    //                     'fillType' => 'solid',
    //                     'color'    => ['rgb' => 'E2EFDA']
    //                 ]
    //             ]);

    //             $s->getStyle('A5:N5')->applyFromArray([
    //                 'font' => ['bold' => true],
    //                 'alignment' => [
    //                     'horizontal' => Alignment::HORIZONTAL_CENTER,
    //                     'vertical'   => Alignment::VERTICAL_CENTER,
    //                     'wrapText'   => true
    //                 ],
    //                 'borders' => [
    //                     'allBorders' => ['borderStyle' => Border::BORDER_THIN]
    //                 ]
    //             ]);
    //         }
    //     ];
    // }
}
