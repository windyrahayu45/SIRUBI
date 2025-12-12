<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PengaduanRumah;
use Yajra\DataTables\Facades\DataTables;

class ListPengaduan extends Component
{
    public $detailData = [];
    public $detailFotos = [];
    public $statusUpdateId;
    public $statusBaru;

    protected $listeners = [
        'refreshTable' => '$refresh',
        'updateStatus',
    ];

    /**
     * ======================================================
     * DATATABLE SERVER SIDE
     * ======================================================
     */
    public function getData()
    {
        $query = PengaduanRumah::with(['kecamatan', 'kelurahan', 'fotos']);

        return DataTables::eloquent($query)
            ->addIndexColumn()

            // Kolom NIK / KK
            ->addColumn('nik_kk', function ($r) {
                return "<b>NIK:</b> {$r->nik}<br><b>KK:</b> {$r->kk}";
            })

            // Kolom Lokasi
            ->addColumn('lokasi', function ($r) {
                return $r->alamat . "<br>RT {$r->rt} / RW {$r->rw}";
            })

            // Kolom Kecamatan / Kelurahan
            ->addColumn('wilayah', function ($r) {
                return "Kec. ".($r->kelurahan->nama_kelurahan ?? '-') . "<br>" .
                       "Kel. ".($r->kecamatan->nama_kecamatan ?? '-');
            })

            // Kolom Status
            ->addColumn('status_badge', function ($r) {
                $color = [
                    'pending' => 'warning',
                    'proses' => 'info',
                    'selesai' => 'success',
                ][$r->status] ?? 'secondary';

                return '<span class="badge badge-light-' . $color . '">' . strtoupper($r->status) . '</span>';
            })

            // Kolom Actions
            ->addColumn('action', function ($r) {

                $btn = '
                <a href="#" class="btn btn-sm btn-light btn-active-light-primary"
                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
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
                            menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-150px py-4"
                    data-kt-menu="true">
                
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3"
                            wire:click.prevent="loadDetail(' . $r->id . ')">
                            Detail
                        </a>
                    </div>';

                // Level 3 tidak boleh ubah status
                if (auth()->user()->level != 3) {
                    $btn .= '
                    <div class="menu-item px-3">
                        <a href="#" class="menu-link px-3 text-primary"
                            wire:click.prevent="openStatusModal(' . $r->id . ')">
                            Ubah Status
                        </a>
                    </div>
                    ';
                }

                $btn .= '</div>';

                return '<div wire:ignore>' . $btn . '</div>';
            })

            ->rawColumns(['nik_kk', 'lokasi', 'wilayah', 'status_badge', 'action'])
            ->toJson();
    }

    /**
     * ======================================================
     * LOAD DETAIL
     * ======================================================
     */
    public function loadDetail($id)
    {
        $peng = PengaduanRumah::with(['fotos', 'kecamatan', 'kelurahan'])->find($id);

        if (!$peng) return;

        $this->detailData = $peng->toArray();
        $this->detailFotos = $peng->fotos;

        $this->dispatch('showDetailModal');
    }

    /**
     * ======================================================
     * OPEN STATUS MODAL
     * ======================================================
     */
    public function openStatusModal($id)
    {
        $this->statusUpdateId = $id;
        $this->statusBaru = null;

        $this->dispatch('showStatusModal');
    }

    /**
     * ======================================================
     * UPDATE STATUS
     * ======================================================
     */
    public function updateStatus()
    {
        if (!$this->statusUpdateId || !$this->statusBaru) return;

        $peng = PengaduanRumah::find($this->statusUpdateId);
        if (!$peng) return;

        $peng->status = $this->statusBaru;
        $peng->save();

        $this->dispatch('hideStatusModal');
        $this->dispatch('pengaduanUpdated');
    }

    /**
     * ======================================================
     * RENDER VIEW
     * ======================================================
     */
    public function render()
    {
        return view('livewire.list-pengaduan')
            ->extends('layouts.master')
            ->section('content');
    }
}
