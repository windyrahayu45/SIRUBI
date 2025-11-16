<?php

namespace App\Livewire;

use App\Models\BantuanRumah;
use App\Models\Rumah;
use App\Models\TblBantuan;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{

   
    public $tab = 'rumah';

     public $rumah = [
        'labels' => [],
        'series' => [],
    ];



   public $penduduk = [
        'labels' => [],
        'series' => [],
    ];


    public $kawasan = [
        'labels' => [],
        'series' => [],
    ];

    public $stat = [
        'total_rumah' => 0,
        'total_penduduk' => 0,
        'total_rtlh' => 0,
        'total_dtks' => 0,
    ];

    public $pieImb = [
    'labels' => [],
    'series' => []
    ];

    public $pieDtks = [
        'labels' => [],
        'series' => []
    ];

    public $topKelurahan = [];
    public $bantuanList = [];
      public $bantuanKelurahan = [
        'labels' => [],
        'series' => [],
    ];

    public function mount()
    {
        $this->loadRumahChart();
        $this->loadPendudukChart();
        $this->loadKawasanChart();
        $this->loadStatCards();
        $this->loadPieImb();
        $this->loadPieDtks();
        $this->loadTopKelurahan();
         $this->loadTopKelurahanBantuan();
    }

    public function loadTopKelurahanBantuan()
    {
        /* --------------------------------------------------------
         * 1️⃣   BANTUAN DARI TABEL bantuan_rumah
         * -------------------------------------------------------- */
       $br = BantuanRumah::with('rumah.kelurahan')
        ->get()
        ->filter(fn($row) =>
            $row->rumah && $row->rumah->kelurahan
        )
        ->groupBy(fn($row) => $row->rumah->kelurahan->nama_kelurahan)
        ->map(fn($g) => $g->count());

            /* --------------------------------------------------------
            * 2️⃣   BANTUAN DARI TABEL tbl_bantuan
            * -------------------------------------------------------- */
        $tb = TblBantuan::with('kepalaKeluarga.rumah.kelurahan')
        ->get()
        ->filter(fn($row) =>
            $row->kepalaKeluarga &&
            $row->kepalaKeluarga->rumah &&
            $row->kepalaKeluarga->rumah->kelurahan
        )
        ->groupBy(fn($row) => $row->kepalaKeluarga->rumah->kelurahan->nama_kelurahan)
        ->map(fn($g) => $g->count());


        /* --------------------------------------------------------
         * 3️⃣   GABUNGKAN DUA SUMBER BANTUAN
         * -------------------------------------------------------- */
        $merged = $br
            ->mergeRecursive($tb)
            ->map(fn($item) => is_array($item) ? array_sum($item) : $item)
            ->sortDesc()
            ->take(10); // TOP 10


        /* --------------------------------------------------------
         * 4️⃣   SET KE CHART
         * -------------------------------------------------------- */
        $this->bantuanKelurahan = [
            'labels' => $merged->keys()->toArray(),
            'series' => $merged->values()->toArray(),
        ];

        $this->bantuanList = collect($this->bantuanKelurahan['labels'])
    ->map(function($nama, $index) {
        return [
            'nama_kelurahan' => $nama,
            'jumlah'         => $this->bantuanKelurahan['series'][$index],
        ];
    })
    ->toArray();
    }

    public function loadTopKelurahan()
    {
        // Ambil total RTLH untuk hitung persentase
        $totalRTLH = \App\Models\Rumah::whereHas('penilaian', function($q){
            $q->where('status_rumah', 'RTLH');
        })->count();

        // Ambil 10 kelurahan teratas
        $data = \App\Models\Rumah::select('kelurahan_id')
            ->whereHas('penilaian', fn($q) => $q->where('status_rumah', 'RTLH'))
            ->with('kelurahan:id_kelurahan,nama_kelurahan') // pastikan model IKelurahan
            ->get()
            ->groupBy('kelurahan_id')
            ->map(function($row) use ($totalRTLH) {
                return [
                    'nama_kelurahan' => $row->first()->kelurahan->nama_kelurahan ?? '-',
                    'jumlah' => $row->count(),
                    'persen' => $totalRTLH > 0 ? round(($row->count() / $totalRTLH) * 100, 1) : 0
                ];
            })
            ->sortByDesc('jumlah')
            ->take(10)
            ->values()
            ->toArray();

        $this->topKelurahan = $data;
    }


    public function loadPieImb()
    {
        $imb      = \App\Models\KepemilikanRumah::where('status_imb_id', 1)->count();
        $nonImb   = \App\Models\KepemilikanRumah::where('status_imb_id', '!=', 1)->count();

        $this->pieImb = [
            'labels' => ['Ada IMB', 'Tidak Ada IMB'],
            'series' => [$imb, $nonImb]
        ];
    }

    public function loadPieDtks()
    {
        $dtks    = \App\Models\SosialEkonomiRumah::where('status_dtks_id', 1)->count();
        $nondtks = \App\Models\SosialEkonomiRumah::where('status_dtks_id', '!=', 1)->count();

        $this->pieDtks = [
            'labels' => ['DTKS', 'Non DTKS'],
            'series' => [$dtks, $nondtks]
        ];
    }

    
    public function loadStatCards()
    {
        // TOTAL RUMAH
        $this->stat['total_rumah'] = \App\Models\Rumah::count();

        // TOTAL RTLH
        $this->stat['total_rtlh'] = \App\Models\Rumah::whereHas('penilaian', function($q){
            $q->where('status_rumah', 'RTLH');
        })->count();


        // TOTAL PENDUDUK = laki + perempuan
        $laki       = \App\Models\FisikRumah::sum('jumlah_penghuni_laki');
        $perempuan  = \App\Models\FisikRumah::sum('jumlah_penghuni_perempuan');
        $this->stat['total_penduduk'] = $laki + $perempuan;

        // TOTAL DTKS (status_dtks_id = 1)
        $this->stat['total_dtks'] = DB::table('sosial_ekonomi_rumah')
            ->where('status_dtks_id', 1)
            ->count();
    }

    public function loadRumahChart()
    {
        $totalRumah = Rumah::count();

        $jumlahRTLH = Rumah::whereHas('penilaian', function($q) {
            $q->where('status_rumah', 'RTLH');
        })->count();

        $jumlahRLH = Rumah::whereHas('penilaian', function($q) {
            $q->where('status_rumah', 'RLH');
        })->count();

        $jumlahRTLHNonSewa = Rumah::whereHas('penilaian', function($q) {
                $q->where('status_rumah', 'RTLH');
            })
            ->whereHas('kepemilikan', function($q) {
                $q->where('status_kepemilikan_rumah_id', '!=', 3);
            })
            ->count();

        $jumlahRTLHSewa = Rumah::whereHas('penilaian', function($q) {
                $q->where('status_rumah', 'RTLH');
            })
            ->whereHas('kepemilikan', function($q) {
                $q->where('status_kepemilikan_rumah_id', 3);
            })
            ->count();

        // 🔥 Tambahan: jumlah rumah DTKS
        $jumlahDTKS = Rumah::whereHas('sosialEkonomi', function($q) {
            $q->where('status_dtks_id', 1); // 1 = DTKS
        })->count();

        // 🔥 MASUKKAN KE FORMAT CHART
        $this->rumah = [
            'labels' => [
                'Total Rumah',
                'RTLH',
                'RLH',
                'RTLH Non Sewa',
                'RTLH Sewa',
                'DTKS',                // tambahan
            ],
            'series' => [
                (int) $totalRumah,
                (int) $jumlahRTLH,
                (int) $jumlahRLH,
                (int) $jumlahRTLHNonSewa,
                (int) $jumlahRTLHSewa,
                (int) $jumlahDTKS,      // tambahan
            ],
        ];
    }

    public function loadKawasanChart()
    {
        // Rumah dengan IMB (status_imb_id = 1)
        $imb = \App\Models\KepemilikanRumah::where('status_imb_id', 1)->count();

        // Rumah tanpa IMB (selain id = 1 atau NULL)
        $nonImb = \App\Models\KepemilikanRumah::where(function($q) {
            $q->where('status_imb_id', '!=', 1)
            ->orWhereNull('status_imb_id');
        })->count();

        // Kawasan Permukiman (jenis_kawasan_lokasi_rumah_id = 7)
        $permukiman = \App\Models\KepemilikanRumah::where('jenis_kawasan_lokasi_rumah_id', 7)->count();

        // Kawasan Rawan Bencana (jenis_kawasan_lokasi_rumah_id = 6)
        $bencana = \App\Models\KepemilikanRumah::where('jenis_kawasan_lokasi_rumah_id', 6)->count();

        // Masukkan ke chart
        $this->kawasan = [
            'labels' => [
                'IMB',
                'Non IMB',
                'Kawasan Permukiman',
                'Kawasan Rawan Bencana'
            ],
            'series' => [
                (int) $imb,
                (int) $nonImb,
                (int) $permukiman,
                (int) $bencana,
            ],
        ];
    }



    public function loadPendudukChart()
    {
        // Total laki-laki
        $laki = \App\Models\FisikRumah::sum('jumlah_penghuni_laki');

        // Total perempuan
        $perempuan = \App\Models\FisikRumah::sum('jumlah_penghuni_perempuan');

        // Total penduduk = laki + perempuan
        $penduduk = $laki + $perempuan;

        // Total ABK
        $abk = \App\Models\FisikRumah::sum('jumlah_abk');

        // Return ke chart Livewire
       $this->penduduk = [
            'labels' => [
                'Total Penduduk',
                'Laki-laki',
                'Perempuan',
                'ABK'
            ],
            'series' => [
                (int) $penduduk,
                (int) $laki,
                (int) $perempuan,
                (int) $abk
            ],
        ];

    }

    public function changeTab($tab)
    {
        $this->tab = $tab;

        $data = $this->{$tab};

        $this->dispatch("chart-update", $data);
    }

    public function render()
    {
        return view('livewire.dashboard')
        ->extends('layouts.master') 
        ->section('content'); 
    }

    
 
}
