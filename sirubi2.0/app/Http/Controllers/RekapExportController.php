<?php

namespace App\Http\Controllers;

use App\Exports\RekapAllExport;
use App\Models\IKecamatan;
use App\Services\Rekap1Builder;
use App\Services\Rekap2Builder;
use App\Services\Rekap2PdfBuilder;
use App\Services\Rekap3Builder;
use App\Services\Rekap3PdfBuilder;
use App\Services\Rekap4Builder;
use App\Services\Rekap4PdfBuilder;
use App\Services\Rekap5Builder;
use App\Services\Rekap5PdfBuilder;
use App\Services\Rekap6Builder;
use App\Services\Rekap6PdfBuilder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;

class RekapExportController extends Controller
{
      public function exportAllExcel($kecamatan)
    {
        $kec = IKecamatan::findOrFail($kecamatan);
        $filename = "rekapitulasi_kecamatan_{$kec->nama_kecamatan}.xlsx";

        return FacadesExcel::download(
            new RekapAllExport($kecamatan), 
            $filename
        );
    }


    /**
     * EXPORT PDF SEMUA TABEL (HALAMAN PER ACCORDION)
     */
    public function exportAllPdf($kecamatan)
    {
        $kec = IKecamatan::findOrFail($kecamatan);

        // Ambil semua data per rekap
    $rekap1     = Rekap1Builder::build($kecamatan);
    $rekap2Full = Rekap2PdfBuilder::build($kecamatan);
    $rekap3Full = Rekap3PdfBuilder::build($kecamatan);

    $html  = view('export.rekap1', compact('rekap1','kec'))->render();

    // HALAMAN BARU
    $html .= '<div class="page-break"></div>';

    $html .= view('export.rekap2', [
        'rekap2'    => $rekap2Full['data'],
        'header2'   => $rekap2Full['header2'],
        'header3'   => $rekap2Full['header3'],
        'rekap2Sum' => $rekap2Full['rekap2Sum'],
        'masters'   => $rekap2Full['masters'],
        'kec'       => $kec
    ])->render();

    // HALAMAN BARU
    // $html .= '<div class="page-break"></div>';

    $html .= view('export.rekap3', [
        'rekap3'    => $rekap3Full['data'],   // ⬅ BENAR!
        'header2'   => $rekap3Full['header2'], // ⬅ BENAR!
        'header3'   => $rekap3Full['header3'], // ⬅ BENAR!
        'rekap3Sum' => $rekap3Full['rekap3Sum'], // ⬅ BENAR!
        'masters'   => $rekap3Full['masters'], // ⬅ BENAR!
        'kec'       => $kec
    ])->render();

    $rekap4Full = Rekap4PdfBuilder::build($kecamatan);

    $html .= view('export.rekap4', [
        'rekap4'     => $rekap4Full['data'],
        'masters'    => $rekap4Full['masters'],
        'chunks'     => $rekap4Full['chunks'],
        'flatCols'   => $rekap4Full['flatCols'],
        'rekap4Sum'  => $rekap4Full['rekap4Sum'],
        'kec'        => $kec
    ])->render();

     $rekap45ull = Rekap5PdfBuilder::build($kecamatan);

    $html .= view('export.rekap5', [
        'data'       => $rekap45ull['data'],   // ✔ BENAR
        'masters'    => $rekap45ull['masters'],
        'chunks'     => $rekap45ull['chunks'],
        'flatCols'   => $rekap45ull['flatCols'],
        'rekap5Sum'  => $rekap45ull['rekap5Sum'],
        'kec'        => $kec
    ])->render();

    $rekap6Full = Rekap6PdfBuilder::build($kecamatan);
$html .= '<div class="page-break"></div>';
    $html .= view('export.rekap6', [
        'data'      => $rekap6Full['data'],
        'chunks'    => $rekap6Full['chunks'],
        'flatCols'  => $rekap6Full['flatCols'],
        'rekap6Sum' => $rekap6Full['rekap6Sum'],
        'kec'       => $kec
    ])->render();

        // // Gabungkan semua view jadi HTML besar
        // $html = view('export.rekap1', compact('rekap1', 'kec'))->render();
        // $html .= view('export.rekap2', compact('rekap2', 'kec'))->render();
        // $html .= view('export.rekap3', compact('rekap3', 'kec'))->render();
        // $html .= view('export.rekap4', compact('rekap4', 'kec'))->render();
        // $html .= view('export.rekap5', compact('rekap5', 'kec'))->render();
        // $html .= view('export.rekap6', compact('rekap6', 'kec'))->render();

        // Buat PDF
        $pdf = Pdf::loadHTML($html)
                ->setPaper('A4', 'landscape')
                ->setOption('isHtml5ParserEnabled', true)
                ->setOption('isRemoteEnabled', true);

        return $pdf->download("Rekap_Kecamatan_{$kec->nama_kecamatan}.pdf");
    }

}
