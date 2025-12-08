<?php

namespace App\Livewire;

use App\Models\IKecamatan;
use App\Models\Pengaduan;
use App\Models\PengaduanPhoto;
use App\Models\Rumah;
use App\Models\TblJenisPolygon;
use App\Models\TblPolygonKelurahan;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

class Home extends Component
{
    protected $listeners = ['loadKecamatanDetail','openRekapKecamatan'];

    public $rumah = [];
    public $penduduk = [];
    public $kawasan = [];
    public $kecamatan;
    public $nama;
    public $no_hp;
    public $judul;
    public $kategori;
    public $lokasi;
    public $deskripsi;
    public $foto = [];

    protected $rules = [
        'nama' => 'required|string|max:255',
        'no_hp' => 'required|regex:/^[0-9]{8,15}$/',

        'judul' => 'required|string|max:255',
        'kategori' => 'required|string',
        'lokasi' => 'required|string',
        'deskripsi' => 'required|string',
        'foto.*' => 'nullable|image|max:2048'
    ];

     use WithFileUploads;

    public function submitPengaduan()
    {
        $this->validate();

        // simpan pengaduan
        $p = Pengaduan::create([
            'judul'     => $this->judul,
            'deskripsi' => $this->deskripsi,
            'kategori'  => $this->kategori,
            'lokasi'    => $this->lokasi,
            'user_id'   => null,
            'nama_pelapor' => $this->nama,
            'no_hp'         => $this->no_hp,
        ]);

        // simpan foto
        if ($this->foto) {
            foreach ($this->foto as $img) {
                $path = $img->store("pengaduan/{$p->id}", 'public');

                PengaduanPhoto::create([
                    'pengaduan_id' => $p->id,
                    'file_path'    => $path,
                ]);
            }
        }

        // reset setelah submit
        $this->reset(['nama','no_hp','judul','kategori','lokasi','deskripsi','foto']);

        // trigger JS notifikasi
        $this->dispatch('pengaduanSuccess');
    }

    public function mount()
    {

     $this->kecamatan = IKecamatan::withCount([
            'rumah as total_rumah' => fn($q) => $q->whereNotNull('kelurahan_id'),

            'rumah as rtlh' => fn($q) =>
                $q->whereNotNull('kelurahan_id')
                ->whereHas('penilaian', fn($p) => $p->where('status_rumah', 'RTLH')),

            'rumah as rlh' => fn($q) =>
                $q->whereNotNull('kelurahan_id')
                ->whereHas('penilaian', fn($p) => $p->where('status_rumah', 'RLH')),
        ])->get();


        $this->loadRumahChart();
        $this->loadPendudukChart();
        $this->loadKawasanChart();
        $this->loadData();
    }


   

    public function openRekapKecamatan($id)
    {
        $rekap = app(\App\Livewire\Rekap::class);
        $rekap->kecamatanId = $id;
        $rekap->loadData();

        // Render partial blade untuk tabel rekap
        $html = view('livewire.partials.rekap1-table', [
            'rekap1' => $rekap->rekap1
        ])->render();

        $this->dispatch('showRekapModal', [
            'nama' => $rekap->kecamatanNama,
            'html' => $html
        ]);
    }


    public function loadKecamatanDetail($id)
    {
        $kec = IKecamatan::find($id);

        $detail = [
            'nama' => $kec->nama_kecamatan,
            'total_rumah' => $kec->rumah()->count(),
            'rtlh' => $kec->rumah()->whereHas('penilaian', fn($q) => $q->where('status_rumah','RTLH'))->count(),
            'rlh' => $kec->rumah()->whereHas('penilaian', fn($q) => $q->where('status_rumah','RLH'))->count(),
            'kelurahan' => $kec->kelurahan()->pluck('nama_kelurahan'),
        ];

        $this->dispatch('showKecamatanModal', $detail);
    }

     public function loadData()
    {
        // --- Helper untuk ambil 1 KK dan 1 anggota saja
        $formatRumah = function ($r) {
            $kk = $r->kepalaKeluarga?->where('kode_kk', 'A')->first();
            $anggota = $kk?->anggota?->where('kode_anggota', 'aa')->first();

            return [
                'id_rumah'        => $r->id_rumah,
                'nama_kk'         => $anggota?->nama ?? '-',
                'status_rumah'    => $r->penilaian->status_rumah ?? '-',
                'prioritas_a'     => $r->penilaian->prioritas_a ?? null,
                'prioritas_b'     => $r->penilaian->prioritas_b ?? null,
                'prioritas_c'     => $r->penilaian->prioritas_c ?? null,
                'nama_kelurahan'  => $r->kelurahan?->nama_kelurahan ?? '-',
                'nama_kecamatan'  => $r->kelurahan?->kecamatan?->nama_kecamatan ?? '-',
                'latitude'        => floatval($r->latitude),
                'longitude'       => floatval($r->longitude),
                'foto_url'        => $r->dokumen?->foto_rumah_satu
                                    ? asset('storage/' . $r->dokumen->foto_rumah_satu)
                                    : asset('images/no_photo.jpg'),
            ];
        };

        // --- Template query dasar
        $baseQuery = Rumah::select([
                'id_rumah',
                'alamat',
                'latitude',
                'longitude',
                'kelurahan_id',
                'tahun_pembangunan_rumah'
            ])
            ->with([
                'penilaian:id,rumah_id,prioritas_a,prioritas_b,prioritas_c,status_rumah',
                'kepalaKeluarga.anggota:id,kepala_keluarga_id,nama,kode_anggota',
                'kelurahan:id_kelurahan,nama_kelurahan,kecamatan_id',
                'kelurahan.kecamatan:id_kecamatan,nama_kecamatan',
                'dokumen:rumah_id,foto_rumah_satu'
            ])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude');

        // --- Ambil SP1, SP2, SP3 seperti logika CI
        $sp_1 = (clone $baseQuery)
            ->whereHas('penilaian', fn($q) => $q->where('prioritas_a', 2))
            ->get()
            ->map($formatRumah);

        $sp_2 = (clone $baseQuery)
            ->whereHas('penilaian', fn($q) => $q
                ->where('prioritas_a', 1)
                ->where('prioritas_b', 2))
            ->get()
            ->map($formatRumah);

        $sp_3 = (clone $baseQuery)
            ->whereHas('penilaian', fn($q) => $q
                ->where('prioritas_a', 1)
                ->where('prioritas_b', 1)
                ->where('prioritas_c', 2))
            ->get()
            ->map($formatRumah);

        // --- Polygon Kelurahan
        $polygon_kelurahan = TblPolygonKelurahan::with(['kelurahan.kecamatan'])
            ->get()
            ->map(fn($p) => [
                'id' => $p->id_polygon,
                'polygon' => $p->polygon,
                'nama_kecamatan' => $p->kelurahan?->kecamatan?->nama_kecamatan,
                'nama_kelurahan' => $p->kelurahan?->nama_kelurahan,
                'luas' => $p->luas,
                'keterangan' => $p->keterangan,
                'warna' => $p->warna ?? '#ffff00'
            ]);

        // --- Polygon Kawasan
        $polygon_kawasan = TblJenisPolygon::with('polygons')
            ->get()
            ->map(fn($jenis) => [
                'jenis' => $jenis->jenis_polygon,
                'color' => match ($jenis->jenis_polygon) {
                    'Kawasan Kumuh' => 'purple',
                    'Kawasan Permukiman' => 'green',
                    'Kawasan Rawan Bencana' => 'black',
                    default => 'gray'
                },
                'data' => $jenis->polygons->map(fn($p) => [
                    'id_polygon' => $p->id_polygon,
                    'nama_kawasan' => $p->nama_kawasan ?? $jenis->jenis_polygon,
                    'jenis_polygon' => $jenis->jenis_polygon,
                    'luas' => $p->luas,
                    'keterangan' => $p->keterangan,
                    'polygon' => $p->polygon,
                ])
            ]);

        // --- Kirim ke JS
        $this->dispatch('initMap', [
            'rumah' => [
                'sp_1' => $sp_1->values(),
                'sp_2' => $sp_2->values(),
                'sp_3' => $sp_3->values(),
            ],
            'polygon_kelurahan' => $polygon_kelurahan->toArray(),
            'polygon_kawasan' => $polygon_kawasan->toArray(),
        ]);
    }

    public function loadRumahChart()
    {
        $totalRumah = \App\Models\Rumah::count();

        $jumlahRTLH = \App\Models\Rumah::whereHas('penilaian', function($q) {
            $q->where('status_rumah', 'RTLH');
        })->count();

        $jumlahRLH = \App\Models\Rumah::whereHas('penilaian', function($q) {
            $q->where('status_rumah', 'RLH');
        })->count();

        $jumlahDTKS = \App\Models\Rumah::whereHas('sosialEkonomi', function($q) {
            $q->where('status_dtks_id', 1);
        })->count();

        $this->rumah = [
            'total' => $totalRumah,
            'rtlh'  => $jumlahRTLH,
            'rlh'   => $jumlahRLH,
            'dtks'  => $jumlahDTKS,
        ];
    }

    public function loadPendudukChart()
    {
        $l = \App\Models\FisikRumah::sum('jumlah_penghuni_laki');
        $p = \App\Models\FisikRumah::sum('jumlah_penghuni_perempuan');
        $abk = \App\Models\FisikRumah::sum('jumlah_abk');

        $this->penduduk = [
            'total' => $l + $p,
            'laki'  => $l,
            'perempuan' => $p,
            'abk' => $abk,
        ];
    }

    public function loadKawasanChart()
    {
        $imb = \App\Models\KepemilikanRumah::where('status_imb_id', 1)->count();
        $nonImb = \App\Models\KepemilikanRumah::where(function($q) {
            $q->where('status_imb_id', '!=', 1)->orWhereNull('status_imb_id');
        })->count();

        $permukiman = \App\Models\KepemilikanRumah::where('jenis_kawasan_lokasi_rumah_id', 7)->count();
        $bencana    = \App\Models\KepemilikanRumah::where('jenis_kawasan_lokasi_rumah_id', 6)->count();

        $this->kawasan = [
            'imb' => $imb,
            'non_imb' => $nonImb,
            'permukiman' => $permukiman,
            'bencana' => $bencana,
        ];
    }


    #[Layout('layouts.base')]
    public function render()
    {
        return view('layouts.home', [
            'rumah'     => $this->rumah,
            'penduduk'  => $this->penduduk,
            'kecamatan' => $this->kecamatan,
            'kawasan'   => $this->kawasan,
        ]);
    }
}