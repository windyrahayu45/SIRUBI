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
use App\Models\SurveyQuestion;
use App\Models\SurveyQuestionAnswer;
use App\Models\TblJenisPondasi;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use App\Traits\LogsRumahHistory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class Edit extends Component
{

    use WithFileUploads;
    use LogsRumahHistory;
    
    public $id_rumah;
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
    public $skipQuestions = [];


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
    public $totalStep = 9; 
    public $lastStep = 7; 

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
     public $childQuestions = [];




  


    public function mount($id)
    {
        $this->id_rumah = $id;
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


        $existingAnswers = SurveyQuestionAnswer::where('rumah_id', $id)->get();

        foreach ($existingAnswers as $ans) {
            
            // TEXT, TEXTAREA, NUMBER, DATE
            if ($ans->answer_text !== null) {
                $this->questionAnswers[$ans->question_id] = $ans->answer_text;
            }

            // SELECT atau RADIO
            if ($ans->answer_option_id !== null) {
                $this->questionAnswers[$ans->question_id] = $ans->answer_option_id;
            }

            // CHECKBOX (multi select)
            if ($ans->answer_option_ids !== null) {
                $this->questionAnswers[$ans->question_id] = $ans->answer_option_ids; // array
            }

            // FILE (kalau ada)
            if ($ans->file_path !== null) {
                $this->questionAnswers[$ans->question_id] = $ans->file_path;
            }
        }

        Log::info('📥 Loaded existing answers', $this->questionAnswers);
        $this->dispatch('fillSelect2', answers: $this->questionAnswers);
        // Daftar listener Livewire 3 style
        // $this->on('setStep', fn ($step) => $this->setStep($step));
        $this->loadRumah($id);

        $this->iJumlahKK = IJumlahKk::all(['id_jumlah_kk', 'jumlah_kk']);
        $this->iJenisKelamin = IJenisKelamin::where('is_active',1)->get();
        $this->iPendidikanTerakhir = IPendidikanTerakhir::where('is_active',1)->get();
        $this->iPekerjaanUtama = IPekerjaanUtama::where('is_active',1)->get();
        $this->iBesarPenghasilan = IBesarPenghasilan::where('is_active',1)->get();
        $this->iBesarPengeluaran = IBesarPengeluaran::where('is_active',1)->get();
        $this->iKecamatan = IKecamatan::where('is_active',1)->get();
        $this->iKelurahan = IKelurahan::where('is_active',1)->get();
        $this->iStatusKepemilikanTanah = IStatusKepemilikanTanah::where('is_active',1)->get();
        $this->iBuktiKepemilikanTanah = IBuktiKepemilikanTanah::where('is_active',1)->get();
        $this->iStatusKepemilikanRumah = IStatusKepemilikanRumah::where('is_active',1)->get();
        $this->iStatusImb = IStatusImb::where('is_active',1)->get();
        $this->iAsetRumahTempatLain = IAsetRumahTempatLain::where('is_active',1)->get();
        $this->iAsetTanahTempatLain = IAsetTanahTempatLain::where('is_active',1)->get();
        $this->iPernahMendapatkanBantuan = IPernahMendapatkanBantuan::where('is_active',1)->get();
        $this->iJenisKawasanLokasi = IJenisKawasanLokasi::where('is_active',1)->get();

        $this->aPondasi = APondasi::where('is_active',1)->get();
        $this->aJenisPondasi = TblJenisPondasi::where('is_active',1)->get();
        $this->aKondisiPondasi = AKondisiPondasi::where('is_active',1)->get();
        $this->aKondisiSloof = AKondisiSloof::where('is_active',1)->get();
        $this->aKondisiKolomTiang = AKondisiKolomTiang::where('is_active',1)->get();
        $this->aKondisiBalok = AKondisiBalok::where('is_active',1)->get();
        $this->aKondisiStrukturAtap = AKondisiStrukturAtap::where('is_active',1)->get();

        $this->bJendelaLubangCahaya = BJendelaLubangCahaya::where('is_active',1)->get();
        $this->bKondisiJendelaLubangCahaya = BKondisiJendelaLubangCahaya::where('is_active',1)->get();
        $this->bVentilasi = BVentilasi::where('is_active',1)->get();
        $this->bKondisiVentilasi = BKondisiVentilasi::where('is_active',1)->get();
        $this->bKamarMandi = BKamarMandi::where('is_active',1)->get();
        $this->bKondisiKamarMandi = BKondisiKamarMandi::where('is_active',1)->get();
        $this->bJamban = BJamban::where('is_active',1)->get();
        $this->bKondisiJamban = BKondisiJamban::where('is_active',1)->get();
        $this->bSistemPembuanganAirKotor = BSistemPembuanganAirKotor::where('is_active',1)->get();
        $this->bKondisiSistemPembuanganAirKotor = BKondisiSistemPembuanganAirKotor::where('is_active',1)->get();
        $this->bFrekuensiPenyedotan = BFrekuensiPenyedotan::where('is_active',1)->get();
        $this->bSumberAirMinum = BSumberAirMinum::where('is_active',1)->get();
        $this->bKondisiSumberAirMinum = BKondisiSumberAirMinum::where('is_active',1)->get();
        $this->bSumberListrik = BSumberListrik::where('is_active',1)->get();

         $this->cRuangKeluargaDanTidur = CRuangKeluargaDanTidur::where('is_active',1)->get();
        $this->cJenisFisikBangunan = CJenisFisikBangunan::where('is_active',1)->get();
        $this->cFungsiRumah = CFungsiRumah::where('is_active',1)->get();
        $this->cTipeRumah = CTipeRumah::where('is_active',1)->get();
        $this->cStatusDtks = CStatusDtks::where('is_active',1)->get();


        $this->dMaterialAtapTerluas = DMaterialAtapTerluas::where('is_active',1)->get();
        $this->dKondisiPenutupAtap = DKondisiPenutupAtap::where('is_active',1)->get();
        $this->dMaterialDindingTerluas = DMaterialDindingTerluas::where('is_active',1)->get();
        $this->dKondisiDinding = DKondisiDinding::where('is_active',1)->get();
        $this->dMaterialLantaiTerluas = DMaterialLantaiTerluas::where('is_active',1)->get();
        $this->dKondisiLantai = DKondisiLantai::where('is_active',1)->get();
        $this->dAksesKeJalan = DAksesKeJalan::where('is_active',1)->get();
        $this->dBangunanMenghadapJalan = DBangunanMenghadapJalan::where('is_active',1)->get();
        $this->dBangunanMenghadapSungai = DBangunanMenghadapSungai::where('is_active',1)->get();
        $this->dBangunanBeradaLimbah = DBangunanBeradaLimbah::where('is_active',1)->get();
        $this->dBangunanBeradaSungai = DBangunanBeradaSungai::where('is_active',1)->get();
    }

    public function loadRumah($id)
    {
        $rumah = Rumah::with([
            'sosialEkonomi',
            'fisik',
            'sanitasi',
            'kepemilikan',
            'bantuan',
            'dokumen',
            'kepalaKeluarga.anggota',
        ])->findOrFail($id);

        // 🏠 Rumah dasar
        $this->alamat = $rumah->alamat;
        $this->latitude = $rumah->latitude;
        $this->longitude = $rumah->longitude;
        $this->rt = $rumah->rt;
        $this->rw = $rumah->rw;
        $this->kecamatan_id = $rumah->kecamatan_id;
        $this->kelurahan_id = $rumah->kelurahan_id;
        $this->tahun_pembangunan_rumah = $rumah->tahun_pembangunan_rumah;

         $this->filteredKelurahan = IKelurahan::where('kecamatan_id', $this->kecamatan_id)
            ->orderBy('nama_kelurahan')
            ->get();

        // 🔹 Reset pilihan kelurahan
        

        // 👨‍👩‍👧 Sosial Ekonomi
        if ($rumah->sosialEkonomi) {
            $se = $rumah->sosialEkonomi;
            $this->jumlahKK = $se->jumlah_kk_id;
            $this->jenis_kelamin_id = $se->jenis_kelamin_id;
            $this->usia = $se->usia;
            $this->pendidikan_terakhir_id = $se->pendidikan_terakhir_id;
            $this->pekerjaan_utama_id = $se->pekerjaan_utama_id;
            $this->besar_penghasilan_id = $se->besar_penghasilan_perbulan_id;
            $this->besar_pengeluaran_id = $se->besar_pengeluaran_perbulan_id;
            $this->status_dtks_id = $se->status_dtks_id;
        }

        // 🧱 Fisik Rumah
        if ($rumah->fisik) {
            $f = $rumah->fisik;
            foreach ([
                'pondasi_id',
                'jenis_pondasi_id' => 'jenis_pondasi', // ⬅️ mapping dari DB → Livewire
                'kondisi_pondasi_id',
                'kondisi_sloof_id',
                'kondisi_kolom_tiang_id',
                'kondisi_balok_id',
                'kondisi_struktur_atap_id',
                'material_atap_terluas_id',
                'kondisi_penutup_atap_id',
                'material_dinding_terluas_id',
                'kondisi_dinding_id',
                'material_lantai_terluas_id',
                'kondisi_lantai_id',
                'akses_ke_jalan_id',
                'bangunan_menghadap_jalan_id',
                'bangunan_menghadap_sungai_id',
                'bangunan_berada_limbah_id',
                'bangunan_berada_sungai_id',
                'luas_rumah',
                'tinggi_rata_rumah',
                'jumlah_penghuni_laki',
                'jumlah_penghuni_perempuan',
                'jumlah_abk',
                'ruang_keluarga_dan_tidur_id' => 'ruang_keluarga_dan_ruang_tidur_id',
                'jumlah_kamar_tidur',
                'luas_rata_kamar_tidur',
                'jenis_fisik_bangunan_id',
                'fungsi_rumah_id',
                'tipe_rumah_id',
                'jumlah_lantai_bangunan'
            ] as $property => $column) {
                if (is_int($property)) {
                    $property = $column; // untuk yang tidak pakai alias
                }
                $this->$property = $f->$column ?? null;
            }
        }


        // 💧 Sanitasi
        if ($rumah->sanitasi) {
            $s = $rumah->sanitasi;
            foreach ([
                'jendela_lubang_cahaya_id', 'kondisi_jendela_lubang_cahaya_id', 'ventilasi_id',
                'keterangan_ventilasi', 'kondisi_ventilasi_id', 'kamar_mandi_id',
                'kondisi_kamar_mandi_id', 'jamban_id', 'kondisi_jamban_id',
                'sistem_pembuangan_air_kotor_id', 'kondisi_sistem_pembuangan_air_kotor_id',
                'frekuensi_penyedotan_id', 'sumber_air_minum_id', 'kondisi_sumber_air_minum_id',
                'sumber_listrik_id'
            ] as $attr) {
                $this->$attr = $s->$attr ?? null;
            }
        }

        // 🏡 Kepemilikan
        if ($rumah->kepemilikan) {
            $k = $rumah->kepemilikan;
            foreach ([
                'status_kepemilikan_tanah_id', 'bukti_kepemilikan_tanah_id', 'status_kepemilikan_rumah_id',
                'nik_kepemilikan_rumah', 'status_imb_id', 'nomor_imb', 'aset_rumah_ditempat_lain_id',
                'aset_tanah_ditempat_lain_id', 'jenis_kawasan_lokasi_rumah_id'
            ] as $attr) {
                $this->$attr = $k->$attr ?? null;
            }
        }

        // 🎁 Bantuan
        if ($rumah->bantuan) {
            $b = $rumah->bantuan;
            foreach ([
                'pernah_mendapatkan_bantuan_id', 'no_kk_penerima', 'tahun_bantuan',
                'nama_bantuan', 'nama_program_bantuan', 'nominal_bantuan'
            ] as $attr) {
                $this->$attr = $b->$attr ?? null;
            }
        }

        // 📷 Dokumen
        if ($rumah->dokumen) {
            $d = $rumah->dokumen;
            $this->foto_kk = $d->foto_kk;
            $this->foto_ktp = $d->foto_ktp;
            $this->foto_rumah_satu = $d->foto_rumah_satu;
            $this->foto_rumah_dua = $d->foto_rumah_dua;
            $this->foto_rumah_tiga = $d->foto_rumah_tiga;
            $this->foto_imb = $d->foto_imb;
        }

        // 👨‍👩 Kepala & Anggota Keluarga
        $this->kks = [];
        foreach ($rumah->kepalaKeluarga as $kk) {
            $this->kks[] = [
                'no_kk' => $kk->no_kk,
                'kode_kk' => $kk->kode_kk,
                'anggota' => $kk->anggota->map(fn($a) => [
                    'nik' => $a->nik,
                    'nama' => $a->nama,
                    'kode_anggota' => $a->kode_anggota,
                ])->toArray(),
            ];
        }

        $select2Values = collect(get_object_vars($this))
            ->filter(fn($v, $k) => str_ends_with($k, '_id'))
            ->toArray();

        // 🔹 Kirim ke frontend (JavaScript)
        logger('📤 Dispatching setAllSelect2', $select2Values);
        $this->js("
    setTimeout(() => {
        console.log('🚀 Dispatching CustomEvent setAllSelect2 dari PHP');
        window.dispatchEvent(new CustomEvent('setAllSelect2', { detail: " . json_encode($select2Values) . " }));
    }, 500);
");
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
            logger("✅ Livewire menerima {$name} = {$value}");
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

        if ($name === 'pernah_mendapatkan_bantuan_id') {
            $this->updatedPernahMendapatkanBantuanId($value);
        }
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
        

       // $this->filteredKelurahan = IKelurahan::where('kecamatan_id', $this->kecamatan_id)->get();
       

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
        return view('livewire.rumah.edit')
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

    public function updateForm()
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

                    // 🔥 LEWATKAN CHILD YANG TIDAK AKTIF
                if ($q->parent_question_id !== null) {

                    $parentAnswer = $this->questionAnswers[$q->parent_question_id] ?? null;

                    // Jika trigger tidak cocok → child tidak aktif → skip
                    if ($q->trigger_option_id != $parentAnswer) {
                        continue;
                    }
                }

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
                // ✅ Foto wajib hanya 3 rumah
            

                // ✅ Semua foto yang mungkin disimpan
            
                // 🔍 Validasi hanya foto wajib
                    foreach ($requiredPhotos as $field => $label) {
                        if (empty($this->$field) && empty(optional($this->rumah->dokumen)[$field])) {
                            // Jika Livewire tidak punya file baru dan di DB juga belum ada
                            $this->dispatch('swal:error', [
                                'title' => 'Dokumentasi Belum Lengkap',
                                'text'  => "{$label} wajib diunggah.",
                            ]);
                            return;
                        }
                    }
            }

        try {
            DB::beginTransaction();

            // 🔍 Ambil rumah beserta relasi
             $rumah = Rumah::with([
                'sosialEkonomi',
                'fisik',
                'sanitasi',
                'kepemilikan',
                'bantuan',
                'dokumen',
                'kepalaKeluarga.anggota',
            ])->findOrFail($this->id_rumah);

            $oldRumah = $rumah->only([
                'alamat',
                'latitude',
                'longitude',
                'rt',
                'rw',
                'kecamatan_id',
                'kelurahan_id',
                'tahun_pembangunan_rumah',
            ]);

            $newRumahData = [
                'alamat'       => $this->alamat,
                'latitude'     => $this->latitude,
                'longitude'    => $this->longitude,
                'rt'           => $this->rt,
                'rw'           => $this->rw,
                'kecamatan_id' => $this->kecamatan_id,
                'kelurahan_id' => $this->kelurahan_id,
                'tahun_pembangunan_rumah' => $this->tahun_pembangunan_rumah,
            ];

            // 🏠 Update data dasar rumah
            $rumah->update($newRumahData);
            $this->logMultiple(
                $rumah->id_rumah,
                'rumah',           // kategori
                $oldRumah,         // data lama
                $newRumahData      // data baru
            );

                $oldKK = KepalaKeluarga::with('anggota')
            ->where('rumah_id', $rumah->id_rumah)
            ->get()
            ->map(function ($kk) {
                return [
                    'kode_kk' => $kk->kode_kk,
                    'no_kk'   => $kk->no_kk,
                    'anggota' => $kk->anggota->map(function ($a) {
                        return [
                            'kode_anggota' => $a->kode_anggota,
                            'nik'          => $a->nik,
                            'nama'         => $a->nama,
                        ];
                    })->toArray()
                ];
            })->toArray();


            if (!empty($this->kks) && count($this->kks) > 0) {
                $kkCodes = []; // untuk melacak KK yang tetap ada

                foreach ($this->kks as $kkIndex => $kk) {
                    $kodeKK = chr(65 + $kkIndex); // A, B, C, D ...
                    $kkCodes[] = $kodeKK;

                    // 🧩 Update atau buat KK
                    $kepalaKeluarga = KepalaKeluarga::updateOrCreate(
                        ['rumah_id' => $rumah->id_rumah, 'kode_kk' => $kodeKK],
                        ['no_kk' => $kk['no_kk'] ?? null]
                    );

                    // 🧩 Update atau buat anggota keluarga
                    if (!empty($kk['anggota']) && count($kk['anggota']) > 0) {
                        $anggotaCodes = [];

                        foreach ($kk['anggota'] as $anggotaIndex => $anggota) {
                            $hurufKK = strtolower($kodeKK);
                            $hurufAnggota = chr(97 + $anggotaIndex); // a, b, c ...
                            $kodeAnggota = $hurufKK . $hurufAnggota;
                            $anggotaCodes[] = $kodeAnggota;

                            AnggotaKeluarga::updateOrCreate(
                                ['kepala_keluarga_id' => $kepalaKeluarga->id, 'kode_anggota' => $kodeAnggota],
                                [
                                    'nik'  => $anggota['nik'] ?? null,
                                    'nama' => $anggota['nama'] ?? null,
                                ]
                            );
                        }

                        // ❌ Hapus anggota lama yang tidak ada lagi
                        $kepalaKeluarga->anggota()
                            ->whereNotIn('kode_anggota', $anggotaCodes)
                            ->delete();
                    }
                }

                // ❌ Hapus KK lama yang tidak ada lagi
                KepalaKeluarga::where('rumah_id', $rumah->id_rumah)
                    ->whereNotIn('kode_kk', $kkCodes)
                    ->delete();
            }
        $newKK = KepalaKeluarga::with('anggota')
            ->where('rumah_id', $rumah->id_rumah)
            ->get()
            ->map(function ($kk) {
                return [
                    'kode_kk' => $kk->kode_kk,
                    'no_kk'   => $kk->no_kk,
                    'anggota' => $kk->anggota->map(function ($a) {
                        return [
                            'kode_anggota' => $a->kode_anggota,
                            'nik'          => $a->nik,
                            'nama'         => $a->nama,
                        ];
                    })->toArray()
                ];
            })->toArray();


          $this->logKKChange(
                $rumah->id_rumah,
                $oldKK,
                $newKK
            );




            //pertanyaan lain
            $oldAnswers = SurveyQuestionAnswer::where('rumah_id', $rumah->id_rumah)
            ->get()
            ->mapWithKeys(function ($a) {
                return [
                    $a->question_id => [
                        'answer_text'       => $a->answer_text,
                        'answer_option_id'  => $a->answer_option_id,
                        'answer_option_ids' => $a->answer_option_ids,
                        'file_path'         => $a->file_path,
                    ]
                ];
            })
            ->toArray();

            foreach ($this->childQuestions as $child) {

                $parentAnswer = $this->questionAnswers[$child->parent_question_id] ?? null;

                //dd($parentAnswer,$child->trigger_option_id);
                // Child TIDAK AKTIF ketika trigger_option_id tidak sama dengan jawaban induk
                if ($child->trigger_option_id != $parentAnswer) {
                    $this->skipQuestions[$child->id] = true;
                    Log::info("{$child->id}/{$rumah->id_rumah}");

                    // $id_data = SurveyQuestionAnswer::where('rumah_id', $rumah->id_rumah)
                    //     ->where('question_id', $child->id)
                    //     ->value('id');
                        
                    // SurveyQuestionAnswer::find($id_data)->delete();

                     $answer = SurveyQuestionAnswer::where('rumah_id', $rumah->id_rumah)
                        ->where('question_id', $child->id)
                        ->first();

                    if ($answer) {
                        $answer->delete();  // delete aman
                    }


                    DB::enableQueryLog();
                  DB::delete("
                    DELETE FROM survey_question_answers
                    WHERE rumah_id='".$rumah->id_rumah."' AND question_id = '".$child->id."'
                ");

                Log::info('query', [DB::getQueryLog()]);
                unset($this->questionAnswers[$child->id]);

                    // 🔑 Penting: kosongkan juga di state Livewire
                  //  unset($this->questionAnswers[$child->id]);
                }
            }

            foreach ($this->allQuestions as $q) {

                if (isset($skipQuestions[$q->id])) {
                    Log::info("Skip question {$q->id} for rumah {$rumah->id_rumah}");
                    continue; // ❌ LEWATKAN, JANGAN SIMPAN ULANG
                }
                $answer = $this->questionAnswers[$q->id] ?? null;

                // Abaikan jika pertanyaan tidak wajib dan tidak diisi
                if (!$q->is_required && empty($answer)) {
                    // Jika sebelumnya ada jawaban → hapus
                    SurveyQuestionAnswer::where('rumah_id', $rumah->id_rumah)
                        ->where('question_id', $q->id)
                        ->delete();
                    continue;
                }

                // --- TEXT / TEXTAREA / NUMBER / DATE ---
                if (in_array($q->type, ['text','textarea','number','date'])) {

                    SurveyQuestionAnswer::updateOrCreate(
                        [
                            'rumah_id'    => $rumah->id_rumah,
                            'question_id' => $q->id,
                        ],
                        [
                            'answer_text'       => $answer,
                            'answer_option_id'  => null,
                            'answer_option_ids' => null,
                            'file_path'         => null,
                        ]
                    );
                }

                // --- SELECT & RADIO ---
                elseif (in_array($q->type, ['select','radio'])) {

                    SurveyQuestionAnswer::updateOrCreate(
                        [
                            'rumah_id'    => $rumah->id_rumah,
                            'question_id' => $q->id,
                        ],
                        [
                            'answer_option_id'  => $answer,
                            'answer_text'       => null,
                            'answer_option_ids' => null,
                            'file_path'         => null,
                        ]
                    );
                }

                // --- CHECKBOX (multi select) ---
                elseif ($q->type === 'checkbox') {

                    SurveyQuestionAnswer::updateOrCreate(
                        [
                            'rumah_id'    => $rumah->id_rumah,
                            'question_id' => $q->id,
                        ],
                        [
                            'answer_option_ids' => is_array($answer) ? $answer : [],
                            'answer_text'       => null,
                            'answer_option_id'  => null,
                            'file_path'         => null,
                        ]
                    );
                }


                // --- FILE ---
                elseif ($q->type === 'file' && $answer) {

                    $filePath = $answer->store('survey_answers', 'public');

                    SurveyQuestionAnswer::updateOrCreate(
                        [
                            'rumah_id'    => $rumah->id_rumah,
                            'question_id' => $q->id,
                        ],
                        [
                            'file_path'         => $filePath,
                            'answer_text'       => null,
                            'answer_option_id'  => null,
                            'answer_option_ids' => null,
                        ]
                    );
                }
            }

            $newAnswers = SurveyQuestionAnswer::where('rumah_id', $rumah->id_rumah)
                ->get()
                ->mapWithKeys(function ($a) {
                    return [
                        $a->question_id => [
                            'answer_text'       => $a->answer_text,
                            'answer_option_id'  => $a->answer_option_id,
                            'answer_option_ids' => $a->answer_option_ids,
                            'file_path'         => $a->file_path,
                        ]
                    ];
                })
                ->toArray();

            $this->logArrayChanges(
                $rumah->id_rumah,
                'survey_answers',
                $oldAnswers,
                $newAnswers
            );


            // 👨‍👩‍👧 Sosial ekonomi
            $oldSosial = $rumah->sosialEkonomi
                ? $rumah->sosialEkonomi->toArray()
                : [];
            $rumah->sosialEkonomi()->updateOrCreate(
                ['rumah_id' => $rumah->id_rumah],
                [
                    'jumlah_kk_id'                  => $this->jumlahKK,
                    'no_kk'                         => $this->kks[0]['no_kk'] ?? null,
                    'jenis_kelamin_id'              => $this->jenis_kelamin_id,
                    'usia'                          => $this->usia,
                    'pendidikan_terakhir_id'        => $this->pendidikan_terakhir_id,
                    'pekerjaan_utama_id'            => $this->pekerjaan_utama_id,
                    'besar_penghasilan_perbulan_id' => $this->besar_penghasilan_id,
                    'besar_pengeluaran_perbulan_id' => $this->besar_pengeluaran_id,
                    'status_dtks_id'                => $this->status_dtks_id,
                ]
            );
            $newSosial = $rumah->sosialEkonomi()->first()->toArray();
            $this->logArrayChanges(
                $rumah->id_rumah,
                'sosial_ekonomi',
                $oldSosial,
                $newSosial
            );


            // 🧱 Fisik rumah
            $oldFisik = $rumah->fisik
            ? $rumah->fisik->toArray()
            : [];
            $rumah->fisik()->updateOrCreate(
                ['rumah_id' => $rumah->id_rumah],
                [
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
                ]
            );
            $newFisik = $rumah->fisik()->first()->toArray();
            $this->logArrayChanges(
                $rumah->id_rumah,
                'fisik_rumah',
                $oldFisik,
                $newFisik
            );


            // 💧 Sanitasi
            $oldSanitasi = $rumah->sanitasi
            ? $rumah->sanitasi->toArray()
            : [];
            $rumah->sanitasi()->updateOrCreate(
                ['rumah_id' => $rumah->id_rumah],
                [
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
                ]
            );
            $newSanitasi = $rumah->sanitasi()->first()->toArray();
            $this->logArrayChanges(
                $rumah->id_rumah,
                'sanitasi_rumah',
                $oldSanitasi,
                $newSanitasi
            );


            // 🎁 Bantuan rumah
            $oldBantuan = $rumah->bantuan
            ? $rumah->bantuan->toArray()
            : [];
            $rumah->bantuan()->updateOrCreate(
                ['rumah_id' => $rumah->id_rumah],
                [
                    'pernah_mendapatkan_bantuan_id' => $this->pernah_mendapatkan_bantuan_id,
                    'no_kk_penerima'                => $this->no_kk_penerima,
                    'tahun_bantuan'                 => $this->tahun_bantuan,
                    'nama_bantuan'                  => $this->nama_bantuan,
                    'nama_program_bantuan'          => $this->nama_program_bantuan,
                    'nominal_bantuan'               => $this->nominal_bantuan,
                ]
            );
            $newBantuan = $rumah->bantuan()->first()->toArray();
            $this->logArrayChanges(
                $rumah->id_rumah,
                'bantuan_rumah',
                $oldBantuan,
                $newBantuan
            );


            // 🏡 Kepemilikan rumah
            $oldKepemilikan = $rumah->kepemilikan
            ? $rumah->kepemilikan->toArray()
            : [];

            $rumah->kepemilikan()->updateOrCreate(
                ['rumah_id' => $rumah->id_rumah],
                [
                    'status_kepemilikan_tanah_id'   => $this->status_kepemilikan_tanah_id,
                    'bukti_kepemilikan_tanah_id'    => $this->bukti_kepemilikan_tanah_id,
                    'status_kepemilikan_rumah_id'   => $this->status_kepemilikan_rumah_id,
                    'nik_kepemilikan_rumah'         => $this->nik_kepemilikan_rumah,
                    'status_imb_id'                 => $this->status_imb_id,
                    'nomor_imb'                     => $this->nomor_imb,
                    'aset_rumah_ditempat_lain_id'   => $this->aset_rumah_ditempat_lain_id,
                    'aset_tanah_ditempat_lain_id'   => $this->aset_tanah_ditempat_lain_id,
                    'jenis_kawasan_lokasi_rumah_id' => $this->jenis_kawasan_lokasi_rumah_id,
                ]
            );
            $newKepemilikan = $rumah->kepemilikan()->first()->toArray();
            $this->logArrayChanges(
                $rumah->id_rumah,
                'kepemilikan_rumah',
                $oldKepemilikan,
                $newKepemilikan
            );


            // 🔢 Hitung & simpan ulang penilaian (sama seperti submitForm)
            $this->hitungDanSimpanPenilaian($rumah->id_rumah);

            // 📸 Update foto hanya jika ada baru
            $oldDokumen = $rumah->dokumen ? $rumah->dokumen->toArray() : [];

            $dokumen = $rumah->dokumen ?? new DokumenRumah(['rumah_id' => $rumah->id_rumah]);

            $changed = []; // untuk menampung perubahan foto

            foreach (array_keys($requiredPhotos) as $field) {

                // Jika upload baru
                if ($this->$field instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {

                    $path = $this->$field->storeAs(
                        "rumah/{$rumah->id_rumah}",
                        "{$field}.jpg"
                    );

                    // Simpan path baru
                    $dokumen->$field = "rumah/{$rumah->id_rumah}/{$field}.jpg";

                    // Catat perubahan history
                    $changed[$field] = [
                        'old' => $oldDokumen[$field] ?? null,
                        'new' => $dokumen->$field
                    ];
                }
            }
            $dokumen->uploaded_by = auth()->user()->id;
            $dokumen->uploaded_at = now();
            $dokumen->save();

            // 🔵 Simpan history jika ada perubahan
            if (!empty($changed)) {
                $this->logArrayChanges(
                    $rumah->id_rumah,
                    'dokumen_rumah',
                    $oldDokumen,
                    array_merge($oldDokumen, array_map(fn($c) => $c['new'], $changed))
                );
            }


            DB::commit();

            $this->dispatch('swal:success', [
                'title' => 'Berhasil!',
                'text'  => 'Data rumah dan penilaian berhasil diperbarui.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('swal:error', [
                'title' => 'Gagal Update!',
                'text'  => 'Terjadi kesalahan: ' . $e->getMessage(),
            ]);
        }
    }

    private function hitungDanSimpanPenilaian($rumahId)
    {
        // Rumus penilaian persis dari submitForm()
        $oldPenilaian = PenilaianRumah::where('rumah_id', $rumahId)
                ->first();

        $oldPenilaianArray = $oldPenilaian ? $oldPenilaian->toArray() : [];

        $jendela = $this->jendela_lubang_cahaya_id;
        $kj = $this->kondisi_jendela_lubang_cahaya_id;
        $ventilasi = $this->ventilasi_id;
        $kv = $this->kondisi_ventilasi_id;
        $km = $this->kamar_mandi_id;
        $kkm = $this->kondisi_kamar_mandi_id;
        $jamban = $this->jamban_id;
        $kjb = $this->kondisi_jamban_id;
        $spak = $this->sistem_pembuangan_air_kotor_id;
        $kspak = $this->kondisi_sistem_pembuangan_air_kotor_id;
        $sam = $this->sumber_air_minum_id;
        $ksam = $this->kondisi_sumber_air_minum_id;
        $atap = $this->material_atap_terluas_id;
        $katap = $this->kondisi_penutup_atap_id;
        $dinding = $this->material_dinding_terluas_id;
        $kdinding = $this->kondisi_dinding_id;
        $lantai = $this->material_lantai_terluas_id;
        $klantai = $this->kondisi_lantai_id;

        $kp = $this->kondisi_pondasi_id;
        $ks = $this->kondisi_sloof_id;
        $kt = $this->kondisi_kolom_tiang_id;
        $kb = $this->kondisi_balok_id;
        $ka = $this->kondisi_struktur_atap_id;

        $l = (float) $this->luas_rumah;
        $pL = (int) $this->jumlah_penghuni_laki;
        $pP = (int) $this->jumlah_penghuni_perempuan;

        // 🔸 logika penilaian sama 100%
        $kj = ($jendela == 1) ? $kj : 4;
        $kv = ($ventilasi == 1) ? $kv : 4;
        $kkm = in_array($km, [1, 2]) ? $kkm : 5;
        $kjb = ($jamban == 1) ? $kjb : 4;
        $kspak = ($spak == 1) ? $kspak : 4;
        $ksam = in_array($sam, [1, 2, 3]) ? $ksam : 4;
        $katap = in_array($atap, [1, 3, 8]) ? $katap : 4;
        $kdinding = in_array($dinding, [1, 2, 3, 4, 5]) ? $kdinding : 4;
        $klantai = in_array($lantai, [1, 2, 3, 4, 5]) ? $klantai : 4;

        $nilai_a = $kp + $ks + $kt + $kb + $ka;
        $nilai_b = $kj + $kv + $kkm + $kjb + $kspak + $ksam;
        $nilai_c = $katap + $kdinding + $klantai;

        $prioritas_a = ($kp >= 4 || $ks >= 4 || $kt >= 4 || $kb >= 4 || $ka >= 4) ? 2 : 1;
        $prioritas_b = (collect([$kj, $kv, $kkm, $kjb, $kspak, $ksam])->filter(fn($v) => $v >= 4)->count() >= 2) ? 2 : 1;
        $prioritas_c = (collect([$katap, $kdinding, $klantai])->filter(fn($v) => $v >= 4)->count() >= 2) ? 2 : 1;

        $nilai = $nilai_a + $nilai_b + $nilai_c;

        $luas_min = ($pL + $pP) * 9;
        $status_luas = ($l >= $luas_min) ? 1 : 2;
        $status_rumah = ($prioritas_a == 2 || $prioritas_b == 2 || $prioritas_c == 2) ? 'RTLH' : 'RLH';

        PenilaianRumah::updateOrCreate(
            ['rumah_id' => $rumahId],
            [
                'nilai_a'      => $nilai_a,
                'prioritas_a'  => $prioritas_a,
                'nilai_b'      => $nilai_b,
                'prioritas_b'  => $prioritas_b,
                'nilai_c'      => $nilai_c,
                'prioritas_c'  => $prioritas_c,
                'nilai'        => $nilai,
                'status_luas'  => $status_luas,
                'status_rumah' => $status_rumah,
            ]
        );

        $newPenilaian = PenilaianRumah::where('rumah_id', $rumahId)
        ->first()
        ->toArray();

        $this->logArrayChanges(
        $rumahId,
        'penilaian_rumah',
        $oldPenilaianArray,
        $newPenilaian
        );
    }


}
