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
use App\Models\TblJenisPondasi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MasterController extends Controller
{
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
            'status_kepemilikan_tanah_id'   => 'required|integer',
            'bukti_kepemilikan_tanah_id'    => 'required|integer',
            'status_kepemilikan_rumah_id'   => 'required|integer',
            'status_imb_id'                 => 'required|integer',
            'jenis_kawasan_lokasi_rumah_id' => 'required|integer',

            // fisik & sanitasi minimal
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

            'material_atap_terluas_id'      => 'required|integer',
            'kondisi_penutup_atap_id'       => 'required|integer',
            'material_dinding_terluas_id'   => 'required|integer',
            'kondisi_dinding_id'            => 'required|integer',
            'material_lantai_terluas_id'    => 'required|integer',
            'kondisi_lantai_id'             => 'required|integer',
            'akses_ke_jalan_id'             => 'required|integer',
            'bangunan_menghadap_jalan_id'   => 'required|integer',
            'bangunan_menghadap_sungai_id'  => 'required|integer',
            'bangunan_berada_limbah_id'     => 'required|integer',
            'bangunan_berada_sungai_id'     => 'required|integer',

            // KK & anggota dalam bentuk JSON string (lihat catatan di bawah)
            'kks'                           => 'nullable|string',

            // foto wajib (sesuai Livewire: rumah1-3 wajib, kk/ktp/imb opsional)
            'foto_rumah_satu'   => 'required|file|mimes:jpg,jpeg,png',
            'foto_rumah_dua'    => 'nullable|file|mimes:jpg,jpeg,png',
            'foto_rumah_tiga'   => 'nullable|file|mimes:jpg,jpeg,png',
            'foto_kk'           => 'nullable|file|mimes:jpg,jpeg,png',
            'foto_ktp'          => 'nullable|file|mimes:jpg,jpeg,png',
            'foto_imb'          => 'nullable|file|mimes:jpg,jpeg,png',
        ], [
            'required' => ':attribute wajib diisi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors(),
            ], 422);
        }

        // ✅ Cek foto wajib sama seperti Livewire
        $requiredPhotos = [
            'foto_rumah_satu'  => 'Foto Rumah 1',
            
        ];

        foreach ($requiredPhotos as $field => $label) {
            if (!$request->hasFile($field)) {
                return response()->json([
                    'status'  => false,
                    'message' => "{$label} wajib diunggah sebelum mengirim data.",
                ], 422);
            }
        }

       
        $uploadedBy = $request->auth->id_user ?? null;

        //  Parse data KK & Anggota (kks) dari JSON string
        /**
         * Format kks (JSON):
         * [
         *   {
         *     "no_kk": "1375xxxx",
         *     "anggota": [
         *       { "nama": "Budi", "nik": "1375..." },
         *       { "nama": "Ani", "nik": "1375..." }
         *     ]
         *   },
         *   ...
         * ]
         */
        $kks = [];
        if ($request->filled('kks')) {
            $kks = json_decode($request->input('kks'), true) ?: [];
        }

        // Untuk jumlah_kk_id, bisa kirim langsung dari client atau di-map dari count($kks)
        $jumlahKkId = $request->input('jumlah_kk_id');
        if (!$jumlahKkId && !empty($kks)) {
            $jumlahSekarang = count($kks);
            $record = IJumlahKk::where('jumlah_kk', $jumlahSekarang)->first();
            $jumlahKkId = $record ? $record->id_jumlah_kk : null;
        }

        try {
            DB::beginTransaction();

            //  Simpan data dasar rumah
            $rumah = Rumah::create([
                'id_rumah_lama'            => '00',
                'alamat'                   => $request->alamat,
                'latitude'                 => $request->latitude,
                'longitude'                => $request->longitude,
                'rt'                       => $request->rt,
                'rw'                       => $request->rw,
                'kecamatan_id'             => $request->kecamatan_id,
                'kelurahan_id'             => $request->kelurahan_id,
                'tahun_pembangunan_rumah'  => $request->tahun_pembangunan_rumah,
            ]);

            //  Simpan Kepala Keluarga & Anggota (kode KK A-F, anggota aa,ab,...)
            if (!empty($kks)) {
                foreach ($kks as $kkIndex => $kk) {
                    $kodeKK = chr(65 + $kkIndex); // A, B, C, ...

                    $kepalaKeluarga = KepalaKeluarga::create([
                        'rumah_id' => $rumah->id_rumah,
                        'no_kk'    => $kk['no_kk'] ?? null,
                        'kode_kk'  => $kodeKK,
                    ]);

                    if (!empty($kk['anggota']) && is_array($kk['anggota'])) {
                        foreach ($kk['anggota'] as $anggotaIndex => $anggota) {
                            $hurufKK      = strtolower($kodeKK);
                            $hurufAnggota = chr(97 + $anggotaIndex); // a,b,c,...
                            $kodeAnggota  = $hurufKK . $hurufAnggota;

                            AnggotaKeluarga::create([
                                'kepala_keluarga_id' => $kepalaKeluarga->id,
                                'nik'                => $anggota['nik']  ?? null,
                                'nama'               => $anggota['nama'] ?? null,
                                'kode_anggota'       => $kodeAnggota,
                            ]);
                        }
                    }
                }
            }

            //  Data sosial ekonomi (SosialEkonomiRumah)
            SosialEkonomiRumah::create([
                'rumah_id'                      => $rumah->id_rumah,
                'jumlah_kk_id'                  => $jumlahKkId,
                'no_kk'                         => !empty($kks) ? ($kks[0]['no_kk'] ?? null) : null,
                'jenis_kelamin_id'              => $request->jenis_kelamin_id,
                'usia'                          => $request->usia,
                'pendidikan_terakhir_id'        => $request->pendidikan_terakhir_id,
                'pekerjaan_utama_id'            => $request->pekerjaan_utama_id,
                'besar_penghasilan_perbulan_id' => $request->besar_penghasilan_id,
                'besar_pengeluaran_perbulan_id' => $request->besar_pengeluaran_id,
                'status_dtks_id'                => $request->status_dtks_id,
            ]);

            // Data Fisik Rumah
            FisikRumah::create([
                'rumah_id'                        => $rumah->id_rumah,
                'pondasi_id'                      => $request->pondasi_id,
                'jenis_pondasi'                   => $request->jenis_pondasi_id,
                'kondisi_pondasi_id'              => $request->kondisi_pondasi_id,
                'kondisi_sloof_id'                => $request->kondisi_sloof_id,
                'kondisi_kolom_tiang_id'          => $request->kondisi_kolom_tiang_id,
                'kondisi_balok_id'                => $request->kondisi_balok_id,
                'kondisi_struktur_atap_id'        => $request->kondisi_struktur_atap_id,
                'material_atap_terluas_id'        => $request->material_atap_terluas_id,
                'kondisi_penutup_atap_id'         => $request->kondisi_penutup_atap_id,
                'material_dinding_terluas_id'     => $request->material_dinding_terluas_id,
                'kondisi_dinding_id'              => $request->kondisi_dinding_id,
                'material_lantai_terluas_id'      => $request->material_lantai_terluas_id,
                'kondisi_lantai_id'               => $request->kondisi_lantai_id,
                'akses_ke_jalan_id'               => $request->akses_ke_jalan_id,
                'bangunan_menghadap_jalan_id'     => $request->bangunan_menghadap_jalan_id,
                'bangunan_menghadap_sungai_id'    => $request->bangunan_menghadap_sungai_id,
                'bangunan_berada_limbah_id'       => $request->bangunan_berada_limbah_id,
                'bangunan_berada_sungai_id'       => $request->bangunan_berada_sungai_id,
                'luas_rumah'                      => $request->luas_rumah,
                'tinggi_rata_rumah'               => $request->tinggi_rata_rumah,
                'jumlah_penghuni_laki'            => $request->jumlah_penghuni_laki,
                'jumlah_penghuni_perempuan'       => $request->jumlah_penghuni_perempuan,
                'jumlah_abk'                      => $request->jumlah_abk,
                'ruang_keluarga_dan_ruang_tidur_id'=> $request->ruang_keluarga_dan_tidur_id,
                'jumlah_kamar_tidur'              => $request->jumlah_kamar_tidur,
                'luas_rata_kamar_tidur'           => $request->luas_rata_kamar_tidur,
                'jenis_fisik_bangunan_id'         => $request->jenis_fisik_bangunan_id,
                'fungsi_rumah_id'                 => $request->fungsi_rumah_id,
                'tipe_rumah_id'                   => $request->tipe_rumah_id,
                'jumlah_lantai_bangunan'          => $request->jumlah_lantai_bangunan,
            ]);

            // Sanitasi Rumah
            SanitasiRumah::create([
                'rumah_id'                               => $rumah->id_rumah,
                'jendela_lubang_cahaya_id'              => $request->jendela_lubang_cahaya_id,
                'kondisi_jendela_lubang_cahaya_id'      => $request->kondisi_jendela_lubang_cahaya_id,
                'ventilasi_id'                          => $request->ventilasi_id,
                'keterangan_ventilasi'                  => $request->keterangan_ventilasi,
                'kondisi_ventilasi_id'                  => $request->kondisi_ventilasi_id,
                'kamar_mandi_id'                        => $request->kamar_mandi_id,
                'kondisi_kamar_mandi_id'                => $request->kondisi_kamar_mandi_id,
                'jamban_id'                             => $request->jamban_id,
                'kondisi_jamban_id'                     => $request->kondisi_jamban_id,
                'sistem_pembuangan_air_kotor_id'        => $request->sistem_pembuangan_air_kotor_id,
                'kondisi_sistem_pembuangan_air_kotor_id'=> $request->kondisi_sistem_pembuangan_air_kotor_id,
                'frekuensi_penyedotan_id'               => $request->frekuensi_penyedotan_id,
                'sumber_air_minum_id'                   => $request->sumber_air_minum_id,
                'kondisi_sumber_air_minum_id'           => $request->kondisi_sumber_air_minum_id,
                'sumber_listrik_id'                     => $request->sumber_listrik_id,
            ]);

            //  Bantuan Rumah
            BantuanRumah::create([
                'rumah_id'                      => $rumah->id_rumah,
                'pernah_mendapatkan_bantuan_id' => $request->pernah_mendapatkan_bantuan_id,
                'no_kk_penerima'                => $request->no_kk_penerima,
                'tahun_bantuan'                 => $request->tahun_bantuan,
                'nama_bantuan'                  => $request->nama_bantuan,
                'nama_program_bantuan'          => $request->nama_program_bantuan,
                'nominal_bantuan'               => $request->nominal_bantuan,
            ]);

            //  Kepemilikan Rumah
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

            // Perhitungan Penilaian Rumah (sama persis dengan Livewire)
            $jendela_lubang_cahaya           = $request->jendela_lubang_cahaya_id;
            $kondisi_jendela_lubang_cahaya_value = $request->kondisi_jendela_lubang_cahaya_id;
            $ventilasi                       = $request->ventilasi_id;
            $kondisi_ventilasi_value         = $request->kondisi_ventilasi_id;
            $kamar_mandi                     = $request->kamar_mandi_id;
            $kondisi_kamar_mandi_value       = $request->kondisi_kamar_mandi_id;
            $jamban                          = $request->jamban_id;
            $kondisi_jamban_value            = $request->kondisi_jamban_id;
            $sistem_pembuangan_air_kotor     = $request->sistem_pembuangan_air_kotor_id;
            $kondisi_sistem_pembuangan_air_kotor_value = $request->kondisi_sistem_pembuangan_air_kotor_id;
            $sumber_air_minum                = $request->sumber_air_minum_id;
            $kondisi_sumber_air_minum_value  = $request->kondisi_sumber_air_minum_id;
            $material_atap_terluas           = $request->material_atap_terluas_id;
            $kondisi_penutup_atap_value      = $request->kondisi_penutup_atap_id;
            $material_dinding_terluas        = $request->material_dinding_terluas_id;
            $kondisi_dinding_value           = $request->kondisi_dinding_id;
            $material_lantai_terluas         = $request->material_lantai_terluas_id;
            $kondisi_lantai_value            = $request->kondisi_lantai_id;

            $kondisi_pondasi                 = $request->kondisi_pondasi_id;
            $kondisi_sloof                   = $request->kondisi_sloof_id;
            $kondisi_kolom_tiang             = $request->kondisi_kolom_tiang_id;
            $kondisi_balok                   = $request->kondisi_balok_id;
            $kondisi_struktur_atap           = $request->kondisi_struktur_atap_id;

            $jumlah_penghuni_laki            = (int) $request->jumlah_penghuni_laki;
            $jumlah_penghuni_perempuan       = (int) $request->jumlah_penghuni_perempuan;
            $luas_rumah                      = (float) $request->luas_rumah;

           
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

            $nilai = $kondisi_pondasi + $kondisi_sloof + $kondisi_kolom_tiang + $kondisi_balok + $kondisi_struktur_atap
                + $kondisi_jendela_lubang_cahaya + $kondisi_ventilasi + $kondisi_kamar_mandi + $kondisi_jamban
                + $kondisi_sistem_pembuangan_air_kotor + $kondisi_sumber_air_minum + $kondisi_penutup_atap
                + $kondisi_dinding + $kondisi_lantai;

            $nilai_a = $kondisi_pondasi + $kondisi_sloof + $kondisi_kolom_tiang + $kondisi_balok + $kondisi_struktur_atap;
            $prioritas_a = ($kondisi_pondasi >= 4 || $kondisi_sloof >= 4 || $kondisi_kolom_tiang >= 4 || $kondisi_balok >= 4 || $kondisi_struktur_atap >= 4) ? 2 : 1;

            $nilai_b = $kondisi_jendela_lubang_cahaya + $kondisi_ventilasi + $kondisi_kamar_mandi + $kondisi_jamban + $kondisi_sistem_pembuangan_air_kotor + $kondisi_sumber_air_minum;
            $p_b_total = collect([
                $kondisi_jendela_lubang_cahaya, $kondisi_ventilasi, $kondisi_kamar_mandi, $kondisi_jamban,
                $kondisi_sistem_pembuangan_air_kotor, $kondisi_sumber_air_minum
            ])->filter(fn($v) => $v >= 4)->count();
            $prioritas_b = ($p_b_total >= 2) ? 2 : 1;

            $nilai_c = $kondisi_penutup_atap + $kondisi_dinding + $kondisi_lantai;
            $p_c_total = collect([$kondisi_penutup_atap, $kondisi_dinding, $kondisi_lantai])
                ->filter(fn($v) => $v >= 4)->count();
            $prioritas_c = ($p_c_total >= 2) ? 2 : 1;

            $luas_meter  = ($jumlah_penghuni_laki + $jumlah_penghuni_perempuan) * 9;
            $status_luas = ($luas_rumah >= $luas_meter) ? 1 : 2;
            $status_rumah = ($prioritas_a == 2 || $prioritas_b == 2 || $prioritas_c == 2) ? 'RTLH' : 'RLH';

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

            //  Simpan dokumen rumah + upload foto multipart
            $dokumen = new DokumenRumah([
                'rumah_id'    => $rumah->id_rumah,
                'uploaded_by' => $uploadedBy,
                'uploaded_at' => now(),
            ]);

            $wajibFoto = [
                'foto_kk',
                'foto_ktp',
                'foto_rumah_satu',
                'foto_rumah_dua',
                'foto_rumah_tiga',
                'foto_imb',
            ];

            foreach ($wajibFoto as $field) {
                if ($request->hasFile($field)) {
                   
                    $request->file($field)->storeAs(
                        "rumah/{$rumah->id_rumah}",
                        "{$field}.jpg"
                    );

                    $dokumen->$field = "rumah/{$rumah->id_rumah}/{$field}.jpg";
                }
            }

            $dokumen->save();

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Data rumah beserta semua komponen dan dokumentasi berhasil disimpan.',
                'data'    => [
                    'id_rumah'      => $rumah->id_rumah,
                    'status_rumah'  => $status_rumah,
                    'status_luas'   => $status_luas,
                    'nilai_total'   => $nilai,
                ],
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => false,
                'message' => 'Terjadi kesalahan saat menyimpan data rumah: '.$e->getMessage(),
            ], 500);
        }
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
}
