<?php

namespace App\Livewire\Rumah;

use App\Exports\BantuanSheet;
use App\Exports\RumahExport;
use Livewire\Component;
use App\Models\AKondisiBalok;
use App\Models\AKondisiKolomTiang;
use App\Models\AKondisiPondasi;
use App\Models\AKondisiSloof;
use App\Models\AKondisiStrukturAtap;
use App\Models\AnggotaKeluarga;
use App\Models\APondasi;
use App\Models\BantuanRumah;
use App\Models\BFrekuensiPenyedotan;
use App\Models\BJamban;
use App\Models\BJendelaLubangCahaya;
use App\Models\BKamarMandi;
use App\Models\BKondisiJamban;
use App\Models\BKondisiJendelaLubangCahaya;
use App\Models\BKondisiKamarMandi;
use App\Models\BKondisiSistemPembuanganAirKotor;
use App\Models\BKondisiSumberAirMinum;
use App\Models\BKondisiVentilasi;
use App\Models\BSistemPembuanganAirKotor;
use App\Models\BSumberAirMinum;
use App\Models\BSumberListrik;
use App\Models\BVentilasi;
use App\Models\CFungsiRumah;
use App\Models\CJenisFisikBangunan;
use App\Models\CRuangKeluargaDanTidur;
use App\Models\CStatusDtks;
use App\Models\CTipeRumah;
use App\Models\DAksesKeJalan;
use App\Models\DBangunanBeradaLimbah;
use App\Models\DBangunanBeradaSungai;
use App\Models\DBangunanMenghadapJalan;
use App\Models\DBangunanMenghadapSungai;
use App\Models\DKondisiDinding;
use App\Models\DKondisiLantai;
use App\Models\DKondisiPenutupAtap;
use App\Models\DMaterialAtapTerluas;
use App\Models\DMaterialDindingTerluas;
use App\Models\DMaterialLantaiTerluas;
use App\Models\DokumenRumah;
use App\Models\FisikRumah;
use App\Models\IAsetRumahTempatLain;
use App\Models\IAsetTanahTempatLain;
use App\Models\IBesarPengeluaran;
use App\Models\IBesarPenghasilan;
use App\Models\IBuktiKepemilikanTanah;
use App\Models\IJenisKawasanLokasi;
use App\Models\IJenisKelamin;
use App\Models\IJumlahKk;
use App\Models\IKecamatan;
use App\Models\IKelurahan;
use App\Models\IPekerjaanUtama;
use App\Models\IPendidikanTerakhir;
use App\Models\IPernahMendapatkanBantuan;
use App\Models\IStatusImb;
use App\Models\IStatusKepemilikanRumah;
use App\Models\IStatusKepemilikanTanah;
use App\Models\KepalaKeluarga;
use App\Models\KepemilikanRumah;
use App\Models\PenilaianRumah;
use App\Models\Rumah;
use App\Models\SanitasiRumah;
use App\Models\SosialEkonomiRumah;
use App\Models\TblJenisPondasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class Filter extends Component
{

    // publiC $latitude = null;
    public $prioritas,$limit_data;
    // public $longitude = null;
    // public $jenis_kelamin_id;
    // public $usia;
    // public $pendidikan_terakhir_id;
    // public $pekerjaan_utama_id;
    // public $besar_penghasilan_id;
    // public $besar_pengeluaran_id;
    // public $alamat;
    // public $rt;
    // public $rw;

    // 🔹 Lokasi
    public $kecamatan_id = [];
    public $kelurahan_id= [];

    // 🔹 Kepemilikan & Status Tanah/Rumah
    public $status_kepemilikan_tanah_id= [];
    public $bukti_kepemilikan_tanah_id = [];
    public $status_kepemilikan_rumah_id = [];
    // public $nik_kepemilikan_rumah= [];
    public $status_imb_id= [];
    // public $nomor_imb;

    // 🔹 Aset Tambahan
    public $aset_rumah_ditempat_lain_id= [];
    public $aset_tanah_ditempat_lain_id = [];

    // 🔹 Bantuan
    public $pernah_mendapatkan_bantuan_id = [];
    // public $no_kk_penerima;
    // public $tahun_bantuan;
    // public $nama_bantuan;
    // public $nama_program_bantuan;
    // public $nominal_bantuan;

    // 🔹 Jenis Kawasan
    public $jenis_kawasan_lokasi_rumah_id = [];

    public $iJumlahKK = [];

    // public $currentStep = 1;
    public $jumlah_kk_id = [];
    // public $kks = [];

    public $iJenisKelamin = [];
    public $iPendidikanTerakhir = [];
    public $iPekerjaanUtama = [];
    public $iBesarPenghasilan = [];
    public $iBesarPengeluaran = [];
    public $iKecamatan = [];
    public $iKelurahan = [];
    public $iStatusKepemilikanTanah = [];
    public $iBuktiKepemilikanTanah = [];
    public $iStatusKepemilikanRumah = [];
    public $iStatusImb = [];
    public $iAsetRumahTempatLain = [];
    public $iAsetTanahTempatLain = [];
    public $iPernahMendapatkanBantuan = [];
    public $iJenisKawasanLokasi = [];
    
    public $filteredKelurahan = [];


    public $pondasi_id = [];
    public $jenis_pondasi_id = [];
    public $kondisi_pondasi_id = [];
    public $kondisi_sloof_id = [];
    public $kondisi_kolom_tiang_id = [];
    public $kondisi_balok_id = [];
    public $kondisi_struktur_atap_id = [];

    public $aPondasi;
    public $aJenisPondasi;
    public $aKondisiPondasi;
    public $aKondisiSloof;
    public $aKondisiKolomTiang;
    public $aKondisiBalok;
    public $aKondisiStrukturAtap;

    // ✅ Model-bound properties
    public $jendela_lubang_cahaya_id = [];
    public $kondisi_jendela_lubang_cahaya_id = [];
    public $ventilasi_id = [];
    // public $keterangan_ventilasi;
    public $kondisi_ventilasi_id = [];
    public $kamar_mandi_id = [];
    public $kondisi_kamar_mandi_id = [];
    public $jamban_id = [];
    public $kondisi_jamban_id = [];
    public $sistem_pembuangan_air_kotor_id = [];
    public $kondisi_sistem_pembuangan_air_kotor_id = [];
    public $frekuensi_penyedotan_id = [];
    public $sumber_air_minum_id = [];
    public $kondisi_sumber_air_minum_id = [];
    public $sumber_listrik_id = [];

    // ✅ Dataset variables
    public $bJendelaLubangCahaya;
    public $bKondisiJendelaLubangCahaya;
    public $bVentilasi;
    public $bKondisiVentilasi;
    public $bKamarMandi;
    public $bKondisiKamarMandi;
    public $bJamban;
    public $bKondisiJamban;
    public $bSistemPembuanganAirKotor;
    public $bKondisiSistemPembuanganAirKotor;
    public $bFrekuensiPenyedotan;
    public $bSumberAirMinum;
    public $bKondisiSumberAirMinum;
    public $bSumberListrik;


    //  public $luas_rumah;
    // public $jumlah_penghuni_laki;
    // public $jumlah_penghuni_perempuan;
    // public $jumlah_abk;
    // public $tinggi_rata_rumah;
    public $ruang_keluarga_dan_tidur_id = [];
    // public $jumlah_kamar_tidur;
    // public $luas_rata_kamar_tidur;
    public $jenis_fisik_bangunan_id = [];
    // public $jumlah_lantai_bangunan
    public $fungsi_rumah_id = [];
    public $tipe_rumah_id = [];
    public $status_dtks_id = [];
    // public $tahun_pembangunan_rumah;

    // ✅ Data reference
    public $cRuangKeluargaDanTidur;
    public $cJenisFisikBangunan;
    public $cFungsiRumah;
    public $cTipeRumah;
    public $cStatusDtks;


     public $material_atap_terluas_id = [];
    public $kondisi_penutup_atap_id= [];
    public $material_dinding_terluas_id= [];
    public $kondisi_dinding_id= [];
    public $material_lantai_terluas_id= [];
    public $kondisi_lantai_id= [];
    public $akses_ke_jalan_id= [];
    public $bangunan_menghadap_jalan_id= [];
    public $bangunan_menghadap_sungai_id= [];
    public $bangunan_berada_limbah_id= [];
    public $bangunan_berada_sungai_id= [];

    // ✅ Dataset reference
    public $dMaterialAtapTerluas;
    public $dKondisiPenutupAtap;
    public $dMaterialDindingTerluas;
    public $dKondisiDinding;
    public $dMaterialLantaiTerluas;
    public $dKondisiLantai;
    public $dAksesKeJalan;
    public $dBangunanMenghadapJalan;
    public $dBangunanMenghadapSungai;
    public $dBangunanBeradaLimbah;
    public $dBangunanBeradaSungai;

    public $filteredData = [];
    public $exportFormat = '';
    protected $listeners = ['applySelect2Filters','handleExportFromFilter'];
   
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
            $disk = 'public';

            $exportPath = storage_path("app/public/$folder");
            if (!file_exists($exportPath)) mkdir($exportPath, 0777, true);

            $files = [];
            $maxRows = 1000;

            $total = $this->buildFilteredQuery()->count();
            $chunkCount = ceil($total / $maxRows);

            for ($i = 0; $i < $chunkCount; $i++) {
                $offset = $i * $maxRows;
                $filename = "data_rumah_" . ($i + 1) . ".xlsx";

                Excel::store(
                    new RumahExport($offset, $maxRows, $this->buildFilteredQuery()),
                    "$folder/$filename",
                    $disk
                );

                $files[] = storage_path("app/public/$folder/$filename");
            }

            // 💰 Ekspor Bantuan
            $bantuanFile = "data_bantuan.xlsx";
            Excel::store(
                new BantuanSheet($this->buildFilteredQuery()),
                "$folder/$bantuanFile",
                $disk
            );
            $files[] = storage_path("app/public/$folder/$bantuanFile");

            // 🗜️ Buat ZIP
            $zipFile = storage_path("app/public/export_data_$timestamp.zip");
            $zip = new \ZipArchive();

            if ($zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE)) {
                foreach ($files as $f) {
                    if (file_exists($f)) $zip->addFile($f, basename($f));
                }
                $zip->close();
            }

            // 🧹 Hapus file sementara
            foreach ($files as $f) {
                if (file_exists($f)) @unlink($f);
            }
            if (is_dir($exportPath)) @rmdir($exportPath);

            

            // ✅ Kirim URL download ke JS
           // $url = asset('storage/export_data_' . $timestamp . '.zip');
            $url = route('export.download', ['filename' => "export_data_$timestamp.zip"]);
            Log::info('✅ Excel ZIP generated', ['url' => $url]);

            //$this->dispatch('excel-ready', url: $url);
            $this->dispatch('geojson-ready', url: $url);
        } catch (\Throwable $e) {
            Log::error('Export Excel gagal: ' . $e->getMessage());
            $this->dispatch('swal:error', [
                'title' => 'Export Gagal!',
                'text'  => $e->getMessage(),
            ]);
        }
    }



    private function buildFilteredQuery()
    {
        $query = Rumah::with([
            'kepemilikan', 'sosialEkonomi', 'fisik', 'sanitasi', 'penilaian',
            'dokumen', 'bantuan', 'kepalaKeluarga.anggota', 'kelurahan.kecamatan'
        ])->orderBy('id_rumah', 'desc');

        // 🧩 Filter Lokasi
        if (!empty($this->kecamatan_id)) {
            $query->whereHas('kelurahan.kecamatan', fn($q) =>
                $q->whereIn('id_kecamatan', $this->kecamatan_id)
            );
        }
        if (!empty($this->kelurahan_id)) {
            $query->whereIn('kelurahan_id', $this->kelurahan_id);
        }

        // 🧩 Filter Kepemilikan
        $kepemilikanFields = [
            'status_kepemilikan_tanah_id', 'bukti_kepemilikan_tanah_id',
            'status_kepemilikan_rumah_id', 'status_imb_id',
            'aset_rumah_ditempat_lain_id', 'aset_tanah_ditempat_lain_id',
            'jenis_kawasan_lokasi_rumah_id'
        ];
        foreach ($kepemilikanFields as $field) {
            if (!empty($this->$field)) {
                $query->whereHas('kepemilikan', fn($q) =>
                    $q->whereIn($field, (array)$this->$field)
                );
            }
        }

        // 🧩 Filter Fisik
        $fisikFields = [
            'pondasi_id','jenis_pondasi_id','kondisi_pondasi_id','kondisi_sloof_id',
            'kondisi_kolom_tiang_id','kondisi_balok_id','kondisi_struktur_atap_id',
            'material_atap_terluas_id','kondisi_penutup_atap_id','material_dinding_terluas_id',
            'kondisi_dinding_id','material_lantai_terluas_id','kondisi_lantai_id',
            'akses_ke_jalan_id','bangunan_menghadap_jalan_id','bangunan_menghadap_sungai_id',
            'bangunan_berada_limbah_id','bangunan_berada_sungai_id','ruang_keluarga_dan_tidur_id',
            'jenis_fisik_bangunan_id','fungsi_rumah_id','tipe_rumah_id'
        ];
        foreach ($fisikFields as $field) {
            if (!empty($this->$field)) {
                $query->whereHas('fisik', fn($q) =>
                    $q->whereIn($field, (array)$this->$field)
                );
            }
        }

        // 🧩 Filter Sanitasi
        $sanitasiFields = [
            'jendela_lubang_cahaya_id','kondisi_jendela_lubang_cahaya_id',
            'ventilasi_id','kondisi_ventilasi_id','kamar_mandi_id','kondisi_kamar_mandi_id',
            'jamban_id','kondisi_jamban_id','sistem_pembuangan_air_kotor_id',
            'kondisi_sistem_pembuangan_air_kotor_id','frekuensi_penyedotan_id',
            'sumber_air_minum_id','kondisi_sumber_air_minum_id','sumber_listrik_id'
        ];
        foreach ($sanitasiFields as $field) {
            if (!empty($this->$field)) {
                $query->whereHas('sanitasi', fn($q) =>
                    $q->whereIn($field, (array)$this->$field)
                );
            }
        }

        // 🧩 Filter Sosial Ekonomi
        if (!empty($this->jumlah_kk_id)) {
            $query->whereHas('sosialEkonomi', fn($q) =>
                $q->whereIn('jumlah_kk_id', $this->jumlah_kk_id)
            );
        }
        if (!empty($this->status_dtks_id)) {
            $query->whereHas('sosialEkonomi', fn($q) =>
                $q->whereIn('status_dtks_id', $this->status_dtks_id)
            );
        }

        // 🧩 Filter Bantuan
        if (!empty($this->pernah_mendapatkan_bantuan_id)) {
            $query->whereHas('bantuan', fn($q) =>
                $q->whereIn('pernah_mendapatkan_bantuan_id', $this->pernah_mendapatkan_bantuan_id)
            );
        }

        // 🧩 Filter Prioritas
        if (!empty($this->prioritas)) {
            $p = $this->prioritas;
            $query->whereHas('penilaian', function ($q) use ($p) {
                if ($p == '1') $q->where('prioritas_a', '2');
                if ($p == '2') $q->where('prioritas_b', '2');
                if ($p == '3') $q->where('prioritas_c', '2');
            });
        }

        return $query;
    }





    public function exportGeoJson()
    {
        try {
            $query = $this->buildFilteredQuery();

            Log::info('🧠 Query SQL:', [
                'sql' => $query->toSql(),
                'bindings' => $query->getBindings(),
            ]);

            $features = [];

            $query->whereNotNull('latitude')->whereNotNull('longitude')
                ->chunk(500, function ($chunk) use (&$features) {
                    foreach ($chunk as $r) {
                        $kepala = $r->kepalaKeluarga?->first();
                        $anggota = $kepala?->anggota?->first();
                        $nama = $anggota?->nama ?? '-';

                        $features[] = [
                            'type' => 'Feature',
                            'geometry' => [
                                'type' => 'Point',
                                'coordinates' => [
                                    (float) $r->longitude,
                                    (float) $r->latitude
                                ],
                            ],
                            'properties' => [
                                'id_rumah' => $r->id_rumah,
                                'nama' => $nama,
                                'alamat' => $r->alamat,
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

            // Simpan file ke storage/public
            $filename = 'rumah_filtered_' . now()->format('Ymd_His') . '.geojson';
            $filePath = Storage::disk('public')->path($filename);

            Storage::disk('public')->put($filename, json_encode($geojson, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            // Dapatkan URL publik ke file
            // $url = Storage::url($filename);

            // Log::info('✅ GeoJSON generated', ['url' => $url]);

            // URL download via route (auto delete setelah download)
        $url = route('geojson.download', ['filename' => $filename]);

        Log::info('✅ GeoJSON generated', ['url' => $url]);
            // Emit event ke browser agar JS trigger download
            $this->dispatch('geojson-ready', url: $url);
        } catch (\Throwable $e) {
            Log::error('Export GeoJSON gagal: ' . $e->getMessage());
            $this->dispatch('swal:error', [
                'title' => 'Export Gagal!',
                'text'  => $e->getMessage(),
            ]);
        }
    }



    public function mount()
    {
        // Daftar listener Livewire 3 style
        // $this->on('setStep', fn ($step) => $this->setStep($step));

        $this->iJumlahKK = IJumlahKk::all(['id_jumlah_kk', 'jumlah_kk']);
        $this->iJenisKelamin = IJenisKelamin::all();
        $this->iPendidikanTerakhir = IPendidikanTerakhir::all();
        $this->iPekerjaanUtama = IPekerjaanUtama::all();
        $this->iBesarPenghasilan = IBesarPenghasilan::all();
        $this->iBesarPengeluaran = IBesarPengeluaran::all();
        $this->iKecamatan = IKecamatan::all();
        $this->iKelurahan = IKelurahan::all();
        $this->iStatusKepemilikanTanah = IStatusKepemilikanTanah::all();
        $this->iBuktiKepemilikanTanah = IBuktiKepemilikanTanah::all();
        $this->iStatusKepemilikanRumah = IStatusKepemilikanRumah::all();
        $this->iStatusImb = IStatusImb::all();
        $this->iAsetRumahTempatLain = IAsetRumahTempatLain::all();
        $this->iAsetTanahTempatLain = IAsetTanahTempatLain::all();
        $this->iPernahMendapatkanBantuan = IPernahMendapatkanBantuan::all();
        $this->iJenisKawasanLokasi = IJenisKawasanLokasi::all();

        $this->aPondasi = APondasi::all();
        $this->aJenisPondasi = TblJenisPondasi::all();
        $this->aKondisiPondasi = AKondisiPondasi::all();
        $this->aKondisiSloof = AKondisiSloof::all();
        $this->aKondisiKolomTiang = AKondisiKolomTiang::all();
        $this->aKondisiBalok = AKondisiBalok::all();
        $this->aKondisiStrukturAtap = AKondisiStrukturAtap::all();

        $this->bJendelaLubangCahaya = BJendelaLubangCahaya::all();
        $this->bKondisiJendelaLubangCahaya = BKondisiJendelaLubangCahaya::all();
        $this->bVentilasi = BVentilasi::all();
        $this->bKondisiVentilasi = BKondisiVentilasi::all();
        $this->bKamarMandi = BKamarMandi::all();
        $this->bKondisiKamarMandi = BKondisiKamarMandi::all();
        $this->bJamban = BJamban::all();
        $this->bKondisiJamban = BKondisiJamban::all();
        $this->bSistemPembuanganAirKotor = BSistemPembuanganAirKotor::all();
        $this->bKondisiSistemPembuanganAirKotor = BKondisiSistemPembuanganAirKotor::all();
        $this->bFrekuensiPenyedotan = BFrekuensiPenyedotan::all();
        $this->bSumberAirMinum = BSumberAirMinum::all();
        $this->bKondisiSumberAirMinum = BKondisiSumberAirMinum::all();
        $this->bSumberListrik = BSumberListrik::all();

         $this->cRuangKeluargaDanTidur = CRuangKeluargaDanTidur::all();
        $this->cJenisFisikBangunan = CJenisFisikBangunan::all();
        $this->cFungsiRumah = CFungsiRumah::all();
        $this->cTipeRumah = CTipeRumah::all();
        $this->cStatusDtks = CStatusDtks::all();


        $this->dMaterialAtapTerluas = DMaterialAtapTerluas::all();
        $this->dKondisiPenutupAtap = DKondisiPenutupAtap::all();
        $this->dMaterialDindingTerluas = DMaterialDindingTerluas::all();
        $this->dKondisiDinding = DKondisiDinding::all();
        $this->dMaterialLantaiTerluas = DMaterialLantaiTerluas::all();
        $this->dKondisiLantai = DKondisiLantai::all();
        $this->dAksesKeJalan = DAksesKeJalan::all();
        $this->dBangunanMenghadapJalan = DBangunanMenghadapJalan::all();
        $this->dBangunanMenghadapSungai = DBangunanMenghadapSungai::all();
        $this->dBangunanBeradaLimbah = DBangunanBeradaLimbah::all();
        $this->dBangunanBeradaSungai = DBangunanBeradaSungai::all();
    }

    
    // public function select2Changed($data)
    // {
    //     $name = $data['name'] ?? null;
    //     $value = $data['value'] ?? null;

    //     if ($name && property_exists($this, $name)) {
    //         $this->$name = $value;
    //         logger("✅ Livewire menerima {$name} = {$value}");
    //     }

    //     // 🔹 Jika kecamatan berubah, filter kelurahan
    //     if ($name === 'kecamatan_id') {
    //         $this->filterKelurahan();
    //     }

       
    // }
    #[On('select2Changed')]
    public function select2Changed($data)
    {
        try {
            $name  = $data['name'] ?? null;
            $value = $data['value'] ?? null;

            if (!$name) {
                throw new \Exception('data-name kosong');
            }

            if (!property_exists($this, $name)) {
                throw new \Exception("Property {$name} tidak ditemukan di komponen");
            }

            // kalau value array, simpan apa adanya
            if (is_array($value)) {
                $this->$name = array_filter($value); // hilangkan null kosong
            } else {
                $this->$name = $value;
            }

            logger("✅ {$name} updated: " . json_encode($value));

            if ($name === 'kecamatan_id') {
                $this->filterKelurahan();
            }

        } catch (\Throwable $e) {
            logger('❌ select2Changed error: ' . $e->getMessage());
            throw $e;
        }
    }

    public function filterKelurahan()
    {
        // Jika belum ada kecamatan dipilih, kosongkan saja
        if (empty($this->kecamatan_id)) {
            $this->filteredKelurahan = collect();
            return;
        }

        // 🔹 Filter daftar kelurahan berdasarkan banyak kecamatan
        $this->filteredKelurahan = IKelurahan::whereIn('kecamatan_id', $this->kecamatan_id)
            ->orderBy('nama_kelurahan')
            ->get();

       Log::info($this->filteredKelurahan);



        // 🔹 Reset pilihan kelurahan
        $this->kelurahan_id = [];

        // 🔹 Kirim event ke browser supaya Select2 Kelurahan juga di-reset
        $this->dispatch('resetKelurahanSelect2');
        $this->dispatch('updateKelurahanOptions', $this->filteredKelurahan->values()->toArray());

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

   
    public function handleExportFromFilter($payload = [])
    {
        if (empty($payload)) {
            Log::warning('⚠️ Payload kosong saat handleExportFromFilter');
            return;
        }

        $this->exportFormat = $payload['format'] ?? 'excel';

        Log:info('nah disni',$this->filteredData);

        // foreach ($payload['filters'] ?? [] as $key => $value) {
        //     if (property_exists($this, $key)) {
        //         $this->$key = $value;
        //     }
        // }

         if (!empty($this->filteredData)) {
                foreach ($this->filteredData as $key => $value) {
                    if (property_exists($this, $key)) {
                        $this->$key = is_array($value) ? array_filter($value) : [$value];
                    }
                }
            }


        Log::info('✅ FILTER TERISI SAAT EXPORT', [
            'format'       => $this->exportFormat,
            'kecamatan_id' => $this->kecamatan_id,
            'kelurahan_id' => $this->kelurahan_id,
            'payload' => $payload['filters'] 
        ]);

        $this->exportData();
    }

    public function submitForm(){
         $this->dispatch('collectSelect2Values');
    }

    

    public function applySelect2Filters($filters)
    {
        $this->filteredData = $filters;

        Log:info($this->filteredData);

        // kalau masih perlu jalankan logika spesifik:
        if (!empty($this->filteredData['kecamatan_id'])) {
            $this->filterKelurahan();
        }

        // 🚀 Kirim ke DataTables
        $this->dispatch('refreshDataTable', $this->filteredData);
          $this->dispatch('swal:success', [
                'title' => 'Berhasil!',
                'text'  => 'Pencarian sudah dilakukan',
            ]);
    }

    public function render()
    {
        return view('livewire.rumah.filter')
        ->extends('layouts.master')
            ->section('content');
    }
}
