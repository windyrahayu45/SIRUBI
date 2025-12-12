<?php

namespace App\Livewire;

use App\Models\TblPolygon;
use Livewire\Component;
use Yajra\DataTables\Facades\DataTables;

class Polygon extends Component
{

     protected $listeners = ['refreshTable' => '$refresh','deleteRumah']; 
    public function getData()
    {
        $request = request();

       $query = TblPolygon::with('jenis');

        return DataTables::eloquent($query)
            ->addIndexColumn()
           
             
                ->addColumn('jenis',function($r){

                    return $r->jenis->jenis_polygon;

                })
                ->addColumn('action', function ($r) {

    // Level 3 tidak boleh edit / hapus
    $canEditDelete = auth()->user()->level != 3;

    $buttons = '
        <a href="#" 
            class="btn btn-sm btn-light btn-active-light-primary" 
            data-kt-menu-trigger="click" 
            data-kt-menu-placement="bottom-end">
            Actions
            <span class="svg-icon svg-icon-5 m-0">
                 <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 
                                    8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 
                                    15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 
                                    8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"/>
                                </svg>
            </span>
        </a>

        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded 
                    menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 
                    w-150px py-4" data-kt-menu="true">
    ';

    // ⭐ Edit hanya tampil kalau level ≠ 3
    if ($canEditDelete) {
        $buttons .= '
            <div class="menu-item px-3">
                <a href="#" class="menu-link px-3"
                wire:click.prevent="goToDetail(' . $r->id_polygon . ')">
                    Edit
                </a>
            </div>
        ';
    }

    // ⭐ Hapus hanya tampil kalau level ≠ 3
    if ($canEditDelete) {
        $buttons .= '
            <div class="menu-item px-3">
                <a href="javascript:void(0)" 
                    class="menu-link px-3 text-danger" 
                    onclick="confirmDelete(' . $r->id_polygon . ')">
                    Hapus
                </a>
            </div>
        ';
    }

    $buttons .= '</div>';

    return '<div wire:ignore>' . $buttons . '</div>';
})


            ->rawColumns(['action','jenis'])
            ->toJson();
    }

      public function goToDetail($id)
    {
        // Langsung redirect ke halaman detail rumah
        return redirect()->route('polygon.edit', ['id' => $id]);
    }


    public function deleteRumah($payload = [])
    {
        $id = $payload['id'] ?? null;

        if (!$id) return;

        $deleted = TblPolygon::where('id_polygon', $id)->delete();

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
        return view('livewire.polygon')
            ->extends('layouts.master')
            ->section('content');
    }
}
