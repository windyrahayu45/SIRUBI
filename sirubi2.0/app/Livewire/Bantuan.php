<?php

namespace App\Livewire;

use App\Imports\BantuanImport;
use App\Models\KepalaKeluarga;
use App\Models\TblBantuan;
use App\Models\TblDokumen;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Yajra\DataTables\Facades\DataTables;

class Bantuan extends Component
{
   use WithFileUploads;

  protected $listeners = ['refreshTable' => '$refresh','deleteRumah'];
  
  public $selectedId;
  public $form = [];
  public $dokumens = [];
  public $id_dokumen;
  public $file_import;

  public $nama_bantuan_input;
    public $nama_program_input;
    public $tahun_bantuan_input;
    public $dokumen_input;

  public function mount(){
    $this->dokumens = TblDokumen::all();
  }


   #[On('select2Changed')]
    public function select2Changed($data)
    {
        $name = $data['name'] ?? null;
        $value = $data['value'] ?? null;

        if ($name && property_exists($this, $name)) {
            $this->$name = $value;
            logger("✅ Livewire menerima {$name} = {$value}");
        }

    }

    public function openEditModal($id)
    {
        $this->selectedId = $id;

        $data = TblBantuan::where('id_bantuan', $id)
                    ->first();
        

        if (!$data) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Data tidak ditemukan!'
            ]);
            return;
        }

        $this->form = [
            'no_kk'           => $data->kk,
            'nama_bantuan'    => $data->nama,
            'program_bantuan' => $data->nama_program,
            'nominal'         => $data->nominal,
            'tahun'           => $data->tahun,
            'id_dokumen'       => $data->id_dokumen,
        ];

        $this->dispatch('showEditModal');
    }

    protected function rules()
    {
        return [
            'form.nama_bantuan'    => 'required|string|max:255',
            'form.program_bantuan' => 'required|string|max:255',
            'form.nominal'         => 'required|numeric',
            'form.tahun'           => 'required|digits:4',
            'id_dokumen'       => 'required',
        ];
    }

  public function updateData()
  {
     try {
            $this->validate([
                 'form.nama_bantuan'    => 'required|string|max:255',
                'form.program_bantuan' => 'required|string|max:255',
                'form.nominal'         => 'required|numeric',
                'form.tahun'           => 'required|digits:4',
                'id_dokumen'       => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            // Ambil pesan error pertama
            $message = collect($e->errors())->first()[0] ?? "Harap lengkapi semua field wajib.";

            // Tampilkan SweetAlert
            $this->dispatch('showAlert', [
                'type'    => 'error',
                'message' => $message
            ]);

            return;
        }

    

      TblBantuan::where('id_bantuan', $this->selectedId)
          ->update([
              'nama'    => $this->form['nama_bantuan'],
              'nama_program' => $this->form['program_bantuan'],
              'nominal'         => $this->form['nominal'],
              'tahun'           => $this->form['tahun'],
              'id_dokumen'       => $this->id_dokumen,
          ]);

      // tutup modal
      $this->dispatch('hideEditModal');

     

      // notifikasi
      $this->dispatch('showAlert', [
          'type' => 'success',
          'message' => 'Data Bantuan berhasil diperbarui!'
      ]);
  }

    public function submitIntegrasi()
    {
        try {
            $this->validate([
                'nama_bantuan_input'    => 'required|string|max:255',
                'nama_program_input'    => 'required|string|max:255',
                'tahun_bantuan_input'   => 'required|numeric',
                'dokumen_input'         => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            $message = collect($e->errors())->first()[0] ?? "Harap lengkapi semua field wajib.";

            $this->dispatch('showAlert', [
                'type'    => 'error',
                'message' => $message
            ]);

            return;
        }

        // -------------------------
        // 🔥 UPDATE LOGIC BARU 🔥
        // -------------------------
        TblBantuan::where('nama', $this->nama_bantuan_input)
            ->where('nama_program', $this->nama_program_input)
            ->where('tahun', $this->tahun_bantuan_input)
            ->update([
                'id_dokumen' => $this->dokumen_input
            ]);

        // 🔥 Reset input setelah update
        $this->reset(['nama_bantuan_input', 'nama_program_input', 'tahun_bantuan_input', 'dokumen_input']);

        // 🔥 Tutup modal
        $this->dispatch('hideIntegrasiModal'); // atau 'hide-modal-integrasi' sesuai JS kamu

        // 🔥 Notifikasi sukses
        $this->dispatch('showAlert', [
            'type'    => 'success',
            'message' => 'Integrasi dokumen berhasil diperbarui!'
        ]);
    }



   public function importData()
{
    $this->validate([
        'file_import' => 'required|file|mimes:xls,xlsx,csv'
    ]);

    $path = $this->file_import->getRealPath();

    // Ambil row pertama
    $firstRow = \Maatwebsite\Excel\Facades\Excel::toCollection(null, $path)[0][0];

    // DETEKSI HEADER YANG BENAR
    // Jika kolom A (index 0) TIDAK numeric → berarti FILE DENGAN HEADER
    $hasHeader = !is_numeric($firstRow[0]);

    if ($hasHeader) {
        // Import dengan header
        \Maatwebsite\Excel\Facades\Excel::import(
            new \App\Imports\BantuanImport, 
            $path
        );

    } else {
        // Import tanpa header
        \Maatwebsite\Excel\Facades\Excel::import(
            new \App\Imports\BantuanImportNoHeader, 
            $path
        );
    }

    // Feedback
    $this->dispatch('showAlert', [
        'type' => 'success',
        'message' => $hasHeader 
            ? 'Import berhasil (mode HEADER)!'
            : 'Import berhasil (mode TANPA HEADER)!'
    ]);

    $this->dispatch('hideImportModal');
}



    public function getData()
    {
        $request = request();

        $query = TblBantuan::with('dokumen')->orderBy('id_bantuan', 'desc');

        return DataTables::eloquent($query)
            ->addIndexColumn()
           
             ->addColumn('nominal', function($r){

                  // Ambil nilai asli
                  $value = $r->nominal ?? 0;

                  // Bersihkan karakter selain angka dan minus
                  $numeric = preg_replace('/[^0-9\-]/', '', $value);

                  // Jika kosong atau bukan angka, jadikan 0
                  if ($numeric === '' || !is_numeric($numeric)) {
                      $numeric = 0;
                  }

                  // Format ulang rupiah
                  return 'Rp ' . number_format((float)$numeric, 0, ',', '.');
              })

               ->addColumn('dokumen', function ($r) {
                    if (!$r->dokumen) {
                        return '<span class="badge bg-secondary">Tidak Ada</span>';
                    }

                    return $r->dokumen->nama_dokumen;
                })

                ->addColumn('status_kk', function ($r) {

                    // cek apakah ada data kepala keluarga
                    $exists = KepalaKeluarga::where('no_kk', $r->kk)->exists();

                    if ($exists) {
                        return '<span class="badge bg-success">Telah Terdata</span>';
                    }

                    return '<span class="badge bg-danger">Rumah Belum Ada</span>';
                })

           ->addColumn('action', function ($r) {

                // User level 3 tidak boleh edit / hapus
                $canEditDelete = auth()->user()->level != 3;

                $buttons = '
                    <a href="#" 
                        class="btn btn-sm btn-light btn-active-light-primary" 
                        data-kt-menu-trigger="click" 
                        data-kt-menu-placement="bottom-end">
                        Actions
                        <span class="svg-icon svg-icon-5 m-0">
                            <svg width="24" height="24" ...></svg>
                        </span>
                    </a>

                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded 
                                menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 
                                w-150px py-4" data-kt-menu="true">
                                
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3"
                            wire:click.prevent="goToDetail(' . $r->kk . ')">
                                View
                            </a>
                        </div>
                ';

                // ⭐ Jika level bukan 3 → boleh Edit
                if ($canEditDelete) {
                    $buttons .= '
                        <div class="menu-item px-3">
                            <a href="javascript:void(0)" 
                                class="menu-link px-3"
                                wire:click.prevent="openEditModal(' . $r->id_bantuan . ')">
                                Edit
                            </a>
                        </div>
                    ';
                }

                // ⭐ Jika level bukan 3 → boleh Hapus
                if ($canEditDelete) {
                    $buttons .= '
                        <div class="menu-item px-3">
                            <a href="javascript:void(0)" 
                                class="menu-link px-3 text-danger"
                                onclick="confirmDelete(' . $r->id_bantuan . ')">
                                Hapus
                            </a>
                        </div>
                    ';
                }

                $buttons .= '</div>';

                return '<div wire:ignore>' . $buttons . '</div>';
            })


            ->rawColumns(['action','nominal','dokumen','status_kk'])
            ->toJson();
    }

     public function goToDetail($id)
    {
        // Langsung redirect ke halaman detail rumah
        return redirect()->route('bantuan.show', ['id' => $id]);
    }

    public function deleteRumah($payload = [])
    {
        $id = $payload['id'] ?? null;

        if (!$id) return;

        $deleted = TblBantuan::where('id_bantuan', $id)->delete();

        if ($deleted > 0) {
            $this->dispatch('rumahDeleted', [
                'message' => "Data Bantuan ID {$id} berhasil dihapus!"
            ]);
        } else {
            $this->dispatch('rumahDeleted', [
                'message' => "Data Bantuan ID {$id} tidak ditemukan!"
            ]);
        }
    }

    public function render()
    {
        return view('livewire.bantuan')
          ->extends('layouts.master')
            ->section('content');
    }
}
