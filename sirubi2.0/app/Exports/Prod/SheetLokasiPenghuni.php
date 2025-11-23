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

class SheetLokasiPenghuni implements
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
     *         FAST MODE – SINGLE HEAVY QUERY
     * ===========================================
     */
    public function query()
    {
        return DB::table('rumah AS r')
            ->select([
                'r.id_rumah',
                'r.alamat',
                'r.latitude',
                'r.longitude',
                'r.rt',
                'r.rw',
                'k.nama_kelurahan',
                'kc.nama_kecamatan',

                // Sosial Ekonomi
                's.status_dtks_id',
                's.jumlah_kk_id',
                's.jenis_kelamin_id',
                's.usia',
                's.pendidikan_terakhir_id',
                's.pekerjaan_utama_id',
                's.besar_penghasilan_perbulan_id',
                's.besar_pengeluaran_perbulan_id',
            ])
            ->leftJoin('i_kelurahan AS k', 'k.id_kelurahan', '=', 'r.kelurahan_id')
            ->leftJoin('i_kecamatan AS kc', 'kc.id_kecamatan', '=', 'k.kecamatan_id')
            ->leftJoin('sosial_ekonomi_rumah AS s', 's.rumah_id', '=', 'r.id_rumah')
            ->when(!empty($this->rumahIds), fn($q) =>
                $q->whereIn('r.id_rumah', $this->rumahIds)
            )
            ->orderBy('r.id_rumah', 'asc');
    }

    /**
     * ===========================================
     *      FAST LOOKUP – CACHE TABLE REFERENSI
     * ===========================================
     */
    public function map($r): array
    {
        static $ref = null;

        if (!$ref) {
            $ref = [
                'dtks'         => DB::table('c_status_dtks')->pluck('status_dtks', 'id_status_dtks'),
                'jumlah_kk'    => DB::table('i_jumlah_kk')->pluck('jumlah_kk', 'id_jumlah_kk'),
                'jk'           => DB::table('i_jenis_kelamin')->pluck('jenis_kelamin', 'id_jenis_kelamin'),
                'pendidikan'   => DB::table('i_pendidikan_terakhir')->pluck('pendidikan_terakhir', 'id_pendidikan_terakhir'),
                'pekerjaan'    => DB::table('i_pekerjaan_utama')->pluck('pekerjaan_utama', 'id_pekerjaan_utama'),
                'penghasilan'  => DB::table('i_besar_penghasilan')->pluck('besar_penghasilan', 'id_besar_penghasilan'),
                'pengeluaran'  => DB::table('i_besar_pengeluaran')->pluck('besar_pengeluaran', 'id_besar_pengeluaran'),
            ];
        }

        return [
            // Lokasi
            $r->id_rumah,
            $r->alamat,
            $r->latitude,
            $r->longitude,
            $r->rt,
            $r->rw,
            $r->nama_kelurahan ?? '-',
            $r->nama_kecamatan ?? '-',

            // Penghuni
            $ref['dtks'][$r->status_dtks_id]         ?? '-',
            $ref['jumlah_kk'][$r->jumlah_kk_id]      ?? '-',
            $ref['jk'][$r->jenis_kelamin_id]         ?? '-',
            $r->usia ?? '-',
            $ref['pendidikan'][$r->pendidikan_terakhir_id] ?? '-',
            $ref['pekerjaan'][$r->pekerjaan_utama_id] ?? '-',
            $ref['penghasilan'][$r->besar_penghasilan_perbulan_id] ?? '-',
            $ref['pengeluaran'][$r->besar_pengeluaran_perbulan_id] ?? '-',
        ];
    }

    /**
     * HEADER KOLUMNYA
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

    public function title(): string
    {
        return 'Lokasi & Penghuni';
    }

    public function chunkSize(): int
    {
        return 1000; // aman untuk 30.000 data
    }

    /**
     * HEADER LOGO & GROUP
     */
    // public function registerEvents(): array
    // {
    //     return [
    //         AfterSheet::class => function (AfterSheet $event) {

    //             $s = $event->sheet->getDelegate();
    //             $s->insertNewRowBefore(1, 4);

    //             // Logo
    //             $logoPath = public_path('assets/media/logos/logo.png');
    //             if (file_exists($logoPath)) {
    //                 $drawing = new Drawing();
    //                 $drawing->setPath($logoPath);
    //                 $drawing->setCoordinates('B1');
    //                 $drawing->setHeight(55);
    //                 $drawing->setWorksheet($s);
    //             }

    //             // Title
    //             $s->mergeCells('C1:P1');
    //             $s->setCellValue('C1', 'DINAS PERUMAHAN DAN KAWASAN PERMUKIMAN');
    //             $s->getStyle('C1')->getFont()->setBold(true)->setSize(20);
    //             $s->getStyle('C1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    //             $s->mergeCells('C2:P2');
    //             $s->setCellValue('C2', 'KOTA BUKITTINGGI');
    //             $s->getStyle('C2')->getFont()->setBold(true)->setSize(18);
    //             $s->getStyle('C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    //             // Group header
    //             $s->mergeCells('A4:H4');
    //             $s->setCellValue('A4', 'Lokasi Rumah');

    //             $s->mergeCells('I4:P4');
    //             $s->setCellValue('I4', 'Penghuni Rumah');

    //             $s->getStyle('A4:P4')->applyFromArray([
    //                 'font' => ['bold' => true],
    //                 'alignment' => [
    //                     'horizontal' => Alignment::HORIZONTAL_CENTER,
    //                     'vertical'   => Alignment::VERTICAL_CENTER
    //                 ],
    //                 'fill' => [
    //                     'fillType' => 'solid',
    //                     'color'    => ['rgb' => 'E2EFDA']
    //                 ]
    //             ]);

    //             // Headings style
    //             $s->getStyle('A5:P5')->applyFromArray([
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
