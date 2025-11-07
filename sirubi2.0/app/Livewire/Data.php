<?php

namespace App\Livewire;

use App\Models\Rumah;
use Livewire\Component;
use Yajra\DataTables\Facades\DataTables;

class Data extends Component
{
   protected $listeners = ['refreshTable' => '$refresh', 'loadDetailRumah','deleteRumah'];

    public function render()
    {
        return view('livewire.data')
            ->extends('layouts.master')
            ->section('content');
    }

    // 🔹 DataTables AJAX source
    public function getData()
    {
        $query = Rumah::with([
                         // ambil relasi anggota keluarga
            'kepemilikan',          // untuk status rumah
            'sosialEkonomi',        // untuk status backlog
            'fisik',
            'sanitasi',
            'penilaian',
            'dokumen',
            'bantuan',
            'kepalaKeluarga.anggota',
            'kelurahan.kecamatan',  // nested: kelurahan -> kecamatan
        ]);

        return DataTables::eloquent($query)
            ->addIndexColumn()

            // 🔹 Tombol expand untuk detail rumah
            ->addColumn('expand', function ($r) {
                return '<button class="btn btn-light btn-sm toggle-detail" data-id="' . $r->id_rumah . '">
                            <i class="fas fa-plus"></i>
                        </button>';
            })

            // 🔹 Nama Pemilik diambil dari anggota keluarga pertama
            ->addColumn('nama_pemilik', function ($r) {
                // Ambil kepala keluarga pertama (jika ada banyak)
                $kepala = $r->kepalaKeluarga?->sortBy('id')->first();

                // Dari kepala keluarga pertama, ambil anggota pertama (berdasarkan id)
                $anggotaPertama = $kepala?->anggota?->sortBy('id')->first();

                // Jika ada nama anggota, tampilkan
                return $anggotaPertama ? e($anggotaPertama->nama) : '-';
            })

            // 🔹 Alamat rumah
            ->addColumn('alamat', fn($r) => e($r->alamat ?? '-'))

            // 🔹 Kecamatan & Kelurahan
            ->addColumn('kecamatan', fn($r) => e($r->kelurahan->kecamatan->nama_kecamatan ?? '-'))
            ->addColumn('kelurahan', fn($r) => e($r->kelurahan->nama_kelurahan ?? '-'))

            // 🔹 Status Rumah dari relasi kepemilikan
           ->addColumn('status_rumah', function ($r) {
                $status = $r->penilaian->status_rumah ?? '-';

                if (strtoupper($status) === 'RTLH') {
                    return '<span class="badge badge-light-danger fw-bold px-3 py-2">' . e($status) . '</span>';
                } elseif ($status && $status !== '-') {
                    return '<span class="badge badge-light-success fw-bold px-3 py-2">' . e($status) . '</span>';
                }

                return '<span class="badge badge-light-secondary fw-bold px-3 py-2">-</span>';
            })

            // 🔹 Status Backlog dari relasi sosialEkonomi
            ->addColumn('status_backlog', function ($r) {
                if ($r->sosialEkonomi && $r->sosialEkonomi->jumlah_kk_id > 1) {
                    return '<span class="badge badge-light-warning fw-bold px-3 py-2">BACKLOG</span>';
                }
                return '<span class="badge badge-light-primary fw-bold px-3 py-2">TIDAK BACKLOG</span>';
            })

            // 🔹 Dropdown aksi
            // ->addColumn('action', function ($r) {pdata
            //     return view('livewire.partials.action-dropdown', ['r' => $r])->render();
            // })
           ->addColumn('action', function ($r) {
                $buttons = '
                    <a href="#" 
                    class="btn btn-sm btn-light btn-active-light-primary" 
                    data-kt-menu-trigger="click" 
                    data-kt-menu-placement="bottom-end">
                        Actions
                        <span class="svg-icon svg-icon-5 m-0">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.4343 12.7344L7.25 8.55C6.83579 8.13579 
                                6.16421 8.13579 5.75 8.55C5.33579 8.96421 
                                5.33579 9.63579 5.75 10.05L11.2929 15.5929
                                C11.6834 15.9834 12.3166 15.9834 12.7071 15.5929
                                L18.25 10.05C18.6642 9.63579 18.6642 8.96421 
                                18.25 8.55C17.8358 8.13579 17.1642 8.13579 
                                16.75 8.55L12.5657 12.7344C12.2533 13.0468 
                                11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"/>
                            </svg>
                        </span>
                    </a>

                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded 
                                menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 
                                w-150px py-4" data-kt-menu="true">

                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3 " 
                            wire:click.prevent="goToDetail(' . $r->id_rumah . ')">
                            View
                            </a>
                        </div>

                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3 " 
                           wire:click.prevent="goToEdit(' . $r->id_rumah . ')">
                            Edit
                            </a>
                        </div>

                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3 " 
                            onclick="confirmDelete(' . $r->id_rumah . ')">
                            Hapus
                            </a>
                        </div>
                    </div>
                ';

                 return '<div wire:ignore.self>' . $buttons . '</div>';
            })
            // 🔹 Izinkan HTML untuk kolom tertentu
            ->rawColumns(['expand', 'status_backlog', 'action','status_rumah'])
            ->toJson();
    }

    // 🔹 Ambil detail rumah (expand)
    public function loadDetailRumah($id)
    {
        $rumah = Rumah::with([
            'kepemilikan', 'sosialEkonomi', 'fisik', 'sanitasi', 'penilaian', 'dokumen', 'bantuan',
            'kepalaKeluarga.anggota', 'kelurahan.kecamatan'
        ])->find($id);

        if (!$rumah) return;

        $html = view('livewire.partials.detail-row', compact('rumah'))->render();

        $this->dispatch('detailRumahLoaded', $html);
    }

    public function goToDetail($id)
    {
        // Langsung redirect ke halaman detail rumah
        return redirect()->route('rumah.show', ['id' => $id]);
    }

    public function goToEdit($id)
    {
        // Redirect ke halaman edit rumah
        return redirect()->route('rumah.edit', ['id' => $id]);
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

}
