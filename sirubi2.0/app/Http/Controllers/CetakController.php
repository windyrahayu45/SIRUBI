<?php

namespace App\Http\Controllers;

use App\Models\IKelurahan;
use App\Models\Rumah;
use App\Models\SurveyQuestion;
use App\Models\SurveyQuestionAnswer;
use App\Models\TblBantuan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CetakController extends Controller
{

    public $question = [];
    public $questionAnswers = []; 
    public $totalStep = 9; 
    public $lastStep = 7; 

     public $allQuestions = [];
    
    public $pertanyaanLokasi = [];
    public $pertanyaanKk = [];
    public $pertanyaanIdentitas = [];
    public $pertanyaanKeselamatan = [];
    public  $pertanyaanKesehatan = [];
    public $pertanyaanLuasBangunan = [];
    public  $pertanyaanBahanBangunan = [];
    public $pertanyaanDokumentasi = [];
    public $pertanyaanLainnya = [];
     public $childQuestions = [];


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

    // Nama Pemilik
    $kepala = $rumah->kepalaKeluarga?->sortBy('id')->first();
    $anggotaPertama = $kepala?->anggota?->sortBy('id')->first();
    $namaPemilik = $anggotaPertama ? e($anggotaPertama->nama) : '-';

    // Bantuan
    $noKkList = $rumah->kepalaKeluarga->pluck('no_kk')->filter()->toArray();
    $bantuanRiwayat = TblBantuan::whereIn('kk', $noKkList)
        ->orderBy('tahun', 'desc')
        ->get();

    // Pertanyaan
    $question = SurveyQuestion::with('options')
        ->where('is_active', 1)
        ->whereNull('parent_question_id')
        ->orderBy('id', 'desc')
        ->get();

    $pertanyaanLokasi        = $question->where('module', 'lokasi');
    $pertanyaanKk            = $question->where('module', 'penghuni_rumah');
    $pertanyaanIdentitas     = $question->where('module', 'identitas_rumah');
    $pertanyaanKeselamatan   = $question->where('module', 'aspek_keselamatan');
    $pertanyaanKesehatan     = $question->where('module', 'aspek_kesehatan');
    $pertanyaanLuasBangunan  = $question->where('module', 'aspek_luas_kebutuhan');
    $pertanyaanBahanBangunan = $question->where('module', 'aspek_bahan_bangunan');
    $pertanyaanDokumentasi   = $question->where('module', 'foto_dokumentasi');
    $pertanyaanLainnya       = $question->where('module', 'pertanyaan_lainnya');

    $childQuestions = SurveyQuestion::with('options')
        ->where('is_active', 1)
        ->whereNotNull('parent_question_id')
        ->get();

    // Ambil jawaban
    $existingAnswers = SurveyQuestionAnswer::where('rumah_id', $id)->get();
    $questionAnswers = [];

    foreach ($existingAnswers as $ans) {
        if ($ans->answer_text !== null) {
            $questionAnswers[$ans->question_id] = $ans->answer_text;
        }
        if ($ans->answer_option_id !== null) {
            $questionAnswers[$ans->question_id] = $ans->answer_option_id;
        }
        if ($ans->answer_option_ids !== null) {
            $questionAnswers[$ans->question_id] = $ans->answer_option_ids;
        }
        if ($ans->file_path !== null) {
            $questionAnswers[$ans->question_id] = $ans->file_path;
        }
    }

    // Fungsi displayAnswer versi controller
    $displayAnswer = function ($q) use ($questionAnswers) {
        $ans = $questionAnswers[$q->id] ?? null;
        if (!$ans) return "-";

        if (in_array($q->type, ['select', 'radio'])) {
            $opt = $q->options->where('id', $ans)->first();
            return $opt ? $opt->label : "-";
        }

        if ($q->type === 'checkbox') {
            if (!is_array($ans)) return "-";
            return $q->options->whereIn('id', $ans)->pluck('label')->implode(', ');
        }

        if ($q->type === 'file') {
            return $ans ? '[File tersedia]' : '-';
        }

        return $ans;
    };

    // Map static
    $lat = $rumah->latitude;
    $lon = $rumah->longitude;
    $apiKey = '38acbfc8ed97436c802882f2e49c13a7';
    $mapUrl = "https://maps.geoapify.com/v1/staticmap?style=osm-carto&width=600&height=350&center=lonlat:{$lon},{$lat}&zoom=16&marker=lonlat:{$lon},{$lat};color:%23ff0000;size:medium&apiKey=$apiKey";

    // Kirim SEMUA data ke Blade PDF
    $pdf = Pdf::loadView('pdf.rumah-full', compact(
        'rumah', 'namaPemilik', 'bantuanRiwayat', 'mapUrl',
        'pertanyaanLokasi', 'pertanyaanKk', 'pertanyaanIdentitas',
        'pertanyaanKeselamatan', 'pertanyaanKesehatan',
        'pertanyaanLuasBangunan', 'pertanyaanBahanBangunan',
        'pertanyaanDokumentasi', 'pertanyaanLainnya',
        'childQuestions', 'questionAnswers', 'displayAnswer'
    ))
    ->setPaper('a4', 'portrait')
    ->setOption('isRemoteEnabled', true)
    ->setOption('isHtml5ParserEnabled', true);

    return $pdf->download('Data_Rumah_' . ($namaPemilik ?? 'Tanpa_Nama') . '.pdf');
    }

    public function getKelurahan(Request $request)
    {
        $kecamatanIds = $request->get('kecamatan_id', []);

        $kelurahan =  IKelurahan::whereIn('kecamatan_id', $kecamatanIds)
            ->orderBy('nama_kelurahan')
            ->get();

        return response()->json($kelurahan);
    }

}
