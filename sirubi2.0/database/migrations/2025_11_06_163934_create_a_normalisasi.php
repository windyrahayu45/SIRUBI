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
        // 1️⃣ RUMAH (IDENTITAS DASAR)
        Schema::create('rumah', function (Blueprint $table) {
            $table->id('id_rumah');
            $table->integer('id_rumah_lama')->nullable();
            $table->text('alamat')->nullable();
            $table->text('latitude')->nullable();
            $table->text('longitude')->nullable();
            $table->string('rt', 10)->nullable();
            $table->string('rw', 10)->nullable();
            $table->unsignedBigInteger('kecamatan_id')->nullable();
            $table->unsignedBigInteger('kelurahan_id')->nullable();
            $table->string('tahun_pembangunan_rumah',10)->nullable();
            $table->timestamps();
        });


           // 2️⃣ SOSIAL EKONOMI
        Schema::create('sosial_ekonomi_rumah', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('rumah_id');
            $table->foreign('rumah_id')->references('id_rumah')->on('rumah')->onDelete('cascade');
            $table->unsignedBigInteger('jumlah_kk_id')->nullable();
            $table->string('no_kk', 50)->nullable();
            $table->unsignedBigInteger('jenis_kelamin_id')->nullable();
            $table->integer('usia')->nullable();
            $table->unsignedBigInteger('pendidikan_terakhir_id')->nullable();
            $table->unsignedBigInteger('pekerjaan_utama_id')->nullable();
            $table->unsignedBigInteger('besar_penghasilan_perbulan_id')->nullable();
            $table->unsignedBigInteger('besar_pengeluaran_perbulan_id')->nullable();
            $table->unsignedBigInteger('status_dtks_id')->nullable();
            $table->timestamps();
        });


        // 3️⃣ KEPEMILIKAN
        Schema::create('kepemilikan_rumah', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('rumah_id');
            $table->foreign('rumah_id')->references('id_rumah')->on('rumah')->onDelete('cascade');
            $table->unsignedBigInteger('status_kepemilikan_tanah_id')->nullable();
            $table->unsignedBigInteger('bukti_kepemilikan_tanah_id')->nullable();
            $table->unsignedBigInteger('status_kepemilikan_rumah_id')->nullable();
            $table->string('nik_kepemilikan_rumah', 50)->nullable();
            $table->unsignedBigInteger('status_imb_id')->nullable();
            $table->string('nomor_imb', 100)->nullable();
            $table->unsignedBigInteger('aset_rumah_ditempat_lain_id')->nullable();
            $table->unsignedBigInteger('aset_tanah_ditempat_lain_id')->nullable();
            $table->unsignedBigInteger('jenis_kawasan_lokasi_rumah_id')->nullable();
            $table->timestamps();
        });


        // 4️⃣ BANTUAN
        Schema::create('bantuan_rumah', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('rumah_id');
           $table->foreign('rumah_id')->references('id_rumah')->on('rumah')->onDelete('cascade');
            $table->unsignedBigInteger('pernah_mendapatkan_bantuan_id')->nullable();
            $table->string('no_kk_penerima', 50)->nullable();
            $table->string('tahun_bantuan',10)->nullable();
            $table->string('nama_bantuan', 255)->nullable();
            $table->string('nama_program_bantuan', 255)->nullable();
            $table->decimal('nominal_bantuan', 15, 2)->nullable();
            $table->timestamps();
        });


         // 5️⃣ FISIK BANGUNAN
        // 5️⃣ FISIK BANGUNAN
        Schema::create('fisik_rumah', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('rumah_id');
            $table->foreign('rumah_id')->references('id_rumah')->on('rumah')->onDelete('cascade');
            // Struktur utama
            $table->unsignedBigInteger('pondasi_id')->nullable();
            $table->string('jenis_pondasi', 255)->nullable();
            $table->unsignedBigInteger('kondisi_pondasi_id')->nullable();
            $table->unsignedBigInteger('kondisi_sloof_id')->nullable();
            $table->unsignedBigInteger('kondisi_kolom_tiang_id')->nullable();
            $table->unsignedBigInteger('kondisi_balok_id')->nullable();
            $table->unsignedBigInteger('kondisi_struktur_atap_id')->nullable();

            // Material & kondisi
            $table->unsignedBigInteger('material_atap_terluas_id')->nullable();
            $table->unsignedBigInteger('kondisi_penutup_atap_id')->nullable();
            $table->unsignedBigInteger('material_dinding_terluas_id')->nullable();
            $table->unsignedBigInteger('kondisi_dinding_id')->nullable();
            $table->unsignedBigInteger('material_lantai_terluas_id')->nullable();
            $table->unsignedBigInteger('kondisi_lantai_id')->nullable();

            // Kondisi fisik tambahan
            $table->unsignedBigInteger('akses_ke_jalan_id')->nullable();
            $table->unsignedBigInteger('bangunan_menghadap_jalan_id')->nullable();
            $table->unsignedBigInteger('bangunan_menghadap_sungai_id')->nullable();
            $table->unsignedBigInteger('bangunan_berada_limbah_id')->nullable();
            $table->unsignedBigInteger('bangunan_berada_sungai_id')->nullable();

            // Ukuran & penghuni
            $table->string('luas_rumah',4)->nullable();
            $table->string('tinggi_rata_rumah',4)->nullable();
            $table->integer('jumlah_penghuni_laki')->nullable();
            $table->integer('jumlah_penghuni_perempuan')->nullable();
            $table->integer('jumlah_abk')->nullable();

            // Ruang dan kamar tidur 🏠
            $table->unsignedBigInteger('ruang_keluarga_dan_ruang_tidur_id')->nullable();
            $table->integer('jumlah_kamar_tidur')->nullable();
            $table->decimal('luas_rata_kamar_tidur', 10, 2)->nullable();

            // Lain-lain
            $table->unsignedBigInteger('jenis_fisik_bangunan_id')->nullable();
            $table->unsignedBigInteger('fungsi_rumah_id')->nullable();
            $table->unsignedBigInteger('tipe_rumah_id')->nullable();
            $table->integer('jumlah_lantai_bangunan')->nullable();

            $table->timestamps();
        });




          // 6️⃣ SANITASI
        Schema::create('sanitasi_rumah', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('rumah_id');
            $table->foreign('rumah_id')->references('id_rumah')->on('rumah')->onDelete('cascade');
            $table->unsignedBigInteger('jendela_lubang_cahaya_id')->nullable();
            $table->unsignedBigInteger('kondisi_jendela_lubang_cahaya_id')->nullable();
            $table->unsignedBigInteger('ventilasi_id')->nullable();
            $table->text('keterangan_ventilasi')->nullable();
            $table->unsignedBigInteger('kondisi_ventilasi_id')->nullable();
            $table->unsignedBigInteger('kamar_mandi_id')->nullable();
            $table->unsignedBigInteger('kondisi_kamar_mandi_id')->nullable();
            $table->unsignedBigInteger('jamban_id')->nullable();
            $table->unsignedBigInteger('kondisi_jamban_id')->nullable();
            $table->unsignedBigInteger('sistem_pembuangan_air_kotor_id')->nullable();
            $table->unsignedBigInteger('kondisi_sistem_pembuangan_air_kotor_id')->nullable();
            $table->unsignedBigInteger('frekuensi_penyedotan_id')->nullable();
            $table->unsignedBigInteger('sumber_air_minum_id')->nullable();
            $table->unsignedBigInteger('kondisi_sumber_air_minum_id')->nullable();
            $table->unsignedBigInteger('sumber_listrik_id')->nullable();
            $table->timestamps();
        });

          // 7️⃣ PENILAIAN
        Schema::create('penilaian_rumah', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('rumah_id');
            $table->foreign('rumah_id')->references('id_rumah')->on('rumah')->onDelete('cascade');
            $table->decimal('nilai_a', 8, 2)->nullable();
            $table->string('prioritas_a', 50)->nullable();
            $table->decimal('nilai_b', 8, 2)->nullable();
            $table->string('prioritas_b', 50)->nullable();
            $table->decimal('nilai_c', 8, 2)->nullable();
            $table->string('prioritas_c', 50)->nullable();
            $table->decimal('nilai', 8, 2)->nullable();
            $table->string('status_rumah', 50)->nullable();
            $table->string('status_luas', 50)->nullable();
            $table->timestamps();
        });


        // 9️⃣ DOKUMEN RUMAH
        Schema::create('dokumen_rumah', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('rumah_id');
            $table->foreign('rumah_id')->references('id_rumah')->on('rumah')->onDelete('cascade');

            // Dokumen administratif
            $table->string('foto_kk')->nullable();
            $table->string('foto_ktp')->nullable();
            $table->string('foto_imb')->nullable();

            // Foto kondisi rumah (multi-angle)
            $table->string('foto_rumah_satu')->nullable();
            $table->string('foto_rumah_dua')->nullable();
            $table->string('foto_rumah_tiga')->nullable();

            // Metadata opsional
            $table->string('uploaded_by')->nullable();
            $table->timestamp('uploaded_at')->nullable();
           
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokumen_rumah');
        Schema::dropIfExists('penilaian_rumah');
        Schema::dropIfExists('sanitasi_rumah');
        Schema::dropIfExists('fisik_rumah');
        Schema::dropIfExists('bantuan_rumah');
        Schema::dropIfExists('kepemilikan_rumah');
        Schema::dropIfExists('sosial_ekonomi_rumah');
        Schema::dropIfExists('rumah');
    }
};
