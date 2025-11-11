<?php

namespace App\Exports;

use App\Models\Rumah;
use App\Models\KepalaKeluarga;
use App\Models\TblBantuan;
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

class BantuanSheet implements FromQuery, WithMapping, WithHeadings, WithTitle, WithChunkReading, ShouldAutoSize, WithEvents
{
    protected $query;

    public function __construct($query = null)
    {
        $this->query = $query;
    }

    /**
     * Query utama
     * Jika $this->query ada → gunakan hasil filter
     * Jika tidak → ambil semua rumah yang pernah mendapat bantuan
     */
    public function query()
    {
        if ($this->query) {
            // Ambil ID rumah hasil filter
            $filteredIds = $this->query->pluck('id_rumah')->toArray();

            return Rumah::with([
                    'kelurahan.kecamatan',
                    'bantuan.pernahMendapatkanBantuan',
                    'kepalaKeluarga.anggota',
                ])
                ->whereIn('id_rumah', $filteredIds)
                ->whereHas('bantuan', fn($q) =>
                    $q->where('pernah_mendapatkan_bantuan_id', 1)
                )
                ->orderBy('id_rumah', 'asc');
        }

        // 🟢 Default: tanpa filter, ambil semua rumah yang punya bantuan
        return Rumah::with([
                'kelurahan.kecamatan',
                'bantuan.pernahMendapatkanBantuan',
                'kepalaKeluarga.anggota',
            ])
            ->whereHas('bantuan', fn($q) =>
                $q->where('pernah_mendapatkan_bantuan_id', 1)
            )
            ->orderBy('id_rumah', 'asc');
    }

    /**
     * Mapping setiap rumah
     */
    public function map($rumah): array
    {
        $rows = [];

        // 🔹 Ambil semua KK (sinkron dengan KepalaKeluargaSheet)
        $kkList = $rumah->kepalaKeluarga->pluck('no_kk')->filter()->toArray();

         $noKK = $kkList[0] ?? '-';

        // Jika no_kk mengandung kata "DUMMY" (case-insensitive), ubah jadi "-"
        if (is_string($noKK) && stripos($noKK, 'DUMMY') !== false) {
            $noKK = '-';
        }

        // 🔹 Data bantuan utama rumah
        if ($rumah->bantuan) {

            

            $rows[] = [
                'Tipe Data' => 'Bantuan Utama Rumah',
                'ID Rumah' => $rumah->id_rumah ?? '-',
                'Alamat' => $rumah->alamat ?? '-',
                'Kecamatan' => $rumah->kelurahan->kecamatan->nama_kecamatan ?? '-',
                'Kelurahan' => $rumah->kelurahan->nama_kelurahan ?? '-',
                'No KK Penerima' => $rumah->bantuan->no_kk_penerima ?? ($noKK ?? '-'),
                'Nama Program Bantuan' => $rumah->bantuan->nama_program_bantuan ?? '-',
                'Nama Bantuan' => $rumah->bantuan->nama_bantuan ?? '-',
                'Tahun Bantuan' => $rumah->bantuan->tahun_bantuan ?? '-',
                'Nominal Bantuan (Rp)' => $rumah->bantuan->nominal_bantuan
                    ? number_format($rumah->bantuan->nominal_bantuan, 0, ',', '.')
                    : '-',
                'Pernah Mendapatkan Bantuan' =>
                    $rumah->bantuan->pernahMendapatkanBantuan->pernah_mendapatkan_bantuan ?? '-',
            ];
        }

        // 🔹 Tambahkan riwayat lain dari TblBantuan berdasarkan semua KK di rumah tersebut
        if (!empty($kkList)) {
            $bantuanRiwayat = TblBantuan::whereIn('kk', $kkList)
                ->orderBy('tahun', 'desc')
                ->get();

            foreach ($bantuanRiwayat as $r) {
                $rows[] = [
                    'Tipe Data' => 'Riwayat Bantuan KK',
                    'ID Rumah' => $rumah->id_rumah ?? '-',
                    'Alamat' => $rumah->alamat ?? '-',
                    'Kecamatan' => $rumah->kelurahan->kecamatan->nama_kecamatan ?? '-',
                    'Kelurahan' => $rumah->kelurahan->nama_kelurahan ?? '-',
                    'No KK Penerima' => $r->kk ?? ($noKK[0] ?? '-'),
                    'Nama Program Bantuan' => $r->nama_program ?? '-',
                    'Nama Bantuan' => $r->nama ?? '-',
                    'Tahun Bantuan' => $r->tahun ?? '-',
                    'Nominal Bantuan (Rp)' => $r->nominal
                        ? number_format($r->nominal, 0, ',', '.')
                        : '-',
                    'Pernah Mendapatkan Bantuan' => '-',
                ];
            }
        }

        // 🔹 Jika rumah tidak punya bantuan sama sekali (fallback)
        if (empty($rows)) {
            $rows[] = [
                'Tipe Data' => 'Kosong',
                'ID Rumah' => $rumah->id_rumah ?? '-',
                'Alamat' => $rumah->alamat ?? '-',
                'Kecamatan' => $rumah->kelurahan->kecamatan->nama_kecamatan ?? '-',
                'Kelurahan' => $rumah->kelurahan->nama_kelurahan ?? '-',
                'No KK Penerima' => $kkList[0] ?? '-',
                'Nama Program Bantuan' => '-',
                'Nama Bantuan' => '-',
                'Tahun Bantuan' => '-',
                'Nominal Bantuan (Rp)' => '-',
                'Pernah Mendapatkan Bantuan' => '-',
            ];
        }

        return $rows[0];
    }

    public function headings(): array
    {
        return [
            'Tipe Data',
            'ID Rumah',
            'Alamat',
            'Kecamatan',
            'Kelurahan',
            'No KK Penerima',
            'Nama Program Bantuan',
            'Nama Bantuan',
            'Tahun Bantuan',
            'Nominal Bantuan (Rp)',
            'Pernah Mendapatkan Bantuan',
        ];
    }

    public function title(): string
    {
        return 'Data Rumah & Riwayat Bantuan';
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

                $s->insertNewRowBefore(1, 4);

                $logoPath = public_path('assets/media/logos/logo.png');
                if (file_exists($logoPath)) {
                    $drawing = new Drawing();
                    $drawing->setPath($logoPath);
                    $drawing->setCoordinates('B1');
                    $drawing->setHeight(60);
                    $drawing->setOffsetX(20)->setOffsetY(5);
                    $drawing->setWorksheet($s);
                }

                $s->mergeCells('C1:L1');
                $s->setCellValue('C1', 'DINAS PERUMAHAN DAN KAWASAN PERMUKIMAN');
                $s->getStyle('C1')->getFont()->setBold(true)->setSize(20);
                $s->getStyle('C1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $s->mergeCells('C2:L2');
                $s->setCellValue('C2', 'KOTA BUKITTINGGI');
                $s->getStyle('C2')->getFont()->setBold(true)->setSize(18);
                $s->getStyle('C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                $s->setCellValue('A4', 'Data Rumah yang Pernah Menerima Bantuan dan Riwayat KK');
                $s->mergeCells('A4:K4');
                $s->getStyle('A4:K4')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 12],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'color'    => ['rgb' => 'E2EFDA'],
                    ],
                ]);

                $s->getStyle('A5:K5')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 10],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                        'wrapText'   => true,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color'       => ['rgb' => 'AAAAAA']
                        ]
                    ]
                ]);

                $s->getRowDimension(1)->setRowHeight(40);
                $s->getRowDimension(2)->setRowHeight(30);
                $s->getRowDimension(4)->setRowHeight(25);
                $s->getRowDimension(5)->setRowHeight(22);
            }
        ];
    }
}
