<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportIdentitasRumahCommand extends Command
{
    protected $signature = 'import:identitas';
    protected $description = 'Import data tbl_identitas_rumah dari database lama (CI) ke tabel hasil normalisasi di Laravel';

    public function handle()
    {
        $oldDb = DB::connection('mysql_old'); // koneksi database lama (CI)
        $this->info('🚀 Memulai import data dari tbl_identitas_rumah...');

        $chunkSize = 1000;
        $offset = 0;
        $totalImported = 0;

        do {
            $data = $oldDb->table('tbl_identitas_rumah')
                ->offset($offset)
                ->limit($chunkSize)
                ->get();

            if ($data->isEmpty()) break;

            foreach ($data as $row) {

                // 1️⃣ RUMAH (IDENTITAS DASAR)
                $rumahId = DB::table('rumah')->insertGetId([
                    'id_rumah_lama' => $row->id_rumah,
                    'alamat' => empty($row->alamat) ? null : $row->alamat,
                    'latitude' => empty($row->latitude) ? null : $row->latitude,
                    'longitude' => empty($row->longitude) ? null : $row->longitude,
                    'rt' => empty($row->rt) ? null : $row->rt,
                    'rw' => empty($row->rw) ? null : $row->rw,
                    'kecamatan_id' => empty($row->kecamatan_id) ? null : $row->kecamatan_id,
                    'kelurahan_id' => empty($row->kelurahan_id) ? null : $row->kelurahan_id,
                    'tahun_pembangunan_rumah' => empty($row->tahun_pembangunan_rumah) ? null : $row->tahun_pembangunan_rumah,
                ], 'id_rumah');

                // 2️⃣ SOSIAL EKONOMI
                DB::table('sosial_ekonomi_rumah')->insert([
                    'rumah_id' => $rumahId,
                    'jumlah_kk_id' => empty($row->jumlah_kk_id) ? null : $row->jumlah_kk_id,
                    'no_kk' => empty($row->no_kk) ? null : $row->no_kk,
                    'jenis_kelamin_id' => empty($row->jenis_kelamin_id) ? null : $row->jenis_kelamin_id,
                    'usia' => empty($row->usia) ? null : (int)$row->usia,
                    'pendidikan_terakhir_id' => empty($row->pendidikan_terakhir_id) ? null : $row->pendidikan_terakhir_id,
                    'pekerjaan_utama_id' => empty($row->pekerjaan_utama_id) ? null : $row->pekerjaan_utama_id,
                    'besar_penghasilan_perbulan_id' => empty($row->besar_penghasilan_perbulan_id) ? null : $row->besar_penghasilan_perbulan_id,
                    'besar_pengeluaran_perbulan_id' => empty($row->besar_pengeluaran_perbulan_id) ? null : $row->besar_pengeluaran_perbulan_id,
                    'status_dtks_id' => empty($row->status_dtks_id) ? null : $row->status_dtks_id,
                ]);

                // 3️⃣ KEPEMILIKAN
                DB::table('kepemilikan_rumah')->insert([
                    'rumah_id' => $rumahId,
                    'status_kepemilikan_tanah_id' => empty($row->status_kepemilikan_tanah_id) ? null : $row->status_kepemilikan_tanah_id,
                    'bukti_kepemilikan_tanah_id' => empty($row->bukti_kepemilikan_tanah_id) ? null : $row->bukti_kepemilikan_tanah_id,
                    'status_kepemilikan_rumah_id' => empty($row->status_kepemilikan_rumah_id) ? null : $row->status_kepemilikan_rumah_id,
                    'nik_kepemilikan_rumah' => empty($row->nik_kepemilikan_rumah) ? null : $row->nik_kepemilikan_rumah,
                    'status_imb_id' => empty($row->status_imb_id) ? null : $row->status_imb_id,
                    'nomor_imb' => empty($row->nomor_imb) ? null : $row->nomor_imb,
                    'aset_rumah_ditempat_lain_id' => empty($row->aset_rumah_ditempat_lain_id) ? null : $row->aset_rumah_ditempat_lain_id,
                    'aset_tanah_ditempat_lain_id' => empty($row->aset_tanah_ditempat_lain_id) ? null : $row->aset_tanah_ditempat_lain_id,
                    'jenis_kawasan_lokasi_rumah_id' => empty($row->jenis_kawasan_lokasi_rumah_id) ? null : $row->jenis_kawasan_lokasi_rumah_id,
                ]);

                // 4️⃣ BANTUAN
                DB::table('bantuan_rumah')->insert([
                    'rumah_id' => $rumahId,
                    'pernah_mendapatkan_bantuan_id' => empty($row->pernah_mendapatkan_bantuan_id) ? null : $row->pernah_mendapatkan_bantuan_id,
                    'no_kk_penerima' => empty($row->no_kk_penerima) ? null : $row->no_kk_penerima,
                    'tahun_bantuan' => empty($row->tahun_bantuan) ? null : (int)$row->tahun_bantuan,
                    'nama_bantuan' => empty($row->nama_bantuan) ? null : $row->nama_bantuan,
                    'nama_program_bantuan' => empty($row->nama_program_bantuan) ? null : $row->nama_program_bantuan,
                    'nominal_bantuan' => empty($row->nominal_bantuan) ? null : $row->nominal_bantuan,
                ]);

                // 5️⃣ FISIK BANGUNAN
                DB::table('fisik_rumah')->insert([
                    'rumah_id' => $rumahId,
                    'pondasi_id' => empty($row->pondasi_id) ? null : $row->pondasi_id,
                    'jenis_pondasi' => empty($row->jenis_pondasi) ? null : $row->jenis_pondasi,
                    'kondisi_pondasi_id' => empty($row->kondisi_pondasi_id) ? null : $row->kondisi_pondasi_id,
                    'kondisi_sloof_id' => empty($row->kondisi_sloof_id) ? null : $row->kondisi_sloof_id,
                    'kondisi_kolom_tiang_id' => empty($row->kondisi_kolom_tiang_id) ? null : $row->kondisi_kolom_tiang_id,
                    'kondisi_balok_id' => empty($row->kondisi_balok_id) ? null : $row->kondisi_balok_id,
                    'kondisi_struktur_atap_id' => empty($row->kondisi_struktur_atap_id) ? null : $row->kondisi_struktur_atap_id,
                    'material_atap_terluas_id' => empty($row->material_atap_terluas_id) ? null : $row->material_atap_terluas_id,
                    'kondisi_penutup_atap_id' => empty($row->kondisi_penutup_atap_id) ? null : $row->kondisi_penutup_atap_id,
                    'material_dinding_terluas_id' => empty($row->material_dinding_terluas_id) ? null : $row->material_dinding_terluas_id,
                    'kondisi_dinding_id' => empty($row->kondisi_dinding_id) ? null : $row->kondisi_dinding_id,
                    'material_lantai_terluas_id' => empty($row->material_lantai_terluas_id) ? null : $row->material_lantai_terluas_id,
                    'kondisi_lantai_id' => empty($row->kondisi_lantai_id) ? null : $row->kondisi_lantai_id,
                    'akses_ke_jalan_id' => empty($row->akses_ke_jalan_id) ? null : $row->akses_ke_jalan_id,
                    'bangunan_menghadap_jalan_id' => empty($row->bangunan_menghadap_jalan_id) ? null : $row->bangunan_menghadap_jalan_id,
                    'bangunan_menghadap_sungai_id' => empty($row->bangunan_menghadap_sungai_id) ? null : $row->bangunan_menghadap_sungai_id,
                    'bangunan_berada_limbah_id' => empty($row->bangunan_berada_limbah_id) ? null : $row->bangunan_berada_limbah_id,
                    'bangunan_berada_sungai_id' => empty($row->bangunan_berada_sungai_id) ? null : $row->bangunan_berada_sungai_id,
                    'luas_rumah' => empty($row->luas_rumah) ? null : (int)$row->luas_rumah,
                    'tinggi_rata_rumah' => empty($row->tinggi_rata_rumah) ? null : (int)$row->tinggi_rata_rumah,
                    'jumlah_penghuni_laki' => empty($row->jumlah_penghuni_laki) ? null : (int)$row->jumlah_penghuni_laki,
                    'jumlah_penghuni_perempuan' => empty($row->jumlah_penghuni_perempuan) ? null : (int)$row->jumlah_penghuni_perempuan,
                    'jumlah_abk' => empty($row->jumlah_abk) ? null : (int)$row->jumlah_abk,
                    'ruang_keluarga_dan_ruang_tidur_id' => empty($row->ruang_keluarga_dan_ruang_tidur_id) ? null : $row->ruang_keluarga_dan_ruang_tidur_id,
                    'jumlah_kamar_tidur' => empty($row->jumlah_kamar_tidur) ? null : (int)$row->jumlah_kamar_tidur,
                    'luas_rata_kamar_tidur' => empty($row->luas_rata_kamar_tidur) ? null : (int)$row->luas_rata_kamar_tidur,
                    'jenis_fisik_bangunan_id' => empty($row->jenis_fisik_bangunan_id) ? null : $row->jenis_fisik_bangunan_id,
                    'fungsi_rumah_id' => empty($row->fungsi_rumah_id) ? null : $row->fungsi_rumah_id,
                    'tipe_rumah_id' => empty($row->tipe_rumah_id) ? null : $row->tipe_rumah_id,
                    'jumlah_lantai_bangunan' => empty($row->jumlah_lantai_bangunan) ? null : (int)$row->jumlah_lantai_bangunan,
                ]);

                // 6️⃣ SANITASI
                DB::table('sanitasi_rumah')->insert([
                    'rumah_id' => $rumahId,
                    'jendela_lubang_cahaya_id' => empty($row->jendela_lubang_cahaya_id) ? null : $row->jendela_lubang_cahaya_id,
                    'kondisi_jendela_lubang_cahaya_id' => empty($row->kondisi_jendela_lubang_cahaya_id) ? null : $row->kondisi_jendela_lubang_cahaya_id,
                    'ventilasi_id' => empty($row->ventilasi_id) ? null : $row->ventilasi_id,
                    'keterangan_ventilasi' => empty($row->keterangan_ventilasi) ? null : $row->keterangan_ventilasi,
                    'kondisi_ventilasi_id' => empty($row->kondisi_ventilasi_id) ? null : $row->kondisi_ventilasi_id,
                    'kamar_mandi_id' => empty($row->kamar_mandi_id) ? null : $row->kamar_mandi_id,
                    'kondisi_kamar_mandi_id' => empty($row->kondisi_kamar_mandi_id) ? null : $row->kondisi_kamar_mandi_id,
                    'jamban_id' => empty($row->jamban_id) ? null : $row->jamban_id,
                    'kondisi_jamban_id' => empty($row->kondisi_jamban_id) ? null : $row->kondisi_jamban_id,
                    'sistem_pembuangan_air_kotor_id' => empty($row->sistem_pembuangan_air_kotor_id) ? null : $row->sistem_pembuangan_air_kotor_id,
                    'kondisi_sistem_pembuangan_air_kotor_id' => empty($row->kondisi_sistem_pembuangan_air_kotor_id) ? null : $row->kondisi_sistem_pembuangan_air_kotor_id,
                    'frekuensi_penyedotan_id' => empty($row->frekuensi_penyedotan_id) ? null : $row->frekuensi_penyedotan_id,
                    'sumber_air_minum_id' => empty($row->sumber_air_minum_id) ? null : $row->sumber_air_minum_id,
                    'kondisi_sumber_air_minum_id' => empty($row->kondisi_sumber_air_minum_id) ? null : $row->kondisi_sumber_air_minum_id,
                    'sumber_listrik_id' => empty($row->sumber_listrik_id) ? null : $row->sumber_listrik_id,
                ]);

                // 7️⃣ PENILAIAN
                DB::table('penilaian_rumah')->insert([
                    'rumah_id' => $rumahId,
                    'nilai_a' => empty($row->nilai_a) ? null : $row->nilai_a,
                    'prioritas_a' => empty($row->prioritas_a) ? null : $row->prioritas_a,
                    'nilai_b' => empty($row->nilai_b) ? null : $row->nilai_b,
                    'prioritas_b' => empty($row->prioritas_b) ? null : $row->prioritas_b,
                    'nilai_c' => empty($row->nilai_c) ? null : $row->nilai_c,
                    'prioritas_c' => empty($row->prioritas_c) ? null : $row->prioritas_c,
                    'nilai' => empty($row->nilai) ? null : $row->nilai,
                    'status_rumah' => empty($row->status_rumah) ? null : $row->status_rumah,
                    'status_luas' => empty($row->status_luas) ? null : $row->status_luas,
                ]);

                // 8️⃣ DOKUMEN RUMAH
                DB::table('dokumen_rumah')->insert([
                    'rumah_id' => $rumahId,
                    'foto_kk' => empty($row->foto_kk) ? null : $row->foto_kk,
                    'foto_ktp' => empty($row->foto_ktp) ? null : $row->foto_ktp,
                    'foto_imb' => empty($row->foto_imb) ? null : $row->foto_imb,
                    'foto_rumah_satu' => empty($row->foto_rumah_satu) ? null : $row->foto_rumah_satu,
                    'foto_rumah_dua' => empty($row->foto_rumah_dua) ? null : $row->foto_rumah_dua,
                    'foto_rumah_tiga' => empty($row->foto_rumah_tiga) ? null : $row->foto_rumah_tiga,
                    'uploaded_by' => empty($row->upload_by_id) ? null : $row->upload_by_id,
                    'uploaded_at' => empty($row->upload_at) ? null : $row->upload_at,
                ]);

                $totalImported++;
            }

            $offset += $chunkSize;
            $this->info("✅ Batch ke-" . ($offset / $chunkSize) . " selesai (" . $totalImported . " data total).");

        } while (true);

        $this->info("🎉 Import selesai. Total {$totalImported} data rumah berhasil dimasukkan.");
    }
}
