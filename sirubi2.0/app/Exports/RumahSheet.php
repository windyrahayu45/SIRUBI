<?php

namespace App\Exports;

use App\Models\Rumah;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class RumahSheet implements FromQuery, WithMapping, WithHeadings, WithTitle, WithChunkReading, ShouldAutoSize, WithEvents
{
    protected $offset;
    protected $limit;

    public function __construct($offset = 0, $limit = 1000)
    {
        $this->offset = $offset;
        $this->limit  = $limit;
    }

    public function query()
    {
        return Rumah::query()
            ->select([
                'id_rumah', 'alamat', 'kelurahan_id', 'tahun_pembangunan_rumah'
            ])
            ->with([
                
                'kelurahan:id_kelurahan,nama_kelurahan,kecamatan_id',
                'kelurahan.kecamatan:id_kecamatan,nama_kecamatan',
                'sosialEkonomi:id,rumah_id,jenis_kelamin_id,usia,pendidikan_terakhir_id,pekerjaan_utama_id,besar_penghasilan_perbulan_id,besar_pengeluaran_perbulan_id,status_dtks_id',
                'sosialEkonomi.jenisKelamin:id_jenis_kelamin,jenis_kelamin',
                'sosialEkonomi.pendidikanTerakhir:id_pendidikan_terakhir,pendidikan_terakhir',
                'sosialEkonomi.pekerjaanUtama:id_pekerjaan_utama,pekerjaan_utama',
                'sosialEkonomi.besarPenghasilan:id_besar_penghasilan,besar_penghasilan',
                'sosialEkonomi.besarPengeluaran:id_besar_pengeluaran,besar_pengeluaran',
                'sosialEkonomi.statusDtks:id_status_dtks,status_dtks',
                'kepemilikan:id,rumah_id,status_kepemilikan_tanah_id,bukti_kepemilikan_tanah_id,status_kepemilikan_rumah_id,status_imb_id,nomor_imb,aset_rumah_ditempat_lain_id,aset_tanah_ditempat_lain_id,jenis_kawasan_lokasi_rumah_id,nik_kepemilikan_rumah',
                'kepemilikan.statusKepemilikanTanah:id_status_kepemilikan_tanah,status_kepemilikan_tanah',
                'kepemilikan.buktiKepemilikanTanah:id_bukti_kepemilikan_tanah,bukti_kepemilikan_tanah',
                'kepemilikan.statusKepemilikanRumah:id_status_kepemilikan_rumah,status_kepemilikan_rumah',
                'kepemilikan.statusImb:id_status_imb,status_imb',
                'kepemilikan.asetRumahDitempatLain:id_aset_rumah_tempat_lain,aset_rumah_tempat_lain',
                'kepemilikan.asetTanahDitempatLain:id_aset_tanah_tempat_lain,aset_tanah_tempat_lain',
                'kepemilikan.jenisKawasanLokasiRumah:id_jenis_kawasan_lokasi,jenis_kawasan_lokasi',
                'fisik:id,rumah_id,pondasi_id,jenis_pondasi,kondisi_pondasi_id,kondisi_sloof_id,kondisi_kolom_tiang_id,kondisi_balok_id,kondisi_struktur_atap_id,material_atap_terluas_id,kondisi_penutup_atap_id,material_dinding_terluas_id,kondisi_dinding_id,material_lantai_terluas_id,kondisi_lantai_id,akses_ke_jalan_id,bangunan_menghadap_jalan_id,bangunan_menghadap_sungai_id,bangunan_berada_sungai_id,bangunan_berada_limbah_id,luas_rumah,tinggi_rata_rumah,jumlah_penghuni_laki,jumlah_penghuni_perempuan,jumlah_abk,jumlah_kamar_tidur,luas_rata_kamar_tidur,ruang_keluarga_dan_ruang_tidur_id,jenis_fisik_bangunan_id,fungsi_rumah_id,tipe_rumah_id,jumlah_lantai_bangunan',
                'fisik.pondasi:id_pondasi,pondasi',
                'fisik.jenisPondasi:id_jenis_pondasi,nama_jenis_pondasi',
                'fisik.kondisiPondasi:id_kondisi_pondasi,kondisi_pondasi',
                'fisik.kondisiSloof:id_kondisi_sloof,kondisi_sloof',
                'fisik.kondisiKolomTiang:id_kondisi_kolom_tiang,kondisi_kolom_tiang',
                'fisik.kondisiBalok:id_kondisi_balok,kondisi_balok',
                'fisik.kondisiStrukturAtap:id_kondisi_struktur_atap,kondisi_struktur_atap',
                'fisik.materialAtapTerluas:id_material_atap_terluas,material_atap_terluas',
                'fisik.kondisiPenutupAtap:id_kondisi_penutup_atap,kondisi_penutup_atap',
                'fisik.materialDindingTerluas:id_material_dinding_terluas,material_dinding_terluas',
                'fisik.kondisiDinding:id_kondisi_dinding,kondisi_dinding',
                'fisik.materialLantaiTerluas:id_material_lantai_terluas,material_lantai_terluas',
                'fisik.kondisiLantai:id_kondisi_lantai,kondisi_lantai',
                'fisik.aksesKeJalan:id_akses_ke_jalan,akses_ke_jalan',
                'fisik.bangunanMenghadapJalan:id_bangunan_menghadap_jalan,bangunan_menghadap_jalan',
                'fisik.bangunanMenghadapSungai:id_bangunan_menghadap_sungai,bangunan_menghadap_sungai',
                'fisik.bangunanBeradaSungai:id_bangunan_berada_sungai,bangunan_berada_sungai',
                'fisik.bangunanBeradaLimbah:id_bangunan_berada_limbah,bangunan_berada_limbah',
                'fisik.ruangKeluargaDanTidur:id_ruang_keluarga_dan_tidur,ruang_keluarga_dan_tidur',
                'fisik.jenisFisikBangunan:id_jenis_fisik_bangunan,jenis_fisik_bangunan',
                'fisik.fungsiRumah:id_fungsi_rumah,fungsi_rumah',
                'fisik.tipeRumah:id_tipe_rumah,tipe_rumah',
                'sanitasi:id,rumah_id,jendela_lubang_cahaya_id,kondisi_jendela_lubang_cahaya_id,ventilasi_id,kondisi_ventilasi_id,kamar_mandi_id,kondisi_kamar_mandi_id,jamban_id,kondisi_jamban_id,sistem_pembuangan_air_kotor_id,kondisi_sistem_pembuangan_air_kotor_id,sumber_air_minum_id,kondisi_sumber_air_minum_id,sumber_listrik_id,frekuensi_penyedotan_id,keterangan_ventilasi',
                'sanitasi.jendelaLubangCahaya:id_jendela_lubang_cahaya,jendela_lubang_cahaya',
                'sanitasi.kondisiJendelaLubangCahaya:id_kondisi_jendela_lubang_cahaya,kondisi_jendela_lubang_cahaya',
                'sanitasi.ventilasi:id_ventilasi,ventilasi',
                'sanitasi.kondisiVentilasi:id_kondisi_ventilasi,kondisi_ventilasi',
                'sanitasi.kamarMandi:id_kamar_mandi,kamar_mandi',
                'sanitasi.kondisiKamarMandi:id_kondisi_kamar_mandi,kondisi_kamar_mandi',
                'sanitasi.jamban:id_jamban,jamban',
                'sanitasi.kondisiJamban:id_kondisi_jamban,kondisi_jamban',
                'sanitasi.sistemPembuanganAirKotor:id_sistem_pembuangan_air_kotor,sistem_pembuangan_air_kotor',
                'sanitasi.kondisiSistemPembuanganAirKotor:id_kondisi_sistem_pembuangan_air_kotor,kondisi_sistem_pembuangan_air_kotor',
                'sanitasi.sumberAirMinum:id_sumber_air_minum,sumber_air_minum',
                'sanitasi.kondisiSumberAirMinum:id_kondisi_sumber_air_minum,kondisi_sumber_air_minum',
                'sanitasi.sumberListrik:id_sumber_listrik,sumber_listrik',
                'sanitasi.frekuensiPenyedotan:id_frekuensi_penyedotan,frekuensi_penyedotan',
                'penilaian:id,rumah_id,nilai_a,nilai_b,nilai_c,nilai,status_rumah,status_luas',
            ])
            ->offset($this->offset)
            ->limit($this->limit);
    }

    public function map($r): array
    {
        // ... (isi mapping kamu tetap sama persis)
        return [
            // Identitas + Sosial + Kepemilikan
            $r->id_rumah,
            $r->alamat,
            $r->kelurahan->kecamatan->nama_kecamatan ?? '-',
            $r->kelurahan->nama_kelurahan ?? '-',
            $r->status_dtks,
            $r->sosialEkonomi->jenisKelamin->jenis_kelamin ?? '-',
            $r->sosialEkonomi->usia ?? '-',
            $r->sosialEkonomi->pendidikanTerakhir->pendidikan_terakhir ?? '-',
            $r->sosialEkonomi->pekerjaanUtama->pekerjaan_utama ?? '-',
            $r->sosialEkonomi->besarPenghasilan->besar_penghasilan ?? '-',
            $r->sosialEkonomi->besarPengeluaran->besar_pengeluaran ?? '-',
            $r->kepemilikan->statusKepemilikanTanah->status_kepemilikan_tanah ?? '-',
            $r->kepemilikan->buktiKepemilikanTanah->bukti_kepemilikan_tanah ?? '-',
            $r->kepemilikan->statusKepemilikanRumah->status_kepemilikan_rumah ?? '-',
            $r->kepemilikan->statusImb->status_imb ?? '-',
            $r->kepemilikan->nomor_imb ?? '-',
            $r->kepemilikan->asetRumahDitempatLain->aset_rumah_tempat_lain ?? '-',
            $r->kepemilikan->asetTanahDitempatLain->aset_tanah_tempat_lain ?? '-',
            $r->kepemilikan->jenisKawasanLokasiRumah->jenis_kawasan_lokasi ?? '-',
            $r->kepemilikan->nik_kepemilikan_rumah ?? '-',
             $r->tahun_pembangunan_rumah ?? '-',

            // Aspek Keselamatan
            $r->fisik->pondasi->pondasi ?? '-',
            $r->fisik?->jenisPondasi?->jenis_pondasi ?? '-',
            $r->fisik->kondisiPondasi->kondisi_pondasi ?? '-',
            $r->fisik->kondisiSloof->kondisi_sloof ?? '-',
            $r->fisik->kondisiKolomTiang->kondisi_kolom_tiang ?? '-',
            $r->fisik->kondisiBalok->kondisi_balok ?? '-',
            $r->fisik->kondisiStrukturAtap->kondisi_struktur_atap ?? '-',
            $r->penilaian->nilai_a ?? '-',

            // Aspek Kesehatan
            $r->sanitasi->jendelaLubangCahaya->jendela_lubang_cahaya ?? '-',
            $r->sanitasi->kondisiJendelaLubangCahaya->kondisi_jendela_lubang_cahaya ?? '-',
            $r->sanitasi->ventilasi->ventilasi ?? '-',
            $r->sanitasi->keterangan_ventilasi ?? '-',
            $r->sanitasi->kondisiVentilasi->kondisi_ventilasi ?? '-',
            $r->sanitasi->kamarMandi->kamar_mandi ?? '-',
            $r->sanitasi->kondisiKamarMandi->kondisi_kamar_mandi ?? '-',
            $r->sanitasi->jamban->jamban ?? '-',
            $r->sanitasi->kondisiJamban->kondisi_jamban ?? '-',
            $r->sanitasi->sistemPembuanganAirKotor->sistem_pembuangan_air_kotor ?? '-',
            $r->sanitasi->kondisiSistemPembuanganAirKotor->kondisi_sistem_pembuangan_air_kotor ?? '-',
            $r->sanitasi->sumberAirMinum->sumber_air_minum ?? '-',
            $r->sanitasi->kondisiSumberAirMinum->kondisi_sumber_air_minum ?? '-',
            $r->sanitasi->sumberListrik->sumber_listrik ?? '-',
            $r->sanitasi->frekuensiPenyedotan->frekuensi_penyedotan ?? '-',
            $r->penilaian->nilai_b ?? '-',

            // Aspek Luas & Ruang
            $r->fisik->luas_rumah ?? '-',
            $r->fisik->tinggi_rata_rumah ?? '-',
            $r->fisik->jumlah_penghuni_laki ?? '-',
            $r->fisik->jumlah_penghuni_perempuan ?? '-',
            $r->fisik->jumlah_abk ?? '-',
            $r->fisik->jumlah_kamar_tidur ?? '-',
            $r->fisik->luas_rata_kamar_tidur ?? '-',
            $r->fisik->ruangKeluargaDanTidur->ruang_keluarga_dan_tidur ?? '-',
            $r->fisik->jenisFisikBangunan->jenis_fisik_bangunan ?? '-',
            $r->fisik->fungsiRumah->fungsi_rumah ?? '-',
            $r->fisik->tipeRumah->tipe_rumah ?? '-',
            $r->fisik->jumlah_lantai_bangunan ?? '-',
            $r->penilaian->nilai_c ?? '-',

            // Komponen Bangunan
            $r->fisik->materialAtapTerluas->material_atap_terluas ?? '-',
            $r->fisik->kondisiPenutupAtap->kondisi_penutup_atap ?? '-',
            $r->fisik->materialDindingTerluas->material_dinding_terluas ?? '-',
            $r->fisik->kondisiDinding->kondisi_dinding ?? '-',
            $r->fisik->materialLantaiTerluas->material_lantai_terluas ?? '-',
            $r->fisik->kondisiLantai->kondisi_lantai ?? '-',
            $r->fisik->aksesKeJalan->akses_ke_jalan ?? '-',
            $r->fisik->bangunanMenghadapJalan->bangunan_menghadap_jalan ?? '-',
            $r->fisik->bangunanMenghadapSungai->bangunan_menghadap_sungai ?? '-',
            $r->fisik->bangunanBeradaSungai->bangunan_berada_sungai ?? '-',
            $r->fisik->bangunanBeradaLimbah->bangunan_berada_limbah ?? '-',

            // Penilaian Akhir
            $r->penilaian->nilai ?? '-',
            $r->penilaian->status_rumah ?? '-',
            $r->penilaian->status_luas == 1 ? 'Cukup' : 'Kurang',
            ($r->kepalaKeluarga->count() > 1) ? 'BACKLOG' : 'TIDAK BACKLOG',
           

            //dokumen
            // // Enam foto terakhir
            // $r->dokumen?->foto_kk ? public_path('storage/'.$r->dokumen->foto_kk) : null,
            // $r->dokumen?->foto_ktp ? public_path('storage/'.$r->dokumen->foto_ktp) : null,
            // $r->dokumen?->foto_imb ? public_path('storage/'.$r->dokumen->foto_imb) : null,
            // $r->dokumen?->foto_rumah_satu ? public_path('storage/'.$r->dokumen->foto_rumah_satu) : null,
            // $r->dokumen?->foto_rumah_dua ? public_path('storage/'.$r->dokumen->foto_rumah_dua) : null,
            // $r->dokumen?->foto_rumah_tiga ? public_path('storage/'.$r->dokumen->foto_rumah_tiga) : null,
        ];
    }

    public function headings(): array
    {
        // tetap sama seperti punyamu di atas
         return [
            // Identitas + Sosial + Kepemilikan
            'ID Rumah', 'Alamat', 'Kecamatan', 'Kelurahan', 'Status DTKS',
            'Jenis Kelamin', 'Usia', 'Pendidikan Terakhir', 'Pekerjaan Utama',
            'Besar Penghasilan/Bulan', 'Besar Pengeluaran/Bulan',
            'Status Kepemilikan Tanah', 'Bukti Kepemilikan Tanah', 'Status Kepemilikan Rumah',
            'Status IMB', 'Nomor IMB', 'Aset Rumah di Tempat Lain', 'Aset Tanah di Tempat Lain',
            'Jenis Kawasan Lokasi Rumah', 'NIK Pemilik Rumah', 'Tahun Pembangunan',

            // Aspek Keselamatan
            'Pondasi', 'Jenis Pondasi', 'Kondisi Pondasi', 'Kondisi Sloof', 'Kondisi Kolom/Tiang',
            'Kondisi Balok', 'Kondisi Struktur Atap', 'Nilai Keselamatan (A)',

            // Aspek Kesehatan
            'Jendela / Lubang Cahaya', 'Kondisi Jendela / Lubang Cahaya', 'Ventilasi',
            'Keterangan Ventilasi', 'Kondisi Ventilasi', 'Kamar Mandi', 'Kondisi Kamar Mandi',
            'Jamban', 'Kondisi Jamban', 'Sistem Pembuangan Air Kotor',
            'Kondisi Sistem Pembuangan Air Kotor', 'Sumber Air Minum',
            'Kondisi Sumber Air Minum', 'Sumber Listrik', 'Frekuensi Penyedotan', 'Nilai Kesehatan (B)',

            // Aspek Luas & Ruang
            'Luas Rumah (m²)', 'Tinggi Rata-rata Rumah (m)', 'Jumlah Penghuni Laki-laki',
            'Jumlah Penghuni Perempuan', 'Jumlah ABK', 'Jumlah Kamar Tidur', 'Luas Rata Kamar Tidur (m²)',
            'Ruang Keluarga & Tidur', 'Jenis Fisik Bangunan', 'Fungsi Rumah',
            'Tipe Rumah', 'Jumlah Lantai Bangunan', 'Nilai Luas & Ruang (C)',

            // Komponen Bangunan
            'Material Atap Terluas', 'Kondisi Penutup Atap', 'Material Dinding Terluas',
            'Kondisi Dinding', 'Material Lantai Terluas', 'Kondisi Lantai',
            'Akses Langsung ke Jalan', 'Bangunan Menghadap Jalan', 'Bangunan Menghadap Sungai',
            'Bangunan di Atas Sempadan Sungai', 'Bangunan di Area Limbah/Sutet',

            // Penilaian Akhir
            'Nilai Total', 'Status Rumah', 'Status Luas Rumah', 'Backlog',


            // //dokumen
            // 'Foto KK',
            // 'Foto KTP',
            // 'Foto IMB',
            // 'Foto Rumah 1',
            // 'Foto Rumah 2',
            // 'Foto Rumah 3',
        ];
    }

   public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $s = $event->sheet->getDelegate();

                // Sisipkan ruang untuk logo + header
                $s->insertNewRowBefore(1, 4);

                // === 🖼️ Logo Dinas ===
                $logoPath = public_path('assets/media/logos/logo.png');
                if (file_exists($logoPath)) {
                    $drawing = new Drawing();
                    $drawing->setPath($logoPath);
                    $drawing->setCoordinates('B1');
                    $drawing->setHeight(60);
                    $drawing->setOffsetX(20)->setOffsetY(5);
                    $drawing->setWorksheet($s);
                }

                // === Judul utama ===
                $s->mergeCells('C1:CV1');
                $s->setCellValue('C1', 'DINAS PERUMAHAN DAN KAWASAN PERMUKIMAN');
                $s->getStyle('C1')->getFont()->setBold(true)->setSize(20);
                $s->getStyle('C1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // === Subjudul ===
                $s->mergeCells('C2:CV2');
                $s->setCellValue('C2', 'KOTA BUKITTINGGI');
                $s->getStyle('C2')->getFont()->setBold(true)->setSize(18);
                $s->getStyle('C2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

                // === Header kategori utama ===
               // === Header kategori utama ===
                $s->setCellValue('A4', 'Identitas Rumah');
                $s->setCellValue('V4', 'Aspek Keselamatan'); // ← dulu U4, geser kanan 1 karena tambah kolom tahun
                $s->setCellValue('AD4', 'Aspek Kesehatan');  // ← dulu AC4
                $s->setCellValue('AT4', 'Aspek Persyaratan Luas dan Kebutuhan Ruang'); // ← dulu AS4
                $s->setCellValue('BF4', 'Aspek Komponen Bahan Bangunan'); // ← dulu BE4
                $s->setCellValue('BQ4', 'Penilaian Akhir'); // ← dulu BP4
                // $s->setCellValue('BW4', 'Dokumen Pendukung'); // jika aktifkan foto

                // === Merge kategori ===
                $s->mergeCells('A4:U4');   // Identitas Rumah → tambah 1 kolom (tahun)
                $s->mergeCells('V4:AC4');  // Aspek Keselamatan
                $s->mergeCells('AD4:AS4'); // Aspek Kesehatan
                $s->mergeCells('AT4:BE4'); // Aspek Luas & Ruang
                $s->mergeCells('BF4:BP4'); // Komponen Bahan
                $s->mergeCells('BQ4:BV4'); // Penilaian Akhir
                // $s->mergeCells('BW4:CB4'); // Dokumen Pendukung jika diaktifkan

                // === Style kategori (baris 4) ===
                $s->getStyle('A4:BV4')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 11],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                    ],
                    'fill' => [
                        'fillType' => 'solid',
                        'color'    => ['rgb' => 'E2EFDA'],
                    ],
                ]);

                // === Style heading kolom (baris 5) ===
                $s->getStyle('A5:BV5')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 10],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                        'wrapText'   => true,
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color'       => ['rgb' => 'AAAAAA'],
                        ],
                    ],
                ]);


                // === Ukuran baris header ===
                $s->getRowDimension(1)->setRowHeight(40);
                $s->getRowDimension(2)->setRowHeight(30);
                $s->getRowDimension(4)->setRowHeight(25);
                $s->getRowDimension(5)->setRowHeight(22);

                // // === Sisipkan foto-foto dokumen ===
                // $rows = $s->toArray(null, true, true, true);
                // $startRow = 6; // data mulai di baris ke-6

                // foreach ($rows as $index => $rowData) {
                //     $rowNum = $startRow + $index - 1;

                //     $fotoCols = [
                //         'BV' => $rowData['BV'] ?? null, // Foto KK
                //         'BW' => $rowData['BW'] ?? null, // Foto KTP
                //         'BX' => $rowData['BX'] ?? null, // Foto IMB
                //         'BY' => $rowData['BY'] ?? null, // Foto Rumah 1
                //         'BZ' => $rowData['BZ'] ?? null, // Foto Rumah 2
                //         'CA' => $rowData['CA'] ?? null, // Foto Rumah 3
                //     ];

                //     foreach ($fotoCols as $col => $path) {
                //         if ($path && file_exists($path)) {
                //             $drawing = new Drawing();
                //             $drawing->setPath($path);
                //             $drawing->setHeight(80);
                //             $drawing->setCoordinates($col . $rowNum);
                //             $drawing->setOffsetX(5)->setOffsetY(5);
                //             $drawing->setWorksheet($s);
                //         }
                //     }

                //     // Tinggi baris menyesuaikan gambar
                //     $s->getRowDimension($rowNum)->setRowHeight(95);
                // }

                // // === Lebar kolom untuk foto ===
                // foreach (['BV', 'BW', 'BX', 'BY', 'BZ', 'CA'] as $col) {
                //     $s->getColumnDimension($col)->setWidth(20);
                // }
            }
        ];
    }


    public function title(): string
    {
        return 'Data Rumah';
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
