<?php

namespace App\Exports;

use App\Exports\All\SheetBantuan;
use App\Exports\All\SheetIdentitasRumah;
use App\Exports\All\SheetKesehatan;
use App\Exports\All\SheetKeselamatan;
use App\Exports\All\SheetKK;
use App\Exports\All\SheetKomponen;
use App\Exports\All\SheetLokasiPenghuni;
use App\Exports\All\SheetLuasRuang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RumahExportAll implements WithMultipleSheets
{
    protected $query;

    public function __construct($query = null)
    {
        $this->query = $query;
    }

    public function sheets(): array
    {
        return [
            new SheetLokasiPenghuni($this->query),
            new SheetIdentitasRumah($this->query),
            new SheetKeselamatan($this->query),
            new SheetKesehatan($this->query),
            new SheetLuasRuang($this->query),
            new SheetKomponen($this->query),
            new SheetKK($this->query),
            new SheetBantuan($this->query)
        ];
    }
}
