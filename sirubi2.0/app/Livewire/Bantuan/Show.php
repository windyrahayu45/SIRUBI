<?php

namespace App\Livewire\Bantuan;

use App\Models\Rumah;
use App\Models\TblBantuan;
use App\Models\KepalaKeluarga;
use Livewire\Component;

class Show extends Component
{
    public $rumah;
    public $namaPemilik = '-';
    public $bantuanRiwayat = [];

    public function mount($id)
    {
        // 🔹 Cari kepala keluarga berdasarkan KK
        $kepala = KepalaKeluarga::with(['rumah', 'anggota'])
            ->where('no_kk', $id)
            ->first();
           

        // Jika tidak ada rumah → handle gracefully
        if (!$kepala || !$kepala->rumah) {
            $this->rumah = null;
            $this->bantuanRiwayat = TblBantuan::where('kk', $id)->get();
            $this->namaPemilik = $kepala?->anggota?->sortBy('id')->first()?->nama ?? '-';
            return;
        }

        // 🔥 Dapatkan Rumah ID
        $rumahId = $kepala->rumah_id;

        // 🔥 Ambil data rumah lengkap seperti contohmu
        $this->rumah = Rumah::with([
            'kepemilikan',
            'sosialEkonomi',
            'fisik',
            'sanitasi',
            'penilaian',
            'dokumen',
            'bantuan',
            'kepalaKeluarga.anggota',
            'kelurahan.kecamatan'
        ])->find($rumahId);

        // 🔹 Ambil semua no_kk untuk rumah ini
        $noKkList = $this->rumah->kepalaKeluarga->pluck('no_kk')->filter()->toArray();

        // 🔥 Ambil seluruh riwayat bantuan berdasarkan daftar KK
        $this->bantuanRiwayat = TblBantuan::with('dokumen')->whereIn('kk', $noKkList)
            ->orderBy('tahun', 'desc')
            ->get();

        // 🔹 Ambil nama pemilik rumah (anggota pertama KK pertama)
        $kepalaUtama = $this->rumah->kepalaKeluarga?->sortBy('id')->first();
        $anggotaPertama = $kepalaUtama?->anggota?->sortBy('id')->first();

        $this->namaPemilik = $anggotaPertama?->nama ?? '-';
    }


    public function render()
    {
        return view('livewire.bantuan.show')
            ->extends('layouts.master')
            ->section('content');
    }
}
