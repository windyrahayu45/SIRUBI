<?php

namespace App\Exports;

use App\Exports\Prod\SheetBantuan;
use App\Exports\Prod\SheetIdentitasRumah;
use App\Exports\Prod\SheetKesehatan;
use App\Exports\Prod\SheetKeselamatan;
use App\Exports\Prod\SheetKK;
use App\Exports\Prod\SheetKomponen;
use App\Exports\Prod\SheetLokasiPenghuni;
use App\Exports\Prod\SheetLuasRuang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProdExportAll implements WithMultipleSheets
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
