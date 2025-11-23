<?php

namespace App\Livewire\Rumah;

use App\Models\Rumah;
use App\Models\RumahHistory;
use App\Models\TblBantuan;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;

class Show extends Component
{
    public $rumah, $namaPemilik = '';
    public $bantuanRiwayat = [];
    //public $historyByDate = [];

    
       protected $listeners = ['deleteRumah'];

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
        
        // $history = RumahHistory::with('user')
        // ->where('rumah_id', $id)
        // ->orderBy('changed_at', 'desc')
        // ->get();

        // // GROUP LEVEL 1 = tanggal
        // $this->historyByDate = $history->groupBy(function($item){
        //     return $item->changed_at->format('Y-m-d');
        // })->map(function($items){
            
        //     // GROUP LEVEL 2 = user
        //     return $items->groupBy('changed_by');

        // });

       // dd($this->historyByDate);

         // 🔹 Ambil semua no_kk dari kepala keluarga rumah ini
        $noKkList = $this->rumah->kepalaKeluarga->pluck('no_kk')->filter()->toArray();

        // 🔹 Ambil semua data bantuan berdasarkan daftar no_kk tersebut
        $this->bantuanRiwayat = TblBantuan::whereIn('kk', $noKkList)
            ->orderBy('tahun', 'desc')
            ->get();

         $kepala = $this->rumah->kepalaKeluarga?->sortBy('id')->first();

        // Dari kepala keluarga pertama, ambil anggota pertama (berdasarkan id)
        $anggotaPertama = $kepala?->anggota?->sortBy('id')->first();

        // Jika ada nama anggota, tampilkan
        $this->namaPemilik = $anggotaPertama ? e($anggotaPertama->nama) : '-';
    }

    public function getHistoryByDateProperty()
{
    return RumahHistory::with('user')
        ->where('rumah_id', $this->rumah->id_rumah)
        ->orderBy('changed_at', 'desc')
        ->get()
        ->groupBy(function ($item) {
            return $item->changed_at->format('Y-m-d');
        })
        ->map(function ($group) {
            return $group->groupBy('changed_by');
        });
}

    public function cetakPdf()
    {
        

        $pdf = Pdf::loadView('pdf.rumah-full', [
            'rumah' => $this->rumah,
            'namaPemilik' => $this->namaPemilik,
            'bantuanRiwayat' => $this->bantuanRiwayat
        ])->setPaper('a4', 'portrait');

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'Data_Rumah_' . ($this->namaPemilik ?? 'Tanpa_Nama') . '.pdf'
        );
    }

    public function goToEdit($id)
    {
        return redirect()->route('rumah.edit', $id);
    }

    public function deleteRumah($payload = [])
    {
        $id = $payload['id'] ?? null;

        if (!$id) return;

        $rumah = Rumah::find($id);

        if ($rumah) {
            //$rumah->delete();
            
            $this->dispatch('rumahDeleted', [
                'message' => "Data rumah ID {$id} berhasil dihapus!"
            ]);
        }
    }


    public function render()
    {
        return view('livewire.rumah.show')
            ->extends('layouts.master')
            ->section('content');
    }
}
