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

class SheetIdentitasRumah implements
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
     * FAST MODE QUERY — tanpa Eloquent
     */
    public function query()
    {
        return DB::table('rumah')
            ->select('id_rumah', 'tahun_pembangunan_rumah', 'kelurahan_id')
            ->when(!empty($this->rumahIds), fn($q) =>
                $q->whereIn('id_rumah', $this->rumahIds)
            )
            ->orderBy('id_rumah');
    }

    /**
     * FAST MAP (NON-ELOQUENT)
     */
    public function map($r): array
    {
        // =====================================================
        // 🔹 1. Ambil Kepemilikan Rumah
        // =====================================================
        $kep = DB::table('kepemilikan_rumah')
            ->where('rumah_id', $r->id_rumah)
            ->select(
                'status_kepemilikan_tanah_id',
                'bukti_kepemilikan_tanah_id',
                'status_kepemilikan_rumah_id',
                'status_imb_id',
                'nomor_imb',
                'aset_rumah_ditempat_lain_id',
                'aset_tanah_ditempat_lain_id',
                'jenis_kawasan_lokasi_rumah_id',
                'nik_kepemilikan_rumah'
            )
            ->first();

        // Jika tidak ada data
        if (!$kep) {
            $kep = (object)[];
        }

        // =====================================================
        // 🔹 2. Ambil relasi-referensi (FAST)
        // =====================================================
        $ref = fn($table, $idColumn, $nameColumn, $id) =>
            $id ? DB::table($table)->where($idColumn, $id)->value($nameColumn) : '-';

        $statusTanah = $ref('i_status_kepemilikan_tanah', 'id_status_kepemilikan_tanah', 'status_kepemilikan_tanah', $kep->status_kepemilikan_tanah_id ?? null);
        $buktiTanah  = $ref('i_bukti_kepemilikan_tanah', 'id_bukti_kepemilikan_tanah', 'bukti_kepemilikan_tanah', $kep->bukti_kepemilikan_tanah_id ?? null);
        $statusRumah = $ref('i_status_kepemilikan_rumah', 'id_status_kepemilikan_rumah', 'status_kepemilikan_rumah', $kep->status_kepemilikan_rumah_id ?? null);
        $statusImb   = $ref('i_status_imb', 'id_status_imb', 'status_imb', $kep->status_imb_id ?? null);
        $asetRumahTL = $ref('i_aset_rumah_tempat_lain', 'id_aset_rumah_tempat_lain', 'aset_rumah_tempat_lain', $kep->aset_rumah_ditempat_lain_id ?? null);
        $asetTanahTL = $ref('i_aset_tanah_tempat_lain', 'id_aset_tanah_tempat_lain', 'aset_tanah_tempat_lain', $kep->aset_tanah_ditempat_lain_id ?? null);
        $jenisKws    = $ref('i_jenis_kawasan_lokasi', 'id_jenis_kawasan_lokasi', 'jenis_kawasan_lokasi', $kep->jenis_kawasan_lokasi_rumah_id ?? null);

        // =====================================================
        // 🔹 3. Dokumentasi
        // =====================================================
        $doc = DB::table('dokumen_rumah')
            ->where('rumah_id', $r->id_rumah)
            ->select('foto_rumah_satu', 'foto_rumah_dua', 'foto_rumah_tiga', 'foto_ktp', 'foto_kk', 'foto_imb')
            ->first();

        $url = fn($file) => $file ? asset('storage/' . $file) : '-';

        // =====================================================
        // 🔹 RETURN MAP
        // =====================================================
        return [
            $r->id_rumah,

            $statusTanah,
            $buktiTanah,
            $statusRumah,
            $statusImb,
            $kep->nomor_imb ?? '-',
            $asetRumahTL,
            $asetTanahTL,
            $jenisKws,
            $kep->nik_kepemilikan_rumah ?? '-',
            $r->tahun_pembangunan_rumah ?? '-',


            // FOTO full URL
            $url($doc->foto_rumah_satu ?? null),
            $url($doc->foto_rumah_dua ?? null),
            $url($doc->foto_rumah_tiga ?? null),
            $url($doc->foto_ktp ?? null),
            $url($doc->foto_kk ?? null),
            $url($doc->foto_imb ?? null),
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
        return 800;
    }

    /**
     * HEADER + LOGO
     */
}
