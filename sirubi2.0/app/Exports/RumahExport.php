<?php

namespace App\Exports;

use App\Models\Rumah;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RumahExport implements WithMultipleSheets
{
    protected $offset;
    protected $limit;

    public function __construct($offset, $limit)
    {
        $this->offset = $offset;
        $this->limit = $limit;
    }

    public function sheets(): array
    {
        return [
            'Rumah' => new RumahSheet($this->offset, $this->limit),
            'Kepala Keluarga' => new KepalaKeluargaSheet($this->offset, $this->limit),
        ];
    }
}