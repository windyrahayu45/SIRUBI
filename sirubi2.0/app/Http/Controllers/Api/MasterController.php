<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// ====== Import semua model ======
use App\Models\AKondisiBalok;
use App\Models\AKondisiKolomTiang;
use App\Models\AKondisiPondasi;
use App\Models\AKondisiSloof;
use App\Models\AKondisiStrukturAtap;
use App\Models\AnggotaKeluarga;
use App\Models\APondasi;
use App\Models\BantuanRumah;
use App\Models\BJamban;
use App\Models\BJendelaLubangCahaya;
use App\Models\BKondisiJendelaLubangCahaya;
use App\Models\BKamarMandi;
use App\Models\BKondisiJamban;
use App\Models\BKondisiKamarMandi;
use App\Models\BKondisiSistemPembuanganAirKotor;
use App\Models\BSistemPembuanganAirKotor;
use App\Models\BFrekuensiPenyedotan;
use App\Models\BSumberAirMinum;
use App\Models\BKondisiSumberAirMinum;
use App\Models\BSumberListrik;
use App\Models\BVentilasi;
use App\Models\BKondisiVentilasi;

use App\Models\CFungsiRumah;
use App\Models\CJenisFisikBangunan;
use App\Models\CRuangKeluargaDanTidur;
use App\Models\CRuangKeluargaTidur;
use App\Models\CStatusDtks;
use App\Models\CTipeRumah;

use App\Models\DKondisiDinding;
use App\Models\DKondisiLantai;
use App\Models\DKondisiPenutupAtap;
use App\Models\DMaterialAtapTerluas;
use App\Models\DMaterialDindingTerluas;
use App\Models\DMaterialLantaiTerluas;
use App\Models\DAksesJalan;
use App\Models\DAksesKeJalan;
use App\Models\DBangunanMenghadapJalan;
use App\Models\DBangunanMenghadapSungai;
use App\Models\DBangunanBeradaLimbah;
use App\Models\DBangunanBeradaSungai;
use App\Models\DokumenRumah;
use App\Models\FisikRumah;
use App\Models\IStatusImb;
use App\Models\IKecamatan;
use App\Models\IKelurahan;
use App\Models\IJenisKelamin;
use App\Models\IStatusKepemilikanRumah;
use App\Models\IStatusKepemilikanTanah;

use App\Models\IAsalPenghasilan;
use App\Models\IBesarPenghasilan;
use App\Models\IBesarPengeluaran;
use App\Models\IPekerjaanUtama;
use App\Models\IPendidikanTerakhir;
use App\Models\IPernahMendapatBantuan;
use App\Models\IJenisKawasanLokasi;
use App\Models\IAsetRumahTempatLain;
use App\Models\IAsetTanahTempatLain;
use App\Models\IBuktiKepemilikanTanah;
use App\Models\IJumlahKk;
use App\Models\IPernahMendapatkanBantuan;
use App\Models\JenisPondasi;
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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Traits\LogsRumahHistory;

class MasterController extends Controller
{
    use LogsRumahHistory;
    public function init(Request $request)
    {
        $user = $request->auth;

        $data = [
            // ===== Bagian A =====
            'a_kondisi_balok'            => AKondisiBalok::all(),
            'a_kondisi_kolom_tiang'      => AKondisiKolomTiang::all(),
            'a_kondisi_pondasi'          => AKondisiPondasi::all(),
            'a_kondisi_sloof'            => AKondisiSloof::all(),
            'a_kondisi_struktur_atap'    => AKondisiStrukturAtap::all(),
            'a_pondasi'                  => APondasi::all(),

            // ===== Bagian B =====
            'b_jamban'                               => BJamban::all(),
            'b_jendela_lubang_cahaya'                => BJendelaLubangCahaya::all(),
            'b_kondisi_jendela_lubang_cahaya'        => BKondisiJendelaLubangCahaya::all(),
            'b_kamar_mandi'                          => BKamarMandi::all(),
            'b_kondisi_jamban'                       => BKondisiJamban::all(),
            'b_kondisi_kamar_mandi'                  => BKondisiKamarMandi::all(),
            'b_kondisi_sistem_pembuangan_air_kotor'  => BKondisiSistemPembuanganAirKotor::all(),
            'b_sistem_pembuangan_air_kotor'          => BSistemPembuanganAirKotor::all(),
            'b_frekuensi_penyedotan'                 => BFrekuensiPenyedotan::all(),
            'b_sumber_air_minum'                     => BSumberAirMinum::all(),
            'b_kondisi_sumber_air_minum'             => BKondisiSumberAirMinum::all(),
            'b_sumber_listrik'                       => BSumberListrik::all(),
            'b_ventilasi'                            => BVentilasi::all(),
            'b_kondisi_ventilasi'                    => BKondisiVentilasi::all(),

            // ===== Bagian C =====
            'c_fungsi_rumah'               => CFungsiRumah::all(),
            'c_jenis_fisik_bangunan'       => CJenisFisikBangunan::all(),
            'c_ruang_keluarga_dan_tidur'   => CRuangKeluargaDanTidur::all(),
            'c_status_dtks'                => CStatusDtks::all(),
            'c_tipe_rumah'                 => CTipeRumah::all(),

            // ===== Bagian D =====
            'd_kondisi_dinding'            => DKondisiDinding::all(),
            'd_kondisi_lantai'             => DKondisiLantai::all(),
            'd_kondisi_penutup_atap'       => DKondisiPenutupAtap::all(),
            'd_material_atap_terluas'      => DMaterialAtapTerluas::all(),
            'd_material_dinding_terluas'   => DMaterialDindingTerluas::all(),
            'd_material_lantai_terluas'    => DMaterialLantaiTerluas::all(),
            'd_akses_ke_jalan'             => DAksesKeJalan::all(),
            'd_bangunan_menghadap_jalan'   => DBangunanMenghadapJalan::all(),
            'd_bangunan_menghadap_sungai'  => DBangunanMenghadapSungai::all(),
            'd_bangunan_berada_limbah'     => DBangunanBeradaLimbah::all(),
            'd_bangunan_berada_sungai'     => DBangunanBeradaSungai::all(),

            // ===== Bagian I =====
            'i_aset_rumah_tempat_lain'     => IAsetRumahTempatLain::all(),
            'i_aset_tanah_tempat_lain'     => IAsetTanahTempatLain::all(),
            'i_besar_pengeluaran'          => IBesarPengeluaran::all(),
            'i_besar_penghasilan'          => IBesarPenghasilan::all(),
            'i_bukti_kepemilikan_tanah'    => IBuktiKepemilikanTanah::all(),
            'i_jenis_kawasan_lokasi'       => IJenisKawasanLokasi::all(),
            'i_jenis_kelamin'              => IJenisKelamin::all(),
            'i_kecamatan'                  => IKecamatan::all(),
            'i_kelurahan'                  => IKelurahan::all(),
            'i_jumlah_kk'                  => IJumlahKk::all(),
            'i_pekerjaan_utama'            => IPekerjaanUtama::all(),
            'i_pendidikan_terakhir'        => IPendidikanTerakhir::all(),
            'i_pernah_mendapatkan_bantuan' => IPernahMendapatkanBantuan::all(),
            'i_status_imb'                 => IStatusImb::all(),
            'i_status_kepemilikan_rumah'   => IStatusKepemilikanRumah::all(),
            'i_status_kepemilikan_tanah'   => IStatusKepemilikanTanah::all(),
            'jenis_pondasi'                => TblJenisPondasi::all(),
        ];

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        // Convert string JSON menjadi array jika yang dikirim form-data
        if ($request->has('pertanyaan') && is_string($request->pertanyaan)) {
            $decoded = json_decode($request->pertanyaan, true);
            $request->merge(['pertanyaan' => $decoded]);
        }
        // ======================
        // VALIDASI DASAR
        // ======================
        $validator = Validator::make($request->all(), [
            'latitude'       => 'required|numeric',
            'longitude'      => 'required|numeric',
            'alamat'         => 'required|string',
            'rt'             => 'required|string',
            'rw'             => 'required|string',
            'kecamatan_id'   => 'required|integer',
            'kelurahan_id'   => 'required|integer',

            // sosial ekonomi
            'jenis_kelamin_id'          => 'required|integer',
            'usia'                      => 'required|integer',
            'pendidikan_terakhir_id'    => 'required|integer',
            'pekerjaan_utama_id'        => 'required|integer',
            'besar_penghasilan_id'      => 'required|integer',
            'besar_pengeluaran_id'      => 'required|integer',

            // status kepemilikan
            'nik_kepemilikan_rumah'     => 'nullable',
            'status_kepemilikan_tanah_id'   => 'required|integer',
            'bukti_kepemilikan_tanah_id'    => 'required|integer',
            'status_kepemilikan_rumah_id'   => 'required|integer',
            'status_imb_id'                 => 'required|integer',
            'jenis_kawasan_lokasi_rumah_id' => 'required|integer',
            'aset_rumah_ditempat_lain_id'   => 'required|integer',
            'aset_tanah_ditempat_lain_id'   => 'required|integer',
            'pernah_mendapatkan_bantuan_id' => 'required|integer',

            // fisik rumah
            'pondasi_id'                    => 'required|integer',
            'jenis_pondasi_id'              => 'required|integer',
            'kondisi_pondasi_id'            => 'required|integer',
            'kondisi_sloof_id'              => 'required|integer',
            'kondisi_kolom_tiang_id'        => 'required|integer',
            'kondisi_balok_id'              => 'required|integer',
            'kondisi_struktur_atap_id'      => 'required|integer',

            'jendela_lubang_cahaya_id'      => 'required|integer',
            'kondisi_jendela_lubang_cahaya_id' => 'required|integer',
            'ventilasi_id'                  => 'required|integer',
            'kondisi_ventilasi_id'          => 'required|integer',
            'kamar_mandi_id'                => 'required|integer',
            'kondisi_kamar_mandi_id'        => 'required|integer',
            'jamban_id'                     => 'required|integer',
            'kondisi_jamban_id'             => 'required|integer',
            'sistem_pembuangan_air_kotor_id'=> 'required|integer',
            'kondisi_sistem_pembuangan_air_kotor_id'=> 'required|integer',
            'frekuensi_penyedotan_id'       => 'required|integer',
            'sumber_air_minum_id'           => 'required|integer',
            'kondisi_sumber_air_minum_id'   => 'required|integer',
            'sumber_listrik_id'             => 'required|integer',

            'luas_rumah'                    => 'required|numeric',
            'jumlah_penghuni_laki'          => 'required|integer',
            'jumlah_penghuni_perempuan'     => 'required|integer',
            'tinggi_rata_rumah'             => 'required|numeric',
            'ruang_keluarga_dan_tidur_id'   => 'required|integer',
            'jumlah_kamar_tidur'            => 'required|integer',
            'luas_rata_kamar_tidur'         => 'required|numeric',
            'jenis_fisik_bangunan_id'       => 'required|integer',
            'jumlah_lantai_bangunan'        => 'required|integer',
            'fungsi_rumah_id'               => 'required|integer',
            'tipe_rumah_id'                 => 'required|integer',
            'status_dtks_id'                => 'required|integer',
            'tahun_pembangunan_rumah'       => 'required|integer',

            // foto wajib
            'foto_rumah_satu'   => 'required|file|mimes:jpg,jpeg,png',

            
            // pertanyaan dinamis
            'pertanyaan' => 'nullable|array',
            'pertanyaan.*.question_id' => 'required_with:pertanyaan',
            'pertanyaan.*.answer'      => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // ============================================
        // VALIDASI PERTANYAAN DINAMIS
        // ============================================
        if ($request->filled('pertanyaan')) {

            $all = SurveyQuestion::active()->get();

            foreach ($all as $q) {

                $row = collect($request->pertanyaan)
                    ->firstWhere('question_id', $q->id);

                if (!$row) continue;

                $answer = $row['answer'] ?? null;

                if (!$q->is_required) continue;

                if (in_array($q->type, ['text','textarea','number','date'])
                    && empty($answer)) {
                    return response()->json([
                        'status' => false,
                        'message' => "Pertanyaan '{$q->label}' wajib diisi."
                    ], 422);
                }

                if (in_array($q->type, ['select','radio'])
                    && empty($answer)) {
                    return response()->json([
                        'status' => false,
                        'message' => "Pertanyaan '{$q->label}' wajib dipilih."
                    ], 422);
                }

                if ($q->type === 'checkbox'
                    && (empty($answer) || count($answer) === 0)) {
                    return response()->json([
                        'status' => false,
                        'message' => "Pertanyaan '{$q->label}' wajib pilih minimal 1."
                    ], 422);
                }
            }
        }

        try {
            DB::beginTransaction();

            $uploadedBy = $request->auth->id_user ?? null;

            // ======================
            // SIMPAN RUMAH
            // ======================
            $rumah = Rumah::create([
                'id_rumah_lama' => '00',
                'alamat'        => $request->alamat,
                'latitude'      => $request->latitude,
                'longitude'     => $request->longitude,
                'rt'            => $request->rt,
                'rw'            => $request->rw,
                'kecamatan_id'  => $request->kecamatan_id,
                'kelurahan_id'  => $request->kelurahan_id,
                'tahun_pembangunan_rumah' => $request->tahun_pembangunan_rumah,
            ]);

            // ====================================================
            // SIMPAN PERTANYAAN DINAMIS (TIDAK ADA HISTORY)
            // ====================================================
            if ($request->filled('pertanyaan')) {

                foreach ($request->pertanyaan as $item) {

                    $q = SurveyQuestion::find($item['question_id']);
                    if (!$q) continue;

                    $answer = $item['answer'] ?? null;

                    if (in_array($q->type, ['text','textarea','number','date'])) {
                        SurveyQuestionAnswer::create([
                            'rumah_id'      => $rumah->id_rumah,
                            'question_id'   => $q->id,
                            'answer_text'   => $answer,
                        ]);
                    }

                    elseif (in_array($q->type, ['select','radio'])) {
                        SurveyQuestionAnswer::create([
                            'rumah_id'         => $rumah->id_rumah,
                            'question_id'      => $q->id,
                            'answer_option_id' => $answer,
                        ]);
                    }

                    elseif ($q->type === 'checkbox') {
                        SurveyQuestionAnswer::create([
                            'rumah_id'           => $rumah->id_rumah,
                            'question_id'        => $q->id,
                            'answer_option_ids'  => $answer,
                        ]);
                    }

                    elseif ($q->type === 'file' && $request->hasFile("qfile_{$q->id}")) {

                        $path = $request->file("qfile_{$q->id}")
                            ->store("survey_answers/{$rumah->id_rumah}", 'public');

                        SurveyQuestionAnswer::create([
                            'rumah_id'     => $rumah->id_rumah,
                            'question_id'  => $q->id,
                            'file_path'    => $path,
                        ]);
                    }
                }
            }

            // ======================================================
            // SIMPAN KEPALA KELUARGA + ANGGOTA
            // ======================================================
            $kks = json_decode($request->kks, true) ?? [];

            foreach ($kks as $kkIndex => $kk) {

                $kodeKK = chr(65 + $kkIndex);

                $kepala = KepalaKeluarga::create([
                    'rumah_id' => $rumah->id_rumah,
                    'no_kk'    => $kk['no_kk'] ?? null,
                    'kode_kk'  => $kodeKK,
                ]);

                if (!empty($kk['anggota'])) {
                    foreach ($kk['anggota'] as $i => $agt) {
                        AnggotaKeluarga::create([
                            'kepala_keluarga_id' => $kepala->id,
                            'nik' => $agt['nik'] ?? null,
                            'nama' => $agt['nama'] ?? null,
                            'kode_anggota' => strtolower($kodeKK) . chr(97 + $i),
                        ]);
                    }
                }
            }

            // ======================================================
            // SIMPAN SOSIAL EKONOMI
            // ======================================================
            SosialEkonomiRumah::create([
                'rumah_id' => $rumah->id_rumah,
                'jumlah_kk_id' => $request->jumlah_kk_id ?? null,
                'no_kk' => $kks[0]['no_kk'] ?? null,
                'jenis_kelamin_id' => $request->jenis_kelamin_id,
                'usia' => $request->usia,
                'pendidikan_terakhir_id' => $request->pendidikan_terakhir_id,
                'pekerjaan_utama_id' => $request->pekerjaan_utama_id,
                'besar_penghasilan_perbulan_id' => $request->besar_penghasilan_id,
                'besar_pengeluaran_perbulan_id' => $request->besar_pengeluaran_id,
                'status_dtks_id' => $request->status_dtks_id,
            ]);

            // ======================================================
            // SIMPAN FISIK RUMAH
            // ======================================================
            FisikRumah::create([
                'rumah_id' => $rumah->id_rumah,
                'pondasi_id' => $request->pondasi_id,
                'jenis_pondasi' => $request->jenis_pondasi_id,
                'kondisi_pondasi_id' => $request->kondisi_pondasi_id,
                'kondisi_sloof_id' => $request->kondisi_sloof_id,
                'kondisi_kolom_tiang_id' => $request->kondisi_kolom_tiang_id,
                'kondisi_balok_id' => $request->kondisi_balok_id,
                'kondisi_struktur_atap_id' => $request->kondisi_struktur_atap_id,
                'material_atap_terluas_id' => $request->material_atap_terluas_id,
                'kondisi_penutup_atap_id' => $request->kondisi_penutup_atap_id,
                'material_dinding_terluas_id' => $request->material_dinding_terluas_id,
                'kondisi_dinding_id' => $request->kondisi_dinding_id,
                'material_lantai_terluas_id' => $request->material_lantai_terluas_id,
                'kondisi_lantai_id' => $request->kondisi_lantai_id,
                'akses_ke_jalan_id' => $request->akses_ke_jalan_id,
                'bangunan_menghadap_jalan_id' => $request->bangunan_menghadap_jalan_id,
                'bangunan_menghadap_sungai_id' => $request->bangunan_menghadap_sungai_id,
                'bangunan_berada_limbah_id' => $request->bangunan_berada_limbah_id,
                'bangunan_berada_sungai_id' => $request->bangunan_berada_sungai_id,
                'luas_rumah' => $request->luas_rumah,
                'tinggi_rata_rumah' => $request->tinggi_rata_rumah,
                'jumlah_penghuni_laki' => $request->jumlah_penghuni_laki,
                'jumlah_penghuni_perempuan' => $request->jumlah_penghuni_perempuan,
                'jumlah_abk' => $request->jumlah_abk,
                'ruang_keluarga_dan_ruang_tidur_id' => $request->ruang_keluarga_dan_tidur_id,
                'jumlah_kamar_tidur' => $request->jumlah_kamar_tidur,
                'luas_rata_kamar_tidur' => $request->luas_rata_kamar_tidur,
                'jenis_fisik_bangunan_id' => $request->jenis_fisik_bangunan_id,
                'fungsi_rumah_id' => $request->fungsi_rumah_id,
                'tipe_rumah_id' => $request->tipe_rumah_id,
                'jumlah_lantai_bangunan' => $request->jumlah_lantai_bangunan,
            ]);

            // ======================================================
            // SIMPAN SANITASI
            // ======================================================
            SanitasiRumah::create([
                'rumah_id' => $rumah->id_rumah,
                'jendela_lubang_cahaya_id' => $request->jendela_lubang_cahaya_id,
                'kondisi_jendela_lubang_cahaya_id' => $request->kondisi_jendela_lubang_cahaya_id,
                'ventilasi_id' => $request->ventilasi_id,
                'keterangan_ventilasi' => $request->keterangan_ventilasi,
                'kondisi_ventilasi_id' => $request->kondisi_ventilasi_id,
                'kamar_mandi_id' => $request->kamar_mandi_id,
                'kondisi_kamar_mandi_id' => $request->kondisi_kamar_mandi_id,
                'jamban_id' => $request->jamban_id,
                'kondisi_jamban_id' => $request->kondisi_jamban_id,
                'sistem_pembuangan_air_kotor_id' => $request->sistem_pembuangan_air_kotor_id,
                'kondisi_sistem_pembuangan_air_kotor_id' => $request->kondisi_sistem_pembuangan_air_kotor_id,
                'frekuensi_penyedotan_id' => $request->frekuensi_penyedotan_id,
                'sumber_air_minum_id' => $request->sumber_air_minum_id,
                'kondisi_sumber_air_minum_id' => $request->kondisi_sumber_air_minum_id,
                'sumber_listrik_id' => $request->sumber_listrik_id,
            ]);

            // ======================================================
            // SIMPAN BANTUAN RUMAH
            // ======================================================
            BantuanRumah::create([
                'rumah_id' => $rumah->id_rumah,
                'pernah_mendapatkan_bantuan_id' => $request->pernah_mendapatkan_bantuan_id,
                'no_kk_penerima'                => $request->no_kk_penerima,
                'tahun_bantuan'                 => $request->tahun_bantuan,
                'nama_bantuan'                  => $request->nama_bantuan,
                'nama_program_bantuan'          => $request->nama_program_bantuan,
                'nominal_bantuan'               => $request->nominal_bantuan,
            ]);

            // ======================================================
            // SIMPAN KEPEMILIKAN
            // ======================================================
            KepemilikanRumah::create([
                'rumah_id'                      => $rumah->id_rumah,
                'status_kepemilikan_tanah_id'   => $request->status_kepemilikan_tanah_id,
                'bukti_kepemilikan_tanah_id'    => $request->bukti_kepemilikan_tanah_id,
                'status_kepemilikan_rumah_id'   => $request->status_kepemilikan_rumah_id,
                'nik_kepemilikan_rumah'         => $request->nik_kepemilikan_rumah,
                'status_imb_id'                 => $request->status_imb_id,
                'nomor_imb'                     => $request->nomor_imb,
                'aset_rumah_ditempat_lain_id'   => $request->aset_rumah_ditempat_lain_id,
                'aset_tanah_ditempat_lain_id'   => $request->aset_tanah_ditempat_lain_id,
                'jenis_kawasan_lokasi_rumah_id' => $request->jenis_kawasan_lokasi_rumah_id,
            ]);

            // ======================================================
            // HITUNG PENILAIAN RTLH (SAMA PERSIS DG VERSI WEB)
            // ======================================================
            $jendela = $request->jendela_lubang_cahaya_id;
            $kond_jendela = $request->kondisi_jendela_lubang_cahaya_id;
            $vent = $request->ventilasi_id;
            $kond_vent = $request->kondisi_ventilasi_id;
            $mandi = $request->kamar_mandi_id;
            $kond_mandi = $request->kondisi_kamar_mandi_id;
            $jamban = $request->jamban_id;
            $kond_jamban = $request->kondisi_jamban_id;
            $lpak = $request->sistem_pembuangan_air_kotor_id;
            $kond_lpak = $request->kondisi_sistem_pembuangan_air_kotor_id;
            $sam = $request->sumber_air_minum_id;
            $kond_sam = $request->kondisi_sumber_air_minum_id;

            $atap = $request->material_atap_terluas_id;
            $kond_atap = $request->kondisi_penutup_atap_id;

            $dinding = $request->material_dinding_terluas_id;
            $kond_dinding = $request->kondisi_dinding_id;

            $lantai = $request->material_lantai_terluas_id;
            $kond_lantai = $request->kondisi_lantai_id;

            $pondasi = $request->kondisi_pondasi_id;
            $sloof = $request->kondisi_sloof_id;
            $kolom = $request->kondisi_kolom_tiang_id;
            $balok = $request->kondisi_balok_id;
            $atap_struktur = $request->kondisi_struktur_atap_id;

            // Terapkan rumus RTLH
            if ($jendela != 1) $kond_jendela = 4;
            if ($vent != 1) $kond_vent = 4;
            if (!in_array($mandi, [1,2])) $kond_mandi = 5;
            if ($jamban != 1) $kond_jamban = 4;
            if ($lpak != 1) $kond_lpak = 4;
            if (!in_array($sam, [1,2,3])) $kond_sam = 4;
            if (!in_array($atap, [1,3,8])) $kond_atap = 4;
            if (!in_array($dinding, [1,2,3,4,5])) $kond_dinding = 4;
            if (!in_array($lantai, [1,2,3,4,5])) $kond_lantai = 4;

            $nilai = $pondasi + $sloof + $kolom + $balok + $atap_struktur
                    + $kond_jendela + $kond_vent + $kond_mandi + $kond_jamban
                    + $kond_lpak + $kond_sam + $kond_atap + $kond_dinding + $kond_lantai;

            $nilaiA = $pondasi + $sloof + $kolom + $balok + $atap_struktur;
            $prioritasA = ($pondasi >= 4 || $sloof >= 4 || $kolom >= 4 || $balok >= 4 || $atap_struktur >= 4) ? 2 : 1;

            $nilaiB = $kond_jendela + $kond_vent + $kond_mandi + $kond_jamban + $kond_lpak + $kond_sam;
            $pB = collect([$kond_jendela,$kond_vent,$kond_mandi,$kond_jamban,$kond_lpak,$kond_sam])
                ->filter(fn($v) => $v >= 4)->count();
            $prioritasB = ($pB >= 2) ? 2 : 1;

            $nilaiC = $kond_atap + $kond_dinding + $kond_lantai;
            $pC = collect([$kond_atap,$kond_dinding,$kond_lantai])
                ->filter(fn($v) => $v >= 4)->count();
            $prioritasC = ($pC >= 2) ? 2 : 1;

            $jumlah_penghuni = $request->jumlah_penghuni_laki + $request->jumlah_penghuni_perempuan;
            $status_luas = ($request->luas_rumah >= ($jumlah_penghuni * 9)) ? 1 : 2;

            $status_rumah = ($prioritasA == 2 || $prioritasB == 2 || $prioritasC == 2)
                            ? 'RTLH' : 'RLH';

            PenilaianRumah::create([
                'rumah_id' => $rumah->id_rumah,
                'nilai_a' => $nilaiA,
                'prioritas_a' => $prioritasA,
                'nilai_b' => $nilaiB,
                'prioritas_b' => $prioritasB,
                'nilai_c' => $nilaiC,
                'prioritas_c' => $prioritasC,
                'nilai' => $nilai,
                'status_rumah' => $status_rumah,
                'status_luas' => $status_luas,
            ]);

            // ======================================================
            // SIMPAN FOTO
            // ======================================================
            $dok = new DokumenRumah([
                'rumah_id'    => $rumah->id_rumah,
                'uploaded_by' => $uploadedBy,
                'uploaded_at' => now(),
            ]);

            $foto = ['foto_kk','foto_ktp','foto_rumah_satu','foto_rumah_dua','foto_rumah_tiga','foto_imb'];

            foreach ($foto as $f) {
                if ($request->hasFile($f)) {

                    $path = $request->file($f)
                        ->storeAs("rumah/{$rumah->id_rumah}", "{$f}.jpg", 'public');

                    $dok->$f = $path;
                }
            }

            $dok->save();

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Data rumah berhasil disimpan lengkap beserta pertanyaan dinamis.',
                'data'    => [
                    'id_rumah'    => $rumah->id_rumah,
                    'status_rumah'=> $status_rumah,
                    'status_luas' => $status_luas,
                    'nilai_total' => $nilai,
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => false,
                'message' => 'Terjadi kesalahan: '.$e->getMessage(),
            ], 500);
        }
    }


    public function search(Request $request)
    {
        // 🔐 Wajib token JWT
        $user = $request->auth->id_user ?? null;

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $keyword = $request->input('q');

        if (!$keyword) {
            return response()->json([
                'status' => false,
                'message' => 'Parameter q wajib diisi.'
            ], 422);
        }

        $rumah = Rumah::with([
                'kepemilikan',
                'kepalaKeluarga.anggota',
                'sosialEkonomi'
            ])
            ->where(function ($q) use ($keyword) {

                // 1️⃣ NIK kepemilikan rumah
                $q->whereHas('kepemilikan', function ($qq) use ($keyword) {
                    $qq->where('nik_kepemilikan_rumah', 'like', "%{$keyword}%");
                });

                // 2️⃣ Nomor KK rumah (multi KK)
                $q->orWhereHas('kepalaKeluarga', function ($qq) use ($keyword) {
                    $qq->where('no_kk', 'like', "%{$keyword}%");
                });

                // 3️⃣ Nomor KK utama dari sosial ekonomi
                $q->orWhereHas('sosialEkonomi', function ($qq) use ($keyword) {
                    $qq->where('no_kk', 'like', "%{$keyword}%");
                });

                // 4️⃣ NIK anggota keluarga
                $q->orWhereHas('kepalaKeluarga.anggota', function ($qq) use ($keyword) {
                    $qq->where('nik', 'like', "%{$keyword}%");
                });

                // 5️⃣ No KK (anggota keluarga ikut KK kepala keluarga)
                $q->orWhereHas('kepalaKeluarga.anggota', function ($qq) use ($keyword) {
                    $qq->where('no_kk', 'like', "%{$keyword}%");
                });
            })
            ->get();

        return response()->json([
            'status'  => true,
            'keyword' => $keyword,
            'total'   => $rumah->count(),
            'data'    => $rumah
        ]);
    }


    public function deleteRumah(Request $request)
    {
       
        $user = $request->auth->id_user;
        if (!$user) {
            return response()->json([
                'status'  => false,
                'message' => 'Unauthorized'
            ], 401);
        }

       
        $id = $request->id_rumah;

        if (empty($id)) {
            return response()->json([
                'status' => false,
                'message' => 'Parameter id_rumah wajib diisi'
            ], 400);
        }

        $rumah = Rumah::with(['dokumen', 'kepalaKeluarga'])->find($id);

        if (!$rumah) {
            return response()->json([
                'status' => false,
                'message' => 'Data rumah tidak ditemukan.'
            ], 404);
        }

      
        if ($rumah->dokumen) {
            $files = [
                $rumah->dokumen->foto_kk,
                $rumah->dokumen->foto_ktp,
                $rumah->dokumen->foto_imb,
                $rumah->dokumen->foto_rumah_satu,
                $rumah->dokumen->foto_rumah_dua,
                $rumah->dokumen->foto_rumah_tiga,
            ];

            foreach ($files as $file) {
                if (!empty($file) && Storage::disk('public')->exists($file)) {
                    Storage::disk('public')->delete($file);
                }
            }
        }

       
        if ($rumah->kepalaKeluarga) {
            foreach ($rumah->kepalaKeluarga as $kk) {
                $kk->anggota()->delete(); // hapus anggota
                $kk->delete();            // hapus KK
            }
        }

        $rumah->dokumen()->delete();
        $rumah->delete();

        
        return response()->json([
            'status'  => true,
            'message' => 'Data rumah berhasil dihapus.',
            'data'    => [
                'id_rumah'   => $id,
                'deleted_by' => $request->auth->id_user
            ]
        ], 200);
    }

    public function pertanyaan()
    {
        // Ambil semua pertanyaan aktif + relasi
        $questions = SurveyQuestion::with([
                'options',
                'children.options',
                'children.triggerOption',
                'children.children.options',
                'children.children.triggerOption',
                'surveyModule'
            ])
            ->active()
            ->orderBy('order')
            ->get();

        // Kelompokkan berdasarkan module
        $modules = [
            'lokasi',
            'penghuni_rumah',
            'identitas_rumah',
            'aspek_keselamatan',
            'aspek_kesehatan',
            'aspek_luas_kebutuhan',
            'aspek_bahan_bangunan',
            'foto_dokumentasi',
            'pertanyaan_lainnya'
        ];

        $data = [];

        foreach ($modules as $module) {
            $data[$module] = $questions
                ->where('module', $module)
                ->whereNull('parent_question_id')   // hanya parent
                ->values();
        }

        return response()->json([
            'status'  => true,
            'message' => 'Pertanyaan per module berhasil diambil.',
            'data'    => $data
        ], 200);
    }

    public function updateRumah(Request $request, $id)
    {

        
        // FIX auth hilang saat method spoofing (_method=PUT)
        $user = $request->auth;
       // dd($request->auth);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized (user not detected)'
            ], 401);
        }

        // Pastikan object auth dipasang ke request
        //$request->merge(['auth' => $user]);

        //dd($request->all());
        // ======================================================
        // JSON decode untuk form-data
        // ======================================================
        if ($request->has('pertanyaan') && is_string($request->pertanyaan)) {
            $request->merge(['pertanyaan' => json_decode($request->pertanyaan, true)]);
        }

        if ($request->has('kks') && is_string($request->kks)) {
            $request->merge(['kks' => json_decode($request->kks, true)]);
        }


        // ======================================================
        // VALIDASI — IDENTIK DENGAN STORE
        // ======================================================
        $validator = Validator::make($request->all(), [
            'latitude'       => 'required|numeric',
            'longitude'      => 'required|numeric',
            'alamat'         => 'required|string',
            'rt'             => 'required|string',
            'rw'             => 'required|string',
            'kecamatan_id'   => 'required|integer',
            'kelurahan_id'   => 'required|integer',

            // sosial ekonomi
            'jenis_kelamin_id'          => 'required|integer',
            'usia'                      => 'required|integer',
            'pendidikan_terakhir_id'    => 'required|integer',
            'pekerjaan_utama_id'        => 'required|integer',
            'besar_penghasilan_id'      => 'required|integer',
            'besar_pengeluaran_id'      => 'required|integer',

            // kepemilikan
            'nik_kepemilikan_rumah'     => 'nullable',
            'status_kepemilikan_tanah_id'   => 'required|integer',
            'bukti_kepemilikan_tanah_id'    => 'required|integer',
            'status_kepemilikan_rumah_id'   => 'required|integer',
            'status_imb_id'                 => 'required|integer',
            'jenis_kawasan_lokasi_rumah_id' => 'required|integer',
            'aset_rumah_ditempat_lain_id'   => 'required|integer',
            'aset_tanah_ditempat_lain_id'   => 'required|integer',
            'pernah_mendapatkan_bantuan_id' => 'required|integer',

            // fisik
            'pondasi_id'                    => 'required|integer',
            'jenis_pondasi_id'              => 'required|integer',
            'kondisi_pondasi_id'            => 'required|integer',
            'kondisi_sloof_id'              => 'required|integer',
            'kondisi_kolom_tiang_id'        => 'required|integer',
            'kondisi_balok_id'              => 'required|integer',
            'kondisi_struktur_atap_id'      => 'required|integer',

            'jendela_lubang_cahaya_id'      => 'required|integer',
            'kondisi_jendela_lubang_cahaya_id' => 'required|integer',
            'ventilasi_id'                  => 'required|integer',
            'kondisi_ventilasi_id'          => 'required|integer',
            'kamar_mandi_id'                => 'required|integer',
            'kondisi_kamar_mandi_id'        => 'required|integer',
            'jamban_id'                     => 'required|integer',
            'kondisi_jamban_id'             => 'required|integer',
            'sistem_pembuangan_air_kotor_id'=> 'required|integer',
            'kondisi_sistem_pembuangan_air_kotor_id'=> 'required|integer',
            'frekuensi_penyedotan_id'       => 'required|integer',
            'sumber_air_minum_id'           => 'required|integer',
            'kondisi_sumber_air_minum_id'   => 'required|integer',
            'sumber_listrik_id'             => 'required|integer',

            'luas_rumah'                    => 'required|numeric',
            'jumlah_penghuni_laki'          => 'required|integer',
            'jumlah_penghuni_perempuan'     => 'required|integer',
            'tinggi_rata_rumah'             => 'required|numeric',
            'ruang_keluarga_dan_tidur_id'   => 'required|integer',
            'jumlah_kamar_tidur'            => 'required|integer',
            'luas_rata_kamar_tidur'         => 'required|numeric',
            'jenis_fisik_bangunan_id'       => 'required|integer',
            'jumlah_lantai_bangunan'        => 'required|integer',
            'fungsi_rumah_id'               => 'required|integer',
            'tipe_rumah_id'                 => 'required|integer',
            'status_dtks_id'                => 'required|integer',
            'tahun_pembangunan_rumah'       => 'required|integer',

            'foto_rumah_satu' => 'nullable|file|mimes:jpg,jpeg,png',

            'pertanyaan' => 'nullable|array',
            'pertanyaan.*.question_id' => 'required_with:pertanyaan',
            'pertanyaan.*.answer'      => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>false,
                'message'=>'Validasi gagal',
                'errors'=>$validator->errors()
            ],422);
        }


        // ============================
        // VALIDASI PERTANYAAN DINAMIS
        // ============================
        if ($request->filled('pertanyaan')) {

            $all = SurveyQuestion::active()->get();

            foreach ($all as $q) {

                $row = collect($request->pertanyaan)
                    ->firstWhere('question_id', $q->id);

                if (!$row) continue;

                $answer = $row['answer'] ?? null;

                if (!$q->is_required) continue;

                if (in_array($q->type,['text','textarea','number','date'])
                    && empty($answer)) {
                    return response()->json([
                        'status'=>false,
                        'message'=>"Pertanyaan '{$q->label}' wajib diisi."
                    ],422);
                }

                if (in_array($q->type,['select','radio'])
                    && empty($answer)) {
                    return response()->json([
                        'status'=>false,
                        'message'=>"Pertanyaan '{$q->label}' wajib dipilih."
                    ],422);
                }

                if ($q->type==='checkbox'
                    && (empty($answer) || count($answer)==0)) {
                    return response()->json([
                        'status'=>false,
                        'message'=>"Pertanyaan '{$q->label}' minimal pilih 1."
                    ],422);
                }
            }
        }


        try {

            DB::beginTransaction();

            // ======================================================
            // GET RUMAH + OLD VALUE
            // ======================================================
            $rumah = Rumah::with([
                'dokumen',
                'kepalaKeluarga.anggota'
            ])->findOrFail($id);

            $oldRumah = $rumah->only([
                'alamat','latitude','longitude','rt','rw',
                'kecamatan_id','kelurahan_id','tahun_pembangunan_rumah'
            ]);


            // ======================================================
            // UPDATE RUMAH
            // ======================================================
            $newRumah = [
                'alamat'=>$request->alamat,
                'latitude'=>$request->latitude,
                'longitude'=>$request->longitude,
                'rt'=>$request->rt,
                'rw'=>$request->rw,
                'kecamatan_id'=>$request->kecamatan_id,
                'kelurahan_id'=>$request->kelurahan_id,
                'tahun_pembangunan_rumah'=>$request->tahun_pembangunan_rumah,
            ];

            $rumah->update($newRumah);

            // 🔥 HISTORY (trait)
            $this->logMultiple($rumah->id_rumah,'rumah',$oldRumah,$newRumah);


            // ======================================================
            // UPDATE KK + ANGGOTA + HISTORY
            // ======================================================
            $oldKK = $rumah->kepalaKeluarga->map(function($kk){
                return [
                    'kode_kk'=>$kk->kode_kk,
                    'no_kk'=>$kk->no_kk,
                    'anggota'=>$kk->anggota->map(fn($a)=>[
                        'kode_anggota'=>$a->kode_anggota,
                        'nik'=>$a->nik,
                        'nama'=>$a->nama
                    ])
                ];
            })->toArray();

            if (!empty($request->kks)) {

                $kkCodes = [];

                foreach ($request->kks as $i=>$kk) {

                    $kodeKK = chr(65+$i);
                    $kkCodes[] = $kodeKK;

                    $kepala = KepalaKeluarga::updateOrCreate(
                        ['rumah_id'=>$rumah->id_rumah,'kode_kk'=>$kodeKK],
                        ['no_kk'=>$kk['no_kk'] ?? null]
                    );

                    $anggotaCodes = [];

                    if (!empty($kk['anggota'])) {

                        foreach ($kk['anggota'] as $j=>$a) {

                            $kodeAng = strtolower($kodeKK).chr(97+$j);
                            $anggotaCodes[] = $kodeAng;

                            AnggotaKeluarga::updateOrCreate(
                                ['kepala_keluarga_id'=>$kepala->id,'kode_anggota'=>$kodeAng],
                                ['nik'=>$a['nik'] ?? null,'nama'=>$a['nama'] ?? null]
                            );
                        }
                    }

                    $kepala->anggota()
                        ->whereNotIn('kode_anggota',$anggotaCodes)
                        ->delete();
                }

                KepalaKeluarga::where('rumah_id',$rumah->id_rumah)
                    ->whereNotIn('kode_kk',$kkCodes)
                    ->delete();
            }

            $newKK = KepalaKeluarga::with('anggota')
                ->where('rumah_id',$rumah->id_rumah)
                ->get()
                ->map(function($kk){
                    return [
                        'kode_kk'=>$kk->kode_kk,
                        'no_kk'=>$kk->no_kk,
                        'anggota'=>$kk->anggota->map(fn($a)=>[
                            'kode_anggota'=>$a->kode_anggota,
                            'nik'=>$a->nik,
                            'nama'=>$a->nama
                        ])
                    ];
                })->toArray();

            // 🔥 HISTORY (trait)
            $this->logKKChange($rumah->id_rumah,$oldKK,$newKK);


            // ======================================================
            // UPDATE PERTANYAAN DINAMIS
            // ======================================================
            $oldAns = SurveyQuestionAnswer::where('rumah_id',$rumah->id_rumah)
                ->get()
                ->mapWithKeys(fn($a)=>[
                    $a->question_id=>[
                        'answer_text'=>$a->answer_text,
                        'answer_option_id'=>$a->answer_option_id,
                        'answer_option_ids'=>$a->answer_option_ids,
                        'file_path'=>$a->file_path,
                    ]
                ])->toArray();

            // ======================================================
            // HAPUS CHILD YANG TIDAK LAGI MEMENUHI TRIGGER (WAJIB)
            // ======================================================
            $inputById = collect($request->pertanyaan ?? [])
                ->mapWithKeys(fn($r) => [$r['question_id'] => $r['answer']]);

            $allQuestions = \App\Models\SurveyQuestion::all();

            foreach ($allQuestions as $q) {

                if (!$q->parent_question_id) continue; // hanya child

                $parentId = $q->parent_question_id;
                $trigger  = $q->trigger_option_id;

                $parentAnswer = $inputById[$parentId] ?? null;

                // JIKA PARENT TIDAK MATCH TRIGGER → hapus CHILD
                if ($parentAnswer != $trigger) {
                    SurveyQuestionAnswer::where('rumah_id', $rumah->id_rumah)
                        ->where('question_id', $q->id)
                        ->delete();
                }
            }


            $input = collect($request->pertanyaan ?? []);

            foreach ($input as $pq) {

                $q = SurveyQuestion::find($pq['question_id']);
                if (!$q) continue;

                $answer = $pq['answer'];

                

                // ---- CHILD SKIP ----
                if ($q->parent_question_id) {

                    $parentAns =
                        $input->firstWhere('question_id',$q->parent_question_id)['answer'] ?? null;

                    if ($q->trigger_option_id != $parentAns) {

                        SurveyQuestionAnswer::where('rumah_id',$rumah->id_rumah)
                            ->where('question_id',$q->id)
                            ->delete();

                        continue;
                    }
                }

                // ---- SAVE ----
                if (in_array($q->type,['text','textarea','number','date'])) {

                    SurveyQuestionAnswer::updateOrCreate(
                        ['rumah_id'=>$rumah->id_rumah,'question_id'=>$q->id],
                        ['answer_text'=>$answer,'answer_option_id'=>null,'answer_option_ids'=>null]
                    );
                }

                elseif (in_array($q->type,['select','radio'])) {

                    SurveyQuestionAnswer::updateOrCreate(
                        ['rumah_id'=>$rumah->id_rumah,'question_id'=>$q->id],
                        ['answer_option_id'=>$answer,'answer_text'=>null,'answer_option_ids'=>null]
                    );
                }

                elseif ($q->type==='checkbox') {

                    SurveyQuestionAnswer::updateOrCreate(
                        ['rumah_id'=>$rumah->id_rumah,'question_id'=>$q->id],
                        ['answer_option_ids'=>$answer,'answer_text'=>null,'answer_option_id'=>null]
                    );
                }
            }

            $newAns = SurveyQuestionAnswer::where('rumah_id',$rumah->id_rumah)
                ->get()
                ->mapWithKeys(fn($a)=>[
                    $a->question_id=>[
                        'answer_text'=>$a->answer_text,
                        'answer_option_id'=>$a->answer_option_id,
                        'answer_option_ids'=>$a->answer_option_ids,
                        'file_path'=>$a->file_path,
                    ]
                ])->toArray();

            // 🔥 HISTORY
            $this->logArrayChanges($rumah->id_rumah,'survey_answers',$oldAns,$newAns);


            // ======================================================
            // UPDATE FOTO + HISTORY
            // ======================================================
            $oldDok = $rumah->dokumen ? $rumah->dokumen->toArray() : [];
            $dok = $rumah->dokumen ?? new DokumenRumah(['rumah_id'=>$rumah->id_rumah]);

            $foto = ['foto_kk','foto_ktp','foto_rumah_satu','foto_rumah_dua','foto_rumah_tiga','foto_imb'];

            $changed = [];

            foreach ($foto as $f) {

                if ($request->hasFile($f)) {

                    if (!empty($dok->$f) && Storage::disk('public')->exists($dok->$f)) {
                        Storage::disk('public')->delete($dok->$f);
                    }

                    $path = $request->file($f)->storeAs(
                        "rumah/{$rumah->id_rumah}",
                        "{$f}.jpg",
                        'public'
                    );

                    $dok->$f = $path;

                    $changed[$f] = [
                        'old'=>$oldDok[$f] ?? null,
                        'new'=>$path
                    ];
                }
            }

            $dok->uploaded_by = $request->auth->id_user;
            $dok->uploaded_at = now();
            $dok->save();

            if (!empty($changed)) {

                $this->logArrayChanges(
                    $rumah->id_rumah,
                    'dokumen_rumah',
                    $oldDok,
                    array_merge($oldDok,array_map(fn($c)=>$c['new'],$changed))
                );
            }


            // ======================================================
            // HITUNG PENILAIAN RTLH (versi API)
            // ======================================================
            $this->hitungDanSimpanPenilaianAPI($rumah->id_rumah,$request);


            // ======================================================
            // SUCCESS
            // ======================================================
            DB::commit();

            return response()->json([
                'status'=>true,
                'message'=>'Data rumah berhasil diperbarui',
                'id_rumah'=>$rumah->id_rumah
            ]);

        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json([
                'status'=>false,
                'message'=>'Gagal update: '.$e->getMessage()
            ],500);
        }
    }

    private function hitungDanSimpanPenilaianAPI($rumahId, Request $request)
    {
        // Ambil penilaian lama untuk history
        $oldPenilaian = PenilaianRumah::where('rumah_id', $rumahId)->first();
        $oldPenilaianArray = $oldPenilaian ? $oldPenilaian->toArray() : [];

        // ========== AMBIL DATA DARI REQUEST ==========
        $jendela = $request->jendela_lubang_cahaya_id;
        $kj = $request->kondisi_jendela_lubang_cahaya_id;
        $ventilasi = $request->ventilasi_id;
        $kv = $request->kondisi_ventilasi_id;
        $km = $request->kamar_mandi_id;
        $kkm = $request->kondisi_kamar_mandi_id;
        $jamban = $request->jamban_id;
        $kjb = $request->kondisi_jamban_id;
        $spak = $request->sistem_pembuangan_air_kotor_id;
        $kspak = $request->kondisi_sistem_pembuangan_air_kotor_id;
        $sam = $request->sumber_air_minum_id;
        $ksam = $request->kondisi_sumber_air_minum_id;
        $atap = $request->material_atap_terluas_id;
        $katap = $request->kondisi_penutup_atap_id;
        $dinding = $request->material_dinding_terluas_id;
        $kdinding = $request->kondisi_dinding_id;
        $lantai = $request->material_lantai_terluas_id;
        $klantai = $request->kondisi_lantai_id;

        $kp = $request->kondisi_pondasi_id;
        $ks = $request->kondisi_sloof_id;
        $kt = $request->kondisi_kolom_tiang_id;
        $kb = $request->kondisi_balok_id;
        $ka = $request->kondisi_struktur_atap_id;

        $l = (float) $request->luas_rumah;
        $pL = (int) $request->jumlah_penghuni_laki;
        $pP = (int) $request->jumlah_penghuni_perempuan;

        // ========== RUMUS RTLH (100% SAMA LIVEWIRE) ==========
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
        $prioritas_b = (collect([$kj, $kv, $kkm, $kjb, $kspak, $ksam])
            ->filter(fn($v) => $v >= 4)->count() >= 2) ? 2 : 1;

        $prioritas_c = (collect([$katap, $kdinding, $klantai])
            ->filter(fn($v) => $v >= 4)->count() >= 2) ? 2 : 1;

        $nilai = $nilai_a + $nilai_b + $nilai_c;

        $luas_min      = ($pL + $pP) * 9;
        $status_luas   = ($l >= $luas_min) ? 1 : 2;
        $status_rumah  = ($prioritas_a == 2 || $prioritas_b == 2 || $prioritas_c == 2) ? 'RTLH' : 'RLH';

        // ========== SIMPAN ==========
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

        $newPenilaian = PenilaianRumah::where('rumah_id', $rumahId)->first()->toArray();

        // ========== SIMPAN HISTORY ==========
        $this->logArrayChanges(
            $rumahId,
            'penilaian_rumah',
            $oldPenilaianArray,
            $newPenilaian
        );

        return [
            'nilai_total'  => $nilai,
            'status_luas'  => $status_luas,
            'status_rumah' => $status_rumah
        ];
    }





}
