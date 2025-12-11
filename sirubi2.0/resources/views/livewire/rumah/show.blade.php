
<div>
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Detail Rumah</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">
                            <a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">Data</a>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <!--end::Item-->
                        <!--begin::Item-->
                        <li class="breadcrumb-item text-muted">Rumah</li>
                        <!--end::Item-->
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                <!--begin::Actions-->
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <!--begin::Filter menu-->
                    <div class="m-0">
                       

                    
                        <a href="#" class="btn btn-light btn-active-light-primary btn-sm show menu-dropdown" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                        <span class="svg-icon svg-icon-5 m-0">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"></path>
                            </svg>
                        </span>
                        <!--end::Svg Icon--></a>
                        <!--begin::Menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true" data-popper-placement="bottom-end" style="z-index: 107; position: fixed; inset: 0px 0px auto auto; margin: 0px; transform: translate(-219px, 443px);">
                            <!--begin::Menu item-->
                            @if (auth()->user()->level != 3)
    <!-- Edit -->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3"
                            wire:click.prevent="goToEdit({{ $rumah->id_rumah }})">
                                <i class="ki-duotone ki-pencil fs-5 text-success me-2"></i>
                                Edit
                            </a>
                        </div>

                        <!-- Hapus -->
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3 text-danger"
                            onclick="confirmDelete({{ $rumah->id_rumah }})">
                                <i class="ki-duotone ki-trash fs-5 text-danger me-2"></i>
                                Hapus
                            </a>
                        </div>
                    @endif


                           <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 text-primary" id="btnCetakPdf">
                                    <i class="ki-duotone ki-printer fs-5 text-primary me-2"></i>
                                    Cetak PDF
                                </a>
                            </div>

                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu-->
													
                        <!--end::Menu 1-->
                    </div>
                    <!--end::Filter menu-->
                    <!--begin::Secondary button-->
                    <!--end::Secondary button-->
                    <!--begin::Primary button-->
                    
                    <!--end::Primary button-->
                </div>
                <!--end::Actions-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Layout-->
                <div class="d-flex flex-column flex-xl-row">
                    <!--begin::Sidebar-->
                    <div class="flex-column flex-lg-row-auto w-100 w-xl-500px mb-10">
                        <!--begin::Card-->
                        <div class="card mb-6 mb-xl-8">
                            <!--begin::Card body-->
                            <div class="card-body pt-15">
                                <!--begin::Summary-->
                                <div class="d-flex flex-center flex-column mb-5">
                                    <!--begin::Avatar-->
                                    
                                    <!--begin::Name-->
                                    <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-1">Foto Rumah</a>
                                    <!--end::Name-->
                                    <div class="separator separator-dashed my-3"></div>
                                   
                                    @if($rumah->dokumen && $rumah->dokumen->foto_rumah_satu)
                                    {{-- @php
    dd(asset('storage/' . $rumah->dokumen->foto_rumah_satu));
@endphp --}}
                                        <img src="{{ asset('storage/' . $rumah->dokumen->foto_rumah_satu) }}"
                                            class="img-fluid rounded shadow-sm mb-2 preview-foto"
                                            style="max-height: 200px; object-fit: cover; cursor: pointer;"
                                            data-bs-toggle="modal"
                                            data-bs-target="#previewModal"
                                            data-src="{{ asset('storage/' . $rumah->dokumen->foto_rumah_satu) }}">
                                    @else
                                        <span class="text-muted">Foto rumah belum diunggah.</span>
                                    @endif
                                    
                                </div>
                                <!--end::Summary-->
                                <!--begin::Details toggle-->
                                <div class="d-flex flex-stack fs-4 py-3">
                                    <div class="fw-bold rotate collapsible" data-bs-toggle="collapse" href="#kt_customer_view_details" role="button" aria-expanded="false" aria-controls="kt_customer_view_details">Lokasi
                                    {{-- <span class="ms-2 rotate-180">
                                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                        <span class="svg-icon svg-icon-3">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span> --}}
                                </div>

                            

                                    
                                </div>
                                <!--end::Details toggle-->
                                <div class="separator separator-dashed my-3"></div>
                                <!--begin::Details content-->
                                <div id="kt_customer_view_details" class="collapse show">
                                    <div class="py-5 fs-6">
                                        <div id="map" style="height: 350px; border-radius: 10px; border: 1px solid #ccc;"></div>

                                    </div>
                                    <div class="separator separator-dashed my-3"></div>
                                    <div class="mt-1">
                                        <table class="table table-row-dashed align-middle gs-0 gy-4">
                                            <tbody>

                                                @foreach($pertanyaanLokasi as $q)
                                                    <tr>
                                                        <!-- Label -->
                                                        <td >
                                                            {{ $q->label }}
                                                          <span class="text-primary fw-bold">*</span>
                                                        </td>

                                                        <!-- Jawaban -->
                                                        <td class="text-gray-800">
                                                            {{ $this->displayAnswer($q) }}
                                                        </td>
                                                    </tr>

                                                    <!-- CHILD QUESTIONS -->
                                                    @foreach($childQuestions as $child)
                                                        @if(
                                                            $child->parent_question_id == $q->id &&
                                                            $child->trigger_option_id == ($questionAnswers[$q->id] ?? null)
                                                        )
                                                            <tr>
                                                                <!-- Label Child -->
                                                                <td class="ps-10 fw-semibold fs-7 text-dark">
                                                                    — {{ $child->label }}

                                                                    @if($child->is_required)
                                                                        <span class="text-primary fw-bold">*</span>
                                                                    @endif
                                                                </td>

                                                                <!-- Jawaban Child -->
                                                                <td class="text-gray-700">
                                                                    {{ $this->displayAnswer($child) }}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach

                                                @endforeach

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                                <!--end::Details content-->
                            </div>
                            <!--end::Card body-->
                        </div>
                        <!--end::Card-->
                        <!--begin::Connected Accounts-->
                        <div class="card mb-5 mb-xl-8">
                            <!--begin::Card header-->
                            <div class="card-header border-0">
                                <div class="card-title">
                                    <h4 class="fw-bold m-0">Riwayat Bantuan</h4>
                                </div>
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                           <div class="card-body pt-2">

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
                            <div class="card-header border-0">
                                <div class="card-title">
                                    <h4 class="fw-bold m-0">Aspek Keselamatan</h4>
                                </div>
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                               <div class="card-body p-5">
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

                                    <div class="separator separator-dashed my-3"></div>
                                    <div class="mt-1">
                                       
                                        <table class="table table-row-dashed align-middle gs-0 gy-4">
                                            <tbody>

                                                @foreach($pertanyaanKeselamatan as $q)
                                                    <tr>
                                                        <!-- Label -->
                                                        <td >
                                                            {{ $q->label }}
                                                          <span class="text-primary fw-bold">*</span>
                                                        </td>

                                                        <!-- Jawaban -->
                                                        <td class="text-gray-800">
                                                            {{ $this->displayAnswer($q) }}
                                                        </td>
                                                    </tr>

                                                    <!-- CHILD QUESTIONS -->
                                                    @foreach($childQuestions as $child)
                                                        @if(
                                                            $child->parent_question_id == $q->id &&
                                                            $child->trigger_option_id == ($questionAnswers[$q->id] ?? null)
                                                        )
                                                            <tr>
                                                                <!-- Label Child -->
                                                                <td class="ps-10 fw-semibold fs-7 text-dark">
                                                                    — {{ $child->label }}

                                                                    @if($child->is_required)
                                                                        <span class="text-primary fw-bold">*</span>
                                                                    @endif
                                                                </td>

                                                                <!-- Jawaban Child -->
                                                                <td class="text-gray-700">
                                                                    {{ $this->displayAnswer($child) }}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach

                                                @endforeach

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
                            <div class="card-header border-0">
                                <div class="card-title">
                                    <h4 class="fw-bold m-0">Aspek Persyaratan Luas dan Kebutuhan Ruang</h4>
                                </div>
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body p-5">
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

                                <div class="separator separator-dashed my-3"></div>
                                    <div class="mt-1">
                                      
                                        <table class="table table-row-dashed align-middle gs-0 gy-4">
                                            <tbody>

                                                @foreach($pertanyaanLuasBangunan as $q)
                                                    <tr>
                                                        <!-- Label -->
                                                        <td >
                                                            {{ $q->label }}
                                                          <span class="text-primary fw-bold">*</span>
                                                        </td>

                                                        <!-- Jawaban -->
                                                        <td class="text-gray-800">
                                                            {{ $this->displayAnswer($q) }}
                                                        </td>
                                                    </tr>

                                                    <!-- CHILD QUESTIONS -->
                                                    @foreach($childQuestions as $child)
                                                        @if(
                                                            $child->parent_question_id == $q->id &&
                                                            $child->trigger_option_id == ($questionAnswers[$q->id] ?? null)
                                                        )
                                                            <tr>
                                                                <!-- Label Child -->
                                                                <td class="ps-10 fw-semibold fs-7 text-dark">
                                                                    — {{ $child->label }}

                                                                    @if($child->is_required)
                                                                        <span class="text-primary fw-bold">*</span>
                                                                    @endif
                                                                </td>

                                                                <!-- Jawaban Child -->
                                                                <td class="text-gray-700">
                                                                    {{ $this->displayAnswer($child) }}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach

                                                @endforeach

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
                            <div class="card-header border-0">
                                <div class="card-title">
                                    <h4 class="fw-bold m-0">Pertanyaan Lainnya</h4>
                                </div>
                            </div>
                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div class="card-body p-5">
                            

                                <div class="separator separator-dashed my-3"></div>
                                    <div class="mt-1">
                                     
                                         <table class="table table-row-dashed align-middle gs-0 gy-4">
                                            <tbody>

                                                @foreach($pertanyaanLainnya as $q)
                                                    <tr>
                                                        <!-- Label -->
                                                        <td >
                                                            {{ $q->label }}
                                                          <span class="text-primary fw-bold">*</span>
                                                        </td>

                                                        <!-- Jawaban -->
                                                        <td class="text-gray-800">
                                                            {{ $this->displayAnswer($q) }}
                                                        </td>
                                                    </tr>

                                                    <!-- CHILD QUESTIONS -->
                                                    @foreach($childQuestions as $child)
                                                        @if(
                                                            $child->parent_question_id == $q->id &&
                                                            $child->trigger_option_id == ($questionAnswers[$q->id] ?? null)
                                                        )
                                                            <tr>
                                                                <!-- Label Child -->
                                                                <td class="ps-10 fw-semibold fs-7 text-dark">
                                                                    — {{ $child->label }}

                                                                    @if($child->is_required)
                                                                        <span class="text-primary fw-bold">*</span>
                                                                    @endif
                                                                </td>

                                                                <!-- Jawaban Child -->
                                                                <td class="text-gray-700">
                                                                    {{ $this->displayAnswer($child) }}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach

                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                            </div>
                            <!--end::Card body-->
                            <!--begin::Card footer-->
                            
                            <!--end::Card footer-->
                        </div>

                    </div>
                    <!--end::Sidebar-->
                    <!--begin::Content-->
                    <div class="flex-lg-row-fluid ms-lg-15">
                       <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">
                            <!--begin:::Tab item-->
                            <li class="nav-item">
                                <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_user_view_overview_tab">Detail Data</a>
                            </li>
                            <!--end:::Tab item-->
                            <!--begin:::Tab item-->
                            <li class="nav-item">
                                <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab" href="#kt_user_view_overview_security">Timeline Perubahan Data</a>
                            </li>
                            <!--end:::Tab item-->
                            <!--begin:::Tab item-->
                            
                                <!--end::Menu-->
                                <!--end::Menu-->
                            
                            <!--end:::Tab item-->
                        </ul>
                        <!--end:::Tabs-->
                        <!--begin:::Tab content-->
                        <div class="tab-content" id="myTabContent">
                            <!--begin:::Tab pane-->
                            <div class="tab-pane fade show active" id="kt_user_view_overview_tab" role="tabpanel">
                                <!--begin::Card-->
                                <div class="card pt-4 mb-6 mb-xl-9">
                                    <!--begin::Card header-->
                                    <div class="card-header border-0">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h4>Kartu Keluarga</h4>
                                        </div>
                                        <!--end::Card title-->
                                        
                                        
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                   <div class="card-body pt-5">
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
                                                    <h6 class="fw-bold text-gray-800 mb-3">Daftar Anggota Keluarga</h6>

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

                                        <div class="separator separator-dashed my-3"></div>
                                        <div class="mt-1">
                                           
                                            <table class="table table-row-dashed align-middle gs-0 gy-4">
                                                <tbody>

                                                    @foreach($pertanyaanKk as $q)
                                                        <tr>
                                                            <!-- Label -->
                                                            <td >
                                                                {{ $q->label }}
                                                               <span class="text-primary fw-bold">*</span>
                                                            </td>

                                                            <!-- Jawaban -->
                                                            <td class="text-gray-800">
                                                                {{ $this->displayAnswer($q) }}
                                                            </td>
                                                        </tr>

                                                        <!-- CHILD QUESTIONS -->
                                                        @foreach($childQuestions as $child)
                                                            @if(
                                                                $child->parent_question_id == $q->id &&
                                                                $child->trigger_option_id == ($questionAnswers[$q->id] ?? null)
                                                            )
                                                                <tr>
                                                                    <!-- Label Child -->
                                                                    <td class="ps-10 fw-semibold fs-7 text-dark">
                                                                        — {{ $child->label }}

                                                                        @if($child->is_required)
                                                                            <span class="text-primary fw-bold">*</span>
                                                                        @endif
                                                                    </td>

                                                                    <!-- Jawaban Child -->
                                                                    <td class="text-gray-700">
                                                                        {{ $this->displayAnswer($child) }}
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach

                                                    @endforeach

                                                </tbody>
                                            </table>

                                            
                                        </div>
                                    </div>

                                    <!--end::Card body-->
                                </div>
                                <!--end::Card-->
                                <!--begin::Card-->
                                <div class="card pt-4 mb-6 mb-xl-9">
                                    <!--begin::Card header-->
                                    <div class="card-header border-0">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h4 class="fw-bold mb-0">Data Umum Rumah</h4>
                                        </div>
                                        <!--end::Card title-->
                                        <!--begin::Card toolbar-->
                                        
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body p-5">
                                        <div class="table-responsive">
                                            <table class="table align-middle table-row-dashed gy-3 fs-7 fw-semibold text-gray-700 mb-0">
                                                <tbody>
                                                    <tr>
                                                        <td class="w-40 text-gray-600">Jenis Kelamin</td>
                                                        <td>{{ $rumah->sosialEkonomi->jenisKelamin->jenis_kelamin ?? '-' }}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Kecamatan</td>
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

                                        <div class="separator separator-dashed my-3"></div>
                                        <div class="mt-1">
                                            
                                              <table class="table table-row-dashed align-middle gs-0 gy-4">
                                                <tbody>

                                                    @foreach($pertanyaanIdentitas as $q)
                                                        <tr>
                                                            <!-- Label -->
                                                            <td >
                                                                {{ $q->label }}
                                                               <span class="text-primary fw-bold">*</span>
                                                            </td>

                                                            <!-- Jawaban -->
                                                            <td class="text-gray-800">
                                                                {{ $this->displayAnswer($q) }}
                                                            </td>
                                                        </tr>

                                                        <!-- CHILD QUESTIONS -->
                                                        @foreach($childQuestions as $child)
                                                            @if(
                                                                $child->parent_question_id == $q->id &&
                                                                $child->trigger_option_id == ($questionAnswers[$q->id] ?? null)
                                                            )
                                                                <tr>
                                                                    <!-- Label Child -->
                                                                    <td class="ps-10 fw-semibold fs-7 text-dark">
                                                                        — {{ $child->label }}

                                                                        @if($child->is_required)
                                                                            <span class="text-primary fw-bold">*</span>
                                                                        @endif
                                                                    </td>

                                                                    <!-- Jawaban Child -->
                                                                    <td class="text-gray-700">
                                                                        {{ $this->displayAnswer($child) }}
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach

                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card-->
                                <!--begin::Card-->
                                <div class="card pt-4 mb-6 mb-xl-9">
                                    <!--begin::Card header-->
                                    <div class="card-header border-0">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <h4 class="fw-bold">Aspek Kesehatan</h4>
                                        </div>
                                        <!--end::Card title-->
                                       
                                        <!--end::Card toolbar-->
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body p-5">
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
                                                        <td>{{ $rumah->sanitasi->keteranganVentilasi->keterangan_ventilasi ?? '-' }}</td>
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

                                         <div class="separator separator-dashed my-3"></div>
                                        <div class="mt-1">
                                           
                                            <table class="table table-row-dashed align-middle gs-0 gy-4">
                                                <tbody>

                                                    @foreach($pertanyaanKesehatan as $q)
                                                        <tr>
                                                            <!-- Label -->
                                                            <td >
                                                                {{ $q->label }}
                                                               <span class="text-primary fw-bold">*</span>
                                                            </td>

                                                            <!-- Jawaban -->
                                                            <td class="text-gray-800">
                                                                {{ $this->displayAnswer($q) }}
                                                            </td>
                                                        </tr>

                                                        <!-- CHILD QUESTIONS -->
                                                        @foreach($childQuestions as $child)
                                                            @if(
                                                                $child->parent_question_id == $q->id &&
                                                                $child->trigger_option_id == ($questionAnswers[$q->id] ?? null)
                                                            )
                                                                <tr>
                                                                    <!-- Label Child -->
                                                                    <td class="ps-10 fw-semibold fs-7 text-dark">
                                                                        — {{ $child->label }}

                                                                        @if($child->is_required)
                                                                            <span class="text-primary fw-bold">*</span>
                                                                        @endif
                                                                    </td>

                                                                    <!-- Jawaban Child -->
                                                                    <td class="text-gray-700">
                                                                        {{ $this->displayAnswer($child) }}
                                                                    </td>
                                                                </tr>
                                                            @endif
                                                        @endforeach

                                                    @endforeach

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

                            <div class="tab-pane fade" id="kt_user_view_overview_security" role="tabpanel">
													<!--begin::Card-->
                              @foreach($this->historyByDate as $date => $users)
    <div class="card my-10">

        <!-- Tanggal -->
        <div class="card-header">
            <h3 class="fw-bold text-gray-800">
                {{ \Carbon\Carbon::parse($date)->translatedFormat('d F Y') }}
            </h3>
        </div>

        <div class="card-body">

            <div class="timeline">

                @foreach($users as $userId => $changes)
                <!-- Timeline item per User -->
                <div class="timeline-item">

                    <!-- Garis -->
                    <div class="timeline-line w-40px"></div>

                    <!-- Icon User -->
                    <div class="timeline-icon symbol symbol-circle symbol-40px me-4">
                        <div class="symbol-label bg-light">
                            <span class="text-primary fw-bold">
                                {{ strtoupper(substr($changes->first()->user->name, 0, 1)) }}
                            </span>
                        </div>
                    </div>

                    <!-- Konten -->
                    <div class="timeline-content mb-10">

                        <!-- Header -->
                        <div class="pe-3 mb-5">
                            <div class="fw-bold fs-5 text-gray-700">
                                {{ $changes->first()->user->name }}
                            </div>

                            <div class="text-muted fs-7">
                                Total perubahan: {{ $changes->count() }}
                            </div>

                            <div class="text-muted fs-8">
                                        {{ $changes->first()->changed_at->format('H:i') }} WIB
                                    </div>
                        </div>

                        <!-- Detail Changes -->
                        <div class="border rounded p-5">

                            @foreach($changes as $item)
                                <div class="d-flex flex-column border-bottom pb-3 mb-3">

                                    <div class="fw-bold mb-1">
                                        {{ $this->formatKategori($item->kategori) }} → 
                                        <span class="text-primary">{{ $this->translateSurveyField($item->field) }}</span>
                                    </div>

                                    

                                    <div class="fs-7 mt-1">
                                        {{-- <span class="text-danger">Old:</span> {{ $this->translateValue($item->kategori, $item->field, $item->old_value) }} <br>
                                        <span class="text-success">New:</span> {{ $this->translateValue($item->kategori, $item->field, $item->new_value) }} --}}
                                        @if($item->field === 'updated_at')

                                        
                                            <span class="text-danger fw-semibold">Data Lama:</span><br>
                                            {{ $item->old_value ? \Carbon\Carbon::parse($item->old_value)->translatedFormat('d F Y • H:i') . ' WIB' : '-' }}
                                            <br>

                                            <span class="text-success fw-semibold">Data Baru:</span><br>
                                            {{ $item->new_value ? \Carbon\Carbon::parse($item->new_value)->translatedFormat('d F Y • H:i') . ' WIB' : '-' }}

                                         @elseif($item->kategori === 'kk')
                                            <div class="mb-2 fw-bold">📌 Perubahan KK/Anggota</div>

                                            @if(empty($item->old_value))
                                                <span class="badge badge-success">Tambah</span>
                                                → {{ $this->translateValue('kk', $item->field, $item->new_value) }}

                                            @elseif(empty($item->new_value))
                                                <span class="badge badge-danger">Hapus</span>
                                                → {{ $this->translateValue('kk', $item->field, $item->old_value) }}

                                            @else
                                                <table class="table table-sm table-bordered w-auto">
                                                    <tr>
                                                        <th>Data Lama</th>
                                                        <td>{{ $this->translateValue('kk', $item->field, $item->old_value) }}</td>
                                                    </tr>
                                                    <tr>
                                                        <th>Data Baru</th>
                                                        <td>{{ $this->translateValue('kk', $item->field, $item->new_value) }}</td>
                                                    </tr>
                                                </table>
                                            @endif

                                        @else
                                            {{-- Default --}}
                                            <span class="text-danger">Data Lama:</span> 
                                            {{ $this->translateValue($item->kategori, $item->field, $item->old_value) }} <br>

                                            <span class="text-success">Data Baru:</span> 
                                            {{ $this->translateValue($item->kategori, $item->field, $item->new_value) }}
                                        @endif

                                    </div>

                                </div>
                            @endforeach

                        </div>
                    </div>

                </div>
                @endforeach

            </div>

        </div>

    </div>
@endforeach



                                <!--end::Card-->
                                <!--begin::Card-->
                               
                                <!--end::Card-->
                            </div>
                            
                        </div>
                        <!--end:::Tab content-->
                    </div>

                    
                    <!--end::Content-->
                </div>

                <div class="card pt-2 mb-6 mb-xl-9">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h4> Aspek Komponen Bahan Bangunan</h4>
                        </div>
                        <!--end::Card title-->
                        
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body p-5">
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

                         <div class="separator separator-dashed my-3"></div>
                        <div class="mt-1">
                          

                                <table class="table table-row-dashed align-middle gs-0 gy-4">
                                    <tbody>

                                        @foreach($pertanyaanBahanBangunan as $q)
                                            <tr>
                                                <!-- Label -->
                                                <td >
                                                    {{ $q->label }}
                                                    @if($q->is_required)
                                                        <span class="text-primary fw-bold">*</span>
                                                    @endif
                                                </td>

                                                <!-- Jawaban -->
                                                <td class="text-gray-800">
                                                    {{ $this->displayAnswer($q) }}
                                                </td>
                                            </tr>

                                            <!-- CHILD QUESTIONS -->
                                            @foreach($childQuestions as $child)
                                                @if(
                                                    $child->parent_question_id == $q->id &&
                                                    $child->trigger_option_id == ($questionAnswers[$q->id] ?? null)
                                                )
                                                    <tr>
                                                        <!-- Label Child -->
                                                        <td class="ps-10 fw-semibold fs-7 text-dark">
                                                            — {{ $child->label }}

                                                            @if($child->is_required)
                                                                <span class="text-primary fw-bold">*</span>
                                                            @endif
                                                        </td>

                                                        <!-- Jawaban Child -->
                                                        <td class="text-gray-700">
                                                            {{ $this->displayAnswer($child) }}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach

                                        @endforeach

                                    </tbody>
                                </table>
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Layout-->
                <div class="card card-flush border border-gray-200 shadow-sm mt-1">
                        <div class="card-header border-0">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h4> Dokumentasi</h4>
                            </div>
                            <!--end::Card title-->
                            
                        </div>
                        <div class="card-body p-5">
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

                            <div class="row g-5">
                                @foreach($fotos as $label => $path)

                              
                                    <div class="col-md-4 col-sm-6">
                                        <div class="card card-bordered shadow-sm hover-elevate-up transition-all h-100">
                                            @if($path)
                                                <div class="overlay">
                                                    
                                                    
                                                        
                                                        <img src="{{ asset('storage/' . $path) }}"
                                                            class="img-fluid w-100 h-250px object-fit-cover rounded-top preview-foto"
                                                            style="max-height: 200px; object-fit: cover; cursor: pointer;"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#previewModal"
                                                            data-src="{{ asset('storage/' . $path) }}">

                                                    
                                                </div>
                                                <div class="card-footer text-center py-3 bg-light">
                                                    <span class="fw-semibold text-gray-700">{{ $label }}</span>
                                                </div>
                                            @else
                                                <div class="d-flex flex-column align-items-center justify-content-center bg-light rounded py-10 h-250px">
                                                    <i class="ki-duotone ki-image fs-3x text-gray-400 mb-3"></i>
                                                    <div class="text-muted fw-semibold">{{ $label }}</div>
                                                    <span class="badge badge-light-secondary mt-2">Belum diunggah</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach

                                  <div class="separator separator-dashed my-3"></div>
                        <div class="mt-1">
                           
                               <table class="table table-row-dashed align-middle gs-0 gy-4">
                                    <tbody>

                                        @foreach($pertanyaanDokumentasi as $q)
                                            <tr>
                                                <!-- Label -->
                                                <td >
                                                    {{ $q->label }}
                                                    @if($q->is_required)
                                                        <span class="text-primary fw-bold">*</span>
                                                    @endif
                                                </td>

                                                <!-- Jawaban -->
                                                <td class="text-gray-800">
                                                    {!! $this->displayAnswer($q) !!}
                                                </td>
                                            </tr>

                                            <!-- CHILD QUESTIONS -->
                                            @foreach($childQuestions as $child)
                                                @if(
                                                    $child->parent_question_id == $q->id &&
                                                    $child->trigger_option_id == ($questionAnswers[$q->id] ?? null)
                                                )
                                                    <tr>
                                                        <!-- Label Child -->
                                                        <td class="ps-10 fw-semibold fs-7 text-dark">
                                                            — {{ $child->label }}

                                                            @if($child->is_required)
                                                                <span class="text-primary fw-bold">*</span>
                                                            @endif
                                                        </td>

                                                        <!-- Jawaban Child -->
                                                        <td class="text-gray-700">
                                                            {!! $this->displayAnswer($child) !!}
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach

                                        @endforeach

                                    </tbody>
                                </table>
                        </div>
                            </div>
                        </div>
                </div>


                @php
                    $penilaian = $rumah->penilaian;

                    // Status rumah
                    $isLayak = ($penilaian->status_rumah === 'RLH');
                    $warna = $isLayak ? 'success' : 'danger';
                    $judul = $isLayak ? 'RUMAH LAYAK HUNI' : 'RUMAH TIDAK LAYAK HUNI';

                    // Backlog
                    $backlog = ($rumah->kepalaKeluarga->count() > 1) ? 'BACKLOG' : 'TIDAK BACKLOG';
                    $warnaBacklog = ($rumah->kepalaKeluarga->count() > 1) ? 'warning' : 'primary';

                    // Luas rumah
                    $statusLuas = ($penilaian->status_luas == 1) ? 'LUAS RUMAH CUKUP' : 'LUAS RUMAH KURANG';
                    $warnaLuas = ($penilaian->status_luas == 1) ? 'success' : 'danger';

                    $nilaiTotal = $penilaian->nilai ?? '-';
                @endphp

                <div class="card card-flush border border-gray-200 shadow-sm mt-1">
                    <!--begin::Header-->
                    <div class="card-header pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark fs-3">{{ $judul }}</span>
                            <span class="text-gray-500 mt-1 fw-semibold fs-7">
                                Nilai Total Penilaian: <span class="fw-bold text-{{ $warna }}">{{ $nilaiTotal }}</span>
                            </span>
                        </h3>

                        <div class="card-toolbar">
                            <span class="badge badge-light-{{ $warna }} fs-base mt-n3">
                                <span class="svg-icon svg-icon-5 svg-icon-{{ $warna }} ms-n1 me-1">
                                    <i class="ki-duotone ki-home fs-5 text-{{ $warna }}"></i>
                                </span>
                                {{ strtoupper($penilaian->status_rumah ?? '-') }}
                            </span>
                        </div>
                    </div>
                    <!--end::Header-->

                    <!--begin::Body-->
                    <div class="card-body d-flex align-items-end pt-6">
                        <div class="row align-items-center mx-0 w-100">
                            <div class="col-7 px-0">
                                <div class="d-flex flex-column content-justify-center">
                                    <!-- Status Rumah -->
                                    <div class="d-flex fs-6 fw-semibold align-items-center mb-4">
                                        <div class="bullet bg-{{ $warna }} me-3" style="border-radius:3px;width:12px;height:12px"></div>
                                        <div class="fs-5 fw-bold text-gray-700 me-5">Status Rumah</div>
                                        <div class="ms-auto fw-bolder text-gray-800">{{ $judul }}</div>
                                    </div>

                                    <!-- Backlog -->
                                    <div class="d-flex fs-6 fw-semibold align-items-center mb-4">
                                        <div class="bullet bg-{{ $warnaBacklog }} me-3" style="border-radius:3px;width:12px;height:12px"></div>
                                        <div class="fs-5 fw-bold text-gray-700 me-5">Kondisi Backlog</div>
                                        <div class="ms-auto fw-bolder text-gray-800">{{ $backlog }}</div>
                                    </div>

                                    <!-- Luas Rumah -->
                                    <div class="d-flex fs-6 fw-semibold align-items-center">
                                        <div class="bullet bg-{{ $warnaLuas }} me-3" style="border-radius:3px;width:12px;height:12px"></div>
                                        <div class="fs-5 fw-bold text-gray-700 me-5">Status Luas Rumah</div>
                                        <div class="ms-auto fw-bolder text-gray-800">{{ $statusLuas }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-5 d-flex justify-content-end px-0">
                                <!-- Grafik dummy / ring status -->
                                <div id="status_rumah_chart" class="h-150px w-150px position-relative">
                                    <canvas id="rumahChart"></canvas>
                                    <div class="position-absolute top-50 start-50 translate-middle text-center">
                                        <span class="fw-bold fs-3 fw-bold text-{{ $warna }}">{{ $nilaiTotal }}</span>
                                        <div class="text-gray-500 fs-8">Nilai</div>
                                    </div>
                                </div>
                            </div>

                            <small><i>*Kriteria RLH atau RTLH dilihat dari kondisi <strong>Atap</strong>, <strong>Lantai</strong> dan <strong>Dinding</strong> (<strong>ALADIN</strong>).</i></small>
                        </div>
                    </div>
                    <!--end::Body-->
                </div>

            </div>
        </div>


@push('js')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const lat = {{ $rumah->latitude ?? '0' }};
    const lon = {{ $rumah->longitude ?? '0' }};

    if (!lat || !lon || lat == 0 || lon == 0) {
        console.warn('⚠️ Lokasi belum tersedia.');
        return;
    }

    // --- Layer Definitions ---
    const googleStreets = L.tileLayer(
        'https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',
        { maxZoom: 21, subdomains: ['mt0','mt1','mt2','mt3'], attribution: '© Google Maps' }
    );

    const googleHybrid = L.tileLayer(
        'https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',
        { maxZoom: 21, subdomains: ['mt0','mt1','mt2','mt3'], attribution: '© Google Hybrid' }
    );

    const openStreet = L.tileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        { maxZoom: 19, attribution: '© OpenStreetMap contributors' }
    );

    // --- Map Initialization (default Google Hybrid) ---
    const map = L.map('map', {
        center: [lat, lon],
        zoom: 15,
        layers: [googleHybrid] // default layer
    });

    // --- Layer Control ---
    const baseLayers = {
        "Google Hybrid": googleHybrid,
        "Google Streets": googleStreets,
        "OpenStreetMap": openStreet
    };

    L.control.layers(baseLayers, null, { position: 'topright', collapsed: true }).addTo(map);

    // --- Marker ---
    const marker = L.marker([lat, lon]).addTo(map);
    marker.bindPopup(`<b>{{ $rumah->alamat }}</b>`).openPopup();

    // --- Fix rendering in hidden containers (delay size update) ---
    setTimeout(() => map.invalidateSize(), 500);



     window.confirmDelete = function(id) {
        event.preventDefault(); // 🧩 Hindari reload form/link

        Swal.fire({
            title: 'Yakin hapus data ini?',
            text: 'Data akan dihapus secara permanen!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // 🔥 Dispatch event ke Livewire TANPA render ulang tabel
                console.log('🔥 Dispatch deleteRumah untuk ID:', id);
           Livewire.dispatch('deleteRumah', [{ id: id }]);

        }
        });
    };
    
});
</script>


<script>
document.addEventListener('livewire:init', () => {
    console.log('✅ Livewire initialized');

   

    // ✅ Tangkap event dari Livewire
    Livewire.on('rumahDeleted', (data) => {
        if (window.rumahTable) {
            window.rumahTable.ajax.reload(null, false);
        }

      Swal.fire({
            toast: true,
            icon: 'success',
            text: 'Data berhasil dihapus!',
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });

        setTimeout(() => {
            window.location.href = "{{ route('data') }}";
        }, 1500);
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('btnCetakPdf');
    if (!btn) return;

    btn.addEventListener('click', async function (e) {
        e.preventDefault();

        Swal.fire({
            title: 'Mempersiapkan PDF...',
            text: 'Mohon tunggu sebentar, sistem sedang membuat dokumen.',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        try {
            // Ambil file dari route PDF (return response()->streamDownload)
            const response = await fetch("{{ route('rumah.pdf', $rumah->id_rumah) }}");

            if (!response.ok) throw new Error('Gagal membuat PDF.');

            // Konversi ke blob (file binary)
            const blob = await response.blob();

            // Buat URL download
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;

            // Nama file hasil download
            a.download = "Data_Rumah_{{ $namaPemilik ?? 'Tanpa_Nama' }}.pdf";

            // Jalankan download
            document.body.appendChild(a);
            a.click();
            a.remove();

            // Bersihkan URL blob
            window.URL.revokeObjectURL(url);

            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'File PDF berhasil diunduh.',
                timer: 2500,
                showConfirmButton: false
            });
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: error.message || 'Terjadi kesalahan saat membuat PDF.',
            });
        }
    });
});
</script>



@endpush