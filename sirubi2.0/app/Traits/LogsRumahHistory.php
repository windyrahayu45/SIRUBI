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
        // 1. JWT user (via middleware)
        if (request()->has('auth')) {
            return request()->auth->id_user
                ?? request()->auth->id
                ?? null;
        }
        else{

            return auth()->user()->if;
        }

        // // 2. Livewire / Laravel default guard
        // if (auth()->check()) {
        //     return auth()->id();
        // }

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

        // WILAYAH
        'kecamatan_id' => \App\Models\IKecamatan::class,
        'kelurahan_id' => \App\Models\IKelurahan::class,

        // SOSIAL EKONOMI
        'jenis_kelamin_id' => IJenisKelamin::class,
        'pendidikan_terakhir_id' => IPendidikanTerakhir::class,
        'pekerjaan_utama_id' =>IPekerjaanUtama::class,
        'jumlah_kk_id' => \App\Models\IJumlahKk::class,
        'besar_penghasilan_perbulan_id' => \App\Models\IBesarPenghasilan::class,
        'besar_pengeluaran_perbulan_id' => \App\Models\IBesarPengeluaran::class,
        'status_dtks_id' => \App\Models\CStatusDtks::class,

        'status_kepemilikan_tanah_id' => \App\Models\IStatusKepemilikanTanah::class,
        'bukti_kepemilikan_tanah_id' => \App\Models\IBuktiKepemilikanTanah::class,
        'status_kepemilikan_rumah_id' => \App\Models\IStatusKepemilikanRumah::class,
        'status_imb_id' => \App\Models\IStatusIMB::class,
        'aset_rumah_ditempat_lain_id' => \App\Models\IAsetRumahTempatLain::class,
        'aset_tanah_ditempat_lain_id' => \App\Models\IAsetTanahTempatLain::class,
        'jenis_kawasan_lokasi_rumah_id' => \App\Models\IJenisKawasanLokasi::class,
        'pernah_mendapatkan_bantuan_id' => \App\Models\IPernahMendapatkanBantuan::class,

        // BANGUNAN
        'pondasi_id' => APondasi::class,
        'kondisi_pondasi_id' =>AKondisiPondasi::class,
        'jenis_pondasi' => TblJenisPondasi::class,
        'kondisi_sloof_id' => \App\Models\AKondisiSloof::class,
        'kondisi_kolom_tiang_id' => \App\Models\AKondisiKolomTiang::class,
        'kondisi_balok_id' => \App\Models\AKondisiBalok::class,
        'kondisi_struktur_atap_id' => \App\Models\AKondisiStrukturAtap::class,
        'material_atap_terluas_id' => \App\Models\DMaterialAtapTerluas::class,
        'kondisi_penutup_atap_id' => \App\Models\DKondisiPenutupAtap::class,
        'material_dinding_terluas_id' => \App\Models\DMaterialDindingTerluas::class,
        'kondisi_dinding_id' => \App\Models\DKondisiDinding::class,
        'material_lantai_terluas_id' => \App\Models\DMaterialLantaiTerluas::class,
        'kondisi_lantai_id' => \App\Models\DKondisiLantai::class,
        'akses_ke_jalan_id' => \App\Models\DAksesKeJalan::class,
        'bangunan_menghadap_jalan_id' => \App\Models\DBangunanMenghadapJalan::class,
        'bangunan_menghadap_sungai_id' => \App\Models\DBangunanMenghadapSungai::class,
        'bangunan_berada_limbah_id' => \App\Models\DBangunanBeradaLimbah::class,
        'bangunan_berada_sungai_id' => \App\Models\DBangunanBeradaSungai::class,
        'ruang_keluarga_dan_ruang_tidur_id' => \App\Models\CRuangKeluargaDanTidur::class,
        'jenis_fisik_bangunan_id' => \App\Models\CJenisFisikBangunan::class,
        'fungsi_rumah_id' => \App\Models\CFungsiRumah::class,
        'tipe_rumah_id' => \App\Models\CTipeRumah::class,


        // SANITASI
        'jendela_lubang_cahaya_id' => \App\Models\BJendelaLubangCahaya::class,
        'kondisi_jendela_lubang_cahaya_id' => \App\Models\BKondisiJendelaLubangCahaya::class,
        'ventilasi_id' => \App\Models\BVentilasi::class,
        'kondisi_ventilasi_id' => \App\Models\BKondisiVentilasi::class,
        'kamar_mandi_id' => \App\Models\BKamarMandi::class,
        'kondisi_kamar_mandi_id' => \App\Models\BKondisiKamarMandi::class,
        'jamban_id' => \App\Models\BJamban::class,
        'kondisi_jamban_id' => \App\Models\BKondisiJamban::class,
        'sistem_pembuangan_air_kotor_id' => \App\Models\BSistemPembuanganAirKotor::class,
        'kondisi_sistem_pembuangan_air_kotor_id' => \App\Models\BKondisiSistemPembuanganAirKotor::class,
        'frekuensi_penyedotan_id' => \App\Models\BFrekuensiPenyedotan::class,
        'sumber_air_minum_id' => \App\Models\BSumberAirMinum::class,
        'kondisi_sumber_air_minum_id' => \App\Models\BKondisiSumberAirMinum::class,
        'sumber_listrik_id' => \App\Models\BSumberListrik::class,

        
    ];

    // Jika field ada di mapping
    if (array_key_exists($field, $masterMap)) {

        $model = $masterMap[$field];

        // ARRAY → berarti checkbox multi
        if (is_array($value)) {
            return collect($value)->map(function ($id) use ($model) {
                return optional($model::find($id))->nama ?? $id;
            })->join(', ');
        }

        // SINGLE OPTION
        return optional($model::find($value))->nama ?? $value;
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