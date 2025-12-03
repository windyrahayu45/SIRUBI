<?php

namespace App\Livewire\Rumah;

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
use App\Models\SurveyQuestion;
use App\Models\SurveyQuestionAnswer;
use App\Models\TblJenisPondasi;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class Add extends Component
{
    use WithFileUploads;
    
    publiC $latitude = null;
    public $longitude = null;
    public $jenis_kelamin_id;
    public $usia;
    public $pendidikan_terakhir_id;
    public $pekerjaan_utama_id;
    public $besar_penghasilan_id;
    public $besar_pengeluaran_id;
    public $alamat;
    public $rt;
    public $rw;

    // 🔹 Lokasi
    public $kecamatan_id;
    public $kelurahan_id;

    // 🔹 Kepemilikan & Status Tanah/Rumah
    public $status_kepemilikan_tanah_id;
    public $bukti_kepemilikan_tanah_id;
    public $status_kepemilikan_rumah_id;
    public $nik_kepemilikan_rumah;
    public $status_imb_id;
    public $nomor_imb;

    // 🔹 Aset Tambahan
    public $aset_rumah_ditempat_lain_id;
    public $aset_tanah_ditempat_lain_id;

    // 🔹 Bantuan
    public $pernah_mendapatkan_bantuan_id;
    public $no_kk_penerima;
    public $tahun_bantuan;
    public $nama_bantuan;
    public $nama_program_bantuan;
    public $nominal_bantuan;

    // 🔹 Jenis Kawasan
    public $jenis_kawasan_lokasi_rumah_id;

    public $iJumlahKK = [];

   public $currentStep = 1;
    public $jumlahKK = 0;
    public $kks = [];

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


    public $pondasi_id;
    public $jenis_pondasi_id;
    public $kondisi_pondasi_id;
    public $kondisi_sloof_id;
    public $kondisi_kolom_tiang_id;
    public $kondisi_balok_id;
    public $kondisi_struktur_atap_id;

    public $aPondasi;
    public $aJenisPondasi;
    public $aKondisiPondasi;
    public $aKondisiSloof;
    public $aKondisiKolomTiang;
    public $aKondisiBalok;
    public $aKondisiStrukturAtap;

    // ✅ Model-bound properties
    public $jendela_lubang_cahaya_id;
    public $kondisi_jendela_lubang_cahaya_id;
    public $ventilasi_id;
    public $keterangan_ventilasi;
    public $kondisi_ventilasi_id;
    public $kamar_mandi_id;
    public $kondisi_kamar_mandi_id;
    public $jamban_id;
    public $kondisi_jamban_id;
    public $sistem_pembuangan_air_kotor_id;
    public $kondisi_sistem_pembuangan_air_kotor_id;
    public $frekuensi_penyedotan_id;
    public $sumber_air_minum_id;
    public $kondisi_sumber_air_minum_id;
    public $sumber_listrik_id;

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


     public $luas_rumah;
    public $jumlah_penghuni_laki;
    public $jumlah_penghuni_perempuan;
    public $jumlah_abk;
    public $tinggi_rata_rumah;
    public $ruang_keluarga_dan_tidur_id;
    public $jumlah_kamar_tidur;
    public $luas_rata_kamar_tidur;
    public $jenis_fisik_bangunan_id;
    public $jumlah_lantai_bangunan;
    public $fungsi_rumah_id;
    public $tipe_rumah_id;
    public $status_dtks_id;
    public $tahun_pembangunan_rumah;

    // ✅ Data reference
    public $cRuangKeluargaDanTidur;
    public $cJenisFisikBangunan;
    public $cFungsiRumah;
    public $cTipeRumah;
    public $cStatusDtks;


     public $material_atap_terluas_id;
    public $kondisi_penutup_atap_id;
    public $material_dinding_terluas_id;
    public $kondisi_dinding_id;
    public $material_lantai_terluas_id;
    public $kondisi_lantai_id;
    public $akses_ke_jalan_id;
    public $bangunan_menghadap_jalan_id;
    public $bangunan_menghadap_sungai_id;
    public $bangunan_berada_limbah_id;
    public $bangunan_berada_sungai_id;

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

    public $foto_kk;
    public $foto_ktp;
    public $foto_rumah_satu;
    public $foto_rumah_dua;
    public $foto_rumah_tiga;
    public $foto_imb;
    public $is_question = false;
    public $question = [];
    public $questionAnswers = []; 
    public $totalStep = 10; 
    public $lastStep = 7; 
    public $childQuestions = [];
    public $allQuestions = [];
    
    public $pertanyaanLokasi = [];
    public $pertanyaanKk = [];
    public $pertanyaanIdentitas = [];
    public $pertanyaanKeselamatan = [];
    public  $pertanyaanKesehatan = [];
    public $pertanyaanLuasBangunan = [];
    public  $pertanyaanBahanBangunan = [];
    public $pertanyaanDokumentasi = [];
    public $pertanyaanLainnya = [];




    public function mount()
    {
        // Daftar listener Livewire 3 style
        // $this->on('setStep', fn ($step) => $this->setStep($step));
        $this->is_question = SurveyQuestion::where('is_active', '1')->where('module','pertanyaan_lainnya')->exists();
         $this->totalStep = $this->is_question ? 10 : 9;
        $this->question = SurveyQuestion::with('options')
            ->where('is_active', 1)
            ->whereNull('parent_question_id')
            ->orderBy('id', 'desc')
            ->get(); 

            
        
        $this->pertanyaanLokasi        = $this->question->where('module', 'lokasi');
        $this->pertanyaanKk            = $this->question->where('module', 'penghuni_rumah');
        $this->pertanyaanIdentitas     = $this->question->where('module', 'identitas_rumah');
        $this->pertanyaanKeselamatan   = $this->question->where('module', 'aspek_keselamatan');
        $this->pertanyaanKesehatan     = $this->question->where('module', 'aspek_kesehatan');
        $this->pertanyaanLuasBangunan  = $this->question->where('module', 'aspek_luas_kebutuhan');
        $this->pertanyaanBahanBangunan = $this->question->where('module', 'aspek_bahan_bangunan');
        $this->pertanyaanDokumentasi   = $this->question->where('module', 'foto_dokumentasi');
        $this->pertanyaanLainnya       = $this->question->where('module', 'pertanyaan_lainnya');

        $this->allQuestions = SurveyQuestion::with('options')->where('is_active', 1)->orderBy('id', 'desc')->get();
        $this->childQuestions = SurveyQuestion::with('options')
            ->where('is_active', 1)
            ->whereNotNull('parent_question_id')
            ->get();
             $this->lastStep = $this->is_question ? 8 : 7;
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

    

    public function removePhoto($field)
    {
        if (property_exists($this, $field)) {
            $this->$field = null;
        }
    }

    #[On('select2Changed')]
    public function select2Changed($data)
    {
        $name = $data['name'] ?? null;
        $value = $data['value'] ?? null;

        if ($name && property_exists($this, $name)) {
            $this->$name = $value;
            logger("Livewire menerima {$name} = {$value}");
        }

        if (str_starts_with($name, 'questionAnswers.')) {

            // Contoh name: questionAnswers.6
            Arr::set($this->questionAnswers, str_replace('questionAnswers.', '', $name), $value);

            logger("Updated $name = $value");
        }


        // 🔹 Jika kecamatan berubah, filter kelurahan
        if ($name === 'kecamatan_id') {
            $this->filterKelurahan();
        }

        if($name)

        if ($name === 'pernah_mendapatkan_bantuan_id') {
            $this->updatedPernahMendapatkanBantuanId($value);
        }
        $this->dispatch('refreshChildQuestions');
    }

    public function updatedPernahMendapatkanBantuanId($value)
    {
        // Jika bukan 1 (bukan "Ya"), reset semua field bantuan
        if ($value != 1) {
            $this->no_kk_penerima      = '';
            $this->tahun_bantuan       = '';
            $this->nama_bantuan        = '';
            $this->nama_program_bantuan = '';
            $this->nominal_bantuan     = '';
        }
    }

    public function filterKelurahan()
    {
        

       

         // 🔹 Filter daftar kelurahan berdasarkan kecamatan
        $this->filteredKelurahan = IKelurahan::where('kecamatan_id', $this->kecamatan_id)
            ->orderBy('nama_kelurahan')
            ->get();

        // 🔹 Reset pilihan kelurahan
        $this->kelurahan_id = '';

        // 🔹 Kirim event ke browser supaya select2 Kelurahan juga di-reset
        $this->dispatch('resetKelurahanSelect2');
    }

    public function render()
    {
        return view('livewire.rumah.add')
            ->extends('layouts.master')
            ->section('content');
    }

    /** Ubah step saat tombol Next/Prev ditekan */
    #[On('setStep')]
    public function setStep($step)
    {

        if ($this->currentStep === 1 && $step > 1) {
            if (empty($this->latitude) || empty($this->longitude)) {
                $this->dispatch('swal:error', [
                    'title' => 'Lokasi Belum Lengkap',
                    'text'  => 'Pastikan titik lokasi (Latitude dan Longitude) sudah ditentukan di peta sebelum melanjutkan.',
                ]);
                return;
            }

            foreach ($this->pertanyaanLokasi as $q) {

                // Ambil jawaban dari Livewire
                $answer = $this->questionAnswers[$q->id] ?? null;

                

                // Abaikan pertanyaan tidak wajib
                if (!$q->is_required) {
                    continue;
                }

                // TEXT, TEXTAREA, NUMBER, DATE
                if (in_array($q->type, ['text', 'textarea', 'number', 'date'])) {
                    if (empty($answer)) {
                        return $this->dispatch('swal:error', [
                            'title' => 'Pertanyaan Belum Terjawab',
                            'text'  => "Pertanyaan '{$q->label}' wajib diisi.",
                        ]);
                    }
                }

                // SELECT & RADIO
                if (in_array($q->type, ['select', 'radio'])) {
                    if (empty($answer)) {
                        return $this->dispatch('swal:error', [
                            'title' => 'Pertanyaan Belum Terjawab',
                            'text'  => "Pertanyaan '{$q->label}' wajib dipilih.",
                        ]);
                    }
                }

                // CHECKBOX (array minimal 1)
                if ($q->type === 'checkbox') {
                    if (empty($answer) || count($answer) === 0) {
                        return $this->dispatch('swal:error', [
                            'title' => 'Pertanyaan Belum Terjawab',
                            'text'  => "Pertanyaan '{$q->label}' wajib memilih minimal 1 opsi.",
                        ]);
                    }
                }
            }
        }

        if ($this->currentStep === 2 && $step > 2) {
            // if (count($this->kks) < 1) {
            //     $this->dispatch('swal:error', [
            //         'title' => 'Data Belum Lengkap',
            //         'text'  => 'Harus menambahkan minimal 1 KK sebelum melanjutkan.',
            //     ]);
            //     return;
            // }

            // foreach ($this->kks as $kkIndex => $kk) {
            //     if (empty($kk['no_kk'])) {
            //         $this->dispatch('swal:error', [
            //             'title' => 'Nomor KK Belum Diisi',
            //             'text'  => 'Nomor KK ke-' . ($kkIndex + 1) . ' wajib diisi.',
            //         ]);
            //         return;
            //     }

            //     if (count($kk['anggota']) < 1) {
            //         $this->dispatch('swal:error', [
            //             'title' => 'Anggota Belum Ada',
            //             'text'  => 'KK ke-' . ($kkIndex + 1) . ' harus memiliki minimal 1 anggota.',
            //         ]);
            //         return;
            //     }

            //     foreach ($kk['anggota'] as $anggotaIndex => $anggota) {
            //         if (empty($anggota['nama']) || empty($anggota['nik'])) {
            //             $this->dispatch('swal:error', [
            //                 'title' => 'Data Anggota Belum Lengkap',
            //                 'text'  => 'Nama dan NIK anggota pada KK ke-' . ($kkIndex + 1) . ' wajib diisi.',
            //             ]);
            //             return;
            //         }
            //     }
            // }

            foreach ($this->pertanyaanKk as $q) {

                // Ambil jawaban dari Livewire
                $answer = $this->questionAnswers[$q->id] ?? null;

                

                // Abaikan pertanyaan tidak wajib
                if (!$q->is_required) {
                    continue;
                }

                // TEXT, TEXTAREA, NUMBER, DATE
                if (in_array($q->type, ['text', 'textarea', 'number', 'date'])) {
                    if (empty($answer)) {
                        return $this->dispatch('swal:error', [
                            'title' => 'Pertanyaan Belum Terjawab',
                            'text'  => "Pertanyaan '{$q->label}' wajib diisi.",
                        ]);
                    }
                }

                // SELECT & RADIO
                if (in_array($q->type, ['select', 'radio'])) {
                    if (empty($answer)) {
                        return $this->dispatch('swal:error', [
                            'title' => 'Pertanyaan Belum Terjawab',
                            'text'  => "Pertanyaan '{$q->label}' wajib dipilih.",
                        ]);
                    }
                }

                // CHECKBOX (array minimal 1)
                if ($q->type === 'checkbox') {
                    if (empty($answer) || count($answer) === 0) {
                        return $this->dispatch('swal:error', [
                            'title' => 'Pertanyaan Belum Terjawab',
                            'text'  => "Pertanyaan '{$q->label}' wajib memilih minimal 1 opsi.",
                        ]);
                    }
                }
            }
        }

        if ($this->currentStep === 3 && $step > 3) {
        // daftar field wajib
            $requiredFields = [
                'jenis_kelamin_id' => 'Jenis Kelamin',
                'usia' => 'Usia',
                'pendidikan_terakhir_id' => 'Pendidikan Terakhir',
                'pekerjaan_utama_id' => 'Pekerjaan Utama',
                'besar_penghasilan_id' => 'Besar Penghasilan',
                'besar_pengeluaran_id' => 'Besar Pengeluaran',
                'alamat' => 'Alamat',
                'rt' => 'RT',
                'rw' => 'RW',
                'kecamatan_id' => 'Kecamatan',
                'kelurahan_id' => 'Kelurahan',
                'status_kepemilikan_tanah_id' => 'Status Kepemilikan Tanah',
                'bukti_kepemilikan_tanah_id' => 'Bukti Kepemilikan Tanah',
                'status_kepemilikan_rumah_id' => 'Status Kepemilikan Rumah',
                'status_imb_id' => 'Status IMB',
                'aset_rumah_ditempat_lain_id' => 'Aset Rumah Ditempat Lain',
                'aset_tanah_ditempat_lain_id' => 'Aset Tanah Ditempat Lain',
                'pernah_mendapatkan_bantuan_id' => 'Pernah Mendapatkan Bantuan',
                'jenis_kawasan_lokasi_rumah_id' => 'Jenis Kawasan Lokasi Rumah',
            ];

            // cek field wajib
            foreach ($requiredFields as $field => $label) {
                if (empty($this->$field)) {
                    $this->dispatch('swal:error', [
                        'title' => 'Data Belum Lengkap',
                        'text'  => "Kolom {$label} wajib diisi sebelum melanjutkan.",
                    ]);
                    return;
                }
            }

            // 🔹 Jika pernah mendapatkan bantuan = 1, wajib isi komponen tambahannya
            if ($this->pernah_mendapatkan_bantuan_id == 1) {
                $conditional = [
                    'no_kk_penerima' => 'KK Penerima Bantuan',
                    'tahun_bantuan' => 'Tahun Bantuan',
                    'nama_bantuan' => 'Nama Bantuan',
                    'nama_program_bantuan' => 'Nama Program Bantuan',
                    'nominal_bantuan' => 'Nominal Bantuan',
                ];

                foreach ($conditional as $field => $label) {
                    if (empty($this->$field)) {
                        $this->dispatch('swal:error', [
                            'title' => 'Data Bantuan Belum Lengkap',
                            'text'  => "Kolom {$label} wajib diisi karena Anda memilih Pernah Mendapatkan Bantuan.",
                        ]);
                        return;
                    }
                }
            }

            foreach ($this->pertanyaanIdentitas as $q) {

                // Ambil jawaban dari Livewire
                $answer = $this->questionAnswers[$q->id] ?? null;

                

                // Abaikan pertanyaan tidak wajib
                if (!$q->is_required) {
                    continue;
                }

                // TEXT, TEXTAREA, NUMBER, DATE
                if (in_array($q->type, ['text', 'textarea', 'number', 'date'])) {
                    if (empty($answer)) {
                        return $this->dispatch('swal:error', [
                            'title' => 'Pertanyaan Belum Terjawab',
                            'text'  => "Pertanyaan '{$q->label}' wajib diisi.",
                        ]);
                    }
                }

                // SELECT & RADIO
                if (in_array($q->type, ['select', 'radio'])) {
                    if (empty($answer)) {
                        return $this->dispatch('swal:error', [
                            'title' => 'Pertanyaan Belum Terjawab',
                            'text'  => "Pertanyaan '{$q->label}' wajib dipilih.",
                        ]);
                    }
                }

                // CHECKBOX (array minimal 1)
                if ($q->type === 'checkbox') {
                    if (empty($answer) || count($answer) === 0) {
                        return $this->dispatch('swal:error', [
                            'title' => 'Pertanyaan Belum Terjawab',
                            'text'  => "Pertanyaan '{$q->label}' wajib memilih minimal 1 opsi.",
                        ]);
                    }
                }
            }
        }

        if ($this->currentStep === 4 && $step > 4) {
            $requiredFields = [
                'pondasi_id' => 'Pondasi',
                'jenis_pondasi_id' => 'Jenis Pondasi',
                'kondisi_pondasi_id' => 'Kondisi Pondasi',
                'kondisi_sloof_id' => 'Kondisi Sloof',
                'kondisi_kolom_tiang_id' => 'Kondisi Kolom / Tiang',
                'kondisi_balok_id' => 'Kondisi Balok',
                'kondisi_struktur_atap_id' => 'Kondisi Struktur Atap',
            ];

            foreach ($requiredFields as $field => $label) {
                if (empty($this->$field)) {
                    $this->dispatch('swal:error', [
                        'title' => 'Data Belum Lengkap',
                        'text'  => "Kolom {$label} wajib diisi sebelum melanjutkan ke tahap berikutnya.",
                    ]);
                    return;
                }
            }

            foreach ($this->pertanyaanKeselamatan as $q) {

                // Ambil jawaban dari Livewire
                $answer = $this->questionAnswers[$q->id] ?? null;

                

                // Abaikan pertanyaan tidak wajib
                if (!$q->is_required) {
                    continue;
                }

                // TEXT, TEXTAREA, NUMBER, DATE
                if (in_array($q->type, ['text', 'textarea', 'number', 'date'])) {
                    if (empty($answer)) {
                        return $this->dispatch('swal:error', [
                            'title' => 'Pertanyaan Belum Terjawab',
                            'text'  => "Pertanyaan '{$q->label}' wajib diisi.",
                        ]);
                    }
                }

                // SELECT & RADIO
                if (in_array($q->type, ['select', 'radio'])) {
                    if (empty($answer)) {
                        return $this->dispatch('swal:error', [
                            'title' => 'Pertanyaan Belum Terjawab',
                            'text'  => "Pertanyaan '{$q->label}' wajib dipilih.",
                        ]);
                    }
                }

                // CHECKBOX (array minimal 1)
                if ($q->type === 'checkbox') {
                    if (empty($answer) || count($answer) === 0) {
                        return $this->dispatch('swal:error', [
                            'title' => 'Pertanyaan Belum Terjawab',
                            'text'  => "Pertanyaan '{$q->label}' wajib memilih minimal 1 opsi.",
                        ]);
                    }
                }
            }
        }

        if ($this->currentStep === 5 && $step > 5) {
            $requiredFields = [
                'jendela_lubang_cahaya_id' => 'Jendela / Lubang Cahaya',
                'kondisi_jendela_lubang_cahaya_id' => 'Kondisi Jendela / Lubang Cahaya',
                'ventilasi_id' => 'Ventilasi',
                'kondisi_ventilasi_id' => 'Kondisi Ventilasi',
                'kamar_mandi_id' => 'Kamar Mandi',
                'kondisi_kamar_mandi_id' => 'Kondisi Kamar Mandi',
                'jamban_id' => 'Jamban',
                'kondisi_jamban_id' => 'Kondisi Jamban',
                'sistem_pembuangan_air_kotor_id' => 'Sistem Pembuangan Air Kotor',
                'kondisi_sistem_pembuangan_air_kotor_id' => 'Kondisi Sistem Pembuangan Air Kotor',
                'frekuensi_penyedotan_id' => 'Frekuensi Penyedotan (5 Tahun)',
                'sumber_air_minum_id' => 'Sumber Air Minum',
                'kondisi_sumber_air_minum_id' => 'Kondisi Sumber Air Minum',
                'sumber_listrik_id' => 'Sumber Listrik',
            ];

            foreach ($requiredFields as $field => $label) {
                if (empty($this->$field)) {
                    $this->dispatch('swal:error', [
                        'title' => 'Data Belum Lengkap',
                        'text'  => "Kolom {$label} wajib diisi sebelum melanjutkan ke tahap berikutnya.",
                    ]);
                    return;
                }
            }

            foreach ($this->pertanyaanKesehatan as $q) {

                // Ambil jawaban dari Livewire
                $answer = $this->questionAnswers[$q->id] ?? null;

                

                // Abaikan pertanyaan tidak wajib
                if (!$q->is_required) {
                    continue;
                }

                // TEXT, TEXTAREA, NUMBER, DATE
                if (in_array($q->type, ['text', 'textarea', 'number', 'date'])) {
                    if (empty($answer)) {
                        return $this->dispatch('swal:error', [
                            'title' => 'Pertanyaan Belum Terjawab',
                            'text'  => "Pertanyaan '{$q->label}' wajib diisi.",
                        ]);
                    }
                }

                // SELECT & RADIO
                if (in_array($q->type, ['select', 'radio'])) {
                    if (empty($answer)) {
                        return $this->dispatch('swal:error', [
                            'title' => 'Pertanyaan Belum Terjawab',
                            'text'  => "Pertanyaan '{$q->label}' wajib dipilih.",
                        ]);
                    }
                }

                // CHECKBOX (array minimal 1)
                if ($q->type === 'checkbox') {
                    if (empty($answer) || count($answer) === 0) {
                        return $this->dispatch('swal:error', [
                            'title' => 'Pertanyaan Belum Terjawab',
                            'text'  => "Pertanyaan '{$q->label}' wajib memilih minimal 1 opsi.",
                        ]);
                    }
                }
            }
        }

        if ($this->currentStep === 6 && $step > 6) {
            $requiredFields = [
                'luas_rumah' => 'Luas Rumah (m²)',
                'jumlah_penghuni_laki' => 'Jumlah Penghuni Laki-laki',
                'jumlah_penghuni_perempuan' => 'Jumlah Penghuni Perempuan',
                'tinggi_rata_rumah' => 'Tinggi Rata-rata Bangunan (m²)',
                'ruang_keluarga_dan_tidur_id' => 'Ruang Keluarga & Ruang Tidur',
                'jumlah_kamar_tidur' => 'Jumlah Kamar Tidur',
                'luas_rata_kamar_tidur' => 'Luas Rata-rata Kamar Tidur (m²)',
                'jenis_fisik_bangunan_id' => 'Jenis Fisik Bangunan',
                'jumlah_lantai_bangunan' => 'Jumlah Lantai Bangunan',
                'fungsi_rumah_id' => 'Fungsi Rumah',
                'tipe_rumah_id' => 'Tipe Rumah',
                'status_dtks_id' => 'Status DTKS',
                'tahun_pembangunan_rumah' => 'Tahun Pembangunan Rumah',
            ];

            foreach ($requiredFields as $field => $label) {
                if (empty($this->$field)) {
                    $this->dispatch('swal:error', [
                        'title' => 'Data Belum Lengkap',
                        'text'  => "Kolom {$label} wajib diisi sebelum melanjutkan ke tahap berikutnya.",
                    ]);
                    return;
                }
            }

            foreach ($this->pertanyaanLuasBangunan as $q) {

                // Ambil jawaban dari Livewire
                $answer = $this->questionAnswers[$q->id] ?? null;

                

                // Abaikan pertanyaan tidak wajib
                if (!$q->is_required) {
                    continue;
                }

                // TEXT, TEXTAREA, NUMBER, DATE
                if (in_array($q->type, ['text', 'textarea', 'number', 'date'])) {
                    if (empty($answer)) {
                        return $this->dispatch('swal:error', [
                            'title' => 'Pertanyaan Belum Terjawab',
                            'text'  => "Pertanyaan '{$q->label}' wajib diisi.",
                        ]);
                    }
                }

                // SELECT & RADIO
                if (in_array($q->type, ['select', 'radio'])) {
                    if (empty($answer)) {
                        return $this->dispatch('swal:error', [
                            'title' => 'Pertanyaan Belum Terjawab',
                            'text'  => "Pertanyaan '{$q->label}' wajib dipilih.",
                        ]);
                    }
                }

                // CHECKBOX (array minimal 1)
                if ($q->type === 'checkbox') {
                    if (empty($answer) || count($answer) === 0) {
                        return $this->dispatch('swal:error', [
                            'title' => 'Pertanyaan Belum Terjawab',
                            'text'  => "Pertanyaan '{$q->label}' wajib memilih minimal 1 opsi.",
                        ]);
                    }
                }
            }
        }

        if ($this->currentStep === 7 && $step > 7) {
            $requiredFields = [
                'material_atap_terluas_id'           => 'Material Atap Terluas',
                'kondisi_penutup_atap_id'            => 'Kondisi Penutup Atap',
                'material_dinding_terluas_id'        => 'Material Dinding Terluas',
                'kondisi_dinding_id'                 => 'Kondisi Dinding',
                'material_lantai_terluas_id'         => 'Material Lantai Terluas',
                'kondisi_lantai_id'                  => 'Kondisi Lantai',
                'akses_ke_jalan_id'                  => 'Akses Langsung ke Jalan',
                'bangunan_menghadap_jalan_id'        => 'Bangunan Menghadap Jalan',
                'bangunan_menghadap_sungai_id'       => 'Bangunan Menghadap Sungai',
                'bangunan_berada_limbah_id'          => 'Bangunan Berada di Buangan Limbah / Sutet',
                'bangunan_berada_sungai_id'          => 'Bangunan Berada di Atas Sempadan Sungai / Laut / Rawa',
            ];

            foreach ($requiredFields as $field => $label) {
                if (empty($this->$field)) {
                    $this->dispatch('swal:error', [
                        'title' => 'Data Belum Lengkap',
                        'text'  => "Kolom {$label} wajib diisi sebelum melanjutkan ke tahap berikutnya.",
                    ]);
                    return;
                }
            }

            foreach ($this->pertanyaanBahanBangunan as $q) {

                // Ambil jawaban dari Livewire
                $answer = $this->questionAnswers[$q->id] ?? null;

                

                // Abaikan pertanyaan tidak wajib
                if (!$q->is_required) {
                    continue;
                }

                // TEXT, TEXTAREA, NUMBER, DATE
                if (in_array($q->type, ['text', 'textarea', 'number', 'date'])) {
                    if (empty($answer)) {
                        return $this->dispatch('swal:error', [
                            'title' => 'Pertanyaan Belum Terjawab',
                            'text'  => "Pertanyaan '{$q->label}' wajib diisi.",
                        ]);
                    }
                }

                // SELECT & RADIO
                if (in_array($q->type, ['select', 'radio'])) {
                    if (empty($answer)) {
                        return $this->dispatch('swal:error', [
                            'title' => 'Pertanyaan Belum Terjawab',
                            'text'  => "Pertanyaan '{$q->label}' wajib dipilih.",
                        ]);
                    }
                }

                // CHECKBOX (array minimal 1)
                if ($q->type === 'checkbox') {
                    if (empty($answer) || count($answer) === 0) {
                        return $this->dispatch('swal:error', [
                            'title' => 'Pertanyaan Belum Terjawab',
                            'text'  => "Pertanyaan '{$q->label}' wajib memilih minimal 1 opsi.",
                        ]);
                    }
                }
            }
        }


         if ($this->currentStep === 8 && $step > 8) {
            $this->dispatch('stepChanged', 8);
            $requiredPhotos = [
                // 'foto_kk'          => 'Foto Kartu Keluarga (KK)',
                // 'foto_ktp'         => 'Foto Kartu Tanda Penduduk (KTP)',
                'foto_rumah_satu'  => 'Foto Rumah 1',
                'foto_rumah_dua'   => 'Foto Rumah 2',
                'foto_rumah_tiga'  => 'Foto Rumah 3',
                //'foto_imb'         => 'Foto IMB',
            ];

            foreach ($requiredPhotos as $field => $label) {
                if (empty($this->$field)) {
                    $this->dispatch('swal:error', [
                        'title' => 'Data Belum Lengkap',
                        'text'  => "Kolom {$label} wajib diisi sebelum melanjutkan ke tahap berikutnya.",
                    ]);
                    return;
                }
            }

            foreach ($this->pertanyaanDokumentasi as $q) {

                // Ambil jawaban dari Livewire
                $answer = $this->questionAnswers[$q->id] ?? null;

                

                // Abaikan pertanyaan tidak wajib
                if (!$q->is_required) {
                    continue;
                }

                // TEXT, TEXTAREA, NUMBER, DATE
                if (in_array($q->type, ['text', 'textarea', 'number', 'date'])) {
                    if (empty($answer)) {
                        return $this->dispatch('swal:error', [
                            'title' => 'Pertanyaan Belum Terjawab',
                            'text'  => "Pertanyaan '{$q->label}' wajib diisi.",
                        ]);
                    }
                }

                // SELECT & RADIO
                if (in_array($q->type, ['select', 'radio'])) {
                    if (empty($answer)) {
                        return $this->dispatch('swal:error', [
                            'title' => 'Pertanyaan Belum Terjawab',
                            'text'  => "Pertanyaan '{$q->label}' wajib dipilih.",
                        ]);
                    }
                }

                // CHECKBOX (array minimal 1)
                if ($q->type === 'checkbox') {
                    if (empty($answer) || count($answer) === 0) {
                        return $this->dispatch('swal:error', [
                            'title' => 'Pertanyaan Belum Terjawab',
                            'text'  => "Pertanyaan '{$q->label}' wajib memilih minimal 1 opsi.",
                        ]);
                    }
                }
            }
        }
        
        

        $this->currentStep = max(1, min($step, 9));

        // 🔁 Kirim balik ke frontend agar header update
        $this->dispatch('stepChanged', $this->currentStep);
    }

    /** Logika form KK dan anggota */
    public function updatedJumlahKK()
    {
        if ($this->jumlahKK > 6) $this->jumlahKK = 6;

        $this->kks = [];
        for ($i = 0; $i < $this->jumlahKK; $i++) {
            $this->kks[] = [
                'no_kk' => '',
                'jumlahAnggota' => 0,
                'anggota' => [],
            ];
        }
    }

    public function updatedKks($value, $name)
    {
        $parts = explode('.', $name);
        if (count($parts) === 3 && $parts[2] === 'jumlahAnggota') {
            $kkIndex = $parts[1];
            $jumlah = min((int) $value, 10);
            $this->kks[$kkIndex]['anggota'] = [];

            for ($i = 0; $i < $jumlah; $i++) {
                $this->kks[$kkIndex]['anggota'][] = ['nama' => '', 'nik' => ''];
            }
        }
    }

    public function tambahAnggota($kkIndex)
    {
        if (count($this->kks[$kkIndex]['anggota']) < 10) {
            $this->kks[$kkIndex]['anggota'][] = ['nama' => '', 'nik' => ''];
        }
    }

    public function hapusAnggota($kkIndex, $anggotaIndex)
    {
        unset($this->kks[$kkIndex]['anggota'][$anggotaIndex]);
        $this->kks[$kkIndex]['anggota'] = array_values($this->kks[$kkIndex]['anggota']);
    }

 public function tambahKK()
{
    // Maksimal 6 KK
    if (count($this->kks) >= 6) {
        $this->dispatch('showAlert', [
            'type' => 'warning',
            'message' => 'Jumlah KK maksimal 6.'
        ]);
        return;
    }

    // Tambahkan satu KK baru
    $this->kks[] = ['no_kk' => '', 'jumlahAnggota' => 0, 'anggota' => []];

    // Hitung jumlah KK yang baru
    $jumlahSekarang = count($this->kks);

    // Pastikan jumlah ini juga tersimpan di model (kalau ada di tabel i_jumlah_kk)
    $record = IJumlahKk::where('jumlah_kk', $jumlahSekarang)->first();

    if ($record) {
        // Update value select-nya otomatis
        $this->jumlahKK = $record->id_jumlah_kk;
    } else {
        // Kalau jumlah tidak ada di tabel (misalnya lebih dari 6), pakai angka mentah saja
        $this->jumlahKK = $jumlahSekarang;
    }
}

    public function hapusKK($kkIndex)
    {
        unset($this->kks[$kkIndex]);
        $this->kks = array_values($this->kks);
        $this->jumlahKK = count($this->kks);
    }

    public function submitForm()
    {
       
         $requiredPhotos = [
            // 'foto_kk'          => 'Foto Kartu Keluarga (KK)',
            // 'foto_ktp'         => 'Foto Kartu Tanda Penduduk (KTP)',
            'foto_rumah_satu'  => 'Foto Rumah 1',
            'foto_rumah_dua'   => 'Foto Rumah 2',
            'foto_rumah_tiga'  => 'Foto Rumah 3',
            //'foto_imb'         => 'Foto IMB',
            ];

            $wajibFoto = [
                'foto_kk'          => 'Foto Kartu Keluarga (KK)',
                'foto_ktp'         => 'Foto Kartu Tanda Penduduk (KTP)',
                'foto_rumah_satu'  => 'Foto Rumah 1',
                'foto_rumah_dua'   => 'Foto Rumah 2',
                'foto_rumah_tiga'  => 'Foto Rumah 3',
                'foto_imb'         => 'Foto IMB',
            ];

        if ($this->is_question) {

           

            // Loop seluruh pertanyaan (Collection)
            foreach ($this->allQuestions as $q) {

                // Ambil jawaban dari Livewire
                $answer = $this->questionAnswers[$q->id] ?? null;

                

                // Abaikan pertanyaan tidak wajib
                if (!$q->is_required) {
                    continue;
                }

                // TEXT, TEXTAREA, NUMBER, DATE
                if (in_array($q->type, ['text', 'textarea', 'number', 'date'])) {
                    if (empty($answer)) {
                        return $this->dispatch('swal:error', [
                            'title' => 'Pertanyaan Belum Terjawab',
                            'text'  => "Pertanyaan '{$q->label}' wajib diisi.",
                        ]);
                    }
                }

                // SELECT & RADIO
                if (in_array($q->type, ['select', 'radio'])) {
                    if (empty($answer)) {
                        return $this->dispatch('swal:error', [
                            'title' => 'Pertanyaan Belum Terjawab',
                            'text'  => "Pertanyaan '{$q->label}' wajib dipilih.",
                        ]);
                    }
                }

                // CHECKBOX (array minimal 1)
                if ($q->type === 'checkbox') {
                    if (empty($answer) || count($answer) === 0) {
                        return $this->dispatch('swal:error', [
                            'title' => 'Pertanyaan Belum Terjawab',
                            'text'  => "Pertanyaan '{$q->label}' wajib memilih minimal 1 opsi.",
                        ]);
                    }
                }
            }
           
        }
        else{
            


            foreach ($requiredPhotos as $field => $label) {
                if (empty($this->$field)) {
                    $this->dispatch('swal:error', [
                        'title' => 'Dokumentasi Belum Lengkap',
                        'text'  => "{$label} wajib diunggah sebelum mengirim data.",
                    ]);
                    return;
                }
            }

        }



        try {
            DB::beginTransaction();

            // 🏠 Simpan data dasar rumah
            $rumah = Rumah::create([
                'id_rumah_lama' => '00',
                'alamat'        => $this->alamat,
                'latitude'      => $this->latitude,
                'longitude'     => $this->longitude,
                'rt'            => $this->rt,
                'rw'            => $this->rw,
                'kecamatan_id'  => $this->kecamatan_id,
                'kelurahan_id'  => $this->kelurahan_id,
                'tahun_pembangunan_rumah' => $this->tahun_pembangunan_rumah,
            ]);

             $kkPertama = null;
            if (!empty($this->kks) && count($this->kks) > 0) {
                foreach ($this->kks as $kkIndex => $kk) {

                    // Tentukan kode KK (A, B, C, D, E, F)
                    $kodeKK = chr(65 + $kkIndex); // 65 = A di ASCII

                    // Buat KK baru
                    $kepalaKeluarga = KepalaKeluarga::create([
                        'rumah_id' => $rumah->id_rumah,
                        'no_kk'    => $kk['no_kk'] ?? null,
                        'kode_kk'  => $kodeKK,
                    ]);

                    if ($kkIndex === 0) {
                        $kkPertama = $kk['no_kk'] ?? null;
                    }

                    // Simpan anggota keluarga dari KK tersebut
                    if (!empty($kk['anggota']) && count($kk['anggota']) > 0) {
                        foreach ($kk['anggota'] as $anggotaIndex => $anggota) {
                            // Tentukan kode anggota (misal: aa, ab, ac ... ba, bb ...)
                            $hurufKK = strtolower($kodeKK);
                            $hurufAnggota = chr(97 + $anggotaIndex); // 97 = a
                            $kodeAnggota = $hurufKK . $hurufAnggota;

                            AnggotaKeluarga::create([
                                'kepala_keluarga_id' => $kepalaKeluarga->id,
                                'nik'   => $anggota['nik'] ?? null,
                                'nama'  => $anggota['nama'] ?? null,
                                'kode_anggota' => $kodeAnggota,
                            ]);
                        }
                    }
                }
            }

            //pertanyaan lain
            foreach ($this->allQuestions as $q) {

                $answer = $this->questionAnswers[$q->id] ?? null;

                // Abaikan jika pertanyaan tidak wajib dan tidak diisi
                if (!$q->is_required && empty($answer)) {
                    continue;
                }

                // TEXT, TEXTAREA, NUMBER, DATE
                if (in_array($q->type, ['text','textarea','number','date'])) {
                    SurveyQuestionAnswer::create([
                        'rumah_id'      => $rumah->id_rumah,
                        'question_id'   => $q->id,
                        'answer_text'   => $answer,
                    ]);
                }

                // SELECT dan RADIO → Simpan 1 ID option
                elseif (in_array($q->type, ['select','radio'])) {
                    SurveyQuestionAnswer::create([
                        'rumah_id'          => $rumah->id_rumah,
                        'question_id'       => $q->id,
                        'answer_option_id'  => $answer,
                    ]);
                }

                // CHECKBOX → Simpan sebagai array of IDs
                elseif ($q->type === 'checkbox') {
                    SurveyQuestionAnswer::create([
                        'rumah_id'          => $rumah->id_rumah,
                        'question_id'       => $q->id,
                        'answer_option_ids' => is_array($answer) ? $answer : [],
                    ]);
                }

                // FILE (jika suatu saat kamu aktifkan)
                elseif ($q->type === 'file' && $answer) {
                    $filePath = $answer->store('survey_answers', 'public');

                    SurveyQuestionAnswer::create([
                        'rumah_id'      => $rumah->id_rumah,
                        'question_id'   => $q->id,
                        'file_path'     => $filePath,
                    ]);
                }
            }

            // 👨‍👩‍👧 Data sosial ekonomi
            SosialEkonomiRumah::create([
                'rumah_id'                      => $rumah->id_rumah,
                'jumlah_kk_id'                  => $this->jumlahKK,
                'no_kk' => $this->kks[0]['no_kk'] ?? null,
                'jenis_kelamin_id'              => $this->jenis_kelamin_id,
                'usia'                          => $this->usia,
                'pendidikan_terakhir_id'        => $this->pendidikan_terakhir_id,
                'pekerjaan_utama_id'            => $this->pekerjaan_utama_id,
                'besar_penghasilan_perbulan_id' => $this->besar_penghasilan_id,   // ✅
                'besar_pengeluaran_perbulan_id' => $this->besar_pengeluaran_id,
                'status_dtks_id'                => $this->status_dtks_id,
            ]);

            // 🧱 Data fisik rumah
            FisikRumah::create([
                'rumah_id'                        => $rumah->id_rumah,
                'pondasi_id'                      => $this->pondasi_id,
                'jenis_pondasi'                   => $this->jenis_pondasi_id,
                'kondisi_pondasi_id'              => $this->kondisi_pondasi_id,
                'kondisi_sloof_id'                => $this->kondisi_sloof_id,
                'kondisi_kolom_tiang_id'          => $this->kondisi_kolom_tiang_id,
                'kondisi_balok_id'                => $this->kondisi_balok_id,
                'kondisi_struktur_atap_id'        => $this->kondisi_struktur_atap_id,
                'material_atap_terluas_id'        => $this->material_atap_terluas_id,
                'kondisi_penutup_atap_id'         => $this->kondisi_penutup_atap_id,
                'material_dinding_terluas_id'     => $this->material_dinding_terluas_id,
                'kondisi_dinding_id'              => $this->kondisi_dinding_id,
                'material_lantai_terluas_id'      => $this->material_lantai_terluas_id,
                'kondisi_lantai_id'               => $this->kondisi_lantai_id,
                'akses_ke_jalan_id'               => $this->akses_ke_jalan_id,
                'bangunan_menghadap_jalan_id'     => $this->bangunan_menghadap_jalan_id,
                'bangunan_menghadap_sungai_id'    => $this->bangunan_menghadap_sungai_id,
                'bangunan_berada_limbah_id'       => $this->bangunan_berada_limbah_id,
                'bangunan_berada_sungai_id'       => $this->bangunan_berada_sungai_id,
                'luas_rumah'                      => $this->luas_rumah,
                'tinggi_rata_rumah'               => $this->tinggi_rata_rumah,
                'jumlah_penghuni_laki'            => $this->jumlah_penghuni_laki,
                'jumlah_penghuni_perempuan'       => $this->jumlah_penghuni_perempuan,
                'jumlah_abk'                      => $this->jumlah_abk,
                'ruang_keluarga_dan_ruang_tidur_id' => $this->ruang_keluarga_dan_tidur_id,
                'jumlah_kamar_tidur'              => $this->jumlah_kamar_tidur,
                'luas_rata_kamar_tidur'           => $this->luas_rata_kamar_tidur,
                'jenis_fisik_bangunan_id'         => $this->jenis_fisik_bangunan_id,
                'fungsi_rumah_id'                 => $this->fungsi_rumah_id,
                'tipe_rumah_id'                   => $this->tipe_rumah_id,
                'jumlah_lantai_bangunan'          => $this->jumlah_lantai_bangunan,
            ]);

            // 💧 Sanitasi rumah
            SanitasiRumah::create([
                'rumah_id'                               => $rumah->id_rumah,
                'jendela_lubang_cahaya_id'              => $this->jendela_lubang_cahaya_id,
                'kondisi_jendela_lubang_cahaya_id'      => $this->kondisi_jendela_lubang_cahaya_id,
                'ventilasi_id'                          => $this->ventilasi_id,
                'keterangan_ventilasi'                  => $this->keterangan_ventilasi,
                'kondisi_ventilasi_id'                  => $this->kondisi_ventilasi_id,
                'kamar_mandi_id'                        => $this->kamar_mandi_id,
                'kondisi_kamar_mandi_id'                => $this->kondisi_kamar_mandi_id,
                'jamban_id'                             => $this->jamban_id,
                'kondisi_jamban_id'                     => $this->kondisi_jamban_id,
                'sistem_pembuangan_air_kotor_id'        => $this->sistem_pembuangan_air_kotor_id,
                'kondisi_sistem_pembuangan_air_kotor_id'=> $this->kondisi_sistem_pembuangan_air_kotor_id,
                'frekuensi_penyedotan_id'               => $this->frekuensi_penyedotan_id,
                'sumber_air_minum_id'                   => $this->sumber_air_minum_id,
                'kondisi_sumber_air_minum_id'           => $this->kondisi_sumber_air_minum_id,
                'sumber_listrik_id'                     => $this->sumber_listrik_id,
            ]);

            BantuanRumah::create([
            'rumah_id'                      => $rumah->id_rumah,
            'pernah_mendapatkan_bantuan_id' => $this->pernah_mendapatkan_bantuan_id,
            'no_kk_penerima'                => $this->no_kk_penerima,
            'tahun_bantuan'                 => $this->tahun_bantuan,
            'nama_bantuan'                  => $this->nama_bantuan,
            'nama_program_bantuan'          => $this->nama_program_bantuan,
            'nominal_bantuan'               => $this->nominal_bantuan,
            ]);


            KepemilikanRumah::create([
                'rumah_id'                      => $rumah->id_rumah,
                'status_kepemilikan_tanah_id'   => $this->status_kepemilikan_tanah_id,
                'bukti_kepemilikan_tanah_id'    => $this->bukti_kepemilikan_tanah_id,
                'status_kepemilikan_rumah_id'   => $this->status_kepemilikan_rumah_id,
                'nik_kepemilikan_rumah'         => $this->nik_kepemilikan_rumah,
                'status_imb_id'                 => $this->status_imb_id,
                'nomor_imb'                     => $this->nomor_imb,
                'aset_rumah_ditempat_lain_id'   => $this->aset_rumah_ditempat_lain_id,
                'aset_tanah_ditempat_lain_id'   => $this->aset_tanah_ditempat_lain_id,
                'jenis_kawasan_lokasi_rumah_id' => $this->jenis_kawasan_lokasi_rumah_id,
            ]);


            // 🧮 Hitung nilai penilaian rumah

            // ambil variabel dari input yang sudah tersimpan sebelumnya (step 4–7)
            $jendela_lubang_cahaya = $this->jendela_lubang_cahaya_id;
            $kondisi_jendela_lubang_cahaya_value = $this->kondisi_jendela_lubang_cahaya_id;
            $ventilasi = $this->ventilasi_id;
            $kondisi_ventilasi_value = $this->kondisi_ventilasi_id;
            $kamar_mandi = $this->kamar_mandi_id;
            $kondisi_kamar_mandi_value = $this->kondisi_kamar_mandi_id;
            $jamban = $this->jamban_id;
            $kondisi_jamban_value = $this->kondisi_jamban_id;
            $sistem_pembuangan_air_kotor = $this->sistem_pembuangan_air_kotor_id;
            $kondisi_sistem_pembuangan_air_kotor_value = $this->kondisi_sistem_pembuangan_air_kotor_id;
            $sumber_air_minum = $this->sumber_air_minum_id;
            $kondisi_sumber_air_minum_value = $this->kondisi_sumber_air_minum_id;
            $material_atap_terluas = $this->material_atap_terluas_id;
            $kondisi_penutup_atap_value = $this->kondisi_penutup_atap_id;
            $material_dinding_terluas = $this->material_dinding_terluas_id;
            $kondisi_dinding_value = $this->kondisi_dinding_id;
            $material_lantai_terluas = $this->material_lantai_terluas_id;
            $kondisi_lantai_value = $this->kondisi_lantai_id;

            $kondisi_pondasi = $this->kondisi_pondasi_id;
            $kondisi_sloof = $this->kondisi_sloof_id;
            $kondisi_kolom_tiang = $this->kondisi_kolom_tiang_id;
            $kondisi_balok = $this->kondisi_balok_id;
            $kondisi_struktur_atap = $this->kondisi_struktur_atap_id;

            $jumlah_penghuni_laki = (int) $this->jumlah_penghuni_laki;
            $jumlah_penghuni_perempuan = (int) $this->jumlah_penghuni_perempuan;
            $luas_rumah = (float) $this->luas_rumah;

            // 🧩 Terapkan rumus penilaian
            if ($jendela_lubang_cahaya == 1) {
                $kondisi_jendela_lubang_cahaya = $kondisi_jendela_lubang_cahaya_value;
            } else {
                $kondisi_jendela_lubang_cahaya = 4;
            }

            if ($ventilasi == 1) {
                $kondisi_ventilasi = $kondisi_ventilasi_value;
            } else {
                $kondisi_ventilasi = 4;
            }

            if ($kamar_mandi == 1 || $kamar_mandi == 2) {
                $kondisi_kamar_mandi = $kondisi_kamar_mandi_value;
            } else {
                $kondisi_kamar_mandi = 5;
            }

            if ($jamban == 1) {
                $kondisi_jamban = $kondisi_jamban_value;
            } else {
                $kondisi_jamban = 4;
            }

            if ($sistem_pembuangan_air_kotor == 1) {
                $kondisi_sistem_pembuangan_air_kotor = $kondisi_sistem_pembuangan_air_kotor_value;
            } else {
                $kondisi_sistem_pembuangan_air_kotor = 4;
            }

            if (in_array($sumber_air_minum, [1, 2, 3])) {
                $kondisi_sumber_air_minum = $kondisi_sumber_air_minum_value;
            } else {
                $kondisi_sumber_air_minum = 4;
            }

            if (in_array($material_atap_terluas, [1, 3, 8])) {
                $kondisi_penutup_atap = $kondisi_penutup_atap_value;
            } else {
                $kondisi_penutup_atap = 4;
            }

            if (in_array($material_dinding_terluas, [1, 2, 3, 4, 5])) {
                $kondisi_dinding = $kondisi_dinding_value;
            } else {
                $kondisi_dinding = 4;
            }

            if (in_array($material_lantai_terluas, [1, 2, 3, 4, 5])) {
                $kondisi_lantai = $kondisi_lantai_value;
            } else {
                $kondisi_lantai = 4;
            }

            // 💡 Nilai total dan subkategori
            $nilai = $kondisi_pondasi + $kondisi_sloof + $kondisi_kolom_tiang + $kondisi_balok + $kondisi_struktur_atap
                + $kondisi_jendela_lubang_cahaya + $kondisi_ventilasi + $kondisi_kamar_mandi + $kondisi_jamban
                + $kondisi_sistem_pembuangan_air_kotor + $kondisi_sumber_air_minum + $kondisi_penutup_atap
                + $kondisi_dinding + $kondisi_lantai;

            // 🔹 Aspek A: Keselamatan
            $nilai_a = $kondisi_pondasi + $kondisi_sloof + $kondisi_kolom_tiang + $kondisi_balok + $kondisi_struktur_atap;
            $prioritas_a = ($kondisi_pondasi >= 4 || $kondisi_sloof >= 4 || $kondisi_kolom_tiang >= 4 || $kondisi_balok >= 4 || $kondisi_struktur_atap >= 4) ? 2 : 1;

            // 🔹 Aspek B: Kesehatan
            $nilai_b = $kondisi_jendela_lubang_cahaya + $kondisi_ventilasi + $kondisi_kamar_mandi + $kondisi_jamban + $kondisi_sistem_pembuangan_air_kotor + $kondisi_sumber_air_minum;
            $p_b_total = collect([
                $kondisi_jendela_lubang_cahaya, $kondisi_ventilasi, $kondisi_kamar_mandi, $kondisi_jamban,
                $kondisi_sistem_pembuangan_air_kotor, $kondisi_sumber_air_minum
            ])->filter(fn($v) => $v >= 4)->count();
            $prioritas_b = ($p_b_total >= 2) ? 2 : 1;

            // 🔹 Aspek C: Komponen bahan bangunan
            $nilai_c = $kondisi_penutup_atap + $kondisi_dinding + $kondisi_lantai;
            $p_c_total = collect([$kondisi_penutup_atap, $kondisi_dinding, $kondisi_lantai])
                ->filter(fn($v) => $v >= 4)->count();
            $prioritas_c = ($p_c_total >= 2) ? 2 : 1;

            // 🔹 Status luas & status rumah
            $luas_meter = ($jumlah_penghuni_laki + $jumlah_penghuni_perempuan) * 9;
            $status_luas = ($luas_rumah >= $luas_meter) ? 1 : 2;
            $status_rumah = ($prioritas_a == 2 || $prioritas_b == 2 || $prioritas_c == 2) ? 'RTLH' : 'RLH';

            // 🏁 Simpan hasil ke tabel
            PenilaianRumah::create([
                'rumah_id'      => $rumah->id_rumah,
                'nilai_a'       => $nilai_a,
                'prioritas_a'   => $prioritas_a,
                'nilai_b'       => $nilai_b,
                'prioritas_b'   => $prioritas_b,
                'nilai_c'       => $nilai_c,
                'prioritas_c'   => $prioritas_c,
                'nilai'         => $nilai,
                'status_rumah'  => $status_rumah,
                'status_luas'   => $status_luas,
            ]);



            // 📷 Simpan dokumen rumah
            $dokumen = new DokumenRumah([
                'rumah_id'     => $rumah->id_rumah,
                'uploaded_by' => auth()->user()->id,

                'uploaded_at'  => now(),
            ]);

           

            foreach (array_keys($wajibFoto) as $field) {
            if (!empty($this->$field)) {
                $path = $this->$field->storeAs("rumah/{$rumah->id_rumah}", "{$field}.jpg");
                $dokumen->$field = "rumah/{$rumah->id_rumah}/{$field}.jpg";
            }
        }

            $dokumen->save();

            DB::commit();

            // ✅ SweetAlert success
            $this->dispatch('swal:success', [
                'title' => 'Berhasil!',
                'text'  => 'Data rumah beserta semua komponen dan dokumentasi berhasil disimpan.',
            ]);

            // Reset form & step
            $this->reset();
            $this->currentStep = 1;

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('swal:error', [
                'title' => 'Gagal Menyimpan',
                'text'  => 'Terjadi kesalahan: ' . $e->getMessage(),
            ]);
        }

    }

}
