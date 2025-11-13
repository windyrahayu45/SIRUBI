<?php

namespace App\Exports;

use App\Exports\Sheets\Rekap2Sheet;
use App\Exports\Sheets\Rekap3Sheet;
use App\Exports\Sheets\Rekap4Sheet;
use App\Exports\Sheets\Rekap5Sheet;
use App\Exports\Sheets\Rekap6Sheet;
use App\Exports\Sheets\Rekap1Sheet;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

// Import semua sheet rekap


class RekapAllExport implements WithMultipleSheets
{
    protected $kecamatanId;

    public function __construct($kecamatanId)
    {
        $this->kecamatanId = $kecamatanId;
    }

    public function sheets(): array
    {
        return [
            new Rekap1Sheet($this->kecamatanId),
            new Rekap2Sheet($this->kecamatanId),
            new Rekap3Sheet($this->kecamatanId),
            new Rekap4Sheet($this->kecamatanId),
            new Rekap5Sheet($this->kecamatanId),
            new Rekap6Sheet($this->kecamatanId),
        ];
    }
}
