<?php

namespace App\Livewire;

use App\Exports\BantuanSheet;
use App\Exports\RumahExport;
use App\Models\Rumah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use ZipArchive;

class Data extends Component
{
   protected $listeners = ['refreshTable' => '$refresh', 'loadDetailRumah','deleteRumah'];

   public $exportFormat = '';

   public function exportData()
    {
        if (empty($this->exportFormat)) {
            $this->dispatch('swal:error', [
                'title' => 'Format belum dipilih!',
                'text'  => 'Silakan pilih format export terlebih dahulu.',
            ]);
            return;
        }

        if ($this->exportFormat === 'excel') {
            return $this->exportExcel();
        }

        if ($this->exportFormat === 'geojson') {
            return $this->exportGeoJson();
        }
    }

    
   public function exportExcel()
{
    try {
        ini_set('memory_limit', '4096M');
        ini_set('max_execution_time', '1800');

        $timestamp = now()->format('Ymd_His');
        $folder = "exports_$timestamp";
        $disk = 'public'; // gunakan disk Laravel agar lebih aman

        // Buat folder public/storage/exports_20251109_1900/
        $exportPath = storage_path("app/public/$folder");
        if (!file_exists($exportPath)) mkdir($exportPath, 0777, true);

        $files = [];
        $maxRows = 1000;

        // 🏠 1️⃣ Ekspor Rumah & KK (chunked)
        $total = DB::table('rumah')->count();
        $chunkCount = ceil($total / $maxRows);

        for ($i = 0; $i < $chunkCount; $i++) {
            $offset = $i * $maxRows;
            $filename = "data_rumah_" . ($i + 1) . ".xlsx";

            // Simpan file ke disk public
            Excel::store(
                new RumahExport($offset, $maxRows),
                "$folder/$filename",
                $disk
            );

            // Ambil path absolut setelah tersimpan
            $files[] = storage_path("app/public/$folder/$filename");
        }

        // 💰 2️⃣ Ekspor Bantuan
        $bantuanFile = "data_bantuan.xlsx";
        Excel::store(
            new BantuanSheet(),
            "$folder/$bantuanFile",
            $disk
        );
        $files[] = storage_path("app/public/$folder/$bantuanFile");

        // 🗜️ 3️⃣ Buat ZIP
        $zipFile = storage_path("app/public/export_data_$timestamp.zip");
        $zip = new \ZipArchive();

        if ($zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
            foreach ($files as $f) {
                if (file_exists($f)) {
                    $zip->addFile($f, basename($f));
                } else {
                    Log::warning("⚠️ File tidak ditemukan: $f");
                }
            }
            $zip->close();
        } else {
            throw new \Exception("Gagal membuat ZIP file di: $zipFile");
        }

        // 🧹 4️⃣ Bersihkan file sementara
        foreach ($files as $f) {
            if (file_exists($f)) @unlink($f);
        }
        if (is_dir($exportPath)) @rmdir($exportPath);

        // 🚀 5️⃣ Download ZIP
        return response()->download($zipFile)->deleteFileAfterSend(true);

    } catch (\Throwable $e) {
        dd($e->getMessage(), $e->getFile(), $e->getLine());
    }
}



public function exportGeoJson()
{
    try {
        $features = [];

        Rumah::with(['kelurahan.kecamatan', 'penilaian','kepalaKeluarga.anggota'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->chunk(500, function ($chunk) use (&$features) {
                foreach ($chunk as $r) {
                    $kepala = $r->kepalaKeluarga?->sortBy('id')->first();
                    $anggotaPertama = $kepala?->anggota?->sortBy('id')->first();
                    $namaPemilik =  $anggotaPertama ? e($anggotaPertama->nama) : '-';

                    $features[] = [
                        'type' => 'Feature',
                        'geometry' => [
                            'type' => 'Point',
                            'coordinates' => [(float) $r->longitude, (float) $r->latitude],
                        ],
                        'properties' => [
                            'id_rumah' => $r->id_rumah,
                            'alamat' => $r->alamat,
                            'nama' => $namaPemilik,
                            'kelurahan' => $r->kelurahan->nama_kelurahan ?? '-',
                            'kecamatan' => $r->kelurahan->kecamatan->nama_kecamatan ?? '-',
                            'status_rumah' => $r->penilaian->status_rumah ?? '-',
                        ],
                    ];
                }
            });

        $geojson = [
            'type' => 'FeatureCollection',
            'features' => $features,
        ];

        $fileName = 'export_rumah_' . now()->format('Ymd_His') . '.geojson';
        $filePath = Storage::disk('public')->path($fileName);

        Storage::disk('public')->put($fileName, json_encode($geojson, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return response()->download($filePath)->deleteFileAfterSend(true);
    } catch (\Throwable $e) {
        Log::error('Export GeoJSON gagal: '.$e->getMessage());
        $this->dispatch('swal:error', [
            'title' => 'Export Gagal!',
            'text' => 'Kesalahan saat export GeoJSON: ' . $e->getMessage(),
        ]);
    }
}




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
        ])
        ->orderBy('id_rumah', 'desc'); // 🔹 urutkan dari terbaru ke terlama

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
