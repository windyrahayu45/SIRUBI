<?php

namespace App\Traits;
use App\Models;
use App\Models\AKondisiPondasi;
use App\Models\APondasi;
use App\Models\IJenisKelamin;
use App\Models\IPekerjaanUtama;
use App\Models\IPendidikanTerakhir;
use App\Models\RumahHistory;
use App\Models\TblJenisPondasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

trait LogsRumahHistory
{

     protected function getUserId()
{
    $auth = request()->auth ?? null;

    // Jika auth dari API (middleware)
    if ($auth !== null && is_object($auth)) {
        return $auth->id_user
            ?? $auth->id
            ?? null;
    }

    // Jika pakai auth web / livewire
    if (auth()->check()) {
        return auth()->user()->id();
    }

    // Fallback terakhir
    return null;
}
    /**
     * Mencatat perubahan pada data rumah (single field)
     */
    public function logHistory($rumahId, $kategori, $field, $oldValue, $newValue)
    {
        // Jika tidak ada perubahan → abaikan
        if ($oldValue == $newValue) {
            return;
        }

        RumahHistory::create([
            'rumah_id'   => $rumahId,
            'kategori'   => $kategori,
            'field'      => $field,
            'old_value'  => $oldValue,
            'new_value'  => $newValue,
            'changed_by' => $this->getUserId(),
            'changed_at' => now(),
        ]);
    }

    /**
 * Log perubahan nested array menjadi per-field
 */
public function logArrayChanges($rumahId, $kategori, $oldData, $newData, $prefix = '')
{
    foreach ($newData as $key => $newValue) {

        $fullKey = $prefix === '' ? $key : $prefix . '.' . $key;
        $oldValue = $oldData[$key] ?? null;

        // Jika value berupa array → masuk rekursif
        if (is_array($newValue)) {
            $this->logArrayChanges($rumahId, $kategori, $oldValue ?? [], $newValue, $fullKey);
            continue;
        }

        // Jika tidak ada perubahan → skip
        if ($oldValue == $newValue) continue;

        // Simpan perubahan (old_value dan new_value bukan JSON)
        RumahHistory::create([
            'rumah_id'   => $rumahId,
            'kategori'   => $kategori,
            'field'      => $fullKey,
            'old_value'  => $oldValue,
            'new_value'  => $newValue,
            'changed_by' => $this->getUserId(),
            'changed_at' => now(),
        ]);
    }
}

public function translateValue($kategori, $field, $value)
{
    if (is_null($value) || $value === '') {
        return '-';
    }

    // Jika value JSON → decode
    if ($this->isJson($value)) {
        $value = json_decode($value, true);
    }

    /*
    |--------------------------------------------------------------------------
    | 1. MASTER DATA STATIS — semua master kamu mapping di sini
    |--------------------------------------------------------------------------
    */

    $masterMap = [

    // ===========================
    // WILAYAH (punya kolom 'nama')
    // ===========================
    'kecamatan_id' => [
        'model'  => \App\Models\IKecamatan::class,
        'column' => 'nama_kecamatan'
    ],
    'kelurahan_id' => [
        'model'  => \App\Models\IKelurahan::class,
        'column' => 'nama_kelurahan'
    ],

    // ===========================
    // SOSIAL EKONOMI
    // ===========================
    'jenis_kelamin_id' => [
        'model'  => IJenisKelamin::class,
        'column' => 'jenis_kelamin'
    ],
    'pendidikan_terakhir_id' => [
        'model'  => IPendidikanTerakhir::class,
        'column' => 'pendidikan_terakhir'
    ],
    'pekerjaan_utama_id' => [
        'model'  => IPekerjaanUtama::class,
        'column' => 'pekerjaan_utama'
    ],
    'jumlah_kk_id' => [
        'model'  => \App\Models\IJumlahKk::class,
        'column' => 'jumlah_kk'
    ],
    'besar_penghasilan_perbulan_id' => [
        'model'  => \App\Models\IBesarPenghasilan::class,
        'column' => 'besar_penghasilan'
    ],
    'besar_pengeluaran_perbulan_id' => [
        'model'  => \App\Models\IBesarPengeluaran::class,
        'column' => 'besar_pengeluaran'
    ],
    'status_dtks_id' => [
        'model'  => \App\Models\CStatusDtks::class,
        'column' => 'status_dtks'
    ],

    'status_kepemilikan_tanah_id' => [
        'model'  => \App\Models\IStatusKepemilikanTanah::class,
        'column' => 'status_kepemilikan_tanah'
    ],
    'bukti_kepemilikan_tanah_id' => [
        'model'  => \App\Models\IBuktiKepemilikanTanah::class,
        'column' => 'bukti_kepemilikan_tanah'
    ],
    'status_kepemilikan_rumah_id' => [
        'model'  => \App\Models\IStatusKepemilikanRumah::class,
        'column' => 'status_kepemilikan_rumah'
    ],
    'status_imb_id' => [
        'model'  => \App\Models\IStatusIMB::class,
        'column' => 'status_imb'
    ],

    // ===========================
    // CONTOH MASTER TANPA 'nama'
    // ===========================
    'aset_rumah_ditempat_lain_id' => [
        'model'  => \App\Models\IAsetRumahTempatLain::class,
        'column' => 'aset_rumah_tempat_lain'
    ],
    'aset_tanah_ditempat_lain_id' => [
        'model'  => \App\Models\IAsetTanahTempatLain::class,
        'column' => 'aset_tanah_tempat_lain'
    ],
    'jenis_kawasan_lokasi_rumah_id' => [
        'model'  => \App\Models\IJenisKawasanLokasi::class,
        'column' => 'jenis_kawasan_lokasi'
    ],
    'pernah_mendapatkan_bantuan_id' => [
        'model'  => \App\Models\IPernahMendapatkanBantuan::class,
        'column' => 'pernah_mendapatkan_bantuan'
    ],

    // ===========================
    // BANGUNAN
    // ===========================
    'pondasi_id' => [
        'model'  => APondasi::class,
        'column' => 'pondasi'
    ],
    'kondisi_pondasi_id' => [
        'model'  => AKondisiPondasi::class,
        'column' => 'kondisi_pondasi'
    ],
    'jenis_pondasi' => [
        'model'  => TblJenisPondasi::class,
        'column' => 'jenis_pondasi'
    ],
    'kondisi_sloof_id' => [
        'model'  => \App\Models\AKondisiSloof::class,
        'column' => 'kondisi_sloof'
    ],
    'kondisi_kolom_tiang_id' => [
        'model'  => \App\Models\AKondisiKolomTiang::class,
        'column' => 'kondisi_kolom_tiang'
    ],
    'kondisi_balok_id' => [
        'model'  => \App\Models\AKondisiBalok::class,
        'column' => 'kondisi_balok'
    ],
    'kondisi_struktur_atap_id' => [
        'model'  => \App\Models\AKondisiStrukturAtap::class,
        'column' => 'kondisi_struktur_atap'
    ],

    'material_atap_terluas_id' => [
        'model'  => \App\Models\DMaterialAtapTerluas::class,
        'column' => 'material_atap_terluas'
    ],
    'kondisi_penutup_atap_id' => [
        'model'  => \App\Models\DKondisiPenutupAtap::class,
        'column' => 'kondisi_penutup_atap'
    ],
    'material_dinding_terluas_id' => [
        'model'  => \App\Models\DMaterialDindingTerluas::class,
        'column' => 'material_dinding_terluas'
    ],
    'kondisi_dinding_id' => [
        'model'  => \App\Models\DKondisiDinding::class,
        'column' => 'kondisi_dinding'
    ],
    'material_lantai_terluas_id' => [
        'model'  => \App\Models\DMaterialLantaiTerluas::class,
        'column' => 'material_lantai_terluas'
    ],
    'kondisi_lantai_id' => [
        'model'  => \App\Models\DKondisiLantai::class,
        'column' => 'kondisi_lantai'
    ],
    'akses_ke_jalan_id' => [
        'model'  => \App\Models\DAksesKeJalan::class,
        'column' => 'akses_ke_jalan'
    ],
    'bangunan_menghadap_jalan_id' => [
        'model'  => \App\Models\DBangunanMenghadapJalan::class,
        'column' => 'bangunan_menghadap_jalan'
    ],
    'bangunan_menghadap_sungai_id' => [
        'model'  => \App\Models\DBangunanMenghadapSungai::class,
        'column' => 'bangunan_menghadap_sungai'
    ],
    'bangunan_berada_limbah_id' => [
        'model'  => \App\Models\DBangunanBeradaLimbah::class,
        'column' => 'bangunan_berada_limbah'
    ],
    'bangunan_berada_sungai_id' => [
        'model'  => \App\Models\DBangunanBeradaSungai::class,
        'column' => 'bangunan_berada_sungai'
    ],

    'ruang_keluarga_dan_ruang_tidur_id' => [
        'model'  => \App\Models\CRuangKeluargaDanTidur::class,
        'column' => 'ruang_keluarga_dan_tidur'
    ],
    'jenis_fisik_bangunan_id' => [
        'model'  => \App\Models\CJenisFisikBangunan::class,
        'column' => 'jenis_fisik_bangunan'
    ],
    'fungsi_rumah_id' => [
        'model'  => \App\Models\CFungsiRumah::class,
        'column' => 'fungsi_rumah'
    ],
    'tipe_rumah_id' => [
        'model'  => \App\Models\CTipeRumah::class,
        'column' => 'tipe_rumah'
    ],

    // ===========================
    // SANITASI
    // ===========================
    'jendela_lubang_cahaya_id' => [
        'model'  => \App\Models\BJendelaLubangCahaya::class,
        'column' => 'jendela_lubang_cahaya'
    ],
    'kondisi_jendela_lubang_cahaya_id' => [
        'model'  => \App\Models\BKondisiJendelaLubangCahaya::class,
        'column' => 'kondisi_jendela_lubang_cahaya'
    ],
    'ventilasi_id' => [
        'model'  => \App\Models\BVentilasi::class,
        'column' => 'ventilasi'
    ],
    'kondisi_ventilasi_id' => [
        'model'  => \App\Models\BKondisiVentilasi::class,
        'column' => 'kondisi_ventilasi'
    ],
    'kamar_mandi_id' => [
        'model'  => \App\Models\BKamarMandi::class,
        'column' => 'kamar_mandi'
    ],
    'kondisi_kamar_mandi_id' => [
        'model'  => \App\Models\BKondisiKamarMandi::class,
        'column' => 'kondisi_kamar_mandi'
    ],
    'jamban_id' => [
        'model'  => \App\Models\BJamban::class,
        'column' => 'jamban'
    ],
    'kondisi_jamban_id' => [
        'model'  => \App\Models\BKondisiJamban::class,
        'column' => 'kondisi_jamban'
    ],
    'sistem_pembuangan_air_kotor_id' => [
        'model'  => \App\Models\BSistemPembuanganAirKotor::class,
        'column' => 'sistem_pembuangan_air_kotor'
    ],
    'kondisi_sistem_pembuangan_air_kotor_id' => [
        'model'  => \App\Models\BKondisiSistemPembuanganAirKotor::class,
        'column' => 'kondisi_sistem_pembuangan_air_kotor'
    ],
    'frekuensi_penyedotan_id' => [
        'model'  => \App\Models\BFrekuensiPenyedotan::class,
        'column' => 'frekuensi_penyedotan'
    ],
    'sumber_air_minum_id' => [
        'model'  => \App\Models\BSumberAirMinum::class,
        'column' => 'sumber_air_minum'
    ],
    'kondisi_sumber_air_minum_id' => [
        'model'  => \App\Models\BKondisiSumberAirMinum::class,
        'column' => 'kondisi_sumber_air_minum'
    ],
    'sumber_listrik_id' => [
        'model'  => \App\Models\BSumberListrik::class,
        'column' => 'sumber_listrik'
    ],
];


    // Jika field ada di mapping
   if (array_key_exists($field, $masterMap)) {

    $conf = $masterMap[$field];
    $model = $conf['model'];
    $column = $conf['column'] ?? 'nama';

    // MULTI (checkbox)
    if (is_array($value)) {
        return collect($value)->map(function ($id) use ($model, $column) {
            $row = $model::find($id);
            return $row ? ($row->$column ?? $id) : $id;
        })->join(', ');
    }

    // SINGLE
    $row = $model::find($value);
    return $row ? ($row->$column ?? $value) : $value;
}



    /*
    |--------------------------------------------------------------------------
    | 2. PERTANYAAN DINAMIS — survey
    |--------------------------------------------------------------------------
    */
     if ($kategori === 'kk') {

        // Jika NULL → ini penambahan
        if (empty($value)) {
            return '- (data baru)';
        }

        // Jika JSON detail → format rapi
        if ($this->isJson($value)) {
            return $this->parseKKString($value);
        }

        return $value;
    }


    if ($kategori === 'survey_answers') {

        /*
        |---------------------------------------------
        | Pecah field menjadi [questionId].[subField]
        |---------------------------------------------
        */
        if (str_contains($field, '.')) {
            [$questionId, $subField] = explode('.', $field);
        } else {
            $subField = $field;
            $questionId = null;
        }

        // Log::info('Translate survey field', [
        //     'field' => $field,
        //     'questionId' => $questionId,
        //     'subField' => $subField,
        //     'value' => $value,
        // ]);

        // TEXT / TEXTAREA
        if (trim($subField) === 'answer_text') {
            return $value;
        }

        // SINGLE SELECT / RADIO
        if (trim($subField) === 'answer_option_id') {
           
            $opt = \App\Models\SurveyQuestionOption::find($value);
             Log::info('Translate survey field', [
                'field' => $field,
                'questionId' => $questionId,
                'subField' => $subField,
                'value' => $value,
                'option' => $opt,
            ]);
            return $opt?->label ?? $opt?->option_text ?? $opt;
        }

        // MULTI SELECT / CHECKBOX
        if (trim($subField) === 'answer_option_ids') {

            if (!is_array($value)) return $value;

            return collect($value)->map(function ($id) {
                $opt = \App\Models\SurveyQuestionOption::find($id);
                return $opt?->label ?? $opt?->option_text ?? $id;
            })->join(', ');
        }
    }


    /*
    |--------------------------------------------------------------------------
    | 3. Default: nilai biasa
    |--------------------------------------------------------------------------
    */

    return $value;
}
private function parseKKString($value)
{
    if (!$value || !is_string($value)) return null;

    // Contoh format:
    // "KK A (No KK: 1212) | Anggota: aa → Tes 1 (123), ab → Tes 2 (456)"

    $result = [];

    // Pisah KK dan Anggota
    $parts = explode('| Anggota:', $value);

    // ====== KK ======
    $kkPart = trim($parts[0]); 
    preg_match('/KK\s+([A-Z])\s+\(No KK:\s+([0-9]+)\)/', $kkPart, $m);

    $result['kode_kk'] = $m[1] ?? null;
    $result['no_kk'] = $m[2] ?? null;

    // ====== Anggota ======
    $result['anggota'] = [];

    if (isset($parts[1])) {
        $anggotaRaw = explode(',', trim($parts[1]));

        foreach ($anggotaRaw as $row) {
            // row: "aa → Tes 1 (123123123)"
            preg_match('/([a-z]+)\s+→\s+(.+)\s+\(([0-9]+)\)/i', trim($row), $a);

            if ($a) {
                $result['anggota'][] = [
                    'kode_anggota' => $a[1],
                    'nama' => $a[2],
                    'nik' => $a[3],
                ];
            }
        }
    }

    return $result;
}


public function formatKategori($kategori)
{
    $map = [
        'survey_answers'        => 'Pertanyaan Lainnya',
        'kk'                    => 'Kepala Keluarga',
        'sosial_ekonomi'        => 'Data Sosial Ekonomi',
        'rumah'                 => 'Data Umum Rumah',
        'fisik_rumah'           => 'Aspek Keselamatan , Persyaratan Luas & Ruang serta Komponen Bangunan',
        'sanitasi_rumah'        => 'Aspek Sanitasi & Kesehatan',
        'bantuan_rumah'         => 'Data Bantuan',
        'kepemilikan_rumah'     => 'Data Kepemilikan',
        'dokumen_rumah'         => 'Dokumentasi Rumah',
        'penilaian_rumah'       => 'Penilaian Kondisi Rumah',
    ];

    return $map[$kategori] ?? ucfirst(str_replace('_', ' ', $kategori));
}

public function translateSurveyField($field)
{
    // Contoh field: "2.answer_option_id"
    if (!str_contains($field, '.')) {
        return $field;
    }

    [$questionId, $subField] = explode('.', $field);

    $question = \App\Models\SurveyQuestion::find($questionId);

    if (!$question) {
        return $field; // fallback
    }

    return $question->label ;
}


private function formatKK($kkArray)
{
    if (!is_array($kkArray)) return $kkArray;

    $output = [];

    foreach ($kkArray as $kk) {

        $line = "KK {$kk['kode_kk']} (No KK: {$kk['no_kk']})";

        // Anggota
        if (!empty($kk['anggota'])) {
            $anggotaList = collect($kk['anggota'])->map(function ($a) {
                return "{$a['kode_anggota']} → {$a['nama']} ({$a['nik']})";
            })->implode(', ');

            $line .= " | Anggota: {$anggotaList}";
        }

        $output[] = $line;
    }

    return implode("\n", $output);
}

public function logKKChange($rumahId, $oldKK, $newKK)
{
    $oldFormatted = $this->formatKK($oldKK);
    $newFormatted = $this->formatKK($newKK);

    if ($oldFormatted !== $newFormatted) {
        RumahHistory::create([
            'rumah_id'   => $rumahId,
            'kategori'   => 'kk',
            'field'      => 'data_kartu_keluarga',
            'old_value'  => $oldFormatted,
            'new_value'  => $newFormatted,
            'changed_by' => $this->getUserId(),
            'changed_at' => now(),
        ]);
    }
}


private function isJson($string)
{
    if (!is_string($string)) return false;
    json_decode($string);
    return json_last_error() === JSON_ERROR_NONE;
}




    /**
     * Mencatat perubahan otomatis untuk banyak field sekaligus
     * $oldData = model ->toArray()
     * $newData = data baru array
     */
    public function logMultiple($rumahId, $kategori, $oldData, $newData)
    {
        foreach ($newData as $field => $newValue) {
            $oldValue = $oldData[$field] ?? null;

            if ($oldValue != $newValue) {
                $this->logHistory($rumahId, $kategori, $field, $oldValue, $newValue);
            }
        }
    }
}