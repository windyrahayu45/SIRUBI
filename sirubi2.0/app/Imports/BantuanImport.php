<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\TblBantuan;

class BantuanImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new TblBantuan([
            'kk'           => $row['no_kk'] ?? null,
            'nama'    => $row['nama_bantuan'] ?? null,
            'nama_program' => $row['program_bantuan'] ?? null,
            'nominal'         => $row['nominal'] ?? 0,
            'tahun'           => $row['tahun'] ?? null,
        ]);
    }
}

