<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use App\Models\TblBantuan;

class BantuanImportNoHeader implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            TblBantuan::create([
                'kk'           => $row[0],
                'nama'    => $row[1],
                'nama_program' => $row[2],
                'nominal'         => $row[3],
                'tahun'           => $row[4],
            ]);
        }
    }
}
