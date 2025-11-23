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

class SheetLokasiPenghuni implements
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
     * FULL QUERY RELASI LANGSUNG (TANPA TRAIT)
     */
    public function query()
    {
        return ($this->query ?? Rumah::query())
            ->select([
                'id_rumah',
                'alamat',
                'latitude',
                'longitude',
                'rt',
                'rw',
                'kelurahan_id',
                'tahun_pembangunan_rumah'
            ])
            ->with([
                // Lokasi
                'kelurahan:id_kelurahan,nama_kelurahan,kecamatan_id',
                'kelurahan.kecamatan:id_kecamatan,nama_kecamatan',

                // Sosial Ekonomi (Penghuni Rumah)
                'sosialEkonomi:id,rumah_id,jenis_kelamin_id,usia,pendidikan_terakhir_id,pekerjaan_utama_id,besar_penghasilan_perbulan_id,besar_pengeluaran_perbulan_id,status_dtks_id,jumlah_kk_id',

                'sosialEkonomi.jenisKelamin:id_jenis_kelamin,jenis_kelamin',
                'sosialEkonomi.pendidikanTerakhir:id_pendidikan_terakhir,pendidikan_terakhir',
                'sosialEkonomi.pekerjaanUtama:id_pekerjaan_utama,pekerjaan_utama',
                'sosialEkonomi.besarPenghasilan:id_besar_penghasilan,besar_penghasilan',
                'sosialEkonomi.besarPengeluaran:id_besar_pengeluaran,besar_pengeluaran',
                'sosialEkonomi.statusDtks:id_status_dtks,status_dtks',
                'sosialEkonomi.jumlahKK:id_jumlah_kk,jumlah_kk',
            ]);
    }

    /**
     * MAPPING (Step 1 + Step 2)
     */
    public function map($r): array
    {
        return [
            // Lokasi Rumah
            $r->id_rumah,
            $r->alamat,
            $r->latitude,
            $r->longitude,
            $r->rt,
            $r->rw,
            $r->kelurahan->nama_kelurahan ?? '-',
            $r->kelurahan->kecamatan->nama_kecamatan ?? '-',

            // Penghuni Rumah
            $r->sosialEkonomi->statusDtks->status_dtks ?? '-',
            $r->sosialEkonomi->jumlahKK->jumlah_kk ?? '-',
            $r->sosialEkonomi->jenisKelamin->jenis_kelamin ?? '-',
            $r->sosialEkonomi->usia ?? '-',
            $r->sosialEkonomi->pendidikanTerakhir->pendidikan_terakhir ?? '-',
            $r->sosialEkonomi->pekerjaanUtama->pekerjaan_utama ?? '-',
            $r->sosialEkonomi->besarPenghasilan->besar_penghasilan ?? '-',
            $r->sosialEkonomi->besarPengeluaran->besar_pengeluaran ?? '-',
        ];
    }

    /**
     * HEADER BARIS 5
     */
    public function headings(): array
    {
        return [
            'ID Rumah', 'Alamat', 'Latitude', 'Longitude', 'RT', 'RW',
            'Kelurahan', 'Kecamatan',

            'Status DTKS', 'Jumlah KK', 'Jenis Kelamin', 'Usia',
            'Pendidikan Terakhir', 'Pekerjaan Utama',
            'Penghasilan', 'Pengeluaran'
        ];
    }

    /**
     * Judul Sheet
     */
    public function title(): string
    {
        return 'Lokasi & Penghuni';
    }

    /**
     * Chunk size
     */
    public function chunkSize(): int
    {
        return 1000;
    }

    /**
     * HEADER GROUP, LOGO, STYLE
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {

                $s = $event->sheet->getDelegate();

                // Tambah row kosong
                $s->insertNewRowBefore(1, 4);

                // Logo
                $logo = public_path('assets/media/logos/logo.png');
                if (file_exists($logo)) {
                    $drawing = new Drawing();
                    $drawing->setPath($logo);
                    $drawing->setCoordinates('B1');
                    $drawing->setHeight(60);
                    $drawing->setWorksheet($s);
                }

                // Title 1
                $s->mergeCells('C1:P1');
                $s->setCellValue('C1', 'DINAS PERUMAHAN DAN KAWASAN PERMUKIMAN');
                $s->getStyle('C1')->getFont()->setBold(true)->setSize(20);
                $s->getStyle('C1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // Title 2
                $s->mergeCells('C2:P2');
                $s->setCellValue('C2', 'KOTA BUKITTINGGI');
                $s->getStyle('C2')->getFont()->setBold(true)->setSize(18);
                $s->getStyle('C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                /**
                 * GROUPING HEADER (Baris 4)
                 */
                $s->setCellValue('A4', 'Lokasi Rumah');
                $s->mergeCells('A4:H4');

                $s->setCellValue('I4', 'Penghuni Rumah');
                $s->mergeCells('I4:P4');

                // Style grup
                $s->getStyle('A4:P4')->applyFromArray([
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

                // Style kolom headings
                $s->getStyle('A5:P5')->applyFromArray([
                    'font' => ['bold' => true],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                        'wrapText' => true
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN
                        ]
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
