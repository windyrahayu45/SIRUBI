<?php

namespace App\Livewire;

use App\Models\AKondisiBalok;
use App\Models\AKondisiKolomTiang;
use App\Models\AKondisiPondasi;
use App\Models\AKondisiSloof;
use App\Models\AKondisiStrukturAtap;
use App\Models\APondasi;
use App\Models\IBesarPengeluaran;
use App\Models\IBesarPenghasilan;
use App\Models\Rumah;
use App\Services\Rekap2Builder;
use App\Services\Rekap3Builder;
use App\Services\Rekap4Builder;
use App\Services\Rekap5Builder;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Rekap extends Component
{
    public $kecamatanId;
    public $kecamatanNama;
    public $rekap1;
    public $rekap2;
    public $pendidikan;
    public $pekerjaan;
    public $penghasilan;
    public $pengeluaran;
    public $statusTanah;
    public $buktiTanah;
    public $statusRumah;
    public $statusImb;
    public $asetRumah;
    public $asetTanah;
    public $bantuan;
    public $kawasan;
    public $rekap2Sum = [];
    public $rekap3 = [];
    public $rekap3Sum = [];

    // master label untuk header
    public $masterPondasi = [];
    public $masterKondisiPondasi = [];
    public $masterSloof = [];
    public $masterKolom = [];
    public $masterBalok = [];
    public $masterAtap = [];

    public $rekap4 = [];
    public $rekap4Sum = [];

    public $masterJendela;
    public $masterKondisiJendela;
    public $masterVentilasi;
    public $masterKondisiVentilasi;
    public $masterKamarMandi;
    public $masterKondisiKamarMandi;
    public $masterJamban;
    public $masterKondisiJamban;
    public $masterSPAL;
    public $masterKondisiSPAL;
    public $masterFrekuensiSedot;
    public $masterAirMinum;
    public $masterKondisiAirMinum;
    public $masterListrik;
    

    public $rekap5 = [];
    public $rekap5Sum = [];

    public $masterRuangTidur;
    public $masterJenisFisik;
    public $masterFungsiRumah;
    public $masterTipeRumah;
    public $masterStatusDtks;

    public $rekap6 = [];
    public $rekap6Sum = [];

    public $materialAtap;
    public $masterKondisiAtap;
    public $masterDinding;
    public $masterKondisiDinding;
    public $masterLantai;
    public $masterKondisiLantai;
    public $masterAksesJalan;
    public $masterMenghadapJalan;
    public $masterMenghadapSungai;
    public $masterBeradaLimbah;
    public $masterBeradaSungai;

    // public $rekap4Columns = [];
    // public $rekap4Labels = [];

    // public $rekap5Columns = [];
    // public $rekap5Labels = [];
    public $format;

    // public function exportData()
    // {
    //     $this->validate([
    //         'format' => 'required'
    //     ]);

    //     if ($this->format === 'excel') {
    //         return redirect()->route('rekap.export.all.excel', [
    //             'kecamatan' => $this->kecamatanId
    //         ]);
    //     }

    //     if ($this->format === 'pdf') {
    //         return redirect()->route('rekap.export.all.pdf', [
    //             'kecamatan' => $this->kecamatanId
    //         ]);
    //     }

    //      if (empty($this->format)) {
    //         $this->dispatch('swal:error', [
    //             'title' => 'Format belum dipilih!',
    //             'text'  => 'Silakan pilih format export terlebih dahulu.',
    //         ]);
    //         return;
    //     }
    // }

    public function exportData()
{
    $this->validate([
        'format' => 'required'
    ]);

    if ($this->format === 'excel') {
        $url = route('rekap.export.all.excel', [
            'kecamatan' => $this->kecamatanId
        ]);

        $this->dispatch('startDownload', $url);
        return;
    }

    if ($this->format === 'pdf') {
        $url = route('rekap.export.all.pdf', [
            'kecamatan' => $this->kecamatanId
        ]);

        $this->dispatch('startDownload', $url);
        return;
    }

    $this->dispatch('swal:error', [
        'title' => 'Format belum dipilih!',
        'text'  => 'Silakan pilih format export terlebih dahulu.',
    ]);
}





    public function mount()
    {
        $this->kecamatanId = request()->get('kecamatan_id');
        if ($this->kecamatanId) {
            $this->loadData();
        }

        $this->pendidikan = \App\Models\IPendidikanTerakhir::orderBy('id_pendidikan_terakhir')->get();
        $this->pekerjaan = \App\Models\IPekerjaanUtama::orderBy('id_pekerjaan_utama')->get();

        $this->penghasilan = IBesarPenghasilan::orderBy('id_besar_penghasilan')->get();
        $this->pengeluaran = IBesarPengeluaran::orderBy('id_besar_pengeluaran')->get();

        $this->statusTanah = \App\Models\IStatusKepemilikanTanah::orderBy('id_status_kepemilikan_tanah')->get();
        $this->buktiTanah = \App\Models\IBuktiKepemilikanTanah::orderBy('id_bukti_kepemilikan_tanah')->get();

        $this->statusRumah = \App\Models\IStatusKepemilikanRumah::orderBy('id_status_kepemilikan_rumah')->get();
        $this->statusImb = \App\Models\IStatusImb::orderBy('id_status_imb')->get();

        $this->asetRumah = \App\Models\IAsetRumahTempatLain::orderBy('id_aset_rumah_tempat_lain')->get();
        $this->asetTanah = \App\Models\IAsetTanahTempatLain::orderBy('id_aset_tanah_tempat_lain')->get();

        $this->bantuan = \App\Models\IPernahMendapatkanBantuan::orderBy('id_pernah_mendapatkan_bantuan')->get();
        $this->kawasan = \App\Models\IJenisKawasanLokasi::orderBy('id_jenis_kawasan_lokasi')->get();

        $this->masterPondasi         = APondasi::all();
        $this->masterKondisiPondasi  = AKondisiPondasi::all();
        $this->masterSloof           = AKondisiSloof::all();
        $this->masterKolom           = AKondisiKolomTiang::all();
        $this->masterBalok           = AKondisiBalok::all();
        $this->masterAtap            = AKondisiStrukturAtap::all();


        // ===== MASTER =====
        $this->masterJendela           = \App\Models\BJendelaLubangCahaya::all();
        $this->masterKondisiJendela    = \App\Models\BKondisiJendelaLubangCahaya::all();
        $this->masterVentilasi         = \App\Models\BVentilasi::all();
        $this->masterKondisiVentilasi  = \App\Models\BKondisiVentilasi::all();
        $this->masterKamarMandi        = \App\Models\BKamarMandi::all();
        $this->masterKondisiKamarMandi = \App\Models\BKondisiKamarMandi::all();
        $this->masterJamban            = \App\Models\BJamban::all();
        $this->masterKondisiJamban     = \App\Models\BKondisiJamban::all();
        $this->masterSPAL              = \App\Models\BSistemPembuanganAirKotor::all();
        $this->masterKondisiSPAL       = \App\Models\BKondisiSistemPembuanganAirKotor::all();
        $this->masterFrekuensiSedot    = \App\Models\BFrekuensiPenyedotan::all();
        $this->masterAirMinum          = \App\Models\BSumberAirMinum::all();
        $this->masterKondisiAirMinum   = \App\Models\BKondisiSumberAirMinum::all();
        $this->masterListrik           = \App\Models\BSumberListrik::all();

         $this->masterRuangTidur   = \App\Models\CRuangKeluargaDanTidur::all();
        $this->masterJenisFisik   = \App\Models\CJenisFisikBangunan::all();
        $this->masterFungsiRumah  = \App\Models\CFungsiRumah::all();
        $this->masterTipeRumah    = \App\Models\CTipeRumah::all();
        $this->masterStatusDtks   = \App\Models\CStatusDtks::all();


         $this->materialAtap            = \App\Models\DMaterialAtapTerluas::all();
        $this->masterKondisiAtap     = \App\Models\DKondisiPenutupAtap::all();
        $this->masterDinding         = \App\Models\DMaterialDindingTerluas::all();
        $this->masterKondisiDinding  = \App\Models\DKondisiDinding::all();
        $this->masterLantai          = \App\Models\DMaterialLantaiTerluas::all();
        $this->masterKondisiLantai   = \App\Models\DKondisiLantai::all();
        $this->masterAksesJalan      = \App\Models\DAksesKeJalan::all();
        $this->masterMenghadapJalan  = \App\Models\DBangunanMenghadapJalan::all();
        $this->masterMenghadapSungai = \App\Models\DBangunanMenghadapSungai::all();
        $this->masterBeradaLimbah    = \App\Models\DBangunanBeradaLimbah::all();
        $this->masterBeradaSungai    = \App\Models\DBangunanBeradaSungai::all();

       // $this->loadKolom();



       

    }

    // public function loadKolom(){
    //         // A
    //     foreach ($this->masterJendela as $m) {
    //         $key = "a_{$m->id_jendela_lubang_cahaya}";
    //         $this->rekap4Columns[] = $key;
    //         $this->rekap4Labels[$key] = $m->jendela_lubang_cahaya;
    //     }

    //     // B
    //     foreach ($this->masterKondisiJendela as $m) {
    //         $key = "b_{$m->id_kondisi_jendela_lubang_cahaya}";
    //         $this->rekap4Columns[] = $key;
    //         $this->rekap4Labels[$key] = $m->kondisi_jendela_lubang_cahaya;
    //     }

    //     // C
    //     foreach ($this->masterVentilasi as $m) {
    //         $key = "c_{$m->id_ventilasi}";
    //         $this->rekap4Columns[] = $key;
    //         $this->rekap4Labels[$key] = $m->ventilasi;
    //     }

    //     // D
    //     foreach ($this->masterKondisiVentilasi as $m) {
    //         $key = "d_{$m->id_kondisi_ventilasi}";
    //         $this->rekap4Columns[] = $key;
    //         $this->rekap4Labels[$key] = $m->kondisi_ventilasi;
    //     }

    //     // E
    //     foreach ($this->masterKamarMandi as $m) {
    //         $key = "e_{$m->id_kamar_mandi}";
    //         $this->rekap4Columns[] = $key;
    //         $this->rekap4Labels[$key] = $m->kamar_mandi;
    //     }

    //     // F
    //     foreach ($this->masterKondisiKamarMandi as $m) {
    //         $key = "f_{$m->id_kondisi_kamar_mandi}";
    //         $this->rekap4Columns[] = $key;
    //         $this->rekap4Labels[$key] = $m->kondisi_kamar_mandi;
    //     }

    //     // G
    //     foreach ($this->masterJamban as $m) {
    //         $key = "g_{$m->id_jamban}";
    //         $this->rekap4Columns[] = $key;
    //         $this->rekap4Labels[$key] = $m->jamban;
    //     }

    //     // H
    //     foreach ($this->masterKondisiJamban as $m) {
    //         $key = "h_{$m->id_kondisi_jamban}";
    //         $this->rekap4Columns[] = $key;
    //         $this->rekap4Labels[$key] = $m->kondisi_jamban;
    //     }

    //     // I
    //     foreach ($this->masterSPAL as $m) {
    //         $key = "i_{$m->id_sistem_pembuangan_air_kotor}";
    //         $this->rekap4Columns[] = $key;
    //         $this->rekap4Labels[$key] = $m->sistem_pembuangan_air_kotor;
    //     }

    //     // J
    //     foreach ($this->masterKondisiSPAL as $m) {
    //         $key = "j_{$m->id_kondisi_sistem_pembuangan_air_kotor}";
    //         $this->rekap4Columns[] = $key;
    //         $this->rekap4Labels[$key] = $m->kondisi_sistem_pembuangan_air_kotor;
    //     }

    //     // IA
    //     foreach ($this->masterFrekuensiSedot as $m) {
    //         $key = "ia_{$m->id_frekuensi_penyedotan}";
    //         $this->rekap4Columns[] = $key;
    //         $this->rekap4Labels[$key] = $m->frekuensi_penyedotan;
    //     }

    //     // K
    //     foreach ($this->masterAirMinum as $m) {
    //         $key = "k_{$m->id_sumber_air_minum}";
    //         $this->rekap4Columns[] = $key;
    //         $this->rekap4Labels[$key] = $m->sumber_air_minum;
    //     }

    //     // KA
    //     foreach ($this->masterKondisiAirMinum as $m) {
    //         $key = "ka_{$m->id_kondisi_sumber_air_minum}";
    //         $this->rekap4Columns[] = $key;
    //         $this->rekap4Labels[$key] = $m->kondisi_sumber_air_minum;
    //     }

    //     // L
    //     foreach ($this->masterListrik as $m) {
    //         $key = "l_{$m->id_sumber_listrik}";
    //         $this->rekap4Columns[] = $key;
    //         $this->rekap4Labels[$key] = $m->sumber_listrik;
    //     }

    //     /* A - Ruang Keluarga & Tidur */
    //     foreach ($this->masterRuangTidur as $m) {
    //         $key = "a_{$m->id_ruang_keluarga_dan_tidur}";
    //         //$this->columnsRuangTidur[] = $key;
    //         $this->rekap5Columns[] = $key;
    //         $this->rekap5Labels[$key] = $m->ruang_keluarga_dan_tidur;
    //     }

    //     /* B - Jenis Fisik Bangunan */
    //     foreach ($this->masterJenisFisik as $m) {
    //         $key = "b_{$m->id_jenis_fisik_bangunan}";
    //         //$this->columnsJenisFisik[] = $key;
    //         $this->rekap5Columns[] = $key;
    //         $this->rekap5Labels[$key] = $m->jenis_fisik_bangunan;
    //     }

    //     /* C - Jumlah Lantai (tetap 3 kategori) */
    //     $this->rekap5Columns[] = 'c_1';
    //     $this->rekap5Columns[] = 'c_2';
    //     $this->rekap5Columns[] = 'c_3';

    //     $this->rekap5Labels['c_1'] = "1 Lantai";
    //     $this->rekap5Labels['c_2'] = "2 Lantai";
    //     $this->rekap5Labels['c_3'] = "≥ 3 Lantai";

    //     /* D - Fungsi Rumah */
    //     foreach ($this->masterFungsiRumah as $m) {
    //         $key = "d_{$m->id_fungsi_rumah}";
    //     // $this->columnsFungsiRumah[] = $key;
    //         $this->rekap5Columns[] = $key;
    //         $this->rekap5Labels[$key] = $m->fungsi_rumah;
    //     }

    //     /* E - Tipe Rumah */
    //     foreach ($this->masterTipeRumah as $m) {
    //         $key = "e_{$m->id_tipe_rumah}";
    //         //$this->columnsTipeRumah[] = $key;
    //         $this->rekap5Columns[] = $key;
    //         $this->rekap5Labels[$key] = $m->tipe_rumah;
    //     }

    //     /* F - Status DTKS */
    //     foreach ($this->masterStatusDtks as $m) {
    //         $key = "f_{$m->id_status_dtks}";
    //     // $this->columnsStatusDtks[] = $key;
    //         $this->rekap5Columns[] = $key;
    //         $this->rekap5Labels[$key] = $m->status_dtks;
    //     }
    // }

  


    public function loadData()
    {
        // 🔹 Ambil nama kecamatan
        $this->kecamatanNama = Rumah::where('kecamatan_id', $this->kecamatanId)
            ->with('kecamatan:id_kecamatan,nama_kecamatan')
            ->first()?->kecamatan?->nama_kecamatan;

        // 🔹 Data agregat per kelurahan
        $rumah = Rumah::with(['kelurahan:id_kelurahan,nama_kelurahan', 'penilaian', 'fisik', 'sosialEkonomi'])
            ->where('kecamatan_id', $this->kecamatanId)
            ->whereNotNull('kelurahan_id')
            ->get();

       $this->rekap1 = $rumah->groupBy('kelurahan.nama_kelurahan')->map(function ($items, $kel) {
            return [
                'nama_kelurahan' => $kel,
                'jumlah_rumah' => $items->count(),
                'jumlah_kk' => $items->sum(fn($r) => data_get($r, 'sosialEkonomi.jumlah_kk_id', 0)),
                'penghuni_laki' => $items->sum(fn($r) => data_get($r, 'fisik.jumlah_penghuni_laki', 0)),
                'penghuni_perempuan' => $items->sum(fn($r) => data_get($r, 'fisik.jumlah_penghuni_perempuan', 0)),
                'rlh' => $items->where(fn($r) => data_get($r, 'penilaian.status_rumah') === 'RLH')->count(),
                'rtlh' => $items->where(fn($r) => data_get($r, 'penilaian.status_rumah') === 'RTLH')->count(),
                'prioritas_a1' => $items->where(fn($r) => data_get($r, 'penilaian.prioritas_a') == 1)->count(),
                'prioritas_a2' => $items->where(fn($r) => data_get($r, 'penilaian.prioritas_a') == 2)->count(),
                'prioritas_b1' => $items->where(fn($r) => data_get($r, 'penilaian.prioritas_b') == 1)->count(),
                'prioritas_b2' => $items->where(fn($r) => data_get($r, 'penilaian.prioritas_b') == 2)->count(),
                'prioritas_c1' => $items->where(fn($r) => data_get($r, 'penilaian.prioritas_c') == 1)->count(),
                'prioritas_c2' => $items->where(fn($r) => data_get($r, 'penilaian.prioritas_c') == 2)->count(),
                'kk_lebih_1' => $items->where(fn($r) => data_get($r, 'sosialEkonomi.jumlah_kk_id', 0) > 1)->count(),
                'kk_1' => $items->where(fn($r) => data_get($r, 'sosialEkonomi.jumlah_kk_id', 0) == 1)->count(),
            ];
        });

        $this->rekap2 = Rekap2Builder::getData($this->kecamatanId);
        $this->rekap2Sum = $this->calculateSum($this->rekap2, [
                'nama_kelurahan',
                'nama_kecamatan',
                'kelurahan_id',
                'kecamatan_id'
            ]);

         $this->rekap3 = Rekap3Builder::build($this->kecamatanId);
         $this->rekap3Sum = $this->calculateSum($this->rekap3, [
            'nama_kelurahan',
            'nama_kecamatan',
            'kelurahan_id'
        ]);

         $this->rekap4 = Rekap4Builder::build($this->kecamatanId);
      
        // Hitung total
        $this->rekap4Sum = $this->calculateSum($this->rekap4, [
            'nama_kelurahan',
            'nama_kecamatan',
            'kelurahan_id'
        ]);



        $this->rekap5 = Rekap5Builder::build($this->kecamatanId);
        
        $this->rekap5Sum = $this->calculateSum($this->rekap5, [
            'nama_kelurahan',
            'nama_kecamatan',
            'kelurahan_id'
        ]);

           $this->rekap6 = \App\Services\Rekap6Builder::build($this->kecamatanId);

        // Hitung total semua kolom, kecuali kolom identitas
        $this->rekap6Sum = $this->calculateSum($this->rekap6, [
            'nama_kelurahan',
            'nama_kecamatan',
            'kelurahan_id'
        ]);

        
    }

   
// public function loadRekap2Sum()
// {
//     $sum = [];

//     if ($this->rekap2->isEmpty()) {
//         $this->rekap2Sum = [];
//         return;
//     }

//     // Ambil semua kolom dari row pertama
//     $columns = array_keys((array) $this->rekap2->first());

//     foreach ($columns as $col) {

//         // Lewati kolom non-numeric
//         if (in_array($col, [
//             'nama_kelurahan',
//             'nama_kecamatan',
//             'kelurahan_id',
//             'kecamatan_id'
//         ])) {
//             continue;
//         }

//         // Hitung manual dengan filter hanya nilai angka
//         $sum[$col] = $this->rekap2
//             ->pluck($col)
//             ->filter(fn($v) => is_numeric($v))
//             ->sum();
//     }

//     $this->rekap2Sum = $sum;
// }

public function calculateSum($collection, $skip = [])
{
    $sum = [];

    if ($collection->isEmpty()) {
        return [];
    }

    $firstRow = json_decode(json_encode($collection->first()), true);
$columns = array_keys($firstRow);

    foreach ($columns as $col) {

        // Lewati kolom non-angka
        if (in_array($col, $skip)) {
            continue;
        }

        // Hitung sum hanya angka
        $sum[$col] = $collection
            ->pluck($col)
            ->filter(fn($v) => is_numeric($v))
            ->sum();
    }

    return $sum;
}



    public function render()
    {
        return view('livewire.rekap')
            ->extends('layouts.master')
            ->section('content');
    }
}
