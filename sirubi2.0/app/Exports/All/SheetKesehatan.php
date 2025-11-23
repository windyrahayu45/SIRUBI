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

class SheetKesehatan implements
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
     * =====================
     * FULL QUERY SANITASI
     * =====================
     */
    public function query()
    {
        return ($this->query ?? Rumah::query())
            ->select(['id_rumah'])
            ->with([

                'sanitasi:id,rumah_id,jendela_lubang_cahaya_id,kondisi_jendela_lubang_cahaya_id,ventilasi_id,kondisi_ventilasi_id,kamar_mandi_id,kondisi_kamar_mandi_id,jamban_id,kondisi_jamban_id,sistem_pembuangan_air_kotor_id,kondisi_sistem_pembuangan_air_kotor_id,sumber_air_minum_id,kondisi_sumber_air_minum_id,sumber_listrik_id,frekuensi_penyedotan_id,keterangan_ventilasi',

                'sanitasi.jendelaLubangCahaya:id_jendela_lubang_cahaya,jendela_lubang_cahaya',
                'sanitasi.kondisiJendelaLubangCahaya:id_kondisi_jendela_lubang_cahaya,kondisi_jendela_lubang_cahaya',
                'sanitasi.ventilasi:id_ventilasi,ventilasi',
                'sanitasi.kondisiVentilasi:id_kondisi_ventilasi,kondisi_ventilasi',
                'sanitasi.kamarMandi:id_kamar_mandi,kamar_mandi',
                'sanitasi.kondisiKamarMandi:id_kondisi_kamar_mandi,kondisi_kamar_mandi',
                'sanitasi.jamban:id_jamban,jamban',
                'sanitasi.kondisiJamban:id_kondisi_jamban,kondisi_jamban',
                'sanitasi.sistemPembuanganAirKotor:id_sistem_pembuangan_air_kotor,sistem_pembuangan_air_kotor',
                'sanitasi.kondisiSistemPembuanganAirKotor:id_kondisi_sistem_pembuangan_air_kotor,kondisi_sistem_pembuangan_air_kotor',
                'sanitasi.sumberAirMinum:id_sumber_air_minum,sumber_air_minum',
                'sanitasi.kondisiSumberAirMinum:id_kondisi_sumber_air_minum,kondisi_sumber_air_minum',
                'sanitasi.sumberListrik:id_sumber_listrik,sumber_listrik',
                'sanitasi.frekuensiPenyedotan:id_frekuensi_penyedotan,frekuensi_penyedotan',

                // nilai B
                'penilaian:id,rumah_id,nilai_b'
            ]);
    }

    /**
     * =====================
     * MAPPING DATA
     * =====================
     */
    public function map($r): array
    {
        return [
            $r->id_rumah,

            // Jendela & Lubang Cahaya
            $r->sanitasi->jendelaLubangCahaya->jendela_lubang_cahaya ?? '-',
            $r->sanitasi->kondisiJendelaLubangCahaya->kondisi_jendela_lubang_cahaya ?? '-',

            // Ventilasi
            $r->sanitasi->ventilasi->ventilasi ?? '-',
            $r->sanitasi->keterangan_ventilasi ?? '-',
            $r->sanitasi->kondisiVentilasi->kondisi_ventilasi ?? '-',

            // Kamar mandi
            $r->sanitasi->kamarMandi->kamar_mandi ?? '-',
            $r->sanitasi->kondisiKamarMandi->kondisi_kamar_mandi ?? '-',

            // Jamban
            $r->sanitasi->jamban->jamban ?? '-',
            $r->sanitasi->kondisiJamban->kondisi_jamban ?? '-',

            // Pembuangan Air Kotor
            $r->sanitasi->sistemPembuanganAirKotor->sistem_pembuangan_air_kotor ?? '-',
            $r->sanitasi->kondisiSistemPembuanganAirKotor->kondisi_sistem_pembuangan_air_kotor ?? '-',

            // Air minum
            $r->sanitasi->sumberAirMinum->sumber_air_minum ?? '-',
            $r->sanitasi->kondisiSumberAirMinum->kondisi_sumber_air_minum ?? '-',

            // Listrik
            $r->sanitasi->sumberListrik->sumber_listrik ?? '-',

            // Penyedotan
            $r->sanitasi->frekuensiPenyedotan->frekuensi_penyedotan ?? '-',

            // Nilai B
            $r->penilaian->nilai_b ?? '-',
        ];
    }

    /**
     * =====================
     * HEADINGS
     * =====================
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

            'Nilai Kesehatan (B)',
        ];
    }

    public function title(): string
    {
        return 'Aspek Kesehatan';
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    /**
     * ===========================
     *  HEADER SAMA DENGAN SHEET 1
     * ===========================
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $s = $event->sheet->getDelegate();

                // Tambah 4 baris sebelum header
                $s->insertNewRowBefore(1, 4);

                // LOGO
                $logo = public_path('assets/media/logos/logo.png');
                if (file_exists($logo)) {
                    $img = new Drawing();
                    $img->setPath($logo);
                    $img->setHeight(70);
                    $img->setCoordinates('A1');
                    $img->setWorksheet($s);
                }

                // Judul
                $s->mergeCells('B1:R1');
                $s->setCellValue('B1', 'DINAS PERUMAHAN DAN KAWASAN PERMUKIMAN');
                $s->getStyle('B1')->getFont()->setBold(true)->setSize(20);
                $s->getStyle('B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Subjudul
                $s->mergeCells('B2:R2');
                $s->setCellValue('B2', 'KOTA BUKITTINGGI');
                $s->getStyle('B2')->getFont()->setBold(true)->setSize(18);
                $s->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                /**
                 * HEADER GROUP
                 */
                $s->setCellValue('A4', 'ID Dasar');
                $s->mergeCells('A4:A4');

                $s->setCellValue('B4', 'Aspek Kesehatan');
                $s->mergeCells('B4:R4');

                // Style group
                $s->getStyle('A4:R4')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'color' => ['rgb' => 'E2EFDA']
                    ]
                ]);

                // Style headings
                $s->getStyle('A5:R5')->applyFromArray([
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
                $s->getRowDimension(1)->setRowHeight(40);
                $s->getRowDimension(2)->setRowHeight(30);
                $s->getRowDimension(4)->setRowHeight(25);
                $s->getRowDimension(5)->setRowHeight(22);
            }
        ];
    }
}
