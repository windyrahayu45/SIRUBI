<div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Layout-->
                <div class="d-flex flex-column flex-xl-row">
                    <!--begin::Sidebar-->
                    <div class="flex-column flex-lg-row-auto w-100 w-xl-500px mb-10">
                        <!--begin::Card-->
                       

                        <!--end::Card-->
                        <!--begin::Connected Accounts-->
                        

                    </div>
                    <!--end::Sidebar-->
                    <!--begin::Content-->
                    <div class="flex-lg-row-fluid ms-lg-15">
                        <!--begin:::Tabs-->
                        <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">
                           
                        </ul>
                        <!--end:::Tabs-->
                        <!--begin:::Tab content-->
                        <div class="tab-content" id="myTabContent">
                            <!--begin:::Tab pane-->
                            <div class="tab-pane fade show active" id="kt_customer_view_overview_tab" role="tabpanel">
                                <!--begin::Card-->
                                <div class="card pt-4 mb-6 mb-xl-9">
                                    <!--begin::Card header-->
                                  
                                    <!--begin::Card body-->
                                   <div class="card-body pt-5">

                                     <h3 class="fw-bold text-gray-800 mb-3">Kepala Keluarga</h3>
                                        @forelse($rumah->kepalaKeluarga as $kk)
                                            {{-- Informasi KK --}}
                                            <div class="mb-5">
                                                <div class="table-responsive">
                                                    <table class="table align-middle table-row-dashed gy-3">
                                                        <tbody class="text-gray-700 fw-semibold">
                                                            <tr>
                                                                <td class="text-muted fw-bold w-40">Nomor KK #{{ $loop->iteration }}</td>
                                                                <td>{{ $kk->no_kk ?? '-' }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-muted fw-bold">Jumlah Anggota</td>
                                                                <td>{{ $kk->anggota->count() }} orang</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                {{-- Daftar Anggota --}}
                                                <div class="mt-3">
                                                    <h3 class="fw-bold text-gray-800 mb-3">Daftar Anggota Keluarga</h3>

                                                    @if($kk->anggota && $kk->anggota->count() > 0)
                                                        <div class="table-responsive">
                                                            <table class="table table-sm align-middle table-row-dashed fs-7">
                                                                <thead>
                                                                    <tr class="text-muted fw-bold text-uppercase">
                                                                        <th class="min-w-150px">Nomor NIK</th>
                                                                        <th class="min-w-200px">Nama Lengkap</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach($kk->anggota as $a)
                                                                        <tr>
                                                                            <td>{{ $a->nik ?? '-' }}</td>
                                                                            <td>{{ $a->nama ?? '-' }}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @else
                                                        <div class="text-muted fst-italic">Belum ada anggota keluarga.</div>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Separator antar KK --}}
                                            @if(!$loop->last)
                                                <div class="separator separator-dashed my-5"></div>
                                            @endif
                                        @empty
                                            <div class="text-center text-muted py-5">Belum ada data kartu keluarga.</div>
                                        @endforelse
                                    </div>

                                    <!--end::Card body-->
                                </div>
                                <!--end::Card-->
                                <!--begin::Card-->
                                <div class="card pt-4 mb-6 mb-xl-9">
                                    <!--begin::Card header-->
                                   
                                    <!--begin::Card body-->
                                    <div class="card-body p-5">
                                        <h3 class="fw-bold text-gray-800 mb-3">Data Rumah</h3>
                                        <div class="table-responsive">
                                            <table class="table align-middle table-row-dashed gy-3 fs-7 fw-semibold text-gray-700 mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="w-40 text-gray-600">Jenis Kelamin</td>
                                                        <td>{{ $rumah->sosialEkonomi->jenisKelamin->jenis_kelamin ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Usia</td>
                                                        <td>{{ $rumah->sosialEkonomi->usia ?? '-' }} Tahun</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="w-40 text-gray-600">Alamat</td>
                                                        <td>{{ $rumah->alamat ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kecamatan</td>
                                                        <td>{{ $rumah->kelurahan->kecamatan->nama_kecamatan ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kelurahan</td>
                                                        <td>{{ $rumah->kelurahan->nama_kelurahan ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pendidikan Terakhir</td>
                                                        <td>{{ $rumah->sosialEkonomi->pendidikanTerakhir->pendidikan_terakhir ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pekerjaan Utama</td>
                                                        <td>{{ $rumah->sosialEkonomi->pekerjaanUtama->pekerjaan_utama ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Besar Penghasilan Per Bulan</td>
                                                        <td>{{ $rumah->sosialEkonomi->besarPenghasilan->besar_penghasilan ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Besar Pengeluaran Per Bulan</td>
                                                        <td>{{ $rumah->sosialEkonomi->besarPengeluaran->besar_pengeluaran ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Status Kepemilikan Tanah</td>
                                                        <td>{{ $rumah->kepemilikan->statusKepemilikanTanah->status_kepemilikan_tanah ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Bukti Kepemilikan Tanah</td>
                                                        <td>{{ $rumah->kepemilikan->buktiKepemilikanTanah->bukti_kepemilikan_tanah ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Status Kepemilikan Rumah</td>
                                                        <td>{{ $rumah->kepemilikan->statusKepemilikanRumah->status_kepemilikan_rumah ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Status IMB</td>
                                                        <td>{{ $rumah->kepemilikan->statusImb->status_imb ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Nomor IMB</td>
                                                        <td>{{ $rumah->kepemilikan->nomor_imb ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Aset Rumah di Tempat Lain</td>
                                                        <td>{{ $rumah->kepemilikan->asetRumahDitempatLain->aset_rumah_tempat_lain ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Aset Tanah di Tempat Lain</td>
                                                        <td>{{ $rumah->kepemilikan->asetTanahDitempatLain->aset_tanah_tempat_lain ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jenis Kawasan Lokasi Rumah</td>
                                                        <td>{{ $rumah->kepemilikan->jenisKawasanLokasiRumah->jenis_kawasan_lokasi ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pernah Mendapatkan Bantuan Perbaikan Rumah</td>
                                                        <td>
                                                            {{ $rumah->bantuan->pernahMendapatkanBantuan->pernah_mendapatkan_bantuan ?? '-' }}

                                                            @if(!empty($rumah->kepemilikan?->nik_kepemilikan_rumah))
                                                                <div class="mt-2">
                                                                    <span class="fw-bold text-gray-700 me-2">Pemilik Rumah:</span>
                                                                    <a href="{{ url('rumah/nik/' . $rumah->kepemilikan->nik_kepemilikan_rumah) }}"
                                                                    target="_blank"
                                                                    class="text-primary fw-bold text-hover-dark">
                                                                    {{ $rumah->kepemilikan->nik_kepemilikan_rumah }}
                                                                    </a>
                                                                </div>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!--end::Card body-->
                                </div>

                                <div class="card mb-5 mb-xl-8">
                                    <!--begin::Card header-->
                                    
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                <div class="card-body pt-2">
                                    <h3 class="fw-bold text-gray-800 mb-3">Riwayat Bantuan</h3>
                                        {{-- 🔹 Bantuan utama rumah (hanya kalau ada) --}}
                                        @if(!empty($rumah->bantuan) && ($rumah->bantuan->pernahMendapatkanBantuan->pernah_mendapatkan_bantuan ?? '-') === 'Ya')
                                            <div class="table-responsive mb-8">
                                                <table class="table align-middle table-row-dashed gy-3 fs-7 fw-semibold text-gray-700 mb-0">
                                                    <tbody>
                                                        <tr>
                                                            <td class="w-40 text-gray-600">Pernah Mendapatkan Bantuan</td>
                                                            <td>
                                                                <span class="badge badge-light-success fw-bold px-3 py-2">
                                                                    {{ $rumah->bantuan->pernahMendapatkanBantuan->pernah_mendapatkan_bantuan ?? '-' }}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nomor KK Penerima</td>
                                                            <td>{{ $rumah->bantuan->no_kk_penerima ?? '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nama Bantuan</td>
                                                            <td>{{ $rumah->bantuan->nama_bantuan ?? '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nama Program Bantuan</td>
                                                            <td>{{ $rumah->bantuan->nama_program_bantuan ?? '-' }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Nominal Bantuan</td>
                                                            <td>
                                                                @if(!empty($rumah->bantuan->nominal_bantuan))
                                                                    Rp {{ number_format($rumah->bantuan->nominal_bantuan, 0, ',', '.') }}
                                                                @else
                                                                    -
                                                                @endif
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tahun Bantuan</td>
                                                            <td>{{ $rumah->bantuan->tahun_bantuan ?? '-' }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif


                                        {{-- 🔹 Riwayat bantuan dari semua KK --}}
                                        @if(!empty($bantuanRiwayat) && count($bantuanRiwayat) > 0)
                                            <div class="separator separator-dashed my-6"></div>
                                            <h5 class="fw-bold text-gray-800 mb-4">
                                                <i class="ki-duotone ki-gift fs-2 me-2 text-primary"></i>
                                                Riwayat Bantuan Berdasarkan Nomor KK
                                            </h5>

                                            <div class="table-responsive">
                                                <table class="table align-middle table-row-dashed gy-3 fs-7 fw-semibold text-gray-700 mb-0">
                                                    <thead class="bg-light fw-bold text-uppercase text-muted">
                                                        <tr>
                                                            <th class="min-w-120px">Nomor KK</th>
                                                            <th class="min-w-150px">Nama Bantuan</th>
                                                            <th class="min-w-200px">Program Bantuan</th>
                                                            <th class="min-w-100px text-center">Tahun</th>
                                                            <th class="min-w-100px text-end">Nominal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($bantuanRiwayat as $b)
                                                            <tr>
                                                                <td>{{ $b->kk ?? '-' }}</td>
                                                                <td>{{ $b->nama ?? '-' }}</td>
                                                                <td>{{ $b->nama_program ?? '-' }}</td>
                                                                <td class="text-center">
                                                                    <span class="badge badge-light-primary fw-bold">{{ $b->tahun ?? '-' }}</span>
                                                                </td>
                                                                <td class="text-end">
                                                                    @if(!empty($b->nominal))
                                                                        Rp {{ number_format($b->nominal, 0, ',', '.') }}
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot class="fw-bold bg-light">
                                                        <tr>
                                                            <td colspan="4" class="text-end">Total Bantuan</td>
                                                            <td class="text-end">
                                                                Rp {{ number_format($bantuanRiwayat->sum('nominal'), 0, ',', '.') }}
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        @endif


                                        {{-- 🔹 Jika dua-duanya kosong --}}
                                        @if(
                                            (empty($rumah->bantuan) || ($rumah->bantuan->pernahMendapatkanBantuan->pernah_mendapatkan_bantuan ?? '-') !== 'Ya') &&
                                            (empty($bantuanRiwayat) || count($bantuanRiwayat) === 0)
                                        )
                                            <div class="d-flex align-items-center justify-content-center py-10">
                                                <div class="text-center">
                                                    <i class="ki-duotone ki-home fs-2tx text-muted mb-3"></i>
                                                    <div class="fw-semibold text-muted fs-6">
                                                        Belum pernah mendapatkan bantuan perbaikan rumah.
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                    </div>

                                    <!--end::Card body-->
                                    <!--begin::Card footer-->
                                    
                                    <!--end::Card footer-->
                                </div>
                                <!--end::Connected Accounts-->


                        <div class="card mb-5 mb-xl-8">
                            <!--begin::Card header-->
                           
                            <!--end::Card header-->
                            <!--begin::Card body-->
                                <div class="card-body p-5">
                                 <h3 class="fw-bold text-gray-800 mb-3">Aspek Keselamatan</h3>
                                    <div class="table-responsive">
                                        <table class="table align-middle table-row-dashed gy-3 fs-7 fw-semibold text-gray-700 mb-0">
                                            <tbody>
                                                <tr>
                                                    <td class="w-40 text-gray-600">Pondasi</td>
                                                    <td>{{ $rumah->fisik?->pondasi?->pondasi ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Jenis Pondasi</td>
                                                    <td>{{ $rumah->fisik?->jenisPondasi?->jenis_pondasi ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Kondisi Pondasi</td>
                                                    <td>
                                                        {{ $rumah->fisik?->kondisiPondasi?->kondisi_pondasi ?? '-' }}
                                                        @if(!empty($rumah->fisik?->kondisi_pondasi_id))
                                                            <span class="badge badge-light-secondary ms-2">1</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Kondisi Sloof</td>
                                                    <td>
                                                        {{ $rumah->fisik?->kondisiSloof?->kondisi_sloof ?? '-' }}
                                                        @if(!empty($rumah->fisik?->kondisi_sloof_id))
                                                            <span class="badge badge-light-secondary ms-2">1</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Kondisi Kolom/Tiang</td>
                                                    <td>
                                                        {{ $rumah->fisik?->kondisiKolomTiang?->kondisi_kolom_tiang ?? '-' }}
                                                        @if(!empty($rumah->fisik?->kondisi_kolom_tiang_id))
                                                            <span class="badge badge-light-secondary ms-2">1</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Kondisi Balok</td>
                                                    <td>
                                                        {{ $rumah->fisik?->kondisiBalok?->kondisi_balok ?? '-' }}
                                                        @if(!empty($rumah->fisik?->kondisi_balok_id))
                                                            <span class="badge badge-light-secondary ms-2">1</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>Kondisi Struktur Atap</td>
                                                    <td>
                                                        {{ $rumah->fisik?->kondisiStrukturAtap?->kondisi_struktur_atap ?? '-' }}
                                                        @if(!empty($rumah->fisik?->kondisi_struktur_atap_id))
                                                            <span class="badge badge-light-secondary ms-2">1</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr class="bg-light-warning">
                                                    <th class="fw-bold text-gray-800">Nilai Aspek Keselamatan</th>
                                                    <th class="fw-bold">
                                                        {{ $rumah->penilaian?->nilai_a ?? '-' }}
                                                        @if($rumah->penilaian?->prioritas_a == 1)
                                                            <span class="badge badge-light-success ms-2">Tidak Prioritas</span>
                                                        @else
                                                            <span class="badge badge-light-danger ms-2">Prioritas</span>
                                                        @endif
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <!--end::Card body-->
                            <!--begin::Card footer-->
                            
                            <!--end::Card footer-->
                        </div>

                        <div class="card mb-5 mb-xl-8">
                            <!--begin::Card header-->
                           
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body p-5">
                                <h3 class="fw-bold text-gray-800 mb-3">Aspek Persyaratan Luas dan Kebutuhan Ruang</h3>
                                <div class="table-responsive">
                                    <table class="table align-middle table-row-dashed gy-3 fs-7 fw-semibold text-gray-700 mb-0">
                                        
                                        <tbody>
                                            <tr>
                                                <td>Luas Rumah</td>
                                                <td>{{ $rumah->fisik->luas_rumah ? $rumah->fisik->luas_rumah . ' m²' : '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Jumlah Penghuni Laki-laki</td>
                                                <td>{{ $rumah->fisik->jumlah_penghuni_laki ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Jumlah Penghuni Perempuan</td>
                                                <td>{{ $rumah->fisik->jumlah_penghuni_perempuan ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Jumlah Anak Berkebutuhan Khusus (ABK)</td>
                                                <td>{{ $rumah->fisik->jumlah_abk ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Tinggi Rata-rata Bangunan</td>
                                                <td>{{ $rumah->fisik->tinggi_rata_rumah ? $rumah->fisik->tinggi_rata_rumah . ' m' : '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Ruang Keluarga & Ruang Tidur</td>
                                                <td>{{ $rumah->fisik->ruangKeluargaDanTidur->ruang_keluarga_dan_tidur ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Jumlah Kamar Tidur</td>
                                                <td>{{ $rumah->fisik->jumlah_kamar_tidur ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Luas Rata-rata Kamar Tidur</td>
                                                <td>
                                                    @if(!empty($rumah->fisik->luas_rata_kamar_tidur))
                                                        {{ $rumah->fisik->luas_rata_kamar_tidur }} m²
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Jenis Fisik Bangunan</td>
                                                <td>{{ $rumah->fisik->jenisFisikBangunan->jenis_fisik_bangunan ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Jumlah Lantai Bangunan</td>
                                                <td>{{ $rumah->fisik->jumlah_lantai_bangunan ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Fungsi Rumah</td>
                                                <td>{{ $rumah->fisik->fungsiRumah->fungsi_rumah ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Tipe Rumah</td>
                                                <td>{{ $rumah->fisik->tipeRumah->tipe_rumah ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td>Status DTKS</td>
                                                <td>
                                                    @if(($rumah->status_dtks ?? 'Tidak') === 'Ya')
                                                        <span class="badge badge-light-success fw-bold px-3 py-2">Terdaftar</span>
                                                    @else
                                                        <span class="badge badge-light-secondary fw-bold px-3 py-2">Tidak</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Tahun Pembangunan Rumah</td>
                                                <td>{{ $rumah->tahun_pembangunan_rumah ?? '-' }}</td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--end::Card body-->
                            <!--begin::Card footer-->
                            
                            <!--end::Card footer-->
                        </div>
                                <!--end::Card-->
                                <!--begin::Card-->
                                <div class="card pt-4 mb-6 mb-xl-9">
                                    <!--begin::Card header-->
                                   
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body p-5">
                                        <h3 class="fw-bold text-gray-800 mb-3">Aspek Kesehatan</h3>
                                        <div class="table-responsive">
                                            <table class="table align-middle table-row-dashed gy-3 fs-7 fw-semibold text-gray-700 mb-0">
                                                

                                                <tbody>
                                                    <tr>
                                                        <td>Jendela / Lubang Cahaya</td>
                                                        <td>{{ $rumah->sanitasi->jendelaLubangCahaya->jendela_lubang_cahaya ?? '-' }}</td>
                                                    </tr>
                                                     <tr>
                                                        <td>Kondisi Jendela / Lubang Cahaya</td>
                                                        <td>
                                                            {{ $rumah->sanitasi->kondisiJendelaLubangCahaya->kondisi_jendela_lubang_cahaya ?? '-' }}
                                                            <span class="badge badge-light-primary ms-2">
                                                                {{ $rumah->sanitasi->kondisiJendelaLubangCahaya->bobot ?? 1 }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Ventilasi</td>
                                                        <td>{{ $rumah->sanitasi->ventilasi->ventilasi ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Keterangan Ventilasi</td>
                                                        <td>{{ $rumah->sanitasi->keterangan_ventilasi ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kondisi Ventilasi</td>
                                                        <td>
                                                            {{ $rumah->sanitasi->kondisiVentilasi->kondisi_ventilasi ?? '-' }}
                                                            <span class="badge badge-light-primary ms-2">
                                                                {{ $rumah->sanitasi->kondisiVentilasi->bobot ?? 1 }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kamar Mandi</td>
                                                        <td>{{ $rumah->sanitasi->kamarMandi->kamar_mandi ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kondisi Kamar Mandi</td>
                                                        <td>
                                                            {{ $rumah->sanitasi->kondisiKamarMandi->kondisi_kamar_mandi ?? '-' }}
                                                            <span class="badge badge-light-primary ms-2">
                                                                {{ $rumah->sanitasi->kondisiKamarMandi->bobot ?? 1 }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                     <tr>
                                                        <td>Jamban</td>
                                                        <td>{{ $rumah->sanitasi->jamban->jamban ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kondisi Jamban</td>
                                                        <td>
                                                            {{ $rumah->sanitasi->kondisiJamban->kondisi_jamban ?? '-' }}
                                                            <span class="badge badge-light-primary ms-2">
                                                                {{ $rumah->sanitasi->kondisiJamban->bobot ?? 1 }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                     <tr>
                                                        <td>Sistem Pembuangan Air Kotor</td>
                                                        <td>{{ $rumah->sanitasi->sistemPembuanganAirKotor->sistem_pembuangan_air_kotor ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kondisi Sistem Pembuangan Air Kotor</td>
                                                        <td>
                                                            {{ $rumah->sanitasi->kondisiSistemPembuanganAirKotor->kondisi_sistem_pembuangan_air_kotor ?? '-' }}
                                                            <span class="badge badge-light-primary ms-2">
                                                                {{ $rumah->sanitasi->kondisiSistemPembuanganAirKotor->bobot ?? 1 }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Sumber Air Minum</td>
                                                        <td>{{ $rumah->sanitasi->sumberAirMinum->sumber_air_minum ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Sumber Listrik</td>
                                                        <td>{{ $rumah->sanitasi->sumberListrik->sumber_listrik ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Frekuensi Penyedotan dalam 5 Tahun</td>
                                                        <td>{{ $rumah->sanitasi->frekuensiPenyedotan->frekuensi_penyedotan ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kondisi Sumber Air Minum</td>
                                                        <td>
                                                            {{ $rumah->sanitasi->kondisiSumberAirMinum->kondisi_sumber_air_minum ?? '-' }}
                                                            <span class="badge badge-light-primary ms-2">
                                                                {{ $rumah->sanitasi->kondisiSumberAirMinum->bobot ?? 1 }}
                                                            </span>
                                                        </td>
                                                    </tr>

                                                    {{-- 🔹 Nilai Aspek Kesehatan --}}
                                                    <tr class="bg-light-warning">
                                                        <td class="fw-bold text-gray-800">Nilai</td>
                                                        <td>
                                                            <span class="fw-bold fs-7 me-3">
                                                                {{ $rumah->penilaian->nilai_b ?? '-' }}
                                                            </span>
                                                            @if(($rumah->penilaian->prioritas_b ?? 1) == 1)
                                                                <span class="badge badge-light-success ms-2">Tidak Prioritas</span>
                                                            @else
                                                                <span class="badge badge-light-danger ms-2">Prioritas</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card-->
                                <!--begin::Card-->
                                
                                <!--end::Card-->
                            </div>
                            <!--end:::Tab pane-->
                            
                        </div>
                        <!--end:::Tab content-->
                    </div>

                    
                    <!--end::Content-->
                </div>

                <div class="card pt-2 mb-6 mb-xl-9">
                    <!--begin::Card header-->
                   
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body p-5">
                         <h3 class="fw-bold text-gray-800 mb-3">Aspek Komponen Bahan Bangunan</h3>
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed gy-3 fs-7 fw-semibold text-gray-700 mb-0">
                                
                                <tbody>
                                    <tr>
                                        <td>Material Atap Terluas</td>
                                        <td>{{ $rumah->fisik->materialAtapTerluas->material_atap_terluas ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Kondisi Penutup Atap</td>
                                        <td>{{ $rumah->fisik->kondisiPenutupAtap->kondisi_penutup_atap ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Material Dinding Terluas</td>
                                        <td>{{ $rumah->fisik->materialDindingTerluas->material_dinding_terluas ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Kondisi Dinding</td>
                                        <td>{{ $rumah->fisik->kondisiDinding->kondisi_dinding ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Material Lantai Terluas</td>
                                        <td>{{ $rumah->fisik->materialLantaiTerluas->material_lantai_terluas ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Kondisi Lantai</td>
                                        <td>{{ $rumah->fisik->kondisiLantai->kondisi_lantai ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Akses Langsung ke Jalan</td>
                                        <td>{{ $rumah->fisik->aksesKeJalan->akses_ke_jalan ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Bangunan Menghadap Jalan</td>
                                        <td>{{ $rumah->fisik->bangunanMenghadapJalan->bangunan_menghadap_jalan ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Bangunan Menghadap Sungai</td>
                                        <td>{{ $rumah->fisik->bangunanMenghadapSungai->bangunan_menghadap_sungai ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Bangunan Berada di Atas Sempadan Sungai/Laut/Rawa</td>
                                        <td>{{ $rumah->fisik->bangunanBeradaSungai->bangunan_berada_sungai ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Bangunan Berada di Buangan Limbah Pabrik/Sutet</td>
                                        <td>{{ $rumah->fisik->bangunanBeradaLimbah->bangunan_berada_limbah ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nama Surveyor</td>
                                        <td>{{ $rumah->nama_surveyor ?? '-' }}</td>
                                    </tr>
                                    <tr class="bg-light-warning">
                                        <td class="fw-bold text-gray-800">Nilai</td>
                                        <td>
                                            <span class="fw-bold fs-7 me-3">
                                                {{ $rumah->penilaian->nilai_c ?? '-' }}
                                            </span>
                                            @if(($rumah->penilaian->prioritas_c ?? 1) == 1)
                                                <span class="badge badge-light-success ms-2">Tidak Prioritas</span>
                                            @else
                                                <span class="badge badge-light-danger ms-2">Prioritas</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Layout-->
             <!-- Dokumentasi Rumah -->
                <!-- Dokumentasi Rumah -->
                <div style="margin-top: 25px;">
                    <h3 style="font-size: 16px; margin-bottom: 12px; text-align: left;">Dokumentasi</h3>

                    @php
                        $fotos = [
                            'Tampak Depan' => $rumah->dokumen->foto_rumah_satu ?? null,
                            'Samping Rumah' => $rumah->dokumen->foto_rumah_dua ?? null,
                            'Belakang Rumah' => $rumah->dokumen->foto_rumah_tiga ?? null,
                            'KTP Pemilik' => $rumah->dokumen->foto_ktp ?? null,
                            'Kartu Keluarga' => $rumah->dokumen->foto_kk ?? null,
                            'Foto IMB' => $rumah->dokumen->foto_imb ?? null,
                        ];
                    @endphp

                    <table width="100%" cellspacing="0" cellpadding="6" style="border-collapse: collapse;">
                        @foreach(array_chunk($fotos, 2, true) as $row)
                            <tr>
                                @foreach($row as $label => $path)
                                    <td width="50%" style="text-align: center; vertical-align: top; padding: 10px;">
                                        @if($path )
                                            <img 
                                                src="{{ public_path('storage/' . $path) }}" 
                                                alt="{{ $label }}" 
                                                style="width: 100%; max-height: 220px; object-fit: cover; border-radius: 6px;"
                                            >
                                            <div style="margin-top: 6px; font-size: 13px; font-weight: 600; color: #333;">
                                                {{ $label }}
                                            </div>
                                        @else
                                            <div style="width: 100%; height: 220px; background: #f7f7f7; border: 1px dashed #ccc; border-radius: 6px; display: flex; align-items: center; justify-content: center; flex-direction: column;">
                                                <div style="font-size: 12px; color: #999;">{{ $label }}</div>
                                                <span style="font-size: 11px; color: #bbb;">Belum diunggah</span>
                                            </div>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </table>
                </div>

<div style="margin-top: 20px;">
    <h3 style="font-size: 16px;">Lokasi Rumah</h3>
    @if(!empty($mapUrl))
        <img src="{{ $mapUrl }}" alt="Peta Lokasi" style="width: 100%; border-radius: 8px; border: 1px solid #ccc;">
    @else
        <p style="color: #777;">Lokasi belum tersedia.</p>
    @endif
</div>


              @php
    $penilaian = $rumah->penilaian;

    // Status rumah
    $isLayak = ($penilaian->status_rumah === 'RLH');
    $warna = $isLayak ? '#28a745' : '#dc3545';
    $judul = $isLayak ? 'RUMAH LAYAK HUNI' : 'RUMAH TIDAK LAYAK HUNI';

    // Backlog
    $backlog = ($rumah->kepalaKeluarga->count() > 1) ? 'BACKLOG' : 'TIDAK BACKLOG';
    $warnaBacklog = ($rumah->kepalaKeluarga->count() > 1) ? '#ffc107' : '#007bff';

    // Luas rumah
    $statusLuas = ($penilaian->status_luas == 1) ? 'LUAS RUMAH CUKUP' : 'LUAS RUMAH KURANG';
    $warnaLuas = ($penilaian->status_luas == 1) ? '#28a745' : '#dc3545';

    $nilaiTotal = $penilaian->nilai ?? '-';
@endphp

<!-- Penilaian Rumah -->
<div style="margin-top: 25px;">

    <h3 style="font-size: 18px; margin-bottom: 6px; text-align: left;">
        {{ $judul }}
    </h3>

    <p style="font-size: 13px; margin: 2px 0 10px;">
        Nilai Total Penilaian: <strong style="color: {{ $warna }};">{{ $nilaiTotal }}</strong>
    </p>

    <table width="100%" border="1" cellspacing="0" cellpadding="8" style="border-collapse: collapse; font-size: 13px;">
        <thead style="background-color: #f2f2f2; text-align: center;">
            <tr>
                <th style="width: 40%;">Aspek Penilaian</th>
                <th style="width: 40%;">Keterangan</th>
                <th style="width: 20%;">Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Status Rumah</strong></td>
                <td>{{ $judul }}</td>
                <td style="text-align: center;">
                    <span style="color: {{ $warna }}; font-weight: bold;">
                        {{ strtoupper($penilaian->status_rumah ?? '-') }}
                    </span>
                </td>
            </tr>
            <tr>
                <td><strong>Kondisi Backlog</strong></td>
                <td>{{ $backlog }}</td>
                <td style="text-align: center;">
                    <span style="color: {{ $warnaBacklog }}; font-weight: bold;">
                        {{ $backlog }}
                    </span>
                </td>
            </tr>
            <tr>
                <td><strong>Status Luas Rumah</strong></td>
                <td>{{ $statusLuas }}</td>
                <td style="text-align: center;">
                    <span style="color: {{ $warnaLuas }}; font-weight: bold;">
                        {{ $statusLuas }}
                    </span>
                </td>
            </tr>
        </tbody>
    </table>

    <p style="font-size: 11px; margin-top: 10px; color: #555;">
        <i>*Kriteria RLH atau RTLH dilihat dari kondisi <strong>Atap</strong>, <strong>Lantai</strong>, dan <strong>Dinding</strong> (<strong>ALADIN</strong>).</i>
    </p>

</div>


            </div>
        </div>