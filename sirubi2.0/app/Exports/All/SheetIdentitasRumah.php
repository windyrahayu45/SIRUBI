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

class SheetIdentitasRumah implements
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

    public function query()
    {
        return ($this->query ?? Rumah::query())
            ->select(['id_rumah', 'tahun_pembangunan_rumah', 'kelurahan_id'])
            ->with([
                'kepemilikan:id,rumah_id,status_kepemilikan_tanah_id,bukti_kepemilikan_tanah_id,status_kepemilikan_rumah_id,status_imb_id,nomor_imb,aset_rumah_ditempat_lain_id,aset_tanah_ditempat_lain_id,jenis_kawasan_lokasi_rumah_id,nik_kepemilikan_rumah',

                'kepemilikan.statusKepemilikanTanah:id_status_kepemilikan_tanah,status_kepemilikan_tanah','kepemilikan.buktiKepemilikanTanah:id_bukti_kepemilikan_tanah,bukti_kepemilikan_tanah','kepemilikan.statusKepemilikanRumah:id_status_kepemilikan_rumah,status_kepemilikan_rumah','kepemilikan.statusImb:id_status_imb,status_imb',
                'kepemilikan.asetRumahDitempatLain:id_aset_rumah_tempat_lain,aset_rumah_tempat_lain',
                'kepemilikan.asetTanahDitempatLain:id_aset_tanah_tempat_lain,aset_tanah_tempat_lain',
                'kepemilikan.jenisKawasanLokasiRumah:id_jenis_kawasan_lokasi,jenis_kawasan_lokasi',

                // dokumentasi
                'dokumen:id,rumah_id,foto_rumah_satu,foto_rumah_dua,foto_rumah_tiga,foto_kk,foto_ktp,foto_imb'
            ]);
    }

    public function map($r): array
    {
        return [
            // Kolom dasar
            $r->id_rumah,

            // Identitas
            $r->kepemilikan->statusKepemilikanTanah->status_kepemilikan_tanah ?? '-',
            $r->kepemilikan->buktiKepemilikanTanah->bukti_kepemilikan_tanah ?? '-',
            $r->kepemilikan->statusKepemilikanRumah->status_kepemilikan_rumah ?? '-',
            $r->kepemilikan->statusImb->status_imb ?? '-',
            $r->kepemilikan->nomor_imb ?? '-',
            $r->kepemilikan->asetRumahDitempatLain->aset_rumah_tempat_lain ?? '-',
            $r->kepemilikan->asetTanahDitempatLain->aset_tanah_tempat_lain ?? '-',
            $r->kepemilikan->jenisKawasanLokasiRumah->jenis_kawasan_lokasi ?? '-',
            $r->kepemilikan->nik_kepemilikan_rumah ?? '-',
            $r->tahun_pembangunan_rumah ?? '-',

           // 🟨 DOKUMENTASI (FULL URL)
            $r->dokumen && $r->dokumen->foto_rumah_satu
                ? asset('storage/' . $r->dokumen->foto_rumah_satu) 
                : '-',

            $r->dokumen && $r->dokumen->foto_rumah_dua
                ? asset('storage/' . $r->dokumen->foto_rumah_dua) 
                : '-',

            $r->dokumen && $r->dokumen->foto_rumah_tiga
                ? asset('storage/' . $r->dokumen->foto_rumah_tiga) 
                : '-',

            $r->dokumen && $r->dokumen->foto_ktp
                ? asset('storage/' . $r->dokumen->foto_ktp) 
                : '-',

            $r->dokumen && $r->dokumen->foto_kk
                ? asset('storage/' . $r->dokumen->foto_kk) 
                : '-',

            $r->dokumen && $r->dokumen->foto_imb
                ? asset('storage/' . $r->dokumen->foto_imb) 
                : '-',

        ];
    }

    public function headings(): array
    {
        return [
            'ID Rumah',
            'Status Kepemilikan Tanah',
            'Bukti Kepemilikan Tanah',
            'Status Kepemilikan Rumah',
            'Status IMB',
            'Nomor IMB',
            'Aset Rumah Tempat Lain',
            'Aset Tanah Tempat Lain',
            'Jenis Kawasan Lokasi Rumah',
            'NIK Kepemilikan Rumah',
            'Tahun Pembangunan',

            'Foto Rumah 1',
            'Foto Rumah 2',
            'Foto Rumah 3',
            'Foto KTP',
            'Foto KK',
            'Foto IMB'
        ];
    }

    public function title(): string
    {
        return 'Identitas & Dokumentasi';
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $s = $event->sheet->getDelegate();

                // ⬆ Tambahkan ruang header (4 baris)
                $s->insertNewRowBefore(1, 4);

                /**
                 * ===========================
                 *   🔥 LOGO + HEADER UTAMA
                 * ===========================
                 */

                $logoPath = public_path('assets/media/logos/logo.png');

                if (file_exists($logoPath)) {
                    $drawing = new Drawing();
                    $drawing->setPath($logoPath);
                    $drawing->setWidth(80);
                    $drawing->setCoordinates('A1'); // sama seperti sheet 1
                    $drawing->setOffsetX(10);
                    $drawing->setWorksheet($s);
                }

                // Judul 1
                $s->mergeCells('B1:U1');
                $s->setCellValue('B1', 'DINAS PERUMAHAN DAN KAWASAN PERMUKIMAN');
                $s->getStyle('B1')->getFont()->setBold(true)->setSize(20);
                $s->getStyle('B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Judul 2
                $s->mergeCells('B2:U2');
                $s->setCellValue('B2', 'KOTA BUKITTINGGI');
                $s->getStyle('B2')->getFont()->setBold(true)->setSize(18);
                $s->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);


                /**
                 * ==============================
                 *     🔥 HEADER GROUPING
                 * ==============================
                 */

                // Identitas Rumah
                $s->setCellValue('A4', 'Identitas Rumah');
                $s->mergeCells('A4:K4');

                // Dokumentasi
                $s->setCellValue('L4', 'Dokumentasi');
                $s->mergeCells('L4:Q4');

                // Styling header grouping
                $s->getStyle('A4:Q4')->applyFromArray([
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

                // Heading row style (baris 5)
                $s->getStyle('A5:Q5')->applyFromArray([
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

                // Tinggi baris header
                $s->getRowDimension(1)->setRowHeight(40);
                $s->getRowDimension(2)->setRowHeight(30);
                $s->getRowDimension(4)->setRowHeight(25);
                $s->getRowDimension(5)->setRowHeight(22);
            }
        ];
    }
}
