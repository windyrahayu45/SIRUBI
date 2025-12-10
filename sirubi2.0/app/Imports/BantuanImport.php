<?php

namespace App\Imports;

use App\Models\TblBantuan;
use App\Models\AnggotaKeluarga;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BantuanImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $kk  = null;
        $nik = $row['nik'] ?? null;
        $excelKK = $row['no_kk'] ?? null;

        // 1️⃣ Jika Excel berisi No KK
        if ($excelKK) {
            $kk = $excelKK;
        }

        // 2️⃣ Jika NIK diisi → cari KK dari database
        if ($nik) {
            $anggota = AnggotaKeluarga::with('kepalaKeluarga')
                        ->where('nik', $nik)
                        ->first();

            if ($anggota && $anggota->kepalaKeluarga) {
                // Override KK dari kepala keluarga
                $kk = $anggota->kepalaKeluarga->no_kk;
            }
            else{
                $kk = $excelKK;
            }
        }

        // 3️⃣ Jika keduanya null → kk tetap null

        return new TblBantuan([
            'kk'            => $kk,
            'nik'           => $nik, // ← simpan nik jika ada
            'nama'          => $row['nama_bantuan'] ?? null,
            'nama_program'  => $row['nama_program'] ?? null,
            'nominal'       => preg_replace('/[^0-9]/', '', ($row['nominal'] ?? 0)),
            'tahun'         => $row['tahun_bantuan'] ?? null,
        ]);
    }
}
