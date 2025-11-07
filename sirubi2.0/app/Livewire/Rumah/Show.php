<?php

namespace App\Livewire\Rumah;

use App\Models\Rumah;
use App\Models\TblBantuan;
use Livewire\Component;

class Show extends Component
{
    public $rumah;
    public $bantuanRiwayat = [];

    public function mount($id)
    {
        $this->rumah = Rumah::with([
            'kepemilikan',          // untuk status rumah
            'sosialEkonomi',        // untuk status backlog
            'fisik',
            'sanitasi',
            'penilaian',
            'dokumen',
            'bantuan',
            'kepalaKeluarga.anggota',
            'kelurahan.kecamatan'
        ])->findOrFail($id);


         // 🔹 Ambil semua no_kk dari kepala keluarga rumah ini
        $noKkList = $this->rumah->kepalaKeluarga->pluck('no_kk')->filter()->toArray();

        // 🔹 Ambil semua data bantuan berdasarkan daftar no_kk tersebut
        $this->bantuanRiwayat = TblBantuan::whereIn('kk', $noKkList)
            ->orderBy('tahun', 'desc')
            ->get();
    }

    public function render()
    {
        return view('livewire.rumah.show')
            ->extends('layouts.master')
            ->section('content');
    }
}
