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

class SheetLuasRuang implements
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
     * ===========================================
     *     FAST MODE QUERY (1 heavy query saja)
     * ===========================================
     */
    public function query()
    {
        return DB::table('rumah AS r')
            ->select([
                'r.id_rumah',

                // luas ruang
                'f.luas_rumah',
                'f.tinggi_rata_rumah',
                'f.jumlah_penghuni_laki',
                'f.jumlah_penghuni_perempuan',
                'f.jumlah_abk',
                'f.jumlah_kamar_tidur',
                'f.luas_rata_kamar_tidur',

                'f.ruang_keluarga_dan_ruang_tidur_id',
                'f.jenis_fisik_bangunan_id',
                'f.fungsi_rumah_id',
                'f.tipe_rumah_id',
                'f.jumlah_lantai_bangunan',

                // nilai C
                'p.nilai AS nilai_c'
            ])
            ->leftJoin('fisik AS f', 'f.rumah_id', '=', 'r.id_rumah')
            ->leftJoin('penilaian AS p', 'p.rumah_id', '=', 'r.id_rumah')
            ->when(!empty($this->rumahIds), fn($q) =>
                $q->whereIn('r.id_rumah', $this->rumahIds)
            )
            ->orderBy('r.id_rumah', 'asc');
    }

    /**
     * ===========================================
     *       LOOKUP TABLE REFERENSI (CACHE)
     * ===========================================
     */
    public function map($r): array
    {
        static $ref = null;

        if (!$ref) {
            $ref = [
                'ruang'   => DB::table('i_ruang_keluarga_dan_tidur')->pluck('ruang_keluarga_dan_tidur', 'id_ruang_keluarga_dan_tidur'),
                'jenis'   => DB::table('i_jenis_fisik_bangunan')->pluck('jenis_fisik_bangunan', 'id_jenis_fisik_bangunan'),
                'fungsi'  => DB::table('i_fungsi_rumah')->pluck('fungsi_rumah', 'id_fungsi_rumah'),
                'tipe'    => DB::table('i_tipe_rumah')->pluck('tipe_rumah', 'id_tipe_rumah'),
            ];
        }

        return [
            $r->id_rumah,

            // Luas & ruang
            $r->luas_rumah ?? '-',
            $r->tinggi_rata_rumah ?? '-',
            $r->jumlah_penghuni_laki ?? '-',
            $r->jumlah_penghuni_perempuan ?? '-',
            $r->jumlah_abk ?? '-',
            $r->jumlah_kamar_tidur ?? '-',
            $r->luas_rata_kamar_tidur ?? '-',

            $ref['ruang'][$r->ruang_keluarga_dan_ruang_tidur_id] ?? '-',
            $ref['jenis'][$r->jenis_fisik_bangunan_id] ?? '-',
            $ref['fungsi'][$r->fungsi_rumah_id] ?? '-',
            $ref['tipe'][$r->tipe_rumah_id] ?? '-',
            $r->jumlah_lantai_bangunan ?? '-',

            // Nilai C
            $r->nilai_c ?? '-',
        ];
    }

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
        return 1000; // aman untuk 30.000+ data
    }

    /**
     * ===========================================
     *    HEADER (Logo + Grouping) — SAME STYLE
     * ===========================================
     */
    // public function registerEvents(): array
    // {
    //     return [
    //         AfterSheet::class => function (AfterSheet $event) {

    //             $s = $event->sheet->getDelegate();

    //             $s->insertNewRowBefore(1, 4);

    //             // LOGO
    //             $logo = public_path('assets/media/logos/logo.png');
    //             if (file_exists($logo)) {
    //                 $d = new Drawing();
    //                 $d->setPath($logo);
    //                 $d->setCoordinates('A1');
    //                 $d->setHeight(70);
    //                 $d->setWorksheet($s);
    //             }

    //             // HEADER 1
    //             $s->mergeCells('B1:N1');
    //             $s->setCellValue('B1', 'DINAS PERUMAHAN DAN KAWASAN PERMUKIMAN');
    //             $s->getStyle('B1')->getFont()->setBold(true)->setSize(20);
    //             $s->getStyle('B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    //             // HEADER 2
    //             $s->mergeCells('B2:N2');
    //             $s->setCellValue('B2', 'KOTA BUKITTINGGI');
    //             $s->getStyle('B2')->getFont()->setBold(true)->setSize(18);
    //             $s->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    //             // GROUP
    //             $s->setCellValue('A4', 'Identitas Dasar');
    //             $s->mergeCells('A4:A4');

    //             $s->setCellValue('B4', 'Aspek Luas & Ruang');
    //             $s->mergeCells('B4:N4');

    //             $s->getStyle('A4:N4')->applyFromArray([
    //                 'font' => ['bold' => true],
    //                 'alignment' => [
    //                     'horizontal' => Alignment::HORIZONTAL_CENTER,
    //                     'vertical'   => Alignment::VERTICAL_CENTER
    //                 ],
    //                 'fill' => [
    //                     'fillType' => 'solid',
    //                     'color' => ['rgb' => 'E2EFDA']
    //                 ]
    //             ]);

    //             // HEADINGS STYLE
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
