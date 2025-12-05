<?php

namespace App\Http\Controllers\Api;

use App\Helpers\JwtHelper;
use App\Http\Controllers\Controller;
use App\Models\KepalaKeluarga;
use App\Models\Rumah;
use App\Models\TblBantuan;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Writer\XLSX\Writer;
use Symfony\Component\HttpFoundation\StreamedResponse;

use OpenSpout\Writer\Common\Creator\WriterEntityFactory;
use OpenSpout\Writer\Common\Creator\Style\StyleBuilder;
use OpenSpout\Writer\XLSX\Writer as XLSXWriter;
class AuthController extends Controller
{
    public function export()
    {
        $response = new StreamedResponse(function () {

            echo '[';
            $first = true;

            DB::table('rumah as r')

                // ========== KELURAHAN & KECAMATAN ==========
                ->leftJoin('i_kelurahan as kel', 'kel.id_kelurahan', '=', 'r.kelurahan_id')
                ->leftJoin('i_kecamatan as kec', 'kec.id_kecamatan', '=', 'kel.kecamatan_id')

                // ========== SOSIAL EKONOMI ==========
                ->leftJoin('sosial_ekonomi_rumah as se', 'se.rumah_id', '=', 'r.id_rumah')
                ->leftJoin('i_jenis_kelamin as jk', 'jk.id_jenis_kelamin', '=', 'se.jenis_kelamin_id')
                ->leftJoin('i_pendidikan_terakhir as pt', 'pt.id_pendidikan_terakhir', '=', 'se.pendidikan_terakhir_id')
                ->leftJoin('i_pekerjaan_utama as pu', 'pu.id_pekerjaan_utama', '=', 'se.pekerjaan_utama_id')
                ->leftJoin('i_besar_penghasilan as bpi', 'bpi.id_besar_penghasilan', '=', 'se.besar_penghasilan_perbulan_id')
                ->leftJoin('i_besar_pengeluaran as bpe', 'bpe.id_besar_pengeluaran', '=', 'se.besar_pengeluaran_perbulan_id')
                ->leftJoin('c_status_dtks as sdt', 'sdt.id_status_dtks', '=', 'se.status_dtks_id')
                ->leftJoin('i_jumlah_kk as jkk', 'jkk.id_jumlah_kk', '=', 'se.jumlah_kk_id')

                // ========== KEPEMILIKAN ==========
                ->leftJoin('kepemilikan_rumah as k', 'k.rumah_id', '=', 'r.id_rumah')
                ->leftJoin('i_status_kepemilikan_tanah as skt', 'skt.id_status_kepemilikan_tanah', '=', 'k.status_kepemilikan_tanah_id')
                ->leftJoin('i_bukti_kepemilikan_tanah as bkt', 'bkt.id_bukti_kepemilikan_tanah', '=', 'k.bukti_kepemilikan_tanah_id')
                ->leftJoin('i_status_kepemilikan_rumah as skr', 'skr.id_status_kepemilikan_rumah', '=', 'k.status_kepemilikan_rumah_id')
                ->leftJoin('i_status_imb as sim', 'sim.id_status_imb', '=', 'k.status_imb_id')
                ->leftJoin('i_aset_rumah_tempat_lain as ar', 'ar.id_aset_rumah_tempat_lain', '=', 'k.aset_rumah_ditempat_lain_id')
                ->leftJoin('i_aset_tanah_tempat_lain as at', 'at.id_aset_tanah_tempat_lain', '=', 'k.aset_tanah_ditempat_lain_id')
                ->leftJoin('i_jenis_kawasan_lokasi as jkl', 'jkl.id_jenis_kawasan_lokasi', '=', 'k.jenis_kawasan_lokasi_rumah_id')

                // ========== FISIK ==========
                ->leftJoin('fisik_rumah as f', 'f.rumah_id', '=', 'r.id_rumah')
                ->leftJoin('a_pondasi as p', 'p.id_pondasi', '=', 'f.pondasi_id')
                ->leftJoin('tbl_jenis_pondasi as jp', 'jp.id_jenis_pondasi', '=', 'f.jenis_pondasi')

                ->leftJoin('a_kondisi_pondasi as kp', 'kp.id_kondisi_pondasi', '=', 'f.kondisi_pondasi_id')
                ->leftJoin('a_kondisi_sloof as ks', 'ks.id_kondisi_sloof', '=', 'f.kondisi_sloof_id')
                ->leftJoin('a_kondisi_kolom_tiang as kkt', 'kkt.id_kondisi_kolom_tiang', '=', 'f.kondisi_kolom_tiang_id')
                ->leftJoin('a_kondisi_balok as kb', 'kb.id_kondisi_balok', '=', 'f.kondisi_balok_id')
                ->leftJoin('a_kondisi_struktur_atap as ksa', 'ksa.id_kondisi_struktur_atap', '=', 'f.kondisi_struktur_atap_id')

                ->leftJoin('d_material_atap_terluas as mat', 'mat.id_material_atap_terluas', '=', 'f.material_atap_terluas_id')
                ->leftJoin('d_kondisi_penutup_atap as kpa', 'kpa.id_kondisi_penutup_atap', '=', 'f.kondisi_penutup_atap_id')

                ->leftJoin('d_material_dinding_terluas as mdt', 'mdt.id_material_dinding_terluas', '=', 'f.material_dinding_terluas_id')
                ->leftJoin('d_kondisi_dinding as kd', 'kd.id_kondisi_dinding', '=', 'f.kondisi_dinding_id')

                ->leftJoin('d_material_lantai_terluas as mlt', 'mlt.id_material_lantai_terluas', '=', 'f.material_lantai_terluas_id')
                ->leftJoin('d_kondisi_lantai as kl', 'kl.id_kondisi_lantai', '=', 'f.kondisi_lantai_id')

                ->leftJoin('d_akses_ke_jalan as akj', 'akj.id_akses_ke_jalan', '=', 'f.akses_ke_jalan_id')
                ->leftJoin('d_bangunan_menghadap_jalan as bmj', 'bmj.id_bangunan_menghadap_jalan', '=', 'f.bangunan_menghadap_jalan_id')
                ->leftJoin('d_bangunan_menghadap_sungai as bms', 'bms.id_bangunan_menghadap_sungai', '=', 'f.bangunan_menghadap_sungai_id')
                ->leftJoin('d_bangunan_berada_sungai as bbs', 'bbs.id_bangunan_berada_sungai', '=', 'f.bangunan_berada_sungai_id')
                ->leftJoin('d_bangunan_berada_limbah as bbl', 'bbl.id_bangunan_berada_limbah', '=', 'f.bangunan_berada_limbah_id')

                // ========== SANITASI ==========
                ->leftJoin('sanitasi_rumah as sn', 'sn.rumah_id', '=', 'r.id_rumah')
                ->leftJoin('b_jendela_lubang_cahaya as jl', 'jl.id_jendela_lubang_cahaya', '=', 'sn.jendela_lubang_cahaya_id')
                ->leftJoin('b_kondisi_jendela_lubang_cahaya as kjl', 'kjl.id_kondisi_jendela_lubang_cahaya', '=', 'sn.kondisi_jendela_lubang_cahaya_id')

                ->leftJoin('b_ventilasi as v', 'v.id_ventilasi', '=', 'sn.ventilasi_id')
                ->leftJoin('b_kondisi_ventilasi as kv', 'kv.id_kondisi_ventilasi', '=', 'sn.kondisi_ventilasi_id')

                ->leftJoin('b_kamar_mandi as km', 'km.id_kamar_mandi', '=', 'sn.kamar_mandi_id')
                ->leftJoin('b_kondisi_kamar_mandi as kkm', 'kkm.id_kondisi_kamar_mandi', '=', 'sn.kondisi_kamar_mandi_id')

                ->leftJoin('b_jamban as j', 'j.id_jamban', '=', 'sn.jamban_id')
                ->leftJoin('b_kondisi_jamban as kj', 'kj.id_kondisi_jamban', '=', 'sn.kondisi_jamban_id')

                ->leftJoin('b_sistem_pembuangan_air_kotor as spak', 'spak.id_sistem_pembuangan_air_kotor', '=', 'sn.sistem_pembuangan_air_kotor_id')
                ->leftJoin('b_kondisi_sistem_pembuangan_air_kotor as kspak', 'kspak.id_kondisi_sistem_pembuangan_air_kotor', '=', 'sn.kondisi_sistem_pembuangan_air_kotor_id')

                ->leftJoin('b_sumber_air_minum as sam', 'sam.id_sumber_air_minum', '=', 'sn.sumber_air_minum_id')
                ->leftJoin('b_kondisi_sumber_air_minum as ksam', 'ksam.id_kondisi_sumber_air_minum', '=', 'sn.kondisi_sumber_air_minum_id')

                ->leftJoin('b_sumber_listrik as sl', 'sl.id_sumber_listrik', '=', 'sn.sumber_listrik_id')

                ->leftJoin('b_frekuensi_penyedotan as fps', 'fps.id_frekuensi_penyedotan', '=', 'sn.frekuensi_penyedotan_id')

                // ========== PENILAIAN ==========
                ->leftJoin('penilaian_rumah as pr', 'pr.rumah_id', '=', 'r.id_rumah')

                ->select([
                    // utama
                    'r.id_rumah','r.alamat','r.kelurahan_id','r.tahun_pembangunan_rumah',

                    'kel.nama_kelurahan','kec.nama_kecamatan',

                    // sosial ekonomi
                    'se.*','jk.jenis_kelamin','pt.pendidikan_terakhir','pu.pekerjaan_utama',
                    'bpi.besar_penghasilan','bpe.besar_pengeluaran','sdt.status_dtks','jkk.jumlah_kk',

                    // kepemilikan
                    'k.*','skt.status_kepemilikan_tanah','bkt.bukti_kepemilikan_tanah',
                    'skr.status_kepemilikan_rumah','sim.status_imb','ar.aset_rumah_tempat_lain',
                    'at.aset_tanah_tempat_lain','jkl.jenis_kawasan_lokasi',

                    // fisik
                    'f.*','p.pondasi','jp.nama_jenis_pondasi',
                    'kp.kondisi_pondasi','ks.kondisi_sloof','kkt.kondisi_kolom_tiang',
                    'kb.kondisi_balok','ksa.kondisi_struktur_atap','mat.material_atap_terluas',
                    'kpa.kondisi_penutup_atap','mdt.material_dinding_terluas','kd.kondisi_dinding',
                    'mlt.material_lantai_terluas','kl.kondisi_lantai','akj.akses_ke_jalan',
                    'bmj.bangunan_menghadap_jalan','bms.bangunan_menghadap_sungai',
                    'bbs.bangunan_berada_sungai','bbl.bangunan_berada_limbah',

                    // sanitasi
                    'sn.*','jl.jendela_lubang_cahaya','kjl.kondisi_jendela_lubang_cahaya',
                    'v.ventilasi','kv.kondisi_ventilasi','km.kamar_mandi','kkm.kondisi_kamar_mandi',
                    'j.jamban','kj.kondisi_jamban','spak.sistem_pembuangan_air_kotor',
                    'ksam.kondisi_sumber_air_minum','sl.sumber_listrik','fps.frekuensi_penyedotan',

                    // penilaian
                    'pr.nilai_a','pr.nilai_b','pr.nilai_c','pr.nilai','pr.status_rumah','pr.status_luas'
                ])

                ->orderBy('r.id_rumah')
                ->chunk(500, function ($rows) use (&$first) {

                    foreach ($rows as $row) {

                        $json = [

                            // SAME STRUCTURE AS ELOQUENT WITH()
                            "id_rumah" => $row->id_rumah,
                            "alamat" => $row->alamat,
                            "kelurahan_id" => $row->kelurahan_id,
                            "tahun_pembangunan_rumah" => $row->tahun_pembangunan_rumah,

                            "kelurahan" => [
                                "nama_kelurahan" => $row->nama_kelurahan,
                                "kecamatan" => [
                                    "nama_kecamatan" => $row->nama_kecamatan
                                ]
                            ],

                            "sosial_ekonomi" => [
                                "jenis_kelamin" => $row->jenis_kelamin,
                                "usia" => $row->usia,
                                "pendidikan_terakhir" => $row->pendidikan_terakhir,
                                "pekerjaan_utama" => $row->pekerjaan_utama,
                                "besar_penghasilan" => $row->besar_penghasilan,
                                "besar_pengeluaran" => $row->besar_pengeluaran,
                                "status_dtks" => $row->status_dtks,
                                "jumlah_kk" => $row->jumlah_kk,
                            ],

                            "kepemilikan" => [
                                "status_kepemilikan_tanah" => $row->status_kepemilikan_tanah,
                                "bukti_kepemilikan_tanah" => $row->bukti_kepemilikan_tanah,
                                "status_kepemilikan_rumah" => $row->status_kepemilikan_rumah,
                                "status_imb" => $row->status_imb,
                                "aset_rumah_ditempat_lain" => $row->aset_rumah_tempat_lain,
                                "aset_tanah_ditempat_lain" => $row->aset_tanah_tempat_lain,
                                "jenis_kawasan_lokasi" => $row->jenis_kawasan_lokasi
                            ],

                            "fisik" => [
                                "pondasi" => $row->pondasi,
                                "jenis_pondasi" => $row->nama_jenis_pondasi,
                                "kondisi_pondasi" => $row->kondisi_pondasi,
                                "kondisi_sloof" => $row->kondisi_sloof,
                                "kondisi_kolom_tiang" => $row->kondisi_kolom_tiang,
                                "kondisi_balok" => $row->kondisi_balok,
                                "kondisi_struktur_atap" => $row->kondisi_struktur_atap,
                                "material_atap_terluas" => $row->material_atap_terluas,
                                "material_dinding_terluas" => $row->material_dinding_terluas,
                                "kondisi_dinding" => $row->kondisi_dinding,
                                "material_lantai_terluas" => $row->material_lantai_terluas,
                                "kondisi_lantai" => $row->kondisi_lantai,
                                "akses_ke_jalan" => $row->akses_ke_jalan,
                                "bangunan_menghadap_jalan" => $row->bangunan_menghadap_jalan,
                                "bangunan_menghadap_sungai" => $row->bangunan_menghadap_sungai,
                                "bangunan_berada_sungai" => $row->bangunan_berada_sungai,
                                "bangunan_berada_limbah" => $row->bangunan_berada_limbah,
                            ],

                            "sanitasi" => [
                                "jendela_lubang_cahaya" => $row->jendela_lubang_cahaya,
                                "kondisi_jendela_lubang_cahaya" => $row->kondisi_jendela_lubang_cahaya,
                                "ventilasi" => $row->ventilasi,
                                "kondisi_ventilasi" => $row->kondisi_ventilasi,
                                "kamar_mandi" => $row->kamar_mandi,
                                "kondisi_kamar_mandi" => $row->kondisi_kamar_mandi,
                                "jamban" => $row->jamban,
                                "kondisi_jamban" => $row->kondisi_jamban,
                                "sistem_pembuangan_air_kotor" => $row->sistem_pembuangan_air_kotor,
                                "kondisi_sumber_air_minum" => $row->kondisi_sumber_air_minum,
                                "sumber_listrik" => $row->sumber_listrik,
                                "frekuensi_penyedotan" => $row->frekuensi_penyedotan
                            ],

                            "penilaian" => [
                                "nilai_a" => $row->nilai_a,
                                "nilai_b" => $row->nilai_b,
                                "nilai_c" => $row->nilai_c,
                                "nilai" => $row->nilai,
                                "status_rumah" => $row->status_rumah,
                                "status_luas" => $row->status_luas
                            ]
                        ];

                        if (!$first) echo ",";
                        echo json_encode($json, JSON_UNESCAPED_UNICODE);
                        $first = false;
                    }

                    flush();
                });

            echo ']';
        });

      $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

//     public function exportXlsx()
// {
//     $filePath = storage_path('app/public/rumah_export.xlsx');

//     $writer = new Writer();
//     $writer->openToFile($filePath);

//     // ===== HEADER XLSX ===== //
//     $writer->addRow(Row::fromValues([
//         'ID Rumah','Alamat','Kelurahan','Kecamatan',
//         'Usia','Jenis Kelamin','Pendidikan','Pekerjaan','Penghasilan','Pengeluaran',
//         'Status DTKS','Jumlah KK',
//         'Status Kep Tanah','Bukti Tanah','Status Rumah','IMB','Aset Rumah TL','Aset Tanah TL','Jenis Kawasan',
//         'Pondasi','Jenis Pondasi','Kond Pondasi','Kond Sloof','Kond Kolom','Kond Balok',
//         'Kond Atap','Mat Atap','Kond Penutup Atap','Mat Dinding','Kond Dinding',
//         'Mat Lantai','Kond Lantai','Akses Jalan','Menghadap Jalan','Menghadap Sungai',
//         'Berada Sungai','Berada Limbah',
//         'Jendela','Kondisi Jendela','Ventilasi','Kondisi Ventilasi',
//         'Kamar Mandi','Kondisi KM','Jamban','Kondisi Jamban',
//         'SPAK','Kondisi SAM','Sumber Listrik','Frekuensi Penyedotan',
//         'Nilai A','Nilai B','Nilai C','Nilai','Status Rumah','Status Luas'
//     ]));

//     // ================== QUERY BESAR JOIN ================== //
//     DB::table('rumah as r')
//         ->leftJoin('i_kelurahan as kel', 'kel.id_kelurahan', '=', 'r.kelurahan_id')
//         ->leftJoin('i_kecamatan as kec', 'kec.id_kecamatan', '=', 'kel.kecamatan_id')

//         ->leftJoin('sosial_ekonomi_rumah as se', 'se.rumah_id', '=', 'r.id_rumah')
//         ->leftJoin('i_jenis_kelamin as jk', 'jk.id_jenis_kelamin', '=', 'se.jenis_kelamin_id')
//         ->leftJoin('i_pendidikan_terakhir as pt', 'pt.id_pendidikan_terakhir', '=', 'se.pendidikan_terakhir_id')
//         ->leftJoin('i_pekerjaan_utama as pu', 'pu.id_pekerjaan_utama', '=', 'se.pekerjaan_utama_id')
//         ->leftJoin('i_besar_penghasilan as bpi', 'bpi.id_besar_penghasilan', '=', 'se.besar_penghasilan_perbulan_id')
//         ->leftJoin('i_besar_pengeluaran as bpe', 'bpe.id_besar_pengeluaran', '=', 'se.besar_pengeluaran_perbulan_id')
//         ->leftJoin('c_status_dtks as sdt', 'sdt.id_status_dtks', '=', 'se.status_dtks_id')
//         ->leftJoin('i_jumlah_kk as jkk', 'jkk.id_jumlah_kk', '=', 'se.jumlah_kk_id')

//         ->leftJoin('kepemilikan_rumah as k', 'k.rumah_id', '=', 'r.id_rumah')
//         ->leftJoin('i_status_kepemilikan_tanah as skt', 'skt.id_status_kepemilikan_tanah', '=', 'k.status_kepemilikan_tanah_id')
//         ->leftJoin('i_bukti_kepemilikan_tanah as bkt', 'bkt.id_bukti_kepemilikan_tanah', '=', 'k.bukti_kepemilikan_tanah_id')
//         ->leftJoin('i_status_kepemilikan_rumah as skr', 'skr.id_status_kepemilikan_rumah', '=', 'k.status_kepemilikan_rumah_id')
//         ->leftJoin('i_status_imb as sim', 'sim.id_status_imb', '=', 'k.status_imb_id')
//         ->leftJoin('i_aset_rumah_tempat_lain as ar', 'ar.id_aset_rumah_tempat_lain', '=', 'k.aset_rumah_ditempat_lain_id')
//         ->leftJoin('i_aset_tanah_tempat_lain as at', 'at.id_aset_tanah_tempat_lain', '=', 'k.aset_tanah_ditempat_lain_id')
//         ->leftJoin('i_jenis_kawasan_lokasi as jkl', 'jkl.id_jenis_kawasan_lokasi', '=', 'k.jenis_kawasan_lokasi_rumah_id')

//         ->leftJoin('fisik_rumah as f', 'f.rumah_id', '=', 'r.id_rumah')
//         ->leftJoin('a_pondasi as p', 'p.id_pondasi', '=', 'f.pondasi_id')
//         ->leftJoin('tbl_jenis_pondasi as jp', 'jp.id_jenis_pondasi', '=', 'f.jenis_pondasi')
//         ->leftJoin('a_kondisi_pondasi as kp', 'kp.id_kondisi_pondasi', '=', 'f.kondisi_pondasi_id')
//         ->leftJoin('a_kondisi_sloof as ks', 'ks.id_kondisi_sloof', '=', 'f.kondisi_sloof_id')
//         ->leftJoin('a_kondisi_kolom_tiang as kkt', 'kkt.id_kondisi_kolom_tiang', '=', 'f.kondisi_kolom_tiang_id')
//         ->leftJoin('a_kondisi_balok as kb', 'kb.id_kondisi_balok', '=', 'f.kondisi_balok_id')
//         ->leftJoin('a_kondisi_struktur_atap as ksa', 'ksa.id_kondisi_struktur_atap', '=', 'f.kondisi_struktur_atap_id')
//         ->leftJoin('d_material_atap_terluas as mat', 'mat.id_material_atap_terluas', '=', 'f.material_atap_terluas_id')
//         ->leftJoin('d_kondisi_penutup_atap as kpa', 'kpa.id_kondisi_penutup_atap', '=', 'f.kondisi_penutup_atap_id')
//         ->leftJoin('d_material_dinding_terluas as mdt', 'mdt.id_material_dinding_terluas', '=', 'f.material_dinding_terluas_id')
//         ->leftJoin('d_kondisi_dinding as kd', 'kd.id_kondisi_dinding', '=', 'f.kondisi_dinding_id')
//         ->leftJoin('d_material_lantai_terluas as mlt', 'mlt.id_material_lantai_terluas', '=', 'f.material_lantai_terluas_id')
//         ->leftJoin('d_kondisi_lantai as kl', 'kl.id_kondisi_lantai', '=', 'f.kondisi_lantai_id')
//         ->leftJoin('d_akses_ke_jalan as akj', 'akj.id_akses_ke_jalan', '=', 'f.akses_ke_jalan_id')
//         ->leftJoin('d_bangunan_menghadap_jalan as bmj', 'bmj.id_bangunan_menghadap_jalan', '=', 'f.bangunan_menghadap_jalan_id')
//         ->leftJoin('d_bangunan_menghadap_sungai as bms', 'bms.id_bangunan_menghadap_sungai', '=', 'f.bangunan_menghadap_sungai_id')
//         ->leftJoin('d_bangunan_berada_sungai as bbs', 'bbs.id_bangunan_berada_sungai', '=', 'f.bangunan_berada_sungai_id')
//         ->leftJoin('d_bangunan_berada_limbah as bbl', 'bbl.id_bangunan_berada_limbah', '=', 'f.bangunan_berada_limbah_id')

//         ->leftJoin('sanitasi_rumah as sn', 'sn.rumah_id', '=', 'r.id_rumah')
//         ->leftJoin('b_jendela_lubang_cahaya as jl', 'jl.id_jendela_lubang_cahaya', '=', 'sn.jendela_lubang_cahaya_id')
//         ->leftJoin('b_kondisi_jendela_lubang_cahaya as kjl', 'kjl.id_kondisi_jendela_lubang_cahaya', '=', 'sn.kondisi_jendela_lubang_cahaya_id')
//         ->leftJoin('b_ventilasi as v', 'v.id_ventilasi', '=', 'sn.ventilasi_id')
//         ->leftJoin('b_kondisi_ventilasi as kv', 'kv.id_kondisi_ventilasi', '=', 'sn.kondisi_ventilasi_id')
//         ->leftJoin('b_kamar_mandi as km', 'km.id_kamar_mandi', '=', 'sn.kamar_mandi_id')
//         ->leftJoin('b_kondisi_kamar_mandi as kkm', 'kkm.id_kondisi_kamar_mandi', '=', 'sn.kondisi_kamar_mandi_id')
//         ->leftJoin('b_jamban as j', 'j.id_jamban', '=', 'sn.jamban_id')
//         ->leftJoin('b_kondisi_jamban as kj', 'kj.id_kondisi_jamban', '=', 'sn.kondisi_jamban_id')
//         ->leftJoin('b_sistem_pembuangan_air_kotor as spak', 'spak.id_sistem_pembuangan_air_kotor', '=', 'sn.sistem_pembuangan_air_kotor_id')
//         ->leftJoin('b_kondisi_sistem_pembuangan_air_kotor as kspak', 'kspak.id_kondisi_sistem_pembuangan_air_kotor', '=', 'sn.kondisi_sistem_pembuangan_air_kotor_id')
//         ->leftJoin('b_sumber_air_minum as sam', 'sam.id_sumber_air_minum', '=', 'sn.sumber_air_minum_id')
//         ->leftJoin('b_kondisi_sumber_air_minum as ksam', 'ksam.id_kondisi_sumber_air_minum', '=', 'sn.kondisi_sumber_air_minum_id')
//         ->leftJoin('b_sumber_listrik as sl', 'sl.id_sumber_listrik', '=', 'sn.sumber_listrik_id')
//         ->leftJoin('b_frekuensi_penyedotan as fps', 'fps.id_frekuensi_penyedotan', '=', 'sn.frekuensi_penyedotan_id')

//         ->leftJoin('penilaian_rumah as pr', 'pr.rumah_id', '=', 'r.id_rumah')

//         ->orderBy('r.id_rumah')
//         ->chunk(1000, function ($rows) use ($writer) {

//             foreach ($rows as $row) {

//                 $writer->addRow(Row::fromValues([
//                     $row->id_rumah,
//                     $row->alamat,
//                     $row->nama_kelurahan,
//                     $row->nama_kecamatan,
//                     $row->usia,
//                     $row->jenis_kelamin,
//                     $row->pendidikan_terakhir,
//                     $row->pekerjaan_utama,
//                     $row->besar_penghasilan,
//                     $row->besar_pengeluaran,
//                     $row->status_dtks,
//                     $row->jumlah_kk,
//                     $row->status_kepemilikan_tanah,
//                     $row->bukti_kepemilikan_tanah,
//                     $row->status_kepemilikan_rumah,
//                     $row->status_imb,
//                     $row->aset_rumah_tempat_lain,
//                     $row->aset_tanah_tempat_lain,
//                     $row->jenis_kawasan_lokasi,
//                     $row->pondasi,
//                     $row->nama_jenis_pondasi,
//                     $row->kondisi_pondasi,
//                     $row->kondisi_sloof,
//                     $row->kondisi_kolom_tiang,
//                     $row->kondisi_balok,
//                     $row->kondisi_struktur_atap,
//                     $row->material_atap_terluas,
//                     $row->kondisi_penutup_atap,
//                     $row->material_dinding_terluas,
//                     $row->kondisi_dinding,
//                     $row->material_lantai_terluas,
//                     $row->kondisi_lantai,
//                     $row->akses_ke_jalan,
//                     $row->bangunan_menghadap_jalan,
//                     $row->bangunan_menghadap_sungai,
//                     $row->bangunan_berada_sungai,
//                     $row->bangunan_berada_limbah,
//                     $row->jendela_lubang_cahaya,
//                     $row->kondisi_jendela_lubang_cahaya,
//                     $row->ventilasi,
//                     $row->kondisi_ventilasi,
//                     $row->kamar_mandi,
//                     $row->kondisi_kamar_mandi,
//                     $row->jamban,
//                     $row->kondisi_jamban,
//                     $row->sistem_pembuangan_air_kotor,
//                     $row->kondisi_sumber_air_minum,
//                     $row->sumber_listrik,
//                     $row->frekuensi_penyedotan,
//                     $row->nilai_a,
//                     $row->nilai_b,
//                     $row->nilai_c,
//                     $row->nilai,
//                     $row->status_rumah,
//                     $row->status_luas,
//                 ]));
//             }
//         });

//     $writer->close();

//     return response()->download($filePath)->deleteFileAfterSend();
// }

     public function exportXlsx()
    {
        $filePath = storage_path('app/public/rumah_export.xlsx');

        $writer = new XLSXWriter();
        $writer->openToFile($filePath);

        /**
         |--------------------------------------------------------------------------
         |  SHEET 1: DATA RUMAH (JOIN BESAR)
         |--------------------------------------------------------------------------
         */
        $writer->getCurrentSheet()->setName("Data Rumah");

        $writer->addRow(Row::fromValues([
            'ID Rumah','Alamat','Kelurahan','Kecamatan',
            'Usia','Jenis Kelamin','Pendidikan','Pekerjaan','Penghasilan','Pengeluaran',
            'Status DTKS','Jumlah KK',
            'Status Kep Tanah','Bukti Tanah','Status Rumah','IMB','Aset Rumah TL','Aset Tanah TL','Jenis Kawasan',
            'Pondasi','Jenis Pondasi','Kond Pondasi','Kond Sloof','Kond Kolom','Kond Balok',
            'Kond Atap','Mat Atap','Kond Penutup Atap','Mat Dinding','Kond Dinding',
            'Mat Lantai','Kond Lantai','Akses Jalan','Menghadap Jalan','Menghadap Sungai',
            'Berada Sungai','Berada Limbah',
            'Jendela','Kondisi Jendela','Ventilasi','Kondisi Ventilasi',
            'Kamar Mandi','Kondisi KM','Jamban','Kondisi Jamban',
            'SPAK','Kondisi SAM','Sumber Listrik','Frekuensi Penyedotan',
            'Nilai A','Nilai B','Nilai C','Nilai','Status Rumah','Status Luas'
        ]));

        DB::table('rumah as r')
            ->leftJoin('i_kelurahan as kel', 'kel.id_kelurahan', '=', 'r.kelurahan_id')
            ->leftJoin('i_kecamatan as kec', 'kec.id_kecamatan', '=', 'kel.kecamatan_id')

            ->leftJoin('sosial_ekonomi_rumah as se', 'se.rumah_id', '=', 'r.id_rumah')
            ->leftJoin('i_jenis_kelamin as jk', 'jk.id_jenis_kelamin', '=', 'se.jenis_kelamin_id')
            ->leftJoin('i_pendidikan_terakhir as pt', 'pt.id_pendidikan_terakhir', '=', 'se.pendidikan_terakhir_id')
            ->leftJoin('i_pekerjaan_utama as pu', 'pu.id_pekerjaan_utama', '=', 'se.pekerjaan_utama_id')
            ->leftJoin('i_besar_penghasilan as bpi', 'bpi.id_besar_penghasilan', '=', 'se.besar_penghasilan_perbulan_id')
            ->leftJoin('i_besar_pengeluaran as bpe', 'bpe.id_besar_pengeluaran', '=', 'se.besar_pengeluaran_perbulan_id')
            ->leftJoin('c_status_dtks as sdt', 'sdt.id_status_dtks', '=', 'se.status_dtks_id')
            ->leftJoin('i_jumlah_kk as jkk', 'jkk.id_jumlah_kk', '=', 'se.jumlah_kk_id')

            ->leftJoin('kepemilikan_rumah as k', 'k.rumah_id', '=', 'r.id_rumah')
            ->leftJoin('i_status_kepemilikan_tanah as skt', 'skt.id_status_kepemilikan_tanah', '=', 'k.status_kepemilikan_tanah_id')
            ->leftJoin('i_bukti_kepemilikan_tanah as bkt', 'bkt.id_bukti_kepemilikan_tanah', '=', 'k.bukti_kepemilikan_tanah_id')
            ->leftJoin('i_status_kepemilikan_rumah as skr', 'skr.id_status_kepemilikan_rumah', '=', 'k.status_kepemilikan_rumah_id')
            ->leftJoin('i_status_imb as sim', 'sim.id_status_imb', '=', 'k.status_imb_id')
            ->leftJoin('i_aset_rumah_tempat_lain as ar', 'ar.id_aset_rumah_tempat_lain', '=', 'k.aset_rumah_ditempat_lain_id')
            ->leftJoin('i_aset_tanah_tempat_lain as at', 'at.id_aset_tanah_tempat_lain', '=', 'k.aset_tanah_ditempat_lain_id')
            ->leftJoin('i_jenis_kawasan_lokasi as jkl', 'jkl.id_jenis_kawasan_lokasi', '=', 'k.jenis_kawasan_lokasi_rumah_id')

            ->leftJoin('fisik_rumah as f', 'f.rumah_id', '=', 'r.id_rumah')
            ->leftJoin('a_pondasi as p', 'p.id_pondasi', '=', 'f.pondasi_id')
            ->leftJoin('tbl_jenis_pondasi as jp', 'jp.id_jenis_pondasi', '=', 'f.jenis_pondasi')
            ->leftJoin('a_kondisi_pondasi as kp', 'kp.id_kondisi_pondasi', '=', 'f.kondisi_pondasi_id')
            ->leftJoin('a_kondisi_sloof as ks', 'ks.id_kondisi_sloof', '=', 'f.kondisi_sloof_id')
            ->leftJoin('a_kondisi_kolom_tiang as kkt', 'kkt.id_kondisi_kolom_tiang', '=', 'f.kondisi_kolom_tiang_id')
            ->leftJoin('a_kondisi_balok as kb', 'kb.id_kondisi_balok', '=', 'f.kondisi_balok_id')
            ->leftJoin('a_kondisi_struktur_atap as ksa', 'ksa.id_kondisi_struktur_atap', '=', 'f.kondisi_struktur_atap_id')
            ->leftJoin('d_material_atap_terluas as mat', 'mat.id_material_atap_terluas', '=', 'f.material_atap_terluas_id')
            ->leftJoin('d_kondisi_penutup_atap as kpa', 'kpa.id_kondisi_penutup_atap', '=', 'f.kondisi_penutup_atap_id')
            ->leftJoin('d_material_dinding_terluas as mdt', 'mdt.id_material_dinding_terluas', '=', 'f.material_dinding_terluas_id')
            ->leftJoin('d_kondisi_dinding as kd', 'kd.id_kondisi_dinding', '=', 'f.kondisi_dinding_id')
            ->leftJoin('d_material_lantai_terluas as mlt', 'mlt.id_material_lantai_terluas', '=', 'f.material_lantai_terluas_id')
            ->leftJoin('d_kondisi_lantai as kl', 'kl.id_kondisi_lantai', '=', 'f.kondisi_lantai_id')
            ->leftJoin('d_akses_ke_jalan as akj', 'akj.id_akses_ke_jalan', '=', 'f.akses_ke_jalan_id')
            ->leftJoin('d_bangunan_menghadap_jalan as bmj', 'bmj.id_bangunan_menghadap_jalan', '=', 'f.bangunan_menghadap_jalan_id')
            ->leftJoin('d_bangunan_menghadap_sungai as bms', 'bms.id_bangunan_menghadap_sungai', '=', 'f.bangunan_menghadap_sungai_id')
            ->leftJoin('d_bangunan_berada_sungai as bbs', 'bbs.id_bangunan_berada_sungai', '=', 'f.bangunan_berada_sungai_id')
            ->leftJoin('d_bangunan_berada_limbah as bbl', 'bbl.id_bangunan_berada_limbah', '=', 'f.bangunan_berada_limbah_id')

            ->leftJoin('sanitasi_rumah as sn', 'sn.rumah_id', '=', 'r.id_rumah')
            ->leftJoin('b_jendela_lubang_cahaya as jl', 'jl.id_jendela_lubang_cahaya', '=', 'sn.jendela_lubang_cahaya_id')
            ->leftJoin('b_kondisi_jendela_lubang_cahaya as kjl', 'kjl.id_kondisi_jendela_lubang_cahaya', '=', 'sn.kondisi_jendela_lubang_cahaya_id')
            ->leftJoin('b_ventilasi as v', 'v.id_ventilasi', '=', 'sn.ventilasi_id')
            ->leftJoin('b_kondisi_ventilasi as kv', 'kv.id_kondisi_ventilasi', '=', 'sn.kondisi_ventilasi_id')
            ->leftJoin('b_kamar_mandi as km', 'km.id_kamar_mandi', '=', 'sn.kamar_mandi_id')
            ->leftJoin('b_kondisi_kamar_mandi as kkm', 'kkm.id_kondisi_kamar_mandi', '=', 'sn.kondisi_kamar_mandi_id')
            ->leftJoin('b_jamban as j', 'j.id_jamban', '=', 'sn.jamban_id')
            ->leftJoin('b_kondisi_jamban as kj', 'kj.id_kondisi_jamban', '=', 'sn.kondisi_jamban_id')
            ->leftJoin('b_sistem_pembuangan_air_kotor as spak', 'spak.id_sistem_pembuangan_air_kotor', '=', 'sn.sistem_pembuangan_air_kotor_id')
            ->leftJoin('b_kondisi_sistem_pembuangan_air_kotor as kspak', 'kspak.id_kondisi_sistem_pembuangan_air_kotor', '=', 'sn.kondisi_sistem_pembuangan_air_kotor_id')
            ->leftJoin('b_sumber_air_minum as sam', 'sam.id_sumber_air_minum', '=', 'sn.sumber_air_minum_id')
            ->leftJoin('b_kondisi_sumber_air_minum as ksam', 'ksam.id_kondisi_sumber_air_minum', '=', 'sn.kondisi_sumber_air_minum_id')
            ->leftJoin('b_sumber_listrik as sl', 'sl.id_sumber_listrik', '=', 'sn.sumber_listrik_id')
            ->leftJoin('b_frekuensi_penyedotan as fps', 'fps.id_frekuensi_penyedotan', '=', 'sn.frekuensi_penyedotan_id')

            ->leftJoin('penilaian_rumah as pr', 'pr.rumah_id', '=', 'r.id_rumah')

            ->orderBy('r.id_rumah')
            ->chunk(1000, function ($rows) use ($writer) {

                foreach ($rows as $row) {
                    $writer->addRow(Row::fromValues([
                        $row->id_rumah,
                        $row->alamat,
                        $row->nama_kelurahan,
                        $row->nama_kecamatan,
                        $row->usia,
                        $row->jenis_kelamin,
                        $row->pendidikan_terakhir,
                        $row->pekerjaan_utama,
                        $row->besar_penghasilan,
                        $row->besar_pengeluaran,
                        $row->status_dtks,
                        $row->jumlah_kk,
                        $row->status_kepemilikan_tanah,
                        $row->bukti_kepemilikan_tanah,
                        $row->status_kepemilikan_rumah,
                        $row->status_imb,
                        $row->aset_rumah_tempat_lain,
                        $row->aset_tanah_tempat_lain,
                        $row->jenis_kawasan_lokasi,
                        $row->pondasi,
                        $row->nama_jenis_pondasi,
                        $row->kondisi_pondasi,
                        $row->kondisi_sloof,
                        $row->kondisi_kolom_tiang,
                        $row->kondisi_balok,
                        $row->kondisi_struktur_atap,
                        $row->material_atap_terluas,
                        $row->kondisi_penutup_atap,
                        $row->material_dinding_terluas,
                        $row->kondisi_dinding,
                        $row->material_lantai_terluas,
                        $row->kondisi_lantai,
                        $row->akses_ke_jalan,
                        $row->bangunan_menghadap_jalan,
                        $row->bangunan_menghadap_sungai,
                        $row->bangunan_berada_sungai,
                        $row->bangunan_berada_limbah,
                        $row->jendela_lubang_cahaya,
                        $row->kondisi_jendela_lubang_cahaya,
                        $row->ventilasi,
                        $row->kondisi_ventilasi,
                        $row->kamar_mandi,
                        $row->kondisi_kamar_mandi,
                        $row->jamban,
                        $row->kondisi_jamban,
                        $row->sistem_pembuangan_air_kotor,
                        $row->kondisi_sumber_air_minum,
                        $row->sumber_listrik,
                        $row->frekuensi_penyedotan,
                        $row->nilai_a,
                        $row->nilai_b,
                        $row->nilai_c,
                        $row->nilai,
                        $row->status_rumah,
                        $row->status_luas,
                    ]));
                }
            });

        /**
         |--------------------------------------------------------------------------
         |  SHEET 2: DATA KEPALA KELUARGA
         |--------------------------------------------------------------------------
         */

        $writer->addNewSheetAndMakeItCurrent()->setName("Data KK & Anggota");

        $writer->addRow(Row::fromValues([
            'No', 'ID Rumah', 'No KK', 'NIK', 'Nama Lengkap'
        ]));

        $no = 1;

        KepalaKeluarga::with(['anggota', 'rumah'])
            ->orderBy('id', 'asc')
            ->chunk(1000, function ($list) use ($writer, &$no) {

                foreach ($list as $kk) {

                    $first = $kk->anggota->first();

                    $idRumah = $kk->rumah->id_rumah ?? $kk->rumah_id ?? '-';

                    $noKK = $kk->no_kk ?? '-';
                    if (is_string($noKK) && stripos($noKK, 'DUMMY') !== false) {
                        $noKK = '-';
                    }

                    $writer->addRow(Row::fromValues([
                        $no++,
                        $idRumah,
                        $noKK,
                        $first->nik ?? '-',
                        $first->nama ?? '-',
                    ]));
                }
            });

        /**
         |--------------------------------------------------------------------------
         |  SHEET 3: DATA BANTUAN & RIWAYAT BANTUAN
         |--------------------------------------------------------------------------
         */

        $writer->addNewSheetAndMakeItCurrent()->setName("Data Bantuan");

        $writer->addRow(Row::fromValues([
            'Tipe Data',
            'ID Rumah',
            'Alamat',
            'Kecamatan',
            'Kelurahan',
            'No KK Penerima',
            'Nama Program Bantuan',
            'Nama Bantuan',
            'Tahun Bantuan',
            'Nominal Bantuan (Rp)',
            'Pernah Mendapatkan Bantuan'
        ]));

        Rumah::with([
            'kelurahan.kecamatan',
            'bantuan.pernahMendapatkanBantuan',
            'kepalaKeluarga.anggota'
        ])
        ->whereHas('bantuan', fn($q) => $q->where('pernah_mendapatkan_bantuan_id', 1))
        ->orderBy('id_rumah')
        ->chunk(500, function ($rumahList) use ($writer) {

            foreach ($rumahList as $rumah) {

                $kkList = $rumah->kepalaKeluarga->pluck('no_kk')->filter()->toArray();

                $noKK = $kkList[0] ?? '-';
                if (is_string($noKK) && stripos($noKK, 'DUMMY') !== false) {
                    $noKK = '-';
                }

                if ($rumah->bantuan) {
                    $writer->addRow(Row::fromValues([
                        'Bantuan Utama Rumah',
                        $rumah->id_rumah,
                        $rumah->alamat,
                        $rumah->kelurahan->kecamatan->nama_kecamatan ?? '-',
                        $rumah->kelurahan->nama_kelurahan ?? '-',
                        $rumah->bantuan->no_kk_penerima ?? $noKK,
                        $rumah->bantuan->nama_program_bantuan ?? '-',
                        $rumah->bantuan->nama_bantuan ?? '-',
                        $rumah->bantuan->tahun_bantuan ?? '-',
                        $rumah->bantuan->nominal_bantuan ?? '-',
                        $rumah->bantuan->pernahMendapatkanBantuan->pernah_mendapatkan_bantuan ?? '-',
                    ]));
                }

                if (!empty($kkList)) {

                    $riwayat = TblBantuan::whereIn('kk', $kkList)
                        ->orderBy('tahun', 'desc')
                        ->get();

                    foreach ($riwayat as $r) {

                        $writer->addRow(Row::fromValues([
                            'Riwayat Bantuan KK',
                            $rumah->id_rumah,
                            $rumah->alamat,
                            $rumah->kelurahan->kecamatan->nama_kecamatan ?? '-',
                            $rumah->kelurahan->nama_kelurahan ?? '-',
                            $r->kk ?? $noKK,
                            $r->nama_program ?? '-',
                            $r->nama ?? '-',
                            $r->tahun ?? '-',
                            $r->nominal ?? '-',
                            '-'
                        ]));
                    }

                    continue;
                }

                if (!$rumah->bantuan) {
                    $writer->addRow(Row::fromValues([
                        'Kosong',
                        $rumah->id_rumah,
                        $rumah->alamat,
                        $rumah->kelurahan->kecamatan->nama_kecamatan ?? '-',
                        $rumah->kelurahan->nama_kelurahan ?? '-',
                        $noKK,
                        '-','-','-','-','-'
                    ]));
                }
            }
        });

        // CLOSE WRITER
        $writer->close();

        return response()->download($filePath)->deleteFileAfterSend();
    }

public function exportXlsx2()
    {
        $filePath = storage_path('app/public/rumah_export.xlsx');

        $writer = new XLSXWriter();
        $writer->openToFile($filePath);

        /**
         |----------------------------------------------------------------------
         |  SHEET 1: DATA RUMAH (JOIN BESAR)
         |----------------------------------------------------------------------
         */
        $writer->getCurrentSheet()->setName("Data Rumah");

        $writer->addRow(Row::fromValues([
            'ID Rumah','Alamat','Kelurahan','Kecamatan',
            'Usia','Jenis Kelamin','Pendidikan','Pekerjaan','Penghasilan','Pengeluaran',
            'Status DTKS','Jumlah KK',
            'Status Kep Tanah','Bukti Tanah','Status Rumah','IMB','Aset Rumah TL','Aset Tanah TL','Jenis Kawasan',
            'Pondasi','Jenis Pondasi','Kond Pondasi','Kond Sloof','Kond Kolom','Kond Balok',
            'Kond Atap','Mat Atap','Kond Penutup Atap','Mat Dinding','Kond Dinding',
            'Mat Lantai','Kond Lantai','Akses Jalan','Menghadap Jalan','Menghadap Sungai',
            'Berada Sungai','Berada Limbah',
            'Jendela','Kondisi Jendela','Ventilasi','Kondisi Ventilasi',
            'Kamar Mandi','Kondisi KM','Jamban','Kondisi Jamban',
            'SPAK','Kondisi SAM','Sumber Listrik','Frekuensi Penyedotan',
            'Nilai A','Nilai B','Nilai C','Nilai','Status Rumah','Status Luas'
        ]));

        DB::table('rumah as r')
            ->leftJoin('i_kelurahan as kel', 'kel.id_kelurahan', '=', 'r.kelurahan_id')
            ->leftJoin('i_kecamatan as kec', 'kec.id_kecamatan', '=', 'kel.kecamatan_id')

            ->leftJoin('sosial_ekonomi_rumah as se', 'se.rumah_id', '=', 'r.id_rumah')
            ->leftJoin('i_jenis_kelamin as jk', 'jk.id_jenis_kelamin', '=', 'se.jenis_kelamin_id')
            ->leftJoin('i_pendidikan_terakhir as pt', 'pt.id_pendidikan_terakhir', '=', 'se.pendidikan_terakhir_id')
            ->leftJoin('i_pekerjaan_utama as pu', 'pu.id_pekerjaan_utama', '=', 'se.pekerjaan_utama_id')
            ->leftJoin('i_besar_penghasilan as bpi', 'bpi.id_besar_penghasilan', '=', 'se.besar_penghasilan_perbulan_id')
            ->leftJoin('i_besar_pengeluaran as bpe', 'bpe.id_besar_pengeluaran', '=', 'se.besar_pengeluaran_perbulan_id')
            ->leftJoin('c_status_dtks as sdt', 'sdt.id_status_dtks', '=', 'se.status_dtks_id')
            ->leftJoin('i_jumlah_kk as jkk', 'jkk.id_jumlah_kk', '=', 'se.jumlah_kk_id')

            ->leftJoin('kepemilikan_rumah as k', 'k.rumah_id', '=', 'r.id_rumah')
            ->leftJoin('i_status_kepemilikan_tanah as skt', 'skt.id_status_kepemilikan_tanah', '=', 'k.status_kepemilikan_tanah_id')
            ->leftJoin('i_bukti_kepemilikan_tanah as bkt', 'bkt.id_bukti_kepemilikan_tanah', '=', 'k.bukti_kepemilikan_tanah_id')
            ->leftJoin('i_status_kepemilikan_rumah as skr', 'skr.id_status_kepemilikan_rumah', '=', 'k.status_kepemilikan_rumah_id')
            ->leftJoin('i_status_imb as sim', 'sim.id_status_imb', '=', 'k.status_imb_id')
            ->leftJoin('i_aset_rumah_tempat_lain as ar', 'ar.id_aset_rumah_tempat_lain', '=', 'k.aset_rumah_ditempat_lain_id')
            ->leftJoin('i_aset_tanah_tempat_lain as at', 'at.id_aset_tanah_tempat_lain', '=', 'k.aset_tanah_ditempat_lain_id')
            ->leftJoin('i_jenis_kawasan_lokasi as jkl', 'jkl.id_jenis_kawasan_lokasi', '=', 'k.jenis_kawasan_lokasi_rumah_id')

            ->leftJoin('fisik_rumah as f', 'f.rumah_id', '=', 'r.id_rumah')
            ->leftJoin('a_pondasi as p', 'p.id_pondasi', '=', 'f.pondasi_id')
            ->leftJoin('tbl_jenis_pondasi as jp', 'jp.id_jenis_pondasi', '=', 'f.jenis_pondasi')
            ->leftJoin('a_kondisi_pondasi as kp', 'kp.id_kondisi_pondasi', '=', 'f.kondisi_pondasi_id')
            ->leftJoin('a_kondisi_sloof as ks', 'ks.id_kondisi_sloof', '=', 'f.kondisi_sloof_id')
            ->leftJoin('a_kondisi_kolom_tiang as kkt', 'kkt.id_kondisi_kolom_tiang', '=', 'f.kondisi_kolom_tiang_id')
            ->leftJoin('a_kondisi_balok as kb', 'kb.id_kondisi_balok', '=', 'f.kondisi_balok_id')
            ->leftJoin('a_kondisi_struktur_atap as ksa', 'ksa.id_kondisi_struktur_atap', '=', 'f.kondisi_struktur_atap_id')
            ->leftJoin('d_material_atap_terluas as mat', 'mat.id_material_atap_terluas', '=', 'f.material_atap_terluas_id')
            ->leftJoin('d_kondisi_penutup_atap as kpa', 'kpa.id_kondisi_penutup_atap', '=', 'f.kondisi_penutup_atap_id')
            ->leftJoin('d_material_dinding_terluas as mdt', 'mdt.id_material_dinding_terluas', '=', 'f.material_dinding_terluas_id')
            ->leftJoin('d_kondisi_dinding as kd', 'kd.id_kondisi_dinding', '=', 'f.kondisi_dinding_id')
            ->leftJoin('d_material_lantai_terluas as mlt', 'mlt.id_material_lantai_terluas', '=', 'f.material_lantai_terluas_id')
            ->leftJoin('d_kondisi_lantai as kl', 'kl.id_kondisi_lantai', '=', 'f.kondisi_lantai_id')
            ->leftJoin('d_akses_ke_jalan as akj', 'akj.id_akses_ke_jalan', '=', 'f.akses_ke_jalan_id')
            ->leftJoin('d_bangunan_menghadap_jalan as bmj', 'bmj.id_bangunan_menghadap_jalan', '=', 'f.bangunan_menghadap_jalan_id')
            ->leftJoin('d_bangunan_menghadap_sungai as bms', 'bms.id_bangunan_menghadap_sungai', '=', 'f.bangunan_menghadap_sungai_id')
            ->leftJoin('d_bangunan_berada_sungai as bbs', 'bbs.id_bangunan_berada_sungai', '=', 'f.bangunan_berada_sungai_id')
            ->leftJoin('d_bangunan_berada_limbah as bbl', 'bbl.id_bangunan_berada_limbah', '=', 'f.bangunan_berada_limbah_id')

            ->leftJoin('sanitasi_rumah as sn', 'sn.rumah_id', '=', 'r.id_rumah')
            ->leftJoin('b_jendela_lubang_cahaya as jl', 'jl.id_jendela_lubang_cahaya', '=', 'sn.jendela_lubang_cahaya_id')
            ->leftJoin('b_kondisi_jendela_lubang_cahaya as kjl', 'kjl.id_kondisi_jendela_lubang_cahaya', '=', 'sn.kondisi_jendela_lubang_cahaya_id')
            ->leftJoin('b_ventilasi as v', 'v.id_ventilasi', '=', 'sn.ventilasi_id')
            ->leftJoin('b_kondisi_ventilasi as kv', 'kv.id_kondisi_ventilasi', '=', 'sn.kondisi_ventilasi_id')
            ->leftJoin('b_kamar_mandi as km', 'km.id_kamar_mandi', '=', 'sn.kamar_mandi_id')
            ->leftJoin('b_kondisi_kamar_mandi as kkm', 'kkm.id_kondisi_kamar_mandi', '=', 'sn.kondisi_kamar_mandi_id')
            ->leftJoin('b_jamban as j', 'j.id_jamban', '=', 'sn.jamban_id')
            ->leftJoin('b_kondisi_jamban as kj', 'kj.id_kondisi_jamban', '=', 'sn.kondisi_jamban_id')
            ->leftJoin('b_sistem_pembuangan_air_kotor as spak', 'spak.id_sistem_pembuangan_air_kotor', '=', 'sn.sistem_pembuangan_air_kotor_id')
            ->leftJoin('b_kondisi_sistem_pembuangan_air_kotor as kspak', 'kspak.id_kondisi_sistem_pembuangan_air_kotor', '=', 'sn.kondisi_sistem_pembuangan_air_kotor_id')
            ->leftJoin('b_sumber_air_minum as sam', 'sam.id_sumber_air_minum', '=', 'sn.sumber_air_minum_id')
            ->leftJoin('b_kondisi_sumber_air_minum as ksam', 'ksam.id_kondisi_sumber_air_minum', '=', 'sn.kondisi_sumber_air_minum_id')
            ->leftJoin('b_sumber_listrik as sl', 'sl.id_sumber_listrik', '=', 'sn.sumber_listrik_id')
            ->leftJoin('b_frekuensi_penyedotan as fps', 'fps.id_frekuensi_penyedotan', '=', 'sn.frekuensi_penyedotan_id')

            ->leftJoin('penilaian_rumah as pr', 'pr.rumah_id', '=', 'r.id_rumah')

            ->selectRaw("
                r.id_rumah, r.alamat, kel.nama_kelurahan, kec.nama_kecamatan,
                se.usia, jk.jenis_kelamin, pt.pendidikan_terakhir, pu.pekerjaan_utama,
                bpi.besar_penghasilan, bpe.besar_pengeluaran,
                sdt.status_dtks, jkk.jumlah_kk,

                skt.status_kepemilikan_tanah, bkt.bukti_kepemilikan_tanah,
                skr.status_kepemilikan_rumah, sim.status_imb,
                ar.aset_rumah_tempat_lain, at.aset_tanah_tempat_lain,
                jkl.jenis_kawasan_lokasi,

                p.pondasi, jp.nama_jenis_pondasi, kp.kondisi_pondasi,
                ks.kondisi_sloof, kkt.kondisi_kolom_tiang, kb.kondisi_balok,
                ksa.kondisi_struktur_atap, mat.material_atap_terluas,
                kpa.kondisi_penutup_atap, mdt.material_dinding_terluas,
                kd.kondisi_dinding, mlt.material_lantai_terluas,
                kl.kondisi_lantai, akj.akses_ke_jalan,
                bmj.bangunan_menghadap_jalan, bms.bangunan_menghadap_sungai,
                bbs.bangunan_berada_sungai, bbl.bangunan_berada_limbah,

                jl.jendela_lubang_cahaya, kjl.kondisi_jendela_lubang_cahaya,
                v.ventilasi, kv.kondisi_ventilasi, km.kamar_mandi,
                kkm.kondisi_kamar_mandi, j.jamban, kj.kondisi_jamban,
                spak.sistem_pembuangan_air_kotor, ksam.kondisi_sumber_air_minum,
                sl.sumber_listrik, fps.frekuensi_penyedotan,

                pr.nilai_a, pr.nilai_b, pr.nilai_c, pr.nilai,
                pr.status_rumah, pr.status_luas
            ")

            ->orderBy('r.id_rumah')
            ->chunk(1000, function ($rows) use ($writer) {
                foreach ($rows as $row) {
                    $writer->addRow(Row::fromValues((array)$row));
                }
            });

        /**
         |----------------------------------------------------------------------
         |  SHEET 2: DATA KEPALA KELUARGA (QUERY BUILDER)
         |----------------------------------------------------------------------
         */
        $writer->addNewSheetAndMakeItCurrent()->setName("Data KK & Anggota");

        $writer->addRow(Row::fromValues([
            'No', 'ID Rumah', 'No KK', 'NIK', 'Nama Lengkap'
        ]));

        $no = 1;

        DB::table('kepala_keluarga as kk')
            ->leftJoin('anggota_keluarga as ak', 'ak.kepala_keluarga_id', '=', 'kk.id')
            ->leftJoin('rumah as r', 'r.id_rumah', '=', 'kk.rumah_id')
            ->select('kk.id','kk.no_kk','kk.rumah_id','ak.nik','ak.nama')
            ->orderBy('kk.id')
            ->chunk(1000, function($list) use ($writer, &$no) {

                foreach ($list as $row) {

                    $noKK = $row->no_kk ?? '-';
                    if (is_string($noKK) && stripos($noKK, 'DUMMY') !== false)
                        $noKK = '-';

                    $writer->addRow(Row::fromValues([
                        $no++,
                        $row->rumah_id ?? '-',
                        $noKK,
                        $row->nik ?? '-',
                        $row->nama ?? '-',
                    ]));
                }
            });

        /**
         |----------------------------------------------------------------------
         |  SHEET 3: DATA BANTUAN (QUERY BUILDER ONLY)
         |----------------------------------------------------------------------
         */
        $writer->addNewSheetAndMakeItCurrent()->setName("Data Bantuan");

        $writer->addRow(Row::fromValues([
            'Tipe Data','ID Rumah','Alamat','Kecamatan','Kelurahan',
            'No KK Penerima','Nama Program Bantuan','Nama Bantuan','Tahun Bantuan',
            'Nominal Bantuan (Rp)','Pernah Mendapatkan Bantuan'
        ]));

        // Ambil semua rumah yang punya bantuan
        DB::table('rumah as r')
            ->leftJoin('i_kelurahan as kel', 'kel.id_kelurahan', '=', 'r.kelurahan_id')
            ->leftJoin('i_kecamatan as kec', 'kec.id_kecamatan', '=', 'kel.kecamatan_id')
            ->leftJoin('bantuan_rumah as br', 'br.rumah_id', '=', 'r.id_rumah')
            ->where('br.pernah_mendapatkan_bantuan_id', 1)
            ->select(
                'r.id_rumah','r.alamat',
                'kel.nama_kelurahan','kec.nama_kecamatan',
                'br.no_kk_penerima','br.nama_program_bantuan',
                'br.nama_bantuan','br.tahun_bantuan','br.nominal_bantuan',
                'br.pernah_mendapatkan_bantuan_id'
            )
            ->orderBy('r.id_rumah')
            ->chunk(500, function($rows) use ($writer) {

                foreach ($rows as $row) {

                    $writer->addRow(Row::fromValues([
                        'Bantuan Utama Rumah',
                        $row->id_rumah,
                        $row->alamat,
                        $row->nama_kecamatan,
                        $row->nama_kelurahan,
                        $row->no_kk_penerima,
                        $row->nama_program_bantuan,
                        $row->nama_bantuan,
                        $row->tahun_bantuan,
                        $row->nominal_bantuan,
                        'Ya'
                    ]));

                    // RIWAYAT BANTUAN KK (tbl_bantuan)
                    $riwayat = DB::table('tbl_bantuan')
                        ->where('kk', $row->no_kk_penerima)
                        ->orderBy('tahun', 'desc')
                        ->get();

                    foreach ($riwayat as $r) {
                        $writer->addRow(Row::fromValues([
                            'Riwayat Bantuan KK',
                            $row->id_rumah,
                            $row->alamat,
                            $row->nama_kecamatan,
                            $row->nama_kelurahan,
                            $r->kk,
                            $r->nama_program,
                            $r->nama,
                            $r->tahun,
                            $r->nominal,
                            '-'
                        ]));
                    }
                }
            });

        $writer->close();

        return response()->download($filePath)->deleteFileAfterSend();
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status'  => false,
                'message' => 'Email atau password salah'
            ], 401);
        }

        $accessPayload = [
            'id_user' => $user->id,
            'email'   => $user->email,
            'level'   => $user->level == 1 ? 'Admin' : 'Staff',
            'iat'     => time(),
            'exp'     => time() + config('jwt.access_expire')
        ];

        $refreshPayload = [
            'id_user' => $user->id,
            'email'   => $user->email,
            'iat'     => time(),
            'exp'     => time() + config('jwt.refresh_expire')
        ];

        return response()->json([
            'status'  => true,
            'message' => 'Login berhasil',
            'access_token' => JwtHelper::generateToken($accessPayload),
            'refresh_token' => JwtHelper::generateToken($refreshPayload),
            'data' => [
                'id_user'   => $user->id,
                'email'     => $user->email,
                'nama_lengkap' => $user->nama_lengkap,
                'level'     => $user->level == 1 ? 'Admin' : 'Staff',
            ]
        ]);
    }

    public function refreshToken(Request $request)
    {
        $request->validate([
            'refresh_token' => 'required'
        ]);

        try {
            $decoded = JwtHelper::decodeToken($request->refresh_token);

            $user = User::find($decoded->id_user);

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Refresh token tidak valid (user tidak ditemukan)'
                ], 401);
            }

            $payload = [
                'id_user' => $user->id,
                'email'   => $user->email,
                'level'   => $user->level == 1 ? 'Admin' : 'Staff',
                'iat'     => time(),
                'exp'     => time() + config('jwt.access_expire')
            ];

            return response()->json([
                'status' => true,
                'message' => 'Access token baru dibuat',
                'access_token' => JwtHelper::generateToken($payload),
                'refresh_token' => $request->refresh_token
            ]);

        } catch (\Firebase\JWT\ExpiredException $e) {
            return response()->json([
                'status' => false,
                'message'=> 'Refresh token expired, login ulang'
            ], 401);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message'=> 'Refresh token tidak valid: '.$e->getMessage()
            ], 401);
        }
    }

    public function profile(Request $request)
    {
        return response()->json([
            'status' => true,
            'message' => 'Data profil',
            'data' => $request->auth
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'password_new1' => 'required',
            'password_new2' => 'required|same:password_new1',
        ]);

        $user = User::find($request->auth->id_user);

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => false,
                'message' => 'Password lama salah'
            ]);
        }

        $user->update([
            'password' => Hash::make($request->password_new1)
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Password berhasil diperbarui, silakan login kembali'
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = User::find($request->auth->id_user);

       

        $user->update([
            'nik'          => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            //'email'        => $request->email,
            'no_hp'        => $request->no_hp,
            'jabatan'      => $request->jabatan,
            'instansi'     => $request->instansi,
            'alamat_user'  => $request->alamat,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Profil berhasil diperbarui',
            'data'    => $user
        ]);
    }




}
