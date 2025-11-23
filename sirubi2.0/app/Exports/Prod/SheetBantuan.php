<?php

namespace App\Exports\Prod;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SheetBantuan implements
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
     * QUERY UTAMA — FAST MODE
     */
    public function query()
    {
        return DB::table('rumah')
            ->select('id_rumah', 'alamat', 'kelurahan_id')
            ->when(!empty($this->rumahIds), fn($q) =>
                $q->whereIn('id_rumah', $this->rumahIds)
            )
            ->orderBy('id_rumah');
    }

    /**
     * MAP PER-RUMAH — MULTI ROW RETURN
     */
    public function map($r): array
    {
        // -------------------------
        // KECAMATAN & KELURAHAN
        // -------------------------
        $kel = DB::table('i_kelurahan')
            ->select('nama_kelurahan', 'kecamatan_id')
            ->where('id_kelurahan', $r->kelurahan_id)
            ->first();

        $kec = $kel
            ? DB::table('i_kecamatan')
                ->where('id_kecamatan', $kel->kecamatan_id)
                ->value('nama_kecamatan')
            : '-';

        // -------------------------
        // DAFTAR KK
        // -------------------------
        $kkList = DB::table('kepala_keluarga')
            ->where('rumah_id', $r->id_rumah)
            ->pluck('no_kk')
            ->filter()
            ->toArray();

        $noKK = $kkList[0] ?? '-';
        if (is_string($noKK) && stripos($noKK, 'DUMMY') !== false) {
            $noKK = '-';
        }

        $rows = [];

        // -------------------------
        // 1️⃣ BANTUAN RUMAH UTAMA
        // -------------------------
        $bantuRumah = DB::table('bantuan_rumah')
            ->where('rumah_id', $r->id_rumah)
            ->first();

        if ($bantuRumah) {
            $rows[] = [
                'Bantuan Rumah',
                $r->id_rumah,
                $r->alamat,
                $kec ?? '-',
                $kel->nama_kelurahan ?? '-',
                $bantuRumah->no_kk_penerima ?? $noKK,
                $bantuRumah->nama_program_bantuan ?? '-',
                $bantuRumah->nama_bantuan ?? '-',
                $bantuRumah->tahun_bantuan ?? '-',
                $bantuRumah->nominal_bantuan ?? '-',
                $bantuRumah->pernah_mendapatkan ?? '-',
            ];
        }

        // -------------------------
        // 2️⃣ RIWAYAT TBL BANTUAN (KK)
        // -------------------------
        if (!empty($kkList)) {
            $riwayat = DB::table('tbl_bantuan')
                ->whereIn('kk', $kkList)
                ->orderBy('tahun', 'desc')
                ->get();

            foreach ($riwayat as $r2) {
                $rows[] = [
                    'Riwayat Bantuan KK',
                    $r->id_rumah,
                    $r->alamat,
                    $kec ?? '-',
                    $kel->nama_kelurahan ?? '-',
                    $r2->kk ?? $noKK,
                    $r2->nama_program ?? '-',
                    $r2->nama ?? '-',
                    $r2->tahun ?? '-',
                    $r2->nominal ?? '-',
                    '-',
                ];
            }
        }

        // -------------------------
        // 3️⃣ JIKA BENAR-BENAR TIDAK ADA DATA
        // -------------------------
        if (empty($rows)) {
            $rows[] = [
                'Kosong',
                $r->id_rumah,
                $r->alamat,
                $kec ?? '-',
                $kel->nama_kelurahan ?? '-',
                $noKK,
                '-','-','-','-','-'
            ];
        }

        // ⚠️ PENTING:
        // Karena Multi-Row mapping tidak didukung nativelly,
        // kita return satu row dulu → sisanya dipush oleh Excel Concerns
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
        return 'Bantuan';
    }

    public function chunkSize(): int
    {
        return 800; // aman & cepat
    }
}
