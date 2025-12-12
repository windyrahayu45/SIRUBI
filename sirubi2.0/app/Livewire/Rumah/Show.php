<?php

namespace App\Livewire\Rumah;

use App\Models\Rumah;
use App\Models\RumahHistory;
use App\Models\SurveyQuestion;
use App\Models\SurveyQuestionAnswer;
use App\Models\TblBantuan;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use App\Traits\LogsRumahHistory;
use Illuminate\Support\Facades\Log;

class Show extends Component
{
     use LogsRumahHistory;
    
    public $rumah, $namaPemilik = '';
    public $bantuanRiwayat = [];
    //public $historyByDate = [];

    
       protected $listeners = ['deleteRumah'];

      public $is_question = false;
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



    public function mount($id)
    {
        $this->rumah = Rumah::with([
            'kepemilikan',          // untuk status rumah
            'sosialEkonomi',        // untuk status backlog
            'fisik',
            'sanitasi',
            'penilaian',
            'dokumen',
            'bantuan',
            'kepalaKeluarga.anggota',
            'kelurahan.kecamatan'
        ])->findOrFail($id);

          $this->question = SurveyQuestion::with('options')
            ->where('is_active', 1)
            ->whereNull('parent_question_id')
            ->orderBy('id', 'desc')
            ->get(); 

            
        
        $this->pertanyaanLokasi        = $this->question->where('module', 'lokasi');
        $this->pertanyaanKk            = $this->question->where('module', 'penghuni_rumah');
        $this->pertanyaanIdentitas     = $this->question->where('module', 'identitas_rumah');
        $this->pertanyaanKeselamatan   = $this->question->where('module', 'aspek_keselamatan');
        $this->pertanyaanKesehatan     = $this->question->where('module', 'aspek_kesehatan');
        $this->pertanyaanLuasBangunan  = $this->question->where('module', 'aspek_luas_kebutuhan');
        $this->pertanyaanBahanBangunan = $this->question->where('module', 'aspek_bahan_bangunan');
        $this->pertanyaanDokumentasi   = $this->question->where('module', 'foto_dokumentasi');
        $this->pertanyaanLainnya       = $this->question->where('module', 'pertanyaan_lainnya');

        $this->allQuestions = SurveyQuestion::with('options')->where('is_active', 1)->orderBy('id', 'desc')->get();
        $this->childQuestions = SurveyQuestion::with('options')
            ->where('is_active', 1)
            ->whereNotNull('parent_question_id')
            ->get();


        $existingAnswers = SurveyQuestionAnswer::where('rumah_id', $id)->get();

        foreach ($existingAnswers as $ans) {
            
            // TEXT, TEXTAREA, NUMBER, DATE
            if ($ans->answer_text !== null) {
                $this->questionAnswers[$ans->question_id] = $ans->answer_text;
            }

            // SELECT atau RADIO
            if ($ans->answer_option_id !== null) {
                $this->questionAnswers[$ans->question_id] = $ans->answer_option_id;
            }

            // CHECKBOX (multi select)
            if ($ans->answer_option_ids !== null) {
                $this->questionAnswers[$ans->question_id] = $ans->answer_option_ids; // array
            }

            // FILE (kalau ada)
            if ($ans->file_path !== null) {
                $this->questionAnswers[$ans->question_id] = $ans->file_path;
            }
        }

        
        // $history = RumahHistory::with('user')
        // ->where('rumah_id', $id)
        // ->orderBy('changed_at', 'desc')
        // ->get();

        // // GROUP LEVEL 1 = tanggal
        // $this->historyByDate = $history->groupBy(function($item){
        //     return $item->changed_at->format('Y-m-d');
        // })->map(function($items){
            
        //     // GROUP LEVEL 2 = user
        //     return $items->groupBy('changed_by');

        // });

       // dd($this->historyByDate);

         // 🔹 Ambil semua no_kk dari kepala keluarga rumah ini
        $noKkList = $this->rumah->kepalaKeluarga->pluck('no_kk')->filter()->toArray();

        // 🔹 Ambil semua data bantuan berdasarkan daftar no_kk tersebut
        $this->bantuanRiwayat = TblBantuan::whereIn('kk', $noKkList)
            ->orderBy('tahun', 'desc')
            ->get();

         $kepala = $this->rumah->kepalaKeluarga?->sortBy('id')->first();

        // Dari kepala keluarga pertama, ambil anggota pertama (berdasarkan id)
        $anggotaPertama = $kepala?->anggota?->sortBy('id')->first();

        // Jika ada nama anggota, tampilkan
        $this->namaPemilik = $anggotaPertama ? e($anggotaPertama->nama) : '-';
    }

    public function displayAnswer($q)
    {
        $answer = $this->questionAnswers[$q->id] ?? null;

        if (!$answer) return '-';

        // SELECT & RADIO (single)
        if (in_array($q->type, ['select', 'radio'])) {
            $opt = $q->options->where('id', $answer)->first();
            return $opt ? $opt->label : $answer;
        }

        // CHECKBOX (multiple)
        if ($q->type === 'checkbox') {
            if (!is_array($answer)) return '-';

            return $q->options
                ->whereIn('id', $answer)
                ->pluck('label')
                ->implode(', ');
        }

        // if ($q->type === 'file') {
        //     if (!$answer) return '-';

        //     if (file_exists(storage_path('app/public/'.$answer))) {
        //         return '[Gambar tersedia]';
        //     }
        //     return '[File] ' . $answer;
        // }

        if ($q->type === 'file') {
    if (!$answer) return '-';

    $path = $answer;
    $fullPath = storage_path('app/public/' . $path);
    $url = asset('storage/' . $path);

    if (!file_exists($fullPath)) {
        return '<span class="text-danger">File tidak ditemukan</span>';
    }

    $ext = strtolower(pathinfo($fullPath, PATHINFO_EXTENSION));

    // ==========================
    // 1️⃣ PREVIEW IMAGE (JPG/PNG/WEBP)
    // ==========================
    if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
        return '
            <img src="'. $url .'"
                class="img-fluid w-100 h-250px object-fit-cover rounded-top preview-foto"
                style="max-height: 200px; object-fit: cover; cursor: pointer;"
                data-bs-toggle="modal"
                data-bs-target="#previewModal"
                data-src="'. $url .'">
        ';
    }

    // ==========================
    // 2️⃣ PREVIEW PDF (IFRAME)
    // ==========================
    if ($ext === 'pdf') {
        return '
            <div class="border rounded" style="overflow: hidden; width:100%; max-width:450px; height:300px;">
                <iframe src="'. $url .'" width="100%" height="100%" style="border:0;"></iframe>
            </div>
            <a href="'. $url .'" target="_blank" class="btn btn-sm btn-primary mt-2">
                Buka PDF
            </a>
        ';
    }

    // ==========================
    // 3️⃣ FILE LAIN: DOCX, XLSX, ZIP, DLL
    // ==========================
    return '
        <a href="'. $url .'" target="_blank" class="d-flex align-items-center">
            <i class="bi bi-file-earmark-text fs-2 me-2"></i>
            '. strtoupper($ext) .' File (klik untuk buka)
        </a>
    ';
}



        // TEXT, TEXTAREA, NUMBER, DATE
        return $answer;
    }

public function getHistoryByDateProperty()
{
    return RumahHistory::with('user')
        ->where('rumah_id', $this->rumah->id_rumah)
        ->orderBy('changed_at', 'desc')
        ->get()

        // Paksa ke timezone WIB
        ->map(function ($item) {
            $item->changed_at = \Carbon\Carbon::parse($item->changed_at)
                ->timezone('Asia/Jakarta');
            return $item;
        })

        // 1️⃣ Group per tanggal
        ->groupBy(function ($item) {
            return $item->changed_at->format('Y-m-d');
        })

        // 2️⃣ Group per jam-menit-detik
        ->map(function ($itemsPerDate) {
            return $itemsPerDate->groupBy(function ($item) {
                return $item->changed_at->format('H:i:s');
            })
            // 3️⃣ Dalam setiap waktu, group lagi per user
            ->map(function ($itemsPerTime) {
                return $itemsPerTime->groupBy('changed_by');
            });
        });
}


    public function cetakPdf()
    {
        

        Log::info('PDF DATA', [
            'lokasi' => $this->pertanyaanLokasi,
            'kk'     => $this->pertanyaanKk,
            'lainnya'=> $this->pertanyaanLainnya,
        ]);

        $pdf = Pdf::loadView('pdf.rumah-full', [
            'rumah' => $this->rumah,
            'namaPemilik' => $this->namaPemilik,
            'bantuanRiwayat' => $this->bantuanRiwayat,

             // Semua grup pertanyaan
            'pertanyaanLokasi'        => $this->pertanyaanLokasi,
            'pertanyaanKk'            => $this->pertanyaanKk,
            'pertanyaanIdentitas'     => $this->pertanyaanIdentitas,
            'pertanyaanKeselamatan'   => $this->pertanyaanKeselamatan,
            'pertanyaanKesehatan'     => $this->pertanyaanKesehatan,
            'pertanyaanLuasBangunan'  => $this->pertanyaanLuasBangunan,
            'pertanyaanBahanBangunan' => $this->pertanyaanBahanBangunan,
            'pertanyaanDokumentasi'   => $this->pertanyaanDokumentasi,
            'pertanyaanLainnya'       => $this->pertanyaanLainnya,

            'childQuestions' => $this->childQuestions,
            'questionAnswers' => $this->questionAnswers,
            'displayAnswer' => fn($q) => $this->displayAnswer($q),
        ])->setPaper('a4', 'portrait');

        

        return response()->streamDownload(
            fn () => print($pdf->output()),
            'Data_Rumah_' . ($this->namaPemilik ?? 'Tanpa_Nama') . '.pdf'
        );
    }

    public function getDisplayAnswerForPdf($q)
    {
        return $this->displayAnswer($q);
    }


    public function goToEdit($id)
    {
        return redirect()->route('rumah.edit', $id);
    }

    public function deleteRumah($payload = [])
    {
        $id = $payload['id'] ?? null;

        if (!$id) return;

        $rumah = Rumah::find($id);

        if ($rumah) {
            $rumah->delete();
            
            $this->dispatch('rumahDeleted', [
                'message' => "Data rumah ID {$id} berhasil dihapus!"
            ]);
        }
    }


    public function render()
    {
        return view('livewire.rumah.show')
            ->extends('layouts.master')
            ->section('content');
    }
}
