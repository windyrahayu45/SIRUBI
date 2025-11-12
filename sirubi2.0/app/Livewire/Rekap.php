<?php

namespace App\Livewire;

use App\Models\Rumah;
use Livewire\Component;

class Rekap extends Component
{
   public $kecamatanId;
    public $kecamatanNama;
    public $rekap1;
    public $rekap1Sum;

    public function mount()
    {
        $this->kecamatanId = request()->get('kecamatan_id');
        if ($this->kecamatanId) {
            $this->loadData();
        }
    }

    public function loadData()
    {
        // 🔹 Ambil nama kecamatan
        $this->kecamatanNama = Rumah::where('kecamatan_id', $this->kecamatanId)
            ->with('kecamatan:id_kecamatan,nama_kecamatan')
            ->first()?->kecamatan?->nama_kecamatan;

        // 🔹 Data agregat per kelurahan
        $rumah = Rumah::with(['kelurahan:id_kelurahan,nama_kelurahan', 'penilaian', 'fisik', 'sosialEkonomi'])
            ->where('kecamatan_id', $this->kecamatanId)
            ->whereNotNull('kelurahan_id')
            ->get();

       $this->rekap1 = $rumah->groupBy('kelurahan.nama_kelurahan')->map(function ($items, $kel) {
            return [
                'nama_kelurahan' => $kel,
                'jumlah_rumah' => $items->count(),
                'jumlah_kk' => $items->sum(fn($r) => data_get($r, 'sosialEkonomi.jumlah_kk_id', 0)),
                'penghuni_laki' => $items->sum(fn($r) => data_get($r, 'fisik.jumlah_penghuni_laki', 0)),
                'penghuni_perempuan' => $items->sum(fn($r) => data_get($r, 'fisik.jumlah_penghuni_perempuan', 0)),
                'rlh' => $items->where(fn($r) => data_get($r, 'penilaian.status_rumah') === 'RLH')->count(),
                'rtlh' => $items->where(fn($r) => data_get($r, 'penilaian.status_rumah') === 'RTLH')->count(),
                'prioritas_a1' => $items->where(fn($r) => data_get($r, 'penilaian.prioritas_a') == 1)->count(),
                'prioritas_a2' => $items->where(fn($r) => data_get($r, 'penilaian.prioritas_a') == 2)->count(),
                'prioritas_b1' => $items->where(fn($r) => data_get($r, 'penilaian.prioritas_b') == 1)->count(),
                'prioritas_b2' => $items->where(fn($r) => data_get($r, 'penilaian.prioritas_b') == 2)->count(),
                'prioritas_c1' => $items->where(fn($r) => data_get($r, 'penilaian.prioritas_c') == 1)->count(),
                'prioritas_c2' => $items->where(fn($r) => data_get($r, 'penilaian.prioritas_c') == 2)->count(),
                'kk_lebih_1' => $items->where(fn($r) => data_get($r, 'sosialEkonomi.jumlah_kk_id', 0) > 1)->count(),
                'kk_1' => $items->where(fn($r) => data_get($r, 'sosialEkonomi.jumlah_kk_id', 0) == 1)->count(),
            ];
        });


        // 🔹 Total keseluruhan (SUM)
        // $this->rekap1Sum = [
        //     'jumlah_rumah' => $rumah->count(),
        //     'jumlah_kk' => $rumah->sum(fn($r) => $r->sosialEkonomi->jumlah_kk_id ?? 0),
        //     'penghuni_laki' => $rumah->sum(fn($r) => $r->fisik->jumlah_penghuni_laki ?? 0),
        //     'penghuni_perempuan' => $rumah->sum(fn($r) => $r->fisik->jumlah_penghuni_perempuan ?? 0),
        //     'rlh' => $rumah->where('penilaian.status_rumah', 'RLH')->count(),
        //     'rtlh' => $rumah->where('penilaian.status_rumah', 'RTLH')->count(),
        // ];
    }
    

    public function render()
    {
        return view('livewire.rekap')
            ->extends('layouts.master')
            ->section('content');
    }
}
