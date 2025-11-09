<?php

namespace App\Exports;

use App\Models\PenilaianRumah;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PenilaianSheet implements FromQuery, WithMapping, WithHeadings, WithTitle, WithChunkReading, ShouldAutoSize
{
    public function query()
    {
        // Stream data langsung dari DB dengan relasi rumah
        return PenilaianRumah::with('rumah:id_rumah,alamat')
            ->orderBy('id_penilaian_rumah', 'asc');
    }

    public function map($p): array
    {
        return [
            $p->rumah->id_rumah ?? '-',
            $p->rumah->alamat ?? '-',
            $p->nilai_a ?? '-',
            $p->nilai_b ?? '-',
            $p->nilai_c ?? '-',
            $p->nilai ?? '-',
            $p->status_rumah ?? '-',
            $p->prioritas ?? '-',
        ];
    }

    public function headings(): array
    {
        return [
            'ID Rumah',
            'Alamat',
            'Nilai A (Keselamatan)',
            'Nilai B (Kesehatan)',
            'Nilai C (Komponen)',
            'Nilai Total',
            'Status Rumah',
            'Prioritas',
        ];
    }

    public function title(): string
    {
        return 'Penilaian Rumah';
    }

    public function chunkSize(): int
    {
        return 5000; // ⚡ baca per 5.000 baris
    }
}
