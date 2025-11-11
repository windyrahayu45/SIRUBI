<?php

namespace App\Exports;

use App\Models\Rumah;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RumahExport implements WithMultipleSheets
{
    protected $offset;
    protected $limit;
    protected $query;

    public function __construct($offset, $limit, $query = null)
    {
        $this->offset = $offset;
        $this->limit = $limit;
        $this->query = $query; // simpan query jika dikirim dari filter
    }

    public function sheets(): array
    {
        return [
            'Rumah' => new RumahSheet($this->offset, $this->limit, $this->query),
            'Kepala Keluarga' => new KepalaKeluargaSheet($this->offset, $this->limit, $this->query),
        ];
    }
}