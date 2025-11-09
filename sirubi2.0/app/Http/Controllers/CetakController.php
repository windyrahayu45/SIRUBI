<?php

namespace App\Http\Controllers;

use App\Models\Rumah;
use App\Models\TblBantuan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class CetakController extends Controller
{
     public function cetak($id)
    {
        $rumah = Rumah::with([
            'kepemilikan',
            'sosialEkonomi',
            'fisik',
            'sanitasi',
            'penilaian',
            'dokumen',
            'bantuan',
            'kepalaKeluarga.anggota',
            'kelurahan.kecamatan'
        ])->findOrFail($id);

        $noKkList = $rumah->kepalaKeluarga->pluck('no_kk')->filter()->toArray();
        $bantuanRiwayat = TblBantuan::whereIn('kk', $noKkList)
            ->orderBy('tahun', 'desc')
            ->get();

        $kepala = $rumah->kepalaKeluarga?->sortBy('id')->first();
        $anggotaPertama = $kepala?->anggota?->sortBy('id')->first();
        $namaPemilik = $anggotaPertama ? e($anggotaPertama->nama) : '-';

        $lat = $rumah->latitude;
        $lon = $rumah->longitude;

        // Ambil snapshot dari layanan static map (contoh OSM via Maps Static API)
        $mapUrl = "https://staticmap.openstreetmap.de/staticmap.php?center={$lat},{$lon}&zoom=16&size=600x350&markers={$lat},{$lon},lightblue1";


        $pdf = Pdf::loadView('pdf.rumah-full', compact('rumah', 'namaPemilik', 'bantuanRiwayat', 'mapUrl'))
            ->setPaper('a4', 'portrait')
             ->setOption('isRemoteEnabled', true)
    ->setOption('isHtml5ParserEnabled', true);

        return $pdf->download('Data_Rumah_' . ($namaPemilik ?? 'Tanpa_Nama') . '.pdf');
    }
}
