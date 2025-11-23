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

class SheetKesehatan implements
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
     * FAST QUERY — NO ELOQUENT
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
     * FAST MAP — ALL DB::table()
     * ============================
     */
    public function map($r): array
    {
        // Ambil sanitasi 1 row saja
        $s = DB::table('sanitasi_rumah')
            ->where('rumah_id', $r->id_rumah)
            ->first();

        if (!$s) {
            $s = (object)[];
        }

        // Helper untuk ambil nama referensi
        $ref = fn($table, $idColumn, $nameColumn, $id) =>
            $id ? DB::table($table)->where($idColumn, $id)->value($nameColumn) : '-';

        return [
            $r->id_rumah,

            // Jendela Cahaya
            $ref('i_jendela_lubang_cahaya', 'id_jendela_lubang_cahaya', 'jendela_lubang_cahaya', $s->jendela_lubang_cahaya_id ?? null),
            $ref('i_kondisi_jendela_lubang_cahaya', 'id_kondisi_jendela_lubang_cahaya', 'kondisi_jendela_lubang_cahaya', $s->kondisi_jendela_lubang_cahaya_id ?? null),

            // Ventilasi
            $ref('i_ventilasi', 'id_ventilasi', 'ventilasi', $s->ventilasi_id ?? null),
            $s->keterangan_ventilasi ?? '-',
            $ref('i_kondisi_ventilasi', 'id_kondisi_ventilasi', 'kondisi_ventilasi', $s->kondisi_ventilasi_id ?? null),

            // Kamar Mandi
            $ref('i_kamar_mandi', 'id_kamar_mandi', 'kamar_mandi', $s->kamar_mandi_id ?? null),
            $ref('i_kondisi_kamar_mandi', 'id_kondisi_kamar_mandi', 'kondisi_kamar_mandi', $s->kondisi_kamar_mandi_id ?? null),

            // Jamban
            $ref('i_jamban', 'id_jamban', 'jamban', $s->jamban_id ?? null),
            $ref('i_kondisi_jamban', 'id_kondisi_jamban', 'kondisi_jamban', $s->kondisi_jamban_id ?? null),

            // Pembuangan Air Kotor
            $ref('i_sistem_pembuangan_air_kotor', 'id_sistem_pembuangan_air_kotor', 'sistem_pembuangan_air_kotor', $s->sistem_pembuangan_air_kotor_id ?? null),
            $ref('i_kondisi_sistem_pembuangan_air_kotor', 'id_kondisi_sistem_pembuangan_air_kotor', 'kondisi_sistem_pembuangan_air_kotor', $s->kondisi_sistem_pembuangan_air_kotor_id ?? null),

            // Air Minum
            $ref('i_sumber_air_minum', 'id_sumber_air_minum', 'sumber_air_minum', $s->sumber_air_minum_id ?? null),
            $ref('i_kondisi_sumber_air_minum', 'id_kondisi_sumber_air_minum', 'kondisi_sumber_air_minum', $s->kondisi_sumber_air_minum_id ?? null),

            // Listrik
            $ref('i_sumber_listrik', 'id_sumber_listrik', 'sumber_listrik', $s->sumber_listrik_id ?? null),

            // Penyedotan
            $ref('i_frekuensi_penyedotan', 'id_frekuensi_penyedotan', 'frekuensi_penyedotan', $s->frekuensi_penyedotan_id ?? null),

            // Nilai B
            DB::table('penilaian_rumah')
                ->where('rumah_id', $r->id_rumah)
                ->value('nilai_b') ?? '-',
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

            'Jendela / Lubang Cahaya',
            'Kondisi Jendela / Lubang Cahaya',

            'Ventilasi',
            'Keterangan Ventilasi',
            'Kondisi Ventilasi',

            'Kamar Mandi',
            'Kondisi Kamar Mandi',

            'Jamban',
            'Kondisi Jamban',

            'Sistem Pembuangan Air Kotor',
            'Kondisi Sistem Pembuangan Air Kotor',

            'Sumber Air Minum',
            'Kondisi Sumber Air Minum',

            'Sumber Listrik',
            'Frekuensi Penyedotan',

            'Nilai Kesehatan (B)'
        ];
    }

    public function title(): string
    {
        return 'Aspek Kesehatan';
    }

    public function chunkSize(): int
    {
        return 800; // aman untuk shared hosting
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
    //             $logo = public_path('assets/media/logos/logo.png');
    //             if (file_exists($logo)) {
    //                 $img = new Drawing();
    //                 $img->setPath($logo);
    //                 $img->setHeight(70);
    //                 $img->setCoordinates('A1');
    //                 $img->setWorksheet($s);
    //             }

    //             // Header
    //             $s->mergeCells('B1:R1');
    //             $s->setCellValue('B1', 'DINAS PERUMAHAN DAN KAWASAN PERMUKIMAN');
    //             $s->getStyle('B1')->getFont()->setBold(true)->setSize(20);
    //             $s->getStyle('B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    //             // Subjudul
    //             $s->mergeCells('B2:R2');
    //             $s->setCellValue('B2', 'KOTA BUKITTINGGI');
    //             $s->getStyle('B2')->getFont()->setBold(true)->setSize(18);
    //             $s->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    //             // Group Title
    //             $s->mergeCells('A4:A4');
    //             $s->mergeCells('B4:R4');
    //             $s->setCellValue('A4', 'ID Dasar');
    //             $s->setCellValue('B4', 'Aspek Kesehatan');

    //             $s->getStyle('A4:R4')->applyFromArray([
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
    //         }
    //     ];
    // }
}
