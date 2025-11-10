<?php

namespace App\Livewire\Rumah;

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
use Livewire\WithFileUploads;

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

    // public function submitForm()
    // {
    //     $query = Rumah::with([
    //         'kepemilikan', 'sosialEkonomi', 'fisik', 'sanitasi',
    //         'penilaian', 'dokumen', 'bantuan', 'kepalaKeluarga.anggota',
    //         'kelurahan.kecamatan',
    //     ])->orderBy('id_rumah', 'desc');

    //     // === 1️⃣ Filter Lokasi ===
    //     if (!empty($this->kecamatan_id)) {
    //         $query->whereHas('kelurahan.kecamatan', fn($q) =>
    //             $q->whereIn('id_kecamatan', (array) $this->kecamatan_id)
    //         );
    //     }

    //     if (!empty($this->kelurahan_id)) {
    //         $query->whereIn('kelurahan_id', (array) $this->kelurahan_id);
    //     }

    //     // === 2️⃣ Filter Dinamis Semua Properti ===
    //     $fields = [
    //         // Kepemilikan & Tanah
    //         'status_kepemilikan_tanah_id', 'bukti_kepemilikan_tanah_id',
    //         'status_kepemilikan_rumah_id', 'status_imb_id',

    //         // Aset
    //         'aset_rumah_ditempat_lain_id', 'aset_tanah_ditempat_lain_id',

    //         // Bantuan & Kawasan
    //         'pernah_mendapatkan_bantuan_id', 'jenis_kawasan_lokasi_rumah_id',

    //         // Struktur
    //         'pondasi_id','jenis_pondasi_id', 'kondisi_pondasi_id', 'kondisi_sloof_id',
    //         'kondisi_kolom_tiang_id', 'kondisi_balok_id', 'kondisi_struktur_atap_id',

    //         // Pencahayaan & Ventilasi
    //         'jendela_lubang_cahaya_id', 'kondisi_jendela_lubang_cahaya_id',
    //         'ventilasi_id', 'kondisi_ventilasi_id',

    //         // Sanitasi
    //         'kamar_mandi_id', 'kondisi_kamar_mandi_id',
    //         'jamban_id', 'kondisi_jamban_id',
    //         'sistem_pembuangan_air_kotor_id', 'kondisi_sistem_pembuangan_air_kotor_id',
    //         'frekuensi_penyedotan_id',

    //         // Sumber daya
    //         'sumber_air_minum_id', 'kondisi_sumber_air_minum_id',
    //         'sumber_listrik_id',

    //         // Ruang & Fisik
    //         'ruang_keluarga_dan_tidur_id', 'jenis_fisik_bangunan_id',
    //         'fungsi_rumah_id', 'tipe_rumah_id',

    //         // Sosial Ekonomi
    //         'status_dtks_id','jumlah_kk_id',

    //         // Material
    //         'material_atap_terluas_id', 'kondisi_penutup_atap_id',
    //         'material_dinding_terluas_id', 'kondisi_dinding_id',
    //         'material_lantai_terluas_id', 'kondisi_lantai_id',

    //         // Akses & Lingkungan
    //         'akses_ke_jalan_id', 'bangunan_menghadap_jalan_id',
    //         'bangunan_menghadap_sungai_id', 'bangunan_berada_limbah_id',
    //         'bangunan_berada_sungai_id',
    //     ];

    //     foreach ($fields as $field) {
    //         $value = $this->$field ?? null;
    //         if (!empty($value)) {
    //             if (is_array($value)) {
    //                 $query->whereIn($field, $value);
    //             } else {
    //                 $query->where($field, $value);
    //             }
    //         }
    //     }

    //     // === 3️⃣ Filter Prioritas & Limit (opsional) ===
    //     if (!empty($this->prioritas)) {
    //         if ($this->prioritas == '1') {
    //             $query->where('prioritas_a', '2');
    //         } elseif ($this->prioritas == '2') {
    //             $query->where('prioritas_b', '2');
    //         } elseif ($this->prioritas == '3') {
    //             $query->where('prioritas_c', '2');
    //         }
    //     }

    //     // if (!empty($this->limit_data)) {
    //     //     $query->limit((int) $this->limit_data);
    //     // }

    //     // === 4️⃣ Ambil hasil ===
    //     $this->filteredData = $query->get();

    //     logger('✅ Filter diterapkan', [
    //         'total' => $this->filteredData->count(),
    //         'filters' => array_filter(get_object_vars($this)),
    //     ]);

    //     session()->flash('success', 'Filter berhasil diterapkan ✅');
    // }

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


    //  public function submitForm()
    // {

        
    //     $filters = [
    //         // PRIORITAS & LIMIT
    //         'prioritas' => $this->prioritas,
    //         // LOKASI
    //         'kecamatan_id' => $this->kecamatan_id,
    //         'kelurahan_id' => $this->kelurahan_id,

    //         // KEPEMILIKAN
    //         'status_kepemilikan_tanah_id' => $this->status_kepemilikan_tanah_id,
    //         'bukti_kepemilikan_tanah_id' => $this->bukti_kepemilikan_tanah_id,
    //         'status_kepemilikan_rumah_id' => $this->status_kepemilikan_rumah_id,
    //         'status_imb_id' => $this->status_imb_id,

    //         // ASET
    //         'aset_rumah_ditempat_lain_id' => $this->aset_rumah_ditempat_lain_id,
    //         'aset_tanah_ditempat_lain_id' => $this->aset_tanah_ditempat_lain_id,

    //         // BANTUAN
    //         'pernah_mendapatkan_bantuan_id' => $this->pernah_mendapatkan_bantuan_id,

    //         // KAWASAN
    //         'jenis_kawasan_lokasi_rumah_id' => $this->jenis_kawasan_lokasi_rumah_id,

    //         // SOSIAL EKONOMI
    //         'jumlah_kk_id' => $this->jumlahKK,
    //         'status_dtks_id' => $this->status_dtks_id,

    //         // STRUKTUR (ASPEK KESELAMATAN)
    //         'pondasi_id' => $this->pondasi_id,
    //         'jenis_pondasi_id' => $this->jenis_pondasi_id,
    //         'kondisi_pondasi_id' => $this->kondisi_pondasi_id,
    //         'kondisi_sloof_id' => $this->kondisi_sloof_id,
    //         'kondisi_kolom_tiang_id' => $this->kondisi_kolom_tiang_id,
    //         'kondisi_balok_id' => $this->kondisi_balok_id,
    //         'kondisi_struktur_atap_id' => $this->kondisi_struktur_atap_id,

    //         // PENCERAHAN & VENTILASI (ASPEK KESEHATAN)
    //         'jendela_lubang_cahaya_id' => $this->jendela_lubang_cahaya_id,
    //         'kondisi_jendela_lubang_cahaya_id' => $this->kondisi_jendela_lubang_cahaya_id,
    //         'ventilasi_id' => $this->ventilasi_id,
    //         'kondisi_ventilasi_id' => $this->kondisi_ventilasi_id,

    //         // SANITASI
    //         'kamar_mandi_id' => $this->kamar_mandi_id,
    //         'kondisi_kamar_mandi_id' => $this->kondisi_kamar_mandi_id,
    //         'jamban_id' => $this->jamban_id,
    //         'kondisi_jamban_id' => $this->kondisi_jamban_id,
    //         'sistem_pembuangan_air_kotor_id' => $this->sistem_pembuangan_air_kotor_id,
    //         'kondisi_sistem_pembuangan_air_kotor_id' => $this->kondisi_sistem_pembuangan_air_kotor_id,
    //         'frekuensi_penyedotan_id' => $this->frekuensi_penyedotan_id,
    //         'sumber_air_minum_id' => $this->sumber_air_minum_id,
    //         'kondisi_sumber_air_minum_id' => $this->kondisi_sumber_air_minum_id,
    //         'sumber_listrik_id' => $this->sumber_listrik_id,

    //         // RUANG & FISIK
    //         'ruang_keluarga_dan_tidur_id' => $this->ruang_keluarga_dan_tidur_id,
    //         'jenis_fisik_bangunan_id' => $this->jenis_fisik_bangunan_id,
    //         'fungsi_rumah_id' => $this->fungsi_rumah_id,
    //         'tipe_rumah_id' => $this->tipe_rumah_id,

    //         // MATERIAL
    //         'material_atap_terluas_id' => $this->material_atap_terluas_id,
    //         'kondisi_penutup_atap_id' => $this->kondisi_penutup_atap_id,
    //         'material_dinding_terluas_id' => $this->material_dinding_terluas_id,
    //         'kondisi_dinding_id' => $this->kondisi_dinding_id,
    //         'material_lantai_terluas_id' => $this->material_lantai_terluas_id,
    //         'kondisi_lantai_id' => $this->kondisi_lantai_id,

    //         // AKSES & LINGKUNGAN
    //         'akses_ke_jalan_id' => $this->akses_ke_jalan_id,
    //         'bangunan_menghadap_jalan_id' => $this->bangunan_menghadap_jalan_id,
    //         'bangunan_menghadap_sungai_id' => $this->bangunan_menghadap_sungai_id,
    //         'bangunan_berada_limbah_id' => $this->bangunan_berada_limbah_id,
    //         'bangunan_berada_sungai_id' => $this->bangunan_berada_sungai_id,
    //     ];

    //     // 🔹 Dispatch ke JS → trigger DataTables reload
    //     $this->dispatch('refreshDataTable', $filters);
    //       $this->dispatch('swal:success', [
    //             'title' => 'Berhasil!',
    //             'text'  => 'Data rumah beserta semua komponen dan dokumentasi berhasil disimpan.',
    //         ]);

    // }

    public function submitForm(){
         $this->dispatch('collectSelect2Values');
    }

    protected $listeners = ['applySelect2Filters'];

    public function applySelect2Filters($filters)
    {
        $this->filteredData = $filters;

        // kalau masih perlu jalankan logika spesifik:
        if (!empty($this->filteredData['kecamatan_id'])) {
            $this->filterKelurahan();
        }

        // 🚀 Kirim ke DataTables
        $this->dispatch('refreshDataTable', $this->filteredData);
          $this->dispatch('swal:success', [
                'title' => 'Berhasil!',
                'text'  => 'Data rumah beserta semua komponen dan dokumentasi berhasil disimpan.',
            ]);
    }

    public function render()
    {
        return view('livewire.rumah.filter')
        ->extends('layouts.master')
            ->section('content');
    }
}
