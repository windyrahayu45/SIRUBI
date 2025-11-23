<?php

namespace App\Livewire;

use App\Models\TblDokumen;
use Livewire\Component;
use Livewire\WithFileUploads;
use Yajra\DataTables\Facades\DataTables;

class Dokumentasi extends Component
{

     use WithFileUploads;

    protected $listeners = ['refreshTable' => '$refresh','deleteRumah']; 
    public $nama_dokumen,$file;





    public function getData()
    {
        $request = request();

       $query = TblDokumen::orderBy('id_dokumen', 'desc');;

        return DataTables::eloquent($query)
            ->addIndexColumn()
           
             
               
                ->addColumn('action', function ($r) {
                    
                     $downloadUrl = asset('storage/' . $r->source); // buat URL publik
                  $buttons = '
                      <a href="#" 
                          class="btn btn-sm btn-light btn-active-light-primary" 
                          data-kt-menu-trigger="click" 
                          data-kt-menu-placement="bottom-end">
                          Actions
                         <span class="svg-icon svg-icon-5 m-0">
																<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																	<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"></path>
																</svg>
															</span>
                      </a>

                      <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded 
                                  menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 
                                  w-150px py-4" data-kt-menu="true">

                          <div class="menu-item px-3">
                            <a href="'.$downloadUrl.'"  class="menu-link px-3 " 
                            >
                            Download
                            </a>
                        </div>


                          <div class="menu-item px-3">
                              <a href="javascript:void(0)" 
                                  class="menu-link px-3" 
                                  onclick="confirmDelete(' . $r->id_dokumen . ')">
                                  Hapus
                              </a>
                          </div>

                      </div>
                  ';

                  return '<div wire:ignore>' . $buttons . '</div>';
              })

            ->rawColumns(['action','jenis'])
            ->toJson();
    }

    public function save()
    {
        $this->validate([
            'nama_dokumen' => 'required',
            'file' => 'required|file|max:10240'
        ]);

        $path = $this->file->store('dokumen', 'public');

        TblDokumen::create([
            'nama_dokumen' => $this->nama_dokumen,
            'source' => $path,
           'date_upload'  => now()->format('Y-m-d'),
        ]);

        $this->reset(['nama_dokumen', 'file']);

        $this->dispatch('hideModalTambahDokumen');
        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => 'Dokumen berhasil ditambahkan!'
        ]);

        $this->dispatch('refreshDatatable');
    }

    public function deleteRumah($payload = [])
    {
        $id = $payload['id'] ?? null;

        if (!$id) return;

        $deleted = TblDokumen::where('id_dokumen', $id)->delete();

        if ($deleted > 0) {
            $this->dispatch('rumahDeleted', [
                'message' => "Data  berhasil dihapus!"
            ]);
        } else {
            $this->dispatch('rumahDeleted', [
                'message' => "Data B tidak ditemukan!"
            ]);
        }
    }

    public function render()
    {
        return view('livewire.dokumentasi')
            ->extends('layouts.master')
            ->section('content');
    }
}
