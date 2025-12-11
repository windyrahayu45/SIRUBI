<?php

namespace App\Livewire;

use App\Exports\BantuanSheet;
use App\Exports\KepalaKeluargaSheet;
use App\Exports\RumahExport;
use App\Exports\RumahSheet;
use App\Jobs\ExportRumahJob;
use App\Jobs\ProcessCompleteExportJob;
use App\Models\Rumah;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use ZipArchive;


use Illuminate\Support\Facades\Hash;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Writer\XLSX\Writer;
use Symfony\Component\HttpFoundation\StreamedResponse;

use OpenSpout\Writer\Common\Creator\WriterEntityFactory;
use OpenSpout\Writer\Common\Creator\Style\StyleBuilder;
use OpenSpout\Writer\XLSX\Writer as XLSXWriter;

class Data extends Component
{
    protected $listeners = ['refreshTable' => '$refresh', 'loadDetailRumah','deleteRumah','checkExportProgress','check-file-ready' => 'checkFile'];
    
    public $exportFormat = '';

    public $exporting = false;
    public $exportProgress = 0;
    public $exportMessage = '';
    public $exportCompleted = false;
   
    public $timestamp = '';
    public $queueId = '';
    public $isProcessing = false;
    public $downloadUrl = null;
    public $jobFile = null;
    public $isExporting = false;

   
    public function exportData()
    {
          $this->isExporting = true;
        if (empty($this->exportFormat)) {
            $this->dispatch('swal:error', [
                'title' => 'Format belum dipilih!',
                'text'  => 'Silakan pilih format export terlebih dahulu.',
            ]);
            return;
        }

        if ($this->exportFormat === 'excel') {
             $this->isExporting = false;
            return $this->exportExcel();
        }

        if ($this->exportFormat === 'geojson') {
            return $this->exportGeoJson();
        }

         
    }

    
    public function exportExcel()
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
            // 'ID Rumah','Alamat','Kelurahan','Kecamatan',
            // 'Usia','Jenis Kelamin','Pendidikan','Pekerjaan','Penghasilan','Pengeluaran',
            // 'Status DTKS','Jumlah KK',
            // 'Status Kep Tanah','Bukti Tanah','Status Rumah','IMB','Aset Rumah TL','Aset Tanah TL','Jenis Kawasan',
            // 'Pondasi','Jenis Pondasi','Kondisi Pondasi','Kondisi Sloof','Kondisi Kolom','Kondisi Balok',
            // 'Kondisi Atap','Mat Atap','Kondisi Penutup Atap','Mat Dinding','Kondisi Dinding',
            // 'Material Lantai','Kondisi Lantai','Akses Jalan','Menghadap Jalan','Menghadap Sungai',
            // 'Berada Sungai','Berada Limbah',
            // 'Jendela','Kondisi Jendela','Ventilasi','Kondisi Ventilasi',
            // 'Kamar Mandi','Kondisi KM','Jamban','Kondisi Jamban',
            // 'SPAK','Kondisi SAM','Sumber Listrik','Frekuensi Penyedotan',
            // 'Nilai A','Nilai B','Nilai C','Nilai','Status Rumah','Status Luas'
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
                f.tinggi_rata_rumah ,
                f.jumlah_penghuni_laki,
                f.jumlah_penghuni_perempuan,
                f.jumlah_abk,
                f.jumlah_kamar_tidur,
                f.luas_rata_kamar_tidur,
                rng.ruang_keluarga_dan_tidur ,
                jns.jenis_fisik_bangunan,
                fng.fungsi_rumah ,
                tp.tipe_rumah,
                f.jumlah_lantai_bangunan ,
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
                 CASE 
                    WHEN pr.status_luas = 1 THEN 'Cukup'
                    ELSE 'Kurang'
                END AS status_luas,
                CASE 
                    WHEN jkk.jumlah_kk > 1 THEN 'BACKLOG'
                    ELSE 'TIDAK BACKLOG'
                END AS backlog
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

    
    // public function exportExcel()
    // {
    //     try {
    //         ini_set('memory_limit', '4096M');
    //         ini_set('max_execution_time', '1800');

    //         $timestamp = now()->format('Ymd_His');
    //         $folder = "exports_$timestamp";
    //         $disk = 'public'; // gunakan disk Laravel agar lebih aman

    //         // Buat folder public/storage/exports_20251109_1900/
    //         $exportPath = storage_path("app/public/$folder");
    //         if (!file_exists($exportPath)) mkdir($exportPath, 0777, true);

    //         $files = [];
    //         $maxRows = 1000;

    //         // 🏠 1️⃣ Ekspor Rumah & KK (chunked)
    //         $total = DB::table('rumah')->count();
    //         $chunkCount = ceil($total / $maxRows);

    //         for ($i = 0; $i < $chunkCount; $i++) {
    //             $offset = $i * $maxRows;
    //             $filename = "data_rumah_" . ($i + 1) . ".xlsx";

    //             // Simpan file ke disk public
    //             Excel::store(
    //                 new RumahExport($offset, $maxRows),
    //                 "$folder/$filename",
    //                 $disk
    //             );

    //             // Ambil path absolut setelah tersimpan
    //             $files[] = storage_path("app/public/$folder/$filename");
    //         }

    //         // 💰 2️⃣ Ekspor Bantuan
    //         $bantuanFile = "data_bantuan.xlsx";
    //         Excel::store(
    //             new BantuanSheet(),
    //             "$folder/$bantuanFile",
    //             $disk
    //         );
    //         $files[] = storage_path("app/public/$folder/$bantuanFile");

    //         // 🗜️ 3️⃣ Buat ZIP
    //         $zipFile = storage_path("app/public/export_data_$timestamp.zip");
    //         $zip = new \ZipArchive();

    //         if ($zip->open($zipFile, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
    //             foreach ($files as $f) {
    //                 if (file_exists($f)) {
    //                     $zip->addFile($f, basename($f));
    //                 } else {
    //                     Log::warning("⚠️ File tidak ditemukan: $f");
    //                 }
    //             }
    //             $zip->close();
    //         } else {
    //             throw new \Exception("Gagal membuat ZIP file di: $zipFile");
    //         }

    //         // 🧹 4️⃣ Bersihkan file sementara
    //         foreach ($files as $f) {
    //             if (file_exists($f)) @unlink($f);
    //         }
    //         if (is_dir($exportPath)) @rmdir($exportPath);

    //         // 🚀 5️⃣ Download ZIP
    //         return response()->download($zipFile)->deleteFileAfterSend(true);

    //     } catch (\Throwable $e) {
    //         dd($e->getMessage(), $e->getFile(), $e->getLine());
    //     }
    // }

    // public function exportExcel()
    // {
    //     try {
    //         // 🔥 OPTIMAL UNTUK PRODUCTION
    //         ini_set('memory_limit', '2048M'); // Jangan -1, beri batas reasonable
    //         ini_set('max_execution_time', 1800); // 30 menit
    //         ini_set('max_input_time', 1800);
            
    //         // Untuk NGINX/Apache timeout
    //         if (function_exists('apache_setenv')) {
    //             apache_setenv('no-gzip', '1');
    //         }

    //         $timestamp = now()->format('Ymd_His');
    //         $folder = "exports_$timestamp";
    //         $disk = 'public';

    //         Log::info("🚀 Starting PRODUCTION export - Folder: {$folder}");

    //         // Buat folder temporary
    //         $exportPath = storage_path("app/public/$folder");
    //         if (!file_exists($exportPath)) {
    //             mkdir($exportPath, 0777, true);
    //         }

    //         $files = [];
    //         $maxRows = 50; // 🔥 KECILKAN DRASTIS untuk production
    //         $filesPerZip = 2;

    //         // 🏠 Ekspor Rumah dengan 2 Sheet - DIPISAH
    //         $total = DB::table('rumah')->count();
    //         $chunkCount = ceil($total / $maxRows);

    //         Log::info("📊 Production - Total: {$total}, Chunks: {$chunkCount}, MaxRows: {$maxRows}");

    //         $zipCounter = 1;
    //         $currentZipFiles = [];

    //         for ($i = 0; $i < $chunkCount; $i++) {
    //             $offset = $i * $maxRows;
                
    //             // 🔄 BUAT 2 FILE TERPISAH dengan nama berbeda
    //             $rumahFilename = "rumah_part_" . ($i + 1) . ".xlsx";
    //             $kkFilename = "kk_part_" . ($i + 1) . ".xlsx";

    //             Log::info("🔄 Processing chunk {$i}/{$chunkCount} - Offset: {$offset}");

    //             // 🔹 1. Export Sheet Rumah DULU
    //             Log::info("📝 Exporting RumahSheet...");
    //             try {
    //                 Excel::store(
    //                     new RumahSheet($offset, $maxRows),
    //                     "$folder/$rumahFilename",
    //                     $disk
    //                 );
    //                 Log::info("✅ RumahSheet exported: {$rumahFilename}");
    //             } catch (\Exception $e) {
    //                 Log::error("❌ RumahSheet export failed: " . $e->getMessage());
    //                 continue; // Skip ke chunk berikutnya
    //             }

    //             // 🔥 BERI JEDA LEBIH LAMA untuk production
    //             sleep(3);
    //             gc_collect_cycles();
                
    //             Log::info("💾 Memory after RumahSheet: " . round(memory_get_usage(true) / 1024 / 1024, 2) . " MB");

    //             // 🔹 2. Export Sheet KK SETELAHNYA  
    //             Log::info("👨‍👩‍👧‍👦 Exporting KepalaKeluargaSheet...");
    //             try {
    //                 Excel::store(
    //                     new KepalaKeluargaSheet($offset, $maxRows),
    //                     "$folder/$kkFilename",
    //                     $disk
    //                 );
    //                 Log::info("✅ KepalaKeluargaSheet exported: {$kkFilename}");
    //             } catch (\Exception $e) {
    //                 Log::error("❌ KepalaKeluargaSheet export failed: " . $e->getMessage());
    //                 // Tetap lanjut, tapi log error
    //             }

    //             $rumahPath = storage_path("app/public/$folder/$rumahFilename");
    //             $kkPath = storage_path("app/public/$folder/$kkFilename");
                
    //             if (file_exists($rumahPath)) {
    //                 $currentZipFiles[] = $rumahPath;
    //                 $files[] = $rumahPath;
    //             }
    //             if (file_exists($kkPath)) {
    //                 $currentZipFiles[] = $kkPath;
    //                 $files[] = $kkPath;
    //             }

    //             // Buat ZIP setiap filesPerZip file
    //             if (count($currentZipFiles) >= $filesPerZip * 2 || $i === $chunkCount - 1) {
    //                 $zipFilename = "batch_{$zipCounter}_{$timestamp}.zip";
    //                 $zipPath = storage_path("app/public/$folder/$zipFilename");
                    
    //                 if ($this->createZipFile($currentZipFiles, $zipPath)) {
    //                     Log::info("📦 ZIP created: {$zipFilename} with " . count($currentZipFiles) . " files");
    //                 } else {
    //                     Log::error("❌ ZIP creation failed: {$zipFilename}");
    //                 }
                    
    //                 // Reset untuk batch berikutnya
    //                 $currentZipFiles = [];
    //                 $zipCounter++;
                    
    //                 // 🔥 JEDA LEBIH LAMA di production
    //                 sleep(5);
    //                 gc_collect_cycles();
                    
    //                 Log::info("💾 Memory after ZIP: " . round(memory_get_usage(true) / 1024 / 1024, 2) . " MB");
    //             }
                
    //             // Progress logging
    //             if ($i % 5 === 0) {
    //                 $progress = round(($i / $chunkCount) * 100, 2);
    //                 Log::info("📈 Export progress: {$progress}%");
    //             }
    //         }

    //         // 🗜️ Buat ZIP Final
    //         Log::info("🎯 Creating final ZIP...");
    //         $finalZipFile = storage_path("app/public/export_complete_{$timestamp}.zip");
            
    //         if ($this->createZipFile($files, $finalZipFile)) {
    //             Log::info("🎉 Final ZIP created: {$finalZipFile}");
                
    //             // 🧹 Cleanup
    //             Log::info("🧹 Cleaning up temporary files...");
    //             foreach ($files as $f) {
    //                 if (file_exists($f) && !str_contains($f, 'batch_')) {
    //                     @unlink($f);
    //                 }
    //             }
                
    //             // Hapus folder temporary
    //             Storage::disk($disk)->deleteDirectory($folder);

    //             Log::info("✅ Export completed successfully!");

    //             // 🚀 Download ZIP Final
    //             return response()->download($finalZipFile)
    //                 ->deleteFileAfterSend(true)
    //                 ->setHeaders([
    //                     'Content-Type' => 'application/zip',
    //                     'Content-Disposition' => 'attachment; filename="export_data_' . $timestamp . '.zip"',
    //                 ]);
                    
    //         } else {
    //             throw new \Exception("Failed to create final ZIP file");
    //         }

    //     } catch (\Throwable $e) {
    //         Log::error('💥 PRODUCTION Export Error: ' . $e->getMessage(), [
    //             'file' => $e->getFile(),
    //             'line' => $e->getLine(),
    //             'trace' => $e->getTraceAsString()
    //         ]);
            
    //         return response()->json([
    //             'error' => 'Export gagal di production: ' . $e->getMessage()
    //         ], 500);
    //     }
    // }

    // /**
    //  * Helper untuk membuat file ZIP
    //  */
    // private function createZipFile(array $files, string $zipPath): bool
    // {
    //     $zip = new \ZipArchive();
        
    //     if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === true) {
    //         foreach ($files as $file) {
    //             if (file_exists($file)) {
    //                 $zip->addFile($file, basename($file));
    //             }
    //         }
    //         $zip->close();
    //         return true;
    //     }
        
    //     return false;
    // }

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

    //         $filteredQuery =  DB::table('rumah');
        
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
    //                 new RumahExport($offset, $maxRows),
    //                 "$folder/$filename",
    //                 $disk
    //             );

    //             $files[] = storage_path("app/public/$folder/$filename");
    //         }

    //         // 💰 Ekspor Bantuan
    //         $bantuanFile = "data_bantuan.xlsx";
    //         Excel::store(
    //             new BantuanSheet(),
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

  
  

 


    public function checkFile()
{
        if (storage_path("app/public/{$this->jobFile}") && file_exists(storage_path("app/public/{$this->jobFile}"))) {
            $this->downloadUrl = asset("storage/{$this->jobFile}");
            $this->isProcessing = false;
              $this->dispatch('export-finished');
        }
    }

    public function refreshState()
{
    // Digunakan JS untuk update state Livewire 3
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
         $this->isExporting = false;
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

  

    public function getData()
    {
         $request = request();

        $query = Rumah::with([
            'kepemilikan',
            'sosialEkonomi',
            'fisik',
            'sanitasi',
            'penilaian',
            'dokumen',
            'bantuan',
            'kepalaKeluarga.anggota',
            'kelurahan.kecamatan',
        ])->orderBy('id_rumah', 'desc');

        // ================================
        // 🧩 1️⃣ FILTER LOKASI LANGSUNG DI RUMAH
        // ================================
        if ($request->filled('kecamatan_id')) {
            $query->whereHas('kelurahan.kecamatan', fn($q) =>
                $q->whereIn('id_kecamatan', (array)$request->get('kecamatan_id'))
            );
        }

        if ($request->filled('kelurahan_id')) {
            $query->whereIn('kelurahan_id', (array)$request->get('kelurahan_id'));
        }

        // ================================
        // 🧩 2️⃣ FILTER KEPEMILIKAN
        // ================================
        $kepemilikanFields = [
            'status_kepemilikan_tanah_id', 'bukti_kepemilikan_tanah_id',
            'status_kepemilikan_rumah_id', 'status_imb_id',
            'aset_rumah_ditempat_lain_id', 'aset_tanah_ditempat_lain_id',
            'jenis_kawasan_lokasi_rumah_id'
        ];

        foreach ($kepemilikanFields as $field) {
            if ($request->filled($field)) {
                $query->whereHas('kepemilikan', fn($q) =>
                    $q->whereIn($field, (array)$request->get($field))
                );
            }
        }

        // ================================
        // 🧩 3️⃣ FILTER FISIK RUMAH
        // ================================
        $fisikFields = [
            'pondasi_id', 'jenis_pondasi', 'kondisi_pondasi_id',
            'kondisi_sloof_id', 'kondisi_kolom_tiang_id', 'kondisi_balok_id',
            'kondisi_struktur_atap_id', 'material_atap_terluas_id',
            'kondisi_penutup_atap_id', 'material_dinding_terluas_id',
            'kondisi_dinding_id', 'material_lantai_terluas_id',
            'kondisi_lantai_id', 'akses_ke_jalan_id', 'bangunan_menghadap_jalan_id',
            'bangunan_menghadap_sungai_id', 'bangunan_berada_limbah_id',
            'bangunan_berada_sungai_id', 'ruang_keluarga_dan_ruang_tidur_id',
            'jenis_fisik_bangunan_id', 'fungsi_rumah_id', 'tipe_rumah_id'
        ];

        foreach ($fisikFields as $field) {
            if ($request->filled($field)) {
                $query->whereHas('fisik', fn($q) =>
                    $q->whereIn($field, (array)$request->get($field))
                );
            }
        }

        // ================================
        // 🧩 4️⃣ FILTER SANITASI
        // ================================
        $sanitasiFields = [
            'jendela_lubang_cahaya_id', 'kondisi_jendela_lubang_cahaya_id',
            'ventilasi_id', 'kondisi_ventilasi_id', 'kamar_mandi_id',
            'kondisi_kamar_mandi_id', 'jamban_id', 'kondisi_jamban_id',
            'sistem_pembuangan_air_kotor_id', 'kondisi_sistem_pembuangan_air_kotor_id',
            'frekuensi_penyedotan_id', 'sumber_air_minum_id',
            'kondisi_sumber_air_minum_id', 'sumber_listrik_id'
        ];

        foreach ($sanitasiFields as $field) {
            if ($request->filled($field)) {
                $query->whereHas('sanitasi', fn($q) =>
                    $q->whereIn($field, (array)$request->get($field))
                );
            }
        }

        // ================================
        // 🧩 5️⃣ FILTER SOSIAL EKONOMI
        // ================================
        if ($request->filled('jumlah_kk_id')) {
            $query->whereHas('sosialEkonomi', fn($q) =>
                $q->whereIn('jumlah_kk_id', (array)$request->get('jumlah_kk_id'))
            );
        }

        if ($request->filled('status_dtks_id')) {
            $query->whereHas('sosialEkonomi', fn($q) =>
                $q->whereIn('status_dtks_id', (array)$request->get('status_dtks_id'))
            );
        }

        // ================================
        // 🧩 6️⃣ FILTER BANTUAN
        // ================================
        if ($request->filled('pernah_mendapatkan_bantuan_id')) {
            $query->whereHas('bantuan', fn($q) =>
                $q->whereIn('pernah_mendapatkan_bantuan_id', (array)$request->get('pernah_mendapatkan_bantuan_id'))
            );
        }

        if ($request->filled('status_umum')) {
            $status_umum = $request->get('status_umum');
            if($status_umum == 'rlh') {
                $query->whereHas('penilaian', fn($q) =>
                    $q->where('status_rumah', 'RLH')
                );
            }
            elseif($status_umum == 'rtlh') {
                $query->whereHas('penilaian', fn($q) =>
                    $q->where('status_rumah',  'RTLH')
                );
            }
            elseif($status_umum == 'rtlh_non_sewa') {
                $query->whereHas('penilaian', fn($q) =>
                    $q->where('status_rumah', 'RTLH')
                );
                $query->whereHas('kepemilikan', fn($q) =>
                    $q->where('status_kepemilikan_rumah_id', '1')
                );
            }

             elseif($status_umum == 'rtlh_sewa') {
                $query->whereHas('penilaian', fn($q) =>
                    $q->where('status_rumah', 'RTLH')
                );
                $query->whereHas('kepemilikan', fn($q) =>
                    $q->where('status_kepemilikan_rumah_id', '2')
                     ->orWhere('status_kepemilikan_rumah_id', '3')
                );
            }
            elseif($status_umum == 'laki') {
                $query->whereHas('fisik', fn($q) =>
                    $q->where('jumlah_penghuni_laki', '!=', '')
                );
            }
            elseif($status_umum == 'perempuan') {
                $query->whereHas('fisik', fn($q) =>
                    $q->where('jumlah_penghuni_perempuan', '!=', '')
                );
            }
            elseif($status_umum == 'abk') {
                $query->whereHas('fisik', fn($q) =>
                    $q->where('jumlah_abk', '!=', '')
                );
            }
            elseif($status_umum == 'dtks') {
                 $query->whereHas('sosialEkonomi', fn($q) =>
                    $q->where('status_dtks_id', '1')
                );
            }
            elseif($status_umum == 'imb') {
                 $query->whereHas('kepemilikan', fn($q) =>
                    $q->where('status_imb_id', '1')
                );
            }
            elseif($status_umum == 'non_imb') {
                 $query->whereHas('kepemilikan', fn($q) =>
                    $q->where('status_imb_id', '2')
                );
            }
            elseif($status_umum == 'backlog') {
                 $query->whereHas('sosialEkonomi', fn($q) =>
                    $q->where('jumlah_kk_id', '>','1')
                );
            }
            elseif($status_umum == 'bencana') {
                 $query->whereHas('kepemilikan', fn($q) =>
                    $q->where('jenis_kawasan_lokasi_rumah_id','6')
                );
            }
            elseif($status_umum == 'non_permukiman') {
                 $query->whereHas('kepemilikan', fn($q) =>
                    $q->where('jenis_kawasan_lokasi_rumah_id','7')
                );
            }
           
        }

        // ================================
        // 🧩 7️⃣ FILTER PRIORITAS
        // ================================
        if ($request->filled('prioritas')) {
            $p = $request->get('prioritas');
            $query->whereHas('penilaian', function ($q) use ($p) {
                if ($p == '1') $q->where('prioritas_a', '2');
                if ($p == '2') $q->where('prioritas_b', '2');
                if ($p == '3') $q->where('prioritas_c', '2');
            });
        }

        

        // ================================
        // 🧩 4️⃣ LIMIT DATA (OPSIONAL)
        // ================================
        // if ($request->filled('limit_data')) {
        //     $query->limit((int) $request->get('limit_data'));
        // }

        // ================================
        // 📊 5️⃣ RETURN DATATABLES
        // ================================
        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('expand', fn($r) =>
                '<button class="btn btn-light btn-sm toggle-detail" data-id="'.$r->id_rumah.'">
                    <i class="fas fa-plus"></i>
                </button>'
            )
            ->addColumn('nama_pemilik', function ($r) {
                $kepala = $r->kepalaKeluarga?->sortBy('id')->first();
                $anggota = $kepala?->anggota?->sortBy('id')->first();
                return $anggota ? e($anggota->nama) : '-';
            })
            ->addColumn('alamat', fn($r) => e($r->alamat ?? '-'))
            ->addColumn('foto', function ($r) {
               
                if ($r->dokumen && $r->dokumen->foto_rumah_satu) {
                    $photoUrl = asset('storage/' . $r->dokumen->foto_rumah_satu);
                    return '<img src="' . $photoUrl . '"
                    class="img-fluid rounded shadow-sm mb-2 preview-foto"
                    style="max-height: 180px; object-fit: cover; cursor: pointer;"
                    data-bs-toggle="modal"
                    data-bs-target="#previewModal"
                    data-src="' . $photoUrl . '">';
                }
                return '<span class="text-muted">Foto rumah belum diunggah.</span>';
            })
            ->addColumn('kecamatan', fn($r) => e($r->kelurahan->kecamatan->nama_kecamatan ?? '-'))
            ->addColumn('kelurahan', fn($r) => e($r->kelurahan->nama_kelurahan ?? '-'))
            ->addColumn('status_rumah', function ($r) {
                $status = $r->penilaian->status_rumah ?? '-';
                if (strtoupper($status) === 'RTLH') {
                    return '<span class="badge badge-light-danger fw-bold px-3 py-2">' . e($status) . '</span>';
                } elseif ($status && $status !== '-') {
                    return '<span class="badge badge-light-success fw-bold px-3 py-2">' . e($status) . '</span>';
                }
                return '<span class="badge badge-light-secondary fw-bold px-3 py-2">-</span>';
            })
            ->addColumn('status_backlog', fn($r) =>
                $r->sosialEkonomi && $r->sosialEkonomi->jumlah_kk_id > 1
                    ? '<span class="badge badge-light-warning fw-bold px-3 py-2">BACKLOG</span>'
                    : '<span class="badge badge-light-primary fw-bold px-3 py-2">TIDAK BACKLOG</span>'
            )
            ->addColumn('action', function ($r) {
                 $userLevel = auth()->user()->level ?? null;


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

                        
                ';
                   if ($userLevel != 3) {
                    $buttons .= '
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" 
                            wire:click.prevent="goToEdit(' . $r->id_rumah . ')">
                            Edit
                            </a>
                        </div>

                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" 
                            onclick="confirmDelete(' . $r->id_rumah . ')">
                            Hapus
                            </a>
                        </div>
                    ';
                }

                // Tutup menu
                $buttons .= '</div>';

                 return '<div wire:ignore.self>' . $buttons . '</div>';
            })
             ->filter(function ($query) {
                $search = request()->get('search')['value'] ?? null;
                if ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('alamat', 'like', "%{$search}%")
                        ->orWhereHas('kelurahan', fn($k) => $k->where('nama_kelurahan', 'like', "%{$search}%"))
                        ->orWhereHas('kelurahan.kecamatan', fn($kc) => $kc->where('nama_kecamatan', 'like', "%{$search}%"))
                        ->orWhereHas('kepalaKeluarga.anggota', fn($a) => $a->where('nama', 'like', "%{$search}%"));
                    });
                }
            })
            ->rawColumns(['expand', 'status_rumah', 'status_backlog', 'action','foto'])
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
            $rumah->delete();
            
            $this->dispatch('rumahDeleted', [
                'message' => "Data rumah ID {$id} berhasil dihapus!"
            ]);
        }
    }

}
