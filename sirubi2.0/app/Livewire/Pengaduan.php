<?php

namespace App\Livewire;

use App\Models\Pengaduan as ModelPengaduan;
use App\Models\PengaduanPhoto;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class Pengaduan extends Component
{
     use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }


    public $selectedId;
    public $status;
    public $catatan_admin;

    protected $listeners = ['confirmDelete' => 'delete','viewDetail' => 'viewDetail','updateStatus' => 'updateStatus'];

    public function viewDetail($id)
    {
        $this->selectedId = $id;
        $data = ModelPengaduan::with('photos')->find($id);

        $this->status = $data->status;
        $this->catatan_admin = $data->catatan_admin;

        $this->dispatch('openDetailModal', $data);
    }

    public function updateStatus()
    {
        $data = ModelPengaduan::findOrFail($this->selectedId);

        $data->update([
            'status' => $this->status,
            'catatan_admin' => $this->catatan_admin,
            'handled_by' => auth()->user()->id,
            'user_id' => auth()->user()->id,
        ]);
         $this->dispatch('hideModalTambahDokumen');
        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => 'Status Pengaduan diperbarui!'
        ]);

        $this->reset(['selectedId','status','catatan_admin']);
    }

    public function delete($id)
    {
        $data = ModelPengaduan::find($id);

        if ($data) {
            // hapus foto
            foreach ($data->photos as $f) {
                Storage::disk('public')->delete($f->file_path);
                $f->delete();
            }

            $data->delete();
        }

        $this->dispatch('swal:success', message: "Pengaduan berhasil dihapus.");
    }

    public function render()
    {
        return view('livewire.pengaduan', [
           'items' => ModelPengaduan::when($this->search, function ($q) {
                $q->where('judul', 'like', "%{$this->search}%")
                  ->orWhere('nama_pelapor', 'like', "%{$this->search}%")
                  ->orWhere('no_hp', 'like', "%{$this->search}%")
                  ->orWhere('kategori', 'like', "%{$this->search}%");
            })
            ->latest()
            ->paginate(10)

        ])->extends('layouts.master')
            ->section('content');
    }
}
