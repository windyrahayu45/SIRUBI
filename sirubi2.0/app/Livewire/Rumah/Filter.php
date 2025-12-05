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

use Illuminate\Support\Facades\Hash;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Writer\XLSX\Writer;
use Symfony\Component\HttpFoundation\StreamedResponse;

use OpenSpout\Writer\Common\Creator\WriterEntityFactory;
use OpenSpout\Writer\Common\Creator\Style\StyleBuilder;
use OpenSpout\Writer\XLSX\Writer as XLSXWriter;

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

    public $status_umum = [];
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

    // public function exportExcel()
    // {
    //     try {
    //         ini_set('memory_limit', '4096M');
    //         ini_set('max_execution_time', '1800');

    //         $timestamp = now()->format('Ymd_His');
    //         $folder = "exports_$timestamp";
    //         $disk = 'public';

    //         $exportPath = storage_path("app/public/$folder");
    //         if (!file_exists($exportPath)) mkdir($exportPath, 0777, true);

    //         $files = [];
    //         $maxRows = 1000;

    //         $filteredQuery = $this->buildFilteredQuery();
        
    //         Log::info('📌 Export Excel - Filtered Query:', [
    //             'sql' => $filteredQuery->toSql(),
    //             'bindings' => $filteredQuery->getBindings(),
    //         ]);
            

    //         $total = $filteredQuery->count();
    //         $chunkCount = ceil($total / $maxRows);

    //         for ($i = 0; $i < $chunkCount; $i++) {
    //             $offset = $i * $maxRows;
    //             $filename = "data_rumah_" . ($i + 1) . ".xlsx";

    //             Excel::store(
    //                 new RumahExport($offset, $maxRows, $this->buildFilteredQuery()),
    //                 "$folder/$filename",
    //                 $disk
    //             );

    //             $files[] = storage_path("app/public/$folder/$filename");
    //         }

    //         // 💰 Ekspor Bantuan
    //         $bantuanFile = "data_bantuan.xlsx";
    //         Excel::store(
    //             new BantuanSheet($this->buildFilteredQuery()),
    //             "$folder/$bantuanFile",
    //             $disk
    //         );
    //         $files[] = storage_path("app/public/$folder/$bantuanFile");

    //         // 🗜️ Buat ZIP
    //          $zipFilename = "export_data_$timestamp.zip";
    //         $zipFile = storage_path("app/public/export_data_$timestamp.zip");
    //         $zip = new \ZipArchive();

    //         if ($zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE)) {
    //             foreach ($files as $f) {
    //                 if (file_exists($f)) $zip->addFile($f, basename($f));
    //             }
    //             $zip->close();
    //         }

    //         // 🧹 Hapus file sementara
    //         foreach ($files as $f) {
    //             if (file_exists($f)) @unlink($f);
    //         }
    //         if (is_dir($exportPath)) @rmdir($exportPath);

            

    //         // ✅ Kirim URL download ke JS
    //        // $url = asset('storage/export_data_' . $timestamp . '.zip');
    //         // $url = route('export.download', ['filename' => "export_data_$timestamp.zip"]);
    //         // Log::info('✅ Excel ZIP generated', ['url' => $url]);

    //         // $url = asset("storage/$zipFilename");
           
            
    //         $url = route('download.export', ['timestamp' => $timestamp]);
    //          Log::info('✅ Excel ZIP generated', [
    //             'url' => $url,
    //             'file_path' => $zipFile
    //         ]);
    //         //$this->dispatch('excel-ready', url: $url);
    //         $this->dispatch('geojson-ready', url: $url);
    //         // HAPUS ZIP FILE SETELAH URL DIKIRIM
    //         // register_shutdown_function(function () use ($zipFile) {
    //         //     if (file_exists($zipFile)) @unlink($zipFile);
    //         // });
    //     } catch (\Throwable $e) {
    //         Log::error('Export Excel gagal: ' . $e->getMessage());
    //         $this->dispatch('swal:error', [
    //             'title' => 'Export Gagal!',
    //             'text'  => $e->getMessage(),
    //         ]);
    //     }
    // }

    public function exportExcel()
    {
        // 1️⃣ Ambil semua ID rumah hasil filter (tidak ganggu fungsi lain)
        $filteredIds = $this->buildFilteredQuery()->pluck('id_rumah')->toArray();

        if (empty($filteredIds)) {
            throw new \Exception("Tidak ada data untuk diexport.");
        }

        // 2️⃣ Siapkan file
       $filename = 'rumah_filtered_' . date('Ymd_His') . '.xlsx';
        $filePath = storage_path('app/public/' . $filename);
        $writer = new XLSXWriter();
        $writer->openToFile($filePath);

        // ======================================================================
        // 📄 SHEET 1 – DATA RUMAH (JOIN BESAR)
        // ======================================================================
        $writer->getCurrentSheet()->setName("Data Rumah");

        $writer->addRow(Row::fromValues([
            'ID Rumah', 'Alamat', 'Kecamatan', 'Kelurahan', 'Status DTKS', 'Jumlah KK',
            'Jenis Kelamin', 'Usia', 'Pendidikan Terakhir', 'Pekerjaan Utama',
            'Besar Penghasilan/Bulan', 'Besar Pengeluaran/Bulan',
            'Status Kepemilikan Tanah', 'Bukti Kepemilikan Tanah', 'Status Kepemilikan Rumah',
            'Status IMB', 'Nomor IMB', 'Aset Rumah di Tempat Lain', 'Aset Tanah di Tempat Lain',
            'Jenis Kawasan Lokasi Rumah', 'NIK Pemilik Rumah', 'Tahun Pembangunan',

            'Pondasi', 'Jenis Pondasi', 'Kondisi Pondasi', 'Kondisi Sloof', 'Kondisi Kolom/Tiang',
            'Kondisi Balok', 'Kondisi Struktur Atap', 'Nilai Keselamatan (A)',

            'Jendela / Lubang Cahaya', 'Kondisi Jendela / Lubang Cahaya', 'Ventilasi',
            'Keterangan Ventilasi', 'Kondisi Ventilasi', 'Kamar Mandi', 'Kondisi Kamar Mandi',
            'Jamban', 'Kondisi Jamban', 'Sistem Pembuangan Air Kotor',
            'Kondisi Sistem Pembuangan Air Kotor', 'Sumber Air Minum',
            'Kondisi Sumber Air Minum', 'Sumber Listrik', 'Frekuensi Penyedotan', 'Nilai Kesehatan (B)',

            'Luas Rumah (m²)', 'Tinggi Rata-rata Rumah (m)', 'Jumlah Penghuni Laki-laki',
            'Jumlah Penghuni Perempuan', 'Jumlah ABK', 'Jumlah Kamar Tidur', 'Luas Rata Kamar Tidur',
            'Ruang Keluarga & Tidur', 'Jenis Fisik Bangunan', 'Fungsi Rumah',
            'Tipe Rumah', 'Jumlah Lantai Bangunan', 'Nilai Luas & Ruang (C)',

            'Material Atap Terluas', 'Kondisi Penutup Atap', 'Material Dinding Terluas',
            'Kondisi Dinding', 'Material Lantai Terluas', 'Kondisi Lantai',
            'Akses Langsung ke Jalan', 'Bangunan Menghadap Jalan', 'Bangunan Menghadap Sungai',
            'Bangunan di Atas Sempadan Sungai', 'Bangunan di Area Limbah/Sutet',

            'Nilai Total', 'Status Rumah', 'Status Luas Rumah', 'Backlog'
        ]));

        DB::table('rumah as r')
            ->whereIn('r.id_rumah', $filteredIds)
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
            ->leftJoin('c_tipe_rumah as tp', 'tp.id_tipe_rumah', '=', 'f.tipe_rumah_id')
            ->leftJoin('c_fungsi_rumah as fng', 'fng.id_fungsi_rumah', '=', 'f.fungsi_rumah_id')
            ->leftJoin('c_jenis_fisik_bangunan as jns', 'jns.id_jenis_fisik_bangunan', '=', 'f.jenis_fisik_bangunan_id')
            ->leftJoin('c_ruang_keluarga_dan_tidur as rng', 'rng.id_ruang_keluarga_dan_tidur', '=', 'f.ruang_keluarga_dan_ruang_tidur_id')
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
                r.id_rumah,
                r.alamat,
                kec.nama_kecamatan,
                kel.nama_kelurahan,
                sdt.status_dtks,
                jkk.jumlah_kk,
                jk.jenis_kelamin,
                se.usia,
                pt.pendidikan_terakhir,
                pu.pekerjaan_utama,
                bpi.besar_penghasilan,
                bpe.besar_pengeluaran,

                skt.status_kepemilikan_tanah,
                bkt.bukti_kepemilikan_tanah,
                skr.status_kepemilikan_rumah,
                sim.status_imb,
                k.nomor_imb,
                ar.aset_rumah_tempat_lain,
                at.aset_tanah_tempat_lain,
                jkl.jenis_kawasan_lokasi,
                k.nik_kepemilikan_rumah,
                r.tahun_pembangunan_rumah,

                p.pondasi,
                jp.nama_jenis_pondasi,
                kp.kondisi_pondasi,
                ks.kondisi_sloof,
                kkt.kondisi_kolom_tiang,
                kb.kondisi_balok,
                ksa.kondisi_struktur_atap,
                pr.nilai_a,

                jl.jendela_lubang_cahaya,
                kjl.kondisi_jendela_lubang_cahaya,
                v.ventilasi,
                sn.keterangan_ventilasi,
                kv.kondisi_ventilasi,
                km.kamar_mandi,
                kkm.kondisi_kamar_mandi,
                j.jamban,
                kj.kondisi_jamban,
                spak.sistem_pembuangan_air_kotor,
                kspak.kondisi_sistem_pembuangan_air_kotor,
                sam.sumber_air_minum,
                ksam.kondisi_sumber_air_minum,
                sl.sumber_listrik,
                fps.frekuensi_penyedotan,
                pr.nilai_b,

                f.luas_rumah,
                f.tinggi_rata_rumah,
                f.jumlah_penghuni_laki,
                f.jumlah_penghuni_perempuan,
                f.jumlah_abk,
                f.jumlah_kamar_tidur,
                f.luas_rata_kamar_tidur,
                rng.ruang_keluarga_dan_tidur,
                jns.jenis_fisik_bangunan,
                fng.fungsi_rumah,
                tp.tipe_rumah,
                f.jumlah_lantai_bangunan,
                pr.nilai_c,

                mat.material_atap_terluas,
                kpa.kondisi_penutup_atap,
                mdt.material_dinding_terluas,
                kd.kondisi_dinding,
                mlt.material_lantai_terluas,
                kl.kondisi_lantai,
                akj.akses_ke_jalan,
                bmj.bangunan_menghadap_jalan,
                bms.bangunan_menghadap_sungai,
                bbs.bangunan_berada_sungai,
                bbl.bangunan_berada_limbah,

                pr.nilai,
                pr.status_rumah,
                CASE WHEN pr.status_luas = 1 THEN 'Cukup' ELSE 'Kurang' END AS status_luas,
                CASE WHEN jkk.jumlah_kk > 1 THEN 'BACKLOG' ELSE 'TIDAK BACKLOG' END AS backlog
            ")

            ->orderBy('r.id_rumah')
            ->chunk(1000, function ($rows) use ($writer) {
                foreach ($rows as $row) {
                    $writer->addRow(Row::fromValues((array)$row));
                }
            });

        // ======================================================================
        // 📄 SHEET 2 – DATA KEPALA KELUARGA
        // ======================================================================
        $writer->addNewSheetAndMakeItCurrent()->setName("Data KK & Anggota");

        $writer->addRow(Row::fromValues([
            'No', 'ID Rumah', 'No KK', 'NIK', 'Nama Lengkap'
        ]));

        $no = 1;

        DB::table('kepala_keluarga as kk')
            ->whereIn('kk.rumah_id', $filteredIds)
            ->leftJoin('anggota_keluarga as ak', 'ak.kepala_keluarga_id', '=', 'kk.id')
            ->select('kk.no_kk','kk.rumah_id','ak.nik','ak.nama')
            ->orderBy('kk.id')
            ->chunk(1000, function ($rows) use ($writer, &$no) {

                foreach ($rows as $row) {

                    $noKK = $row->no_kk ?? '-';
                    if (stripos($noKK, 'DUMMY') !== false) {
                        $noKK = '-';
                    }

                    $writer->addRow(Row::fromValues([
                        $no++,
                        $row->rumah_id ?? '-',
                        $noKK,
                        $row->nik ?? '-',
                        $row->nama ?? '-',
                    ]));
                }
            });

        // ======================================================================
        // 📄 SHEET 3 – DATA BANTUAN + RIWAYAT KK
        // ======================================================================
        $writer->addNewSheetAndMakeItCurrent()->setName("Data Bantuan");

        $writer->addRow(Row::fromValues([
            'Tipe Data','ID Rumah','Alamat','Kecamatan','Kelurahan',
            'No KK Penerima','Nama Program Bantuan','Nama Bantuan','Tahun Bantuan',
            'Nominal Bantuan (Rp)','Pernah Mendapatkan Bantuan'
        ]));

        DB::table('rumah as r')
            ->whereIn('r.id_rumah', $filteredIds)
            ->leftJoin('bantuan_rumah as br', 'br.rumah_id', '=', 'r.id_rumah')
            ->leftJoin('i_kelurahan as kel', 'kel.id_kelurahan', '=', 'r.kelurahan_id')
            ->leftJoin('i_kecamatan as kec', 'kec.id_kecamatan', '=', 'kel.kecamatan_id')
            ->orderBy('r.id_rumah')

            ->select(
                'r.id_rumah','r.alamat',
                'kec.nama_kecamatan','kel.nama_kelurahan',
                'br.no_kk_penerima','br.nama_program_bantuan',
                'br.nama_bantuan','br.tahun_bantuan','br.nominal_bantuan'
            )

            ->chunk(500, function ($rows) use ($writer) {

                foreach ($rows as $row) {

                    $writer->addRow(row::fromValues([
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

                    // Tambahkan RIWAYAT KK
                    $riwayat = DB::table('tbl_bantuan')
                        ->where('kk', $row->no_kk_penerima)
                        ->orderBy('tahun','desc')
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

        // FINAL
        $writer->close();
        // $url = asset('storage/' . $filename);
        $url = route('geojson.download', ['filename' => $filename]);
        //  Emit event ke Alpine/JS agar download otomatis
        $this->dispatch('geojson-ready', url: $url);

        return $url;
        //return response()->download($filePath)->deleteFileAfterSend();
    }



    // private function buildFilteredQuery()
    // {
    //     $query = Rumah::with([
    //         'kepemilikan', 'sosialEkonomi', 'fisik', 'sanitasi', 'penilaian',
    //         'dokumen', 'bantuan', 'kepalaKeluarga.anggota', 'kelurahan.kecamatan'
    //     ])->orderBy('id_rumah', 'desc');

    //     // 🧩 Filter Lokasi
    //     if (!empty($this->kecamatan_id)) {
    //         $query->whereHas('kelurahan.kecamatan', fn($q) =>
    //             $q->whereIn('id_kecamatan', $this->kecamatan_id)
    //         );
    //     }
    //     if (!empty($this->kelurahan_id)) {
    //         $query->whereIn('kelurahan_id', $this->kelurahan_id);
    //     }

    //     // 🧩 Filter Kepemilikan
    //     $kepemilikanFields = [
    //         'status_kepemilikan_tanah_id', 'bukti_kepemilikan_tanah_id',
    //         'status_kepemilikan_rumah_id', 'status_imb_id',
    //         'aset_rumah_ditempat_lain_id', 'aset_tanah_ditempat_lain_id',
    //         'jenis_kawasan_lokasi_rumah_id'
    //     ];
    //     foreach ($kepemilikanFields as $field) {
    //         if (!empty($this->$field)) {
    //             $query->whereHas('kepemilikan', fn($q) =>
    //                 $q->whereIn($field, (array)$this->$field)
    //             );
    //         }
    //     }

    //     // 🧩 Filter Fisik
    //     $fisikFields = [
    //         'pondasi_id','jenis_pondasi_id','kondisi_pondasi_id','kondisi_sloof_id',
    //         'kondisi_kolom_tiang_id','kondisi_balok_id','kondisi_struktur_atap_id',
    //         'material_atap_terluas_id','kondisi_penutup_atap_id','material_dinding_terluas_id',
    //         'kondisi_dinding_id','material_lantai_terluas_id','kondisi_lantai_id',
    //         'akses_ke_jalan_id','bangunan_menghadap_jalan_id','bangunan_menghadap_sungai_id',
    //         'bangunan_berada_limbah_id','bangunan_berada_sungai_id','ruang_keluarga_dan_tidur_id',
    //         'jenis_fisik_bangunan_id','fungsi_rumah_id','tipe_rumah_id'
    //     ];
    //     foreach ($fisikFields as $field) {
    //         if (!empty($this->$field)) {
    //             $query->whereHas('fisik', fn($q) =>
    //                 $q->whereIn($field, (array)$this->$field)
    //             );
    //         }
    //     }

    //     // 🧩 Filter Sanitasi
    //     $sanitasiFields = [
    //         'jendela_lubang_cahaya_id','kondisi_jendela_lubang_cahaya_id',
    //         'ventilasi_id','kondisi_ventilasi_id','kamar_mandi_id','kondisi_kamar_mandi_id',
    //         'jamban_id','kondisi_jamban_id','sistem_pembuangan_air_kotor_id',
    //         'kondisi_sistem_pembuangan_air_kotor_id','frekuensi_penyedotan_id',
    //         'sumber_air_minum_id','kondisi_sumber_air_minum_id','sumber_listrik_id'
    //     ];
    //     foreach ($sanitasiFields as $field) {
    //         if (!empty($this->$field)) {
    //             $query->whereHas('sanitasi', fn($q) =>
    //                 $q->whereIn($field, (array)$this->$field)
    //             );
    //         }
    //     }

    //     // 🧩 Filter Sosial Ekonomi
    //     if (!empty($this->jumlah_kk_id)) {
    //         $query->whereHas('sosialEkonomi', fn($q) =>
    //             $q->whereIn('jumlah_kk_id', $this->jumlah_kk_id)
    //         );
    //     }
    //     if (!empty($this->status_dtks_id)) {
    //         $query->whereHas('sosialEkonomi', fn($q) =>
    //             $q->whereIn('status_dtks_id', $this->status_dtks_id)
    //         );
    //     }

    //     // 🧩 Filter Bantuan
    //     if (!empty($this->pernah_mendapatkan_bantuan_id)) {
    //         $query->whereHas('bantuan', fn($q) =>
    //             $q->whereIn('pernah_mendapatkan_bantuan_id', $this->pernah_mendapatkan_bantuan_id)
    //         );
    //     }

    //     $status = $this->filteredData['status_umum'] ?? null;

    //      if ($status) {

    //         if($status == 'rlh') {
    //             $query->whereHas('penilaian', fn($q) =>
    //                 $q->where('status_rumah', 'RLH')
    //             );
    //         }
    //         elseif($status == 'rtlh') {
    //             $query->whereHas('penilaian', fn($q) =>
    //                 $q->where('status_rumah',  'RTLH')
    //             );
    //         }
    //         elseif($status == 'rtlh_non_sewa') {
    //             $query->whereHas('penilaian', fn($q) =>
    //                 $q->where('status_rumah', 'RTLH')
    //             );
    //             $query->whereHas('kepemilikan', fn($q) =>
    //                 $q->where('status_kepemilikan_rumah_id', '1')
    //             );
    //         }

    //          elseif($status == 'rtlh_sewa') {
    //             $query->whereHas('penilaian', fn($q) =>
    //                 $q->where('status_rumah', 'RTLH')
    //             );
    //             $query->whereHas('kepemilikan', fn($q) =>
    //                 $q->where('status_kepemilikan_rumah_id', '2')
    //                  ->orWhere('status_kepemilikan_rumah_id', '3')
    //             );
    //         }
    //         elseif($status == 'laki') {
    //             $query->whereHas('fisik', fn($q) =>
    //                 $q->where('jumlah_penghuni_laki', '!=', '')
    //             );
    //         }
    //         elseif($status == 'perempuan') {
    //             $query->whereHas('fisik', fn($q) =>
    //                 $q->where('jumlah_penghuni_perempuan', '!=', '')
    //             );
    //         }
    //         elseif($status == 'abk') {
    //             $query->whereHas('fisik', fn($q) =>
    //                 $q->where('jumlah_abk', '!=', '')
    //             );
    //         }
    //         elseif($status == 'dtks') {
    //              $query->whereHas('sosialEkonomi', fn($q) =>
    //                 $q->where('status_dtks_id', '1')
    //             );
    //         }
    //         elseif($status == 'imb') {
    //              $query->whereHas('kepemilikan', fn($q) =>
    //                 $q->where('status_imb_id', '1')
    //             );
    //         }
    //         elseif($status == 'non_imb') {
    //              $query->whereHas('kepemilikan', fn($q) =>
    //                 $q->where('status_imb_id', '2')
    //             );
    //         }
    //         elseif($status == 'backlog') {
    //              $query->whereHas('sosialEkonomi', fn($q) =>
    //                 $q->where('jumlah_kk_id', '>','1')
    //             );
    //         }
    //         elseif($status == 'bencana') {
    //              $query->whereHas('kepemilikan', fn($q) =>
    //                 $q->where('jenis_kawasan_lokasi_rumah_id','6')
    //             );
    //         }
    //         elseif($status == 'non_permukiman') {
    //              $query->whereHas('kepemilikan', fn($q) =>
    //                 $q->where('jenis_kawasan_lokasi_rumah_id','7')
    //             );
    //         }
           
    //     }

    //     // 🧩 Filter Prioritas
    //     if (!empty($this->prioritas)) {
    //         $p = $this->prioritas;
    //         $query->whereHas('penilaian', function ($q) use ($p) {
    //             if ($p == '1') $q->where('prioritas_a', '2');
    //             if ($p == '2') $q->where('prioritas_b', '2');
    //             if ($p == '3') $q->where('prioritas_c', '2');
    //         });
    //     }

    //     return $query;
    // }

    private function buildFilteredQuery()
    {
        $query = Rumah::query()->with([
            'kepemilikan', 'sosialEkonomi', 'fisik', 'sanitasi', 'penilaian',
            'dokumen', 'bantuan', 'kepalaKeluarga.anggota', 'kelurahan.kecamatan'
        ]);

        // ---------------------------
        // FILTER LOKASI
        // ---------------------------
        if (!empty($this->kecamatan_id)) {
            $query->whereHas('kelurahan.kecamatan', fn($q) =>
                $q->whereIn('id_kecamatan', $this->kecamatan_id)
            );
        }

        if (!empty($this->kelurahan_id)) {
            $query->whereIn('kelurahan_id', $this->kelurahan_id);
        }

        // ---------------------------
        // FILTER KEPEMILIKAN
        // ---------------------------
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

        // ---------------------------
        // FILTER FISIK
        // ---------------------------
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

        // ---------------------------
        // FILTER SANITASI
        // ---------------------------
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

        // ---------------------------
        // FILTER SOSIAL EKONOMI
        // ---------------------------
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

        // ---------------------------
        // FILTER BANTUAN
        // ---------------------------
        if (!empty($this->pernah_mendapatkan_bantuan_id)) {
            $query->whereHas('bantuan', fn($q) =>
                $q->whereIn('pernah_mendapatkan_bantuan_id', $this->pernah_mendapatkan_bantuan_id)
            );
        }

        // ---------------------------
        // FILTER STATUS KHUSUS
        // ---------------------------
        $status = $this->filteredData['status_umum'] ?? null;

        if ($status) {
            if ($status === 'rlh') {
                $query->whereHas('penilaian', fn($q) => $q->where('status_rumah', 'RLH'));
            }
            elseif ($status === 'rtlh') {
                $query->whereHas('penilaian', fn($q) => $q->where('status_rumah', 'RTLH'));
            }
            elseif ($status === 'rtlh_non_sewa') {
                $query->whereHas('penilaian', fn($q) => $q->where('status_rumah', 'RTLH'));
                $query->whereHas('kepemilikan', fn($q) => $q->where('status_kepemilikan_rumah_id', '1'));
            }
            elseif ($status === 'rtlh_sewa') {
                $query->whereHas('penilaian', fn($q) => $q->where('status_rumah', 'RTLH'));
                $query->whereHas('kepemilikan', fn($q) =>
                    $q->whereIn('status_kepemilikan_rumah_id', ['2','3'])
                );
            }
            elseif ($status === 'laki') {
                $query->whereHas('fisik', fn($q) => $q->where('jumlah_penghuni_laki', '!=', ''));
            }
            elseif ($status === 'perempuan') {
                $query->whereHas('fisik', fn($q) => $q->where('jumlah_penghuni_perempuan', '!=', ''));
            }
            elseif ($status === 'abk') {
                $query->whereHas('fisik', fn($q) => $q->where('jumlah_abk', '!=', ''));
            }
            elseif ($status === 'dtks') {
                $query->whereHas('sosialEkonomi', fn($q) => $q->where('status_dtks_id', '1'));
            }
            elseif ($status === 'imb') {
                $query->whereHas('kepemilikan', fn($q) => $q->where('status_imb_id', '1'));
            }
            elseif ($status === 'non_imb') {
                $query->whereHas('kepemilikan', fn($q) => $q->where('status_imb_id', '2'));
            }
            elseif ($status === 'backlog') {
                $query->whereHas('sosialEkonomi', fn($q) => $q->where('jumlah_kk_id', '>', '1'));
            }
            elseif ($status === 'bencana') {
                $query->whereHas('kepemilikan', fn($q) => $q->where('jenis_kawasan_lokasi_rumah_id','6'));
            }
            elseif ($status === 'non_permukiman') {
                $query->whereHas('kepemilikan', fn($q) => $q->where('jenis_kawasan_lokasi_rumah_id','7'));
            }
        }

        // ---------------------------
        // FILTER PRIORITAS
        // ---------------------------
        if (!empty($this->prioritas)) {
            $query->whereHas('penilaian', function ($q) {
                if ($this->prioritas == '1') $q->where('prioritas_a', '2');
                if ($this->prioritas == '2') $q->where('prioritas_b', '2');
                if ($this->prioritas == '3') $q->where('prioritas_c', '2');
            });
        }

        // ❗❗ RETURN HANYA ARRAY id_rumah — supaya Spout EXPORT bisa Query Builder
        return $query;
    }


    private function getFilteredIds()
    {
        return $this->buildFilteredQuery()
            ->pluck('id_rumah')
            ->toArray();
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
