<?php

namespace App\Services;

use App\Models\Rumah;

class Rekap1Builder
{
    public static function build($kecamatanId)
    {
        // Ambil seluruh data rumah + relasi
        $rumah = Rumah::with([
                'kelurahan:id_kelurahan,nama_kelurahan',
                'penilaian',
                'fisik',
                'sosialEkonomi'
            ])
            ->where('kecamatan_id', $kecamatanId)
            ->whereNotNull('kelurahan_id')
            ->get();

        if ($rumah->isEmpty()) {
            return collect([]);
        }

        // Grup per kelurahan lalu hitung semua nilai
        return $rumah->groupBy('kelurahan.nama_kelurahan')
            ->map(function ($items, $kel) {
                return [
                    'nama_kelurahan' => $kel,

                    // Jumlah rumah
                    'jumlah_rumah' => $items->count(),

                    // Jumlah KK
                    'jumlah_kk' => $items->sum(
                        fn($r) => data_get($r, 'sosialEkonomi.jumlah_kk_id', 0)
                    ),

                    // Penghuni laki-laki
                    'penghuni_laki' => $items->sum(
                        fn($r) => data_get($r, 'fisik.jumlah_penghuni_laki', 0)
                    ),

                    // Penghuni perempuan
                    'penghuni_perempuan' => $items->sum(
                        fn($r) => data_get($r, 'fisik.jumlah_penghuni_perempuan', 0)
                    ),

                    // Status RLH / RTLH
                    'rlh'  => $items->where(fn($r) =>
                        data_get($r, 'penilaian.status_rumah') === 'RLH'
                    )->count(),

                    'rtlh' => $items->where(fn($r) =>
                        data_get($r, 'penilaian.status_rumah') === 'RTLH'
                    )->count(),

                    // Prioritas A
                    'prioritas_a1' => $items->where(
                        fn($r) => data_get($r, 'penilaian.prioritas_a') == 1
                    )->count(),

                    'prioritas_a2' => $items->where(
                        fn($r) => data_get($r, 'penilaian.prioritas_a') == 2
                    )->count(),

                    // Prioritas B
                    'prioritas_b1' => $items->where(
                        fn($r) => data_get($r, 'penilaian.prioritas_b') == 1
                    )->count(),

                    'prioritas_b2' => $items->where(
                        fn($r) => data_get($r, 'penilaian.prioritas_b') == 2
                    )->count(),

                    // Prioritas C
                    'prioritas_c1' => $items->where(
                        fn($r) => data_get($r, 'penilaian.prioritas_c') == 1
                    )->count(),

                    'prioritas_c2' => $items->where(
                        fn($r) => data_get($r, 'penilaian.prioritas_c') == 2
                    )->count(),

                    // KK lebih dari 1
                    'kk_lebih_1' => $items->where(
                        fn($r) => data_get($r, 'sosialEkonomi.jumlah_kk_id', 0) > 1
                    )->count(),

                    // KK = 1
                    'kk_1' => $items->where(
                        fn($r) => data_get($r, 'sosialEkonomi.jumlah_kk_id', 0) == 1
                    )->count(),
                ];
            })
            ->values(); // Biar indeks rapi
    }
}
