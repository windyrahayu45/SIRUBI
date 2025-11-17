<?php

namespace App\Exports;

use App\Models\Rumah;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RumahExport implements WithMultipleSheets
{
    protected $offset;
    protected $limit;
    protected $query;
    protected $queryCallback;

    public function __construct($offset, $limit, $query = null)
    {
        $this->offset = $offset;
        $this->limit = $limit;
        $this->query = $query;
        
        // // 🔥 Pastikan query sudah object, bukan callable
        // if (is_callable($query)) {
        //     $this->queryCallback = function() use ($query) {
        //         return $query();
        //     };
        // } else {
        //     $this->queryCallback = function() use ($query) {
        //         return $query;
        //     };
        // }

         if ($query) {
            Log::info('RumahSheet menerima query:', [
                'sql'      => $query->toSql(),
                'bindings' => $query->getBindings(),
                'offset'   => $offset,
                'limit'    => $limit,
            ]);
        }
    }

    public function sheets(): array
    {
        return [
            // 'Rumah' => new RumahSheet($this->offset, $this->limit, $this->query),
            // 'Kepala Keluarga' => new KepalaKeluargaSheet($this->offset, $this->limit, $this->query),
            'Rumah' => new RumahSheet($this->query),
            'Kepala Keluarga' => new KepalaKeluargaSheet($this->query),
        ];
    }
}