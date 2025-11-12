<?php

namespace App\Livewire;

use App\Models\DokumenRumah;
use App\Models\IKecamatan;
use App\Models\IKelurahan;
use App\Models\Rumah;
use App\Models\TblJenisPolygon;
use App\Models\TblPolygonKelurahan;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Peta extends Component
{
    public $data = [];

    public function mount()
    {
        $this->loadData();
    }

    // public function loadData()
    // {
    //      // --- Rumah (marker)
    //     $rumah = collect();

    //     Rumah::select([
    //             'id_rumah',
    //             'alamat',
    //             'latitude',
    //             'longitude',
    //             'kelurahan_id',
    //             'tahun_pembangunan_rumah'
    //         ])
    //         ->with([
    //             'penilaian:id,rumah_id,nilai,status_rumah,prioritas_a,prioritas_b,prioritas_c',
    //             // 'kepalaKeluarga' => function ($q) {
    //             //     // Ambil hanya KK dengan kode_kk = 'A'
    //             //     $q->where('kode_kk', 'A')->orderBy('id');
    //             // },
    //             // 'kepalaKeluarga.anggota' => function ($q) {
    //             //     // Ambil hanya anggota dengan kode_anggota = 'AA'
    //             //     $q->select('id', 'kepala_keluarga_id', 'nama', 'kode_anggota')
    //             //     ->where('kode_anggota', 'AA')
    //             //     ->orderBy('id');
    //             // },
    //             'kelurahan:id_kelurahan,nama_kelurahan,kecamatan_id',
    //             'kelurahan.kecamatan:id_kecamatan,nama_kecamatan',
    //             'dokumen:rumah_id,foto_rumah_satu'
    //         ])
    //         ->whereNotNull('latitude')
    //         ->whereNotNull('longitude')
    //         ->chunk(1000, function ($chunk) use (&$rumah) {
    //             $filtered = $chunk
    //                 ->filter(fn($r) => is_numeric($r->latitude) && is_numeric($r->longitude))
    //                 ->map(function ($r) {
    //                     // Ambil KK dengan kode_kk = 'A'
    //                     $kk = $r->kepalaKeluarga?->first();

    //                     // Ambil anggota dengan kode_anggota = 'AA'
    //                     $anggota = $kk?->anggota?->first();

    //                     // Tambahkan ke model
    //                     $r->nama_kk = $anggota?->nama ?? '-';
    //                     $r->status_rumah = $r->penilaian->status_rumah ?? '-';
    //                     $r->prioritas_a = $r->penilaian->prioritas_a ?? null;
    //                     $r->prioritas_b = $r->penilaian->prioritas_b ?? null;
    //                     $r->prioritas_c = $r->penilaian->prioritas_c ?? null;
    //                     $r->nama_kelurahan = $r->kelurahan?->nama_kelurahan ?? '-';
    //                     $r->nama_kecamatan = $r->kelurahan?->kecamatan?->nama_kecamatan ?? '-';

    //                     // Foto
    //                     $r->foto_url = $r->dokumen?->foto_rumah_satu
    //                         ? asset('storage/' . $r->dokumen->foto_rumah_satu)
    //                         : asset('images/no_photo.jpg');

    //                     return $r;
    //                 });

    //             $rumah = $rumah->concat($filtered);
    //         });


    //     // --- Polygon Kelurahan (tiap kecamatan)
    //     $polygon_kelurahan = TblPolygonKelurahan::with(['kelurahan.kecamatan'])
    //         ->get()
    //         ->map(function ($p) {
    //             return [
    //                 'id' => $p->id_polygon,
    //                 'polygon' => $p->polygon,
    //                 'nama_kecamatan' => $p->kelurahan?->kecamatan?->nama_kecamatan,
    //                 'nama_kelurahan' => $p->kelurahan?->nama_kelurahan,
    //                 'luas' => $p->luas,
    //                 'keterangan' => $p->keterangan,
    //                 'warna' => $p->warna ?? '#ffff00'
    //             ];
    //         });

    //     // --- Polygon Kawasan (kumuh, permukiman, rawan bencana)
    //     $polygon_kawasan = TblJenisPolygon::with('polygons')
    //         ->get()
    //         ->map(function ($jenis) {
    //             return [
    //                 'jenis' => $jenis->jenis_polygon,
    //                 'color' => match ($jenis->jenis_polygon) {
    //                     'Kawasan Kumuh' => 'purple',
    //                     'Kawasan Permukiman' => 'green',
    //                     'Kawasan Rawan Bencana' => 'black',
    //                     default => 'gray'
    //                 },
    //                 'data' => $jenis->polygons->map(fn($p) => [
    //                     'id_polygon' => $p->id_polygon,
    //                     'nama_kawasan' => $p->nama_kawasan ?? $jenis->jenis_polygon,
    //                     'jenis_polygon' => $jenis->jenis_polygon,
    //                     'luas' => $p->luas,
    //                     'keterangan' => $p->keterangan,
    //                     'polygon' => $p->polygon,
    //                 ])
    //             ];
    //         });

    //     $this->dispatch('initMap', [
    //         'rumah' => $rumah->values(),
    //         'polygon_kelurahan' => $polygon_kelurahan->toArray(),
    //         'polygon_kawasan' => $polygon_kawasan->toArray(),
    //     ]);
    // }

    public function loadData()
    {
        // --- Helper untuk ambil 1 KK dan 1 anggota saja
        $formatRumah = function ($r) {
            $kk = $r->kepalaKeluarga?->where('kode_kk', 'A')->first();
            $anggota = $kk?->anggota?->where('kode_anggota', 'aa')->first();

            return [
                'id_rumah'        => $r->id_rumah,
                'nama_kk'         => $anggota?->nama ?? '-',
                'status_rumah'    => $r->penilaian->status_rumah ?? '-',
                'prioritas_a'     => $r->penilaian->prioritas_a ?? null,
                'prioritas_b'     => $r->penilaian->prioritas_b ?? null,
                'prioritas_c'     => $r->penilaian->prioritas_c ?? null,
                'nama_kelurahan'  => $r->kelurahan?->nama_kelurahan ?? '-',
                'nama_kecamatan'  => $r->kelurahan?->kecamatan?->nama_kecamatan ?? '-',
                'latitude'        => floatval($r->latitude),
                'longitude'       => floatval($r->longitude),
                'foto_url'        => $r->dokumen?->foto_rumah_satu
                                    ? asset('storage/' . $r->dokumen->foto_rumah_satu)
                                    : asset('images/no_photo.jpg'),
            ];
        };

        // --- Template query dasar
        $baseQuery = Rumah::select([
                'id_rumah',
                'alamat',
                'latitude',
                'longitude',
                'kelurahan_id',
                'tahun_pembangunan_rumah'
            ])
            ->with([
                'penilaian:id,rumah_id,prioritas_a,prioritas_b,prioritas_c,status_rumah',
                'kepalaKeluarga.anggota:id,kepala_keluarga_id,nama,kode_anggota',
                'kelurahan:id_kelurahan,nama_kelurahan,kecamatan_id',
                'kelurahan.kecamatan:id_kecamatan,nama_kecamatan',
                'dokumen:rumah_id,foto_rumah_satu'
            ])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude');

        // --- Ambil SP1, SP2, SP3 seperti logika CI
        $sp_1 = (clone $baseQuery)
            ->whereHas('penilaian', fn($q) => $q->where('prioritas_a', 2))
            ->get()
            ->map($formatRumah);

        $sp_2 = (clone $baseQuery)
            ->whereHas('penilaian', fn($q) => $q
                ->where('prioritas_a', 1)
                ->where('prioritas_b', 2))
            ->get()
            ->map($formatRumah);

        $sp_3 = (clone $baseQuery)
            ->whereHas('penilaian', fn($q) => $q
                ->where('prioritas_a', 1)
                ->where('prioritas_b', 1)
                ->where('prioritas_c', 2))
            ->get()
            ->map($formatRumah);

        // --- Polygon Kelurahan
        $polygon_kelurahan = TblPolygonKelurahan::with(['kelurahan.kecamatan'])
            ->get()
            ->map(fn($p) => [
                'id' => $p->id_polygon,
                'polygon' => $p->polygon,
                'nama_kecamatan' => $p->kelurahan?->kecamatan?->nama_kecamatan,
                'nama_kelurahan' => $p->kelurahan?->nama_kelurahan,
                'luas' => $p->luas,
                'keterangan' => $p->keterangan,
                'warna' => $p->warna ?? '#ffff00'
            ]);

        // --- Polygon Kawasan
        $polygon_kawasan = TblJenisPolygon::with('polygons')
            ->get()
            ->map(fn($jenis) => [
                'jenis' => $jenis->jenis_polygon,
                'color' => match ($jenis->jenis_polygon) {
                    'Kawasan Kumuh' => 'purple',
                    'Kawasan Permukiman' => 'green',
                    'Kawasan Rawan Bencana' => 'black',
                    default => 'gray'
                },
                'data' => $jenis->polygons->map(fn($p) => [
                    'id_polygon' => $p->id_polygon,
                    'nama_kawasan' => $p->nama_kawasan ?? $jenis->jenis_polygon,
                    'jenis_polygon' => $jenis->jenis_polygon,
                    'luas' => $p->luas,
                    'keterangan' => $p->keterangan,
                    'polygon' => $p->polygon,
                ])
            ]);

        // --- Kirim ke JS
        $this->dispatch('initMap', [
            'rumah' => [
                'sp_1' => $sp_1->values(),
                'sp_2' => $sp_2->values(),
                'sp_3' => $sp_3->values(),
            ],
            'polygon_kelurahan' => $polygon_kelurahan->toArray(),
            'polygon_kawasan' => $polygon_kawasan->toArray(),
        ]);
    }


    
    public function render()
    {
        return view('livewire.peta')
            ->extends('layouts.master')
            ->section('content');
    }
}
