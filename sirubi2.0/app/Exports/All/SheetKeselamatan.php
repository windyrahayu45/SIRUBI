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

class SheetKeselamatan implements
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
     * Full query dengan relasi aspek keselamatan
     */
    public function query()
    {
        return ($this->query ?? Rumah::query())
            ->select(['id_rumah'])
            ->with([

                'fisik:id,rumah_id,pondasi_id,jenis_pondasi,kondisi_pondasi_id,kondisi_sloof_id,kondisi_kolom_tiang_id,kondisi_balok_id,kondisi_struktur_atap_id',

                'fisik.pondasi:id_pondasi,pondasi',
                'fisik.jenisPondasi:id_jenis_pondasi,nama_jenis_pondasi',
                'fisik.kondisiPondasi:id_kondisi_pondasi,kondisi_pondasi',
                'fisik.kondisiSloof:id_kondisi_sloof,kondisi_sloof',
                'fisik.kondisiKolomTiang:id_kondisi_kolom_tiang,kondisi_kolom_tiang',
                'fisik.kondisiBalok:id_kondisi_balok,kondisi_balok',
                'fisik.kondisiStrukturAtap:id_kondisi_struktur_atap,kondisi_struktur_atap',

                // nilai A
                'penilaian:id,rumah_id,nilai_a'
            ]);
    }

    public function map($r): array
    {
        return [

            // Kolom dasar
            $r->id_rumah,

            // Aspek keselamatan lengkap
            $r->fisik->pondasi->pondasi ?? '-',
            $r->fisik->jenisPondasi->nama_jenis_pondasi ?? '-',
            $r->fisik->kondisiPondasi->kondisi_pondasi ?? '-',
            $r->fisik->kondisiSloof->kondisi_sloof ?? '-',
            $r->fisik->kondisiKolomTiang->kondisi_kolom_tiang ?? '-',
            $r->fisik->kondisiBalok->kondisi_balok ?? '-',
            $r->fisik->kondisiStrukturAtap->kondisi_struktur_atap ?? '-',
            $r->penilaian->nilai_a ?? '-',
        ];
    }

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
        return 1000;
    }

    /**
     * Header seperti Sheet 1 & Sheet 2
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $s = $event->sheet->getDelegate();

                // 4 baris kosong sebelum header
                $s->insertNewRowBefore(1, 4);

                /**
                 * ===================================
                 *    🔥 LOGO + HEADER UTAMA
                 * ===================================
                 */
                $logoPath = public_path('assets/media/logos/logo.png');

                if (file_exists($logoPath)) {
                    $logo = new Drawing();
                    $logo->setPath($logoPath);
                    $logo->setHeight(70);
                    $logo->setCoordinates('A1');
                    $logo->setWorksheet($s);
                }

                // Judul utama
                $s->mergeCells('B1:I1');
                $s->setCellValue('B1', 'DINAS PERUMAHAN DAN KAWASAN PERMUKIMAN');
                $s->getStyle('B1')->getFont()->setBold(true)->setSize(20);
                $s->getStyle('B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Subjudul
                $s->mergeCells('B2:I2');
                $s->setCellValue('B2', 'KOTA BUKITTINGGI');
                $s->getStyle('B2')->getFont()->setBold(true)->setSize(18);
                $s->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


                /**
                 * ===================================
                 *          🔥 HEADER GROUP
                 * ===================================
                 */

                // Identitas dasar
                $s->setCellValue('A4', 'Identitas Dasar');
                $s->mergeCells('A4:A4');

                // Aspek keselamatan
                $s->setCellValue('B4', 'Aspek Keselamatan');
                $s->mergeCells('B4:I4');

                // Styling grup
                $s->getStyle('A4:I4')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'color' => ['rgb' => 'E2EFDA']
                    ]
                ]);

                // Styling heading baris 5
                $s->getStyle('A5:I5')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                        'wrapText'   => true,
                    ],
                    'borders' => [
                        'allBorders' => ['borderStyle' => Border::BORDER_THIN]
                    ]
                ]);

                // Tinggi baris
                $s->getRowDimension(1)->setRowHeight(40);
                $s->getRowDimension(2)->setRowHeight(30);
                $s->getRowDimension(4)->setRowHeight(25);
                $s->getRowDimension(5)->setRowHeight(22);
            }
        ];
    }
}
