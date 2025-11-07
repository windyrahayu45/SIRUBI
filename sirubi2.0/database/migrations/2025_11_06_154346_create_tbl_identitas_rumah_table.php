<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_identitas_rumah', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('id_rumah')->nullable();
            $table->text('jumlah_kk_id')->nullable();
            $table->text('no_kk')->nullable();
            $table->text('jenis_kelamin_id')->nullable();
            $table->text('usia')->nullable();
            $table->text('pendidikan_terakhir_id')->nullable();
            $table->text('pekerjaan_utama_id')->nullable();
            $table->text('besar_penghasilan_perbulan_id')->nullable();
            $table->text('besar_pengeluaran_perbulan_id')->nullable();
            $table->text('alamat')->nullable();
            $table->string('rt');
            $table->string('rw');
            $table->text('kelurahan_id')->nullable();
            $table->text('kecamatan_id')->nullable();
            $table->text('status_kepemilikan_tanah_id')->nullable();
            $table->text('bukti_kepemilikan_tanah_id')->nullable();
            $table->text('status_kepemilikan_rumah_id')->nullable();
            $table->text('nik_kepemilikan_rumah')->nullable();
            $table->text('status_imb_id')->nullable();
            $table->text('nomor_imb')->nullable();
            $table->text('aset_rumah_ditempat_lain_id')->nullable();
            $table->text('aset_tanah_ditempat_lain_id')->nullable();
            $table->text('pernah_mendapatkan_bantuan_id')->nullable();
            $table->text('no_kk_penerima')->nullable();
            $table->text('tahun_bantuan')->nullable();
            $table->text('nama_bantuan')->nullable();
            $table->text('nama_program_bantuan')->nullable();
            $table->text('nominal_bantuan')->nullable();
            $table->text('jenis_kawasan_lokasi_rumah_id')->nullable();
            $table->text('pondasi_id')->nullable();
            $table->text('jenis_pondasi')->nullable();
            $table->text('kondisi_pondasi_id')->nullable();
            $table->text('kondisi_sloof_id')->nullable();
            $table->text('kondisi_kolom_tiang_id')->nullable();
            $table->text('kondisi_balok_id')->nullable();
            $table->text('kondisi_struktur_atap_id')->nullable();
            $table->text('jendela_lubang_cahaya_id')->nullable();
            $table->text('kondisi_jendela_lubang_cahaya_id')->nullable();
            $table->text('ventilasi_id')->nullable();
            $table->text('keterangan_ventilasi')->nullable();
            $table->text('kondisi_ventilasi_id')->nullable();
            $table->text('kamar_mandi_id')->nullable();
            $table->text('kondisi_kamar_mandi_id')->nullable();
            $table->text('jamban_id')->nullable();
            $table->text('kondisi_jamban_id')->nullable();
            $table->text('sistem_pembuangan_air_kotor_id')->nullable();
            $table->text('kondisi_sistem_pembuangan_air_kotor_id')->nullable();
            $table->text('frekuensi_penyedotan_id')->nullable();
            $table->text('sumber_air_minum_id')->nullable();
            $table->text('kondisi_sumber_air_minum_id')->nullable();
            $table->text('sumber_listrik_id')->nullable();
            $table->text('luas_rumah')->nullable();
            $table->text('jumlah_penghuni_laki')->nullable();
            $table->text('jumlah_penghuni_perempuan')->nullable();
            $table->text('jumlah_abk')->nullable();
            $table->text('tinggi_rata_rumah')->nullable();
            $table->text('ruang_keluarga_dan_ruang_tidur_id')->nullable();
            $table->text('jumlah_kamar_tidur')->nullable();
            $table->text('luas_rata_kamar_tidur')->nullable();
            $table->text('jenis_fisik_bangunan_id')->nullable();
            $table->text('jumlah_lantai_bangunan')->nullable();
            $table->text('fungsi_rumah_id')->nullable();
            $table->text('tipe_rumah_id')->nullable();
            $table->text('status_dtks_id')->nullable();
            $table->text('tahun_pembangunan_rumah')->nullable();
            $table->text('material_atap_terluas_id')->nullable();
            $table->text('kondisi_penutup_atap_id')->nullable();
            $table->text('material_dinding_terluas_id')->nullable();
            $table->text('kondisi_dinding_id')->nullable();
            $table->text('material_lantai_terluas_id')->nullable();
            $table->text('kondisi_lantai_id')->nullable();
            $table->text('akses_ke_jalan_id')->nullable();
            $table->text('bangunan_menghadap_jalan_id')->nullable();
            $table->text('bangunan_menghadap_sungai_id')->nullable();
            $table->text('bangunan_berada_limbah_id')->nullable();
            $table->text('bangunan_berada_sungai_id')->nullable();
            $table->string('foto_kk');
            $table->string('foto_ktp');
            $table->string('foto_imb');
            $table->string('foto_rumah_satu');
            $table->string('foto_rumah_dua');
            $table->string('foto_rumah_tiga');
            $table->text('latitude')->nullable();
            $table->text('longitude')->nullable();
            $table->string('upload_by_id');
            $table->text('nilai_a')->nullable();
            $table->text('prioritas_a')->nullable();
            $table->text('nilai_b')->nullable();
            $table->text('prioritas_b')->nullable();
            $table->text('nilai_c')->nullable();
            $table->text('prioritas_c')->nullable();
            $table->text('nilai')->nullable();
            $table->text('status_rumah')->nullable();
            $table->text('status_luas')->nullable();
            $table->date('upload_at')->nullable();
            $table->text('update_at')->nullable();
            $table->time('time_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_identitas_rumah');
    }
};
