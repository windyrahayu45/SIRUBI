<div>
    <div class="d-flex flex-column flex-column-fluid">
        
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">

                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Detail Bantuan Rumah
                    </h1>

                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="#" class="text-muted text-hover-primary">Data</a>
                        </li>

                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>

                        <li class="breadcrumb-item text-muted">Bantuan Rumah</li>
                    </ul>
                </div>

            </div>
        </div>
        <!--end::Toolbar-->


        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">

                <div class="d-flex flex-column flex-xl-row">



                    <!-- ====================================================== -->
                    <!--  SIDEBAR KIRI: TAMPIL HANYA JIKA RUMAH TERDATA         -->
                    <!-- ====================================================== -->
                    @if($rumah)
                        <div class="flex-column flex-lg-row-auto w-100 w-xl-500px mb-10">

                            <!-- Foto Rumah -->
                            <div class="card mb-6 mb-xl-8">
                                <div class="card-body pt-15">

                                    <div class="d-flex flex-center flex-column mb-5">
                                        <span class="fs-3 text-gray-800 fw-bold mb-1">Foto Rumah</span>
                                        <div class="separator separator-dashed my-3"></div>

                                        @php
                                            $foto = $rumah?->dokumen?->foto_rumah_satu
                                                    ? asset('storage/'.$rumah->dokumen->foto_rumah_satu)
                                                    : asset('images/no-image.png');
                                        @endphp

                                        <img src="{{ $foto }}"
                                            class="img-fluid rounded shadow-sm mb-2"
                                            style="max-height:200px; object-fit:cover;">
                                    </div>

                                    <!-- Lokasi -->
                                    <div class="d-flex flex-stack fs-4 py-3">
                                        <div class="fw-bold">Lokasi</div>
                                    </div>

                                    <div class="separator separator-dashed my-3"></div>

                                    <table class="table table-row-dashed fs-6 fw-semibold text-gray-700">
                                        <tbody>
                                            <tr>
                                                <td class="text-gray-600" width="40%">Alamat</td>
                                                <td>{{ $rumah->alamat ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-gray-600">Kecamatan</td>
                                                <td>{{ $rumah->kelurahan->kecamatan->nama_kecamatan ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="text-gray-600">Kelurahan</td>
                                                <td>{{ $rumah->kelurahan->nama_kelurahan ?? '-' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>


                            <!-- ANGGOTA KELUARGA -->
                            <div class="card mb-5 mb-xl-8">

                                <div class="card-header border-0">
                                    <div class="card-title">
                                        <h4 class="fw-bold m-0">Anggota Keluarga</h4>
                                    </div>
                                </div>

                                <div class="card-body pt-2">

                                    <div class="table-responsive">
                                        <table class="table align-middle table-row-dashed gy-4 fs-7 fw-semibold text-gray-700">

                                            <thead class="bg-light fw-bold text-uppercase text-muted">
                                                <tr>
                                                    <th>Nama</th>
                                                    <th>NIK</th>
                                                    <th>Jenis Kelamin</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @foreach($rumah->kepalaKeluarga as $kepala)
                                                    @foreach($kepala->anggota as $a)
                                                        <tr>
                                                            <td>{{ $a->nama }}</td>
                                                            <td>{{ $a->nik }}</td>
                                                            <td>{{ $a->jk ?? '-' }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            </tbody>

                                        </table>
                                    </div>

                                </div>
                            </div>


                            <!-- STATUS RUMAH -->
                            @if(isset($rumah->penilaian))
                                @php
                                    $penilaian = $rumah->penilaian;

                                    $isLayak = ($penilaian->status_rumah === 'RLH');
                                    $warna = $isLayak ? 'success' : 'danger';
                                    $judul = $isLayak ? 'RUMAH LAYAK HUNI' : 'RUMAH TIDAK LAYAK HUNI';

                                    $backlog = ($rumah->kepalaKeluarga->count() > 1) ? 'BACKLOG' : 'TIDAK BACKLOG';
                                    $warnaBacklog = ($rumah->kepalaKeluarga->count() > 1) ? 'warning' : 'primary';

                                    $statusLuas = ($penilaian->status_luas == 1) ? 'LUAS RUMAH CUKUP' : 'LUAS RUMAH KURANG';
                                    $warnaLuas = ($penilaian->status_luas == 1) ? 'success' : 'danger';

                                    $nilaiTotal = $penilaian->nilai ?? '-';
                                @endphp

                                <div class="card card-flush border border-gray-200 shadow-sm mt-1">

                                    <div class="card-header pt-5">
                                        <h3 class="card-title align-items-start flex-column">
                                            <span class="card-label fw-bold text-dark fs-3">{{ $judul }}</span>
                                            <span class="text-gray-500 mt-1 fw-semibold fs-7">
                                                Nilai Total Penilaian: 
                                                <span class="fw-bold text-{{ $warna }}">{{ $nilaiTotal }}</span>
                                            </span>
                                        </h3>

                                        <div class="card-toolbar">
                                            <span class="badge badge-light-{{ $warna }} fs-base mt-n3">
                                                {{ strtoupper($penilaian->status_rumah ?? '-') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    @else
                    <!-- ====================================================== -->
                    <!--  TAMPILAN ALTERNATIF JIKA RUMAH BELUM TERDATA          -->
                    <!-- ====================================================== -->

                        <div class="flex-column flex-lg-row-auto w-100 w-xl-500px mb-10">
                            <div class="card shadow-sm border">
                                <div class="card-body text-center py-10">

                                    <i class="ki-duotone ki-home fs-2tx text-muted mb-4"></i>

                                    <h3 class="fw-bold text-danger">Rumah Belum Terdata</h3>

                                    <p class="text-gray-600 mt-3">
                                        KK ini memiliki riwayat bantuan, namun data rumahnya belum terhubung
                                        pada sistem SIRUBI.
                                    </p>
                                </div>
                            </div>
                        </div>

                    @endif




                    <!-- ====================================================== -->
                    <!--   KANAN: RIWAYAT BANTUAN TETAP MUNCUL (SELALU ADA)    -->
                    <!-- ====================================================== -->
                    <div class="flex-lg-row-fluid ms-xl-15">

                        <div class="card mb-5 mb-xl-8">

                            <div class="card-header border-0">
                                <div class="card-title">
                                    <h4 class="fw-bold m-0">Riwayat Bantuan Berdasarkan KK</h4>
                                </div>
                            </div>

                            <div class="card-body pt-2">

                                @if(count($bantuanRiwayat) > 0)

                                    <div class="table-responsive">
                                        <table class="table align-middle table-row-dashed gy-3 fs-7 fw-semibold text-gray-700">

                                            <thead class="bg-light fw-bold text-uppercase text-muted">
                                                <tr>
                                                    <th>Nomor KK</th>
                                                    <th>Nama Bantuan</th>
                                                    <th>Program</th>
                                                    <th class="text-center">Tahun</th>
                                                    <th class="text-end">Nominal</th>
                                                    <th class="text-center">Dokumen</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($bantuanRiwayat as $b)
                                                <tr>
                                                    <td>{{ $b->kk }}</td>
                                                    <td>{{ $b->nama }}</td>
                                                    <td>{{ $b->nama_program }}</td>

                                                    <td class="text-center">
                                                        <span class="badge badge-light-primary fw-bold">
                                                            {{ $b->tahun }}
                                                        </span>
                                                    </td>

                                                    <td class="text-end">
                                                        Rp {{ number_format($b->nominal,0,',','.') }}
                                                    </td>

                                                    <td class="text-center">
                                                        @if($b->dokumen)
                                                            <a href="{{ asset('storage/'.$b->dokumen->source) }}"
                                                               target="_blank"
                                                               class="btn btn-sm btn-light-primary">
                                                                <i class="bi bi-file-earmark"></i>
                                                                Dokumen
                                                            </a>
                                                        @else
                                                            <span class="badge bg-secondary">Tidak Ada</span>
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
                                                    <td></td>
                                                </tr>
                                            </tfoot>

                                        </table>
                                    </div>

                                @else
                                    <div class="d-flex align-items-center justify-content-center py-10">
                                        <div class="text-center">
                                            <i class="ki-duotone ki-home fs-2tx text-muted mb-3"></i>
                                            <div class="fw-semibold text-muted fs-6">
                                                Tidak ada riwayat bantuan untuk KK ini.
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>
        <!--end::Content-->

    </div>
</div>
