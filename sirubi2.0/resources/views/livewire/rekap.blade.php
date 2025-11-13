
<div x-data x-init="window.livewireComponentId = $el.getAttribute('wire:id')" wire:key="rekap-tabel" class="d-flex flex-column flex-fill">
 <style>
 .loading .indicator-label { display:none; }
.loading .indicator-progress { display:inline-block !important; }

   /* WRAPPER RESPONSIVE */
.rekap-wrapper {
    width: 100%;
    overflow-x: auto;
}

/* TABEL DASAR */
.rekap-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 900px;
    border: 1px solid var(--rekap-border);
}

.rekap-table th,
.rekap-table td {
    border: 1px solid var(--rekap-border);
    padding: 6px 4px;
}

/* TITLE CELL */
.rekap-title-cell {
    font-weight: bold;
    border: 1px solid var(--rekap-border);
}

/* DARK MODE COLORS */
[data-theme="dark"] .rekap-table,
.dark-mode .rekap-table {
    --rekap-border: #3f3f57;
    --rekap-bg-header: #1f1f2e;
    --rekap-bg-sub: #2b2b40;
    --rekap-bg-footer: #2b2b40;
    --rekap-text: #e5e5f0;
}

/* LIGHT MODE COLORS */
[data-theme="light"] .rekap-table,
.rekap-table {
    --rekap-border: #cbd0d8;
    --rekap-bg-header: #f2f3f7;
    --rekap-bg-sub: #fafbfc;
    --rekap-bg-footer: #f2f3f7;
    --rekap-text: #333;
}

/* HEADER */
.rekap-table thead th {
    background: var(--rekap-bg-header);
    color: var(--rekap-text);
    font-weight: 600;
    text-transform: uppercase;
}

/* SUBHEADER */
.rekap-table .subhead th {
    background: var(--rekap-bg-sub);
    color: var(--rekap-text);
    font-size: 11px;
}

/* FOOTER */
.rekap-table tfoot td {
    background: var(--rekap-bg-footer);
    color: var(--rekap-text);
    font-weight: bold;
}


</style>
    <div class="d-flex flex-column flex-column-fluid">

        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex fw-bold fs-3 flex-column justify-content-center my-0 ">
                        Data Rekapitulasi
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1 text-gray-400">
                        <li class="breadcrumb-item">
                            <a href="{{ url('/') }}" class="text-gray-400 text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-500 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-gray-400">Rekapitulasi</li>
                    </ul>
                </div>
            </div>
        </div>
        <!--end::Toolbar-->

        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">

                <!--begin::Card-->
                <div class="card shadow-sm border border-gray-600 ">
                    <div class="card-header border-0">
                        <h3 class="card-title fw-bold ">
                             Rekapitulasi Data Rumah (Kecamatan {{ $kecamatanNama }})
                        </h3>

                        <div class="card-toolbar" data-select2-id="select2-data-132-9owp">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                               
                                <!--begin::Menu 1-->
                                
                                <!--end::Menu 1-->
                                <!--end::Filter-->
                                <!--begin::Export-->
                                <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_export_users">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr078.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1" transform="rotate(90 12.75 4.25)" fill="currentColor"></rect>
                                        <path d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z" fill="currentColor"></path>
                                        <path opacity="0.3" d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->Export</button>
                                
                            
                                <!--end::Add user-->
                            </div>
                            <!--end::Toolbar-->
                            <div class="modal fade" id="kt_modal_export_users" tabindex="-1" aria-hidden="true" style="display: none;"  wire:ignore.self>
                                <!--begin::Modal dialog-->
                                <div class="modal-dialog modal-dialog-centered mw-650px" data-select2-id="select2-data-131-um5u">
                                    <!--begin::Modal content-->
                                    <div class="modal-content">
                                        <!--begin::Modal header-->
                                        <div class="modal-header">
                                            <!--begin::Modal title-->
                                            <h2 class="fw-bold">Export Data</h2>
                                            <!--end::Modal title-->
                                            <!--begin::Close-->
                                            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close" data-bs-dismiss="modal">
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                                                <span class="svg-icon svg-icon-1">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor"></rect>
                                                        <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor"></rect>
                                                    </svg>
                                                </span>
                                                <!--end::Svg Icon-->
                                            </div>
                                            <!--end::Close-->
                                        </div>
                                        <!--end::Modal header-->
                                        <!--begin::Modal body-->
                                        <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                                            <!--begin::Form-->
                                            <form id="kt_modal_export_users_form" class="form fv-plugins-bootstrap5 fv-plugins-framework" wire:submit.prevent="exportData" >
                                               
                                                <!--begin::Input group-->
                                                <div class="fv-row mb-10" wire:ignore>
                                                    <!--begin::Label-->
                                                    <label class="required fs-6 fw-semibold form-label mb-2">Pilih Format Export</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <select name="format"  data-control="select2" data-placeholder="Select a format" data-hide-search="true" class="form-select form-select-solid fw-bold"   wire:ignore.self style="border-color: rgb(54 54 96);" >
                                                        <option></option>
                                                        <option value="excel">Excel (.xls)</option>
                                                        <option value="pdf">Pdf</option>
                                                        
                                                    </select>
                                                    <!--end::Input-->
                                                </div>
                                                <!--end::Input group-->
                                                <!--begin::Actions-->
                                                <div class="text-center">
                                                    <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                                        <span class="indicator-label" wire:loading.remove>Export</span>
                                                        <span class="indicator-progress" wire:loading>Mohon Tunggu...
                                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>
                                                </div>
                                                <!--end::Actions-->
                                            </form>
                                            <!--end::Form-->
                                        </div>
                                        <!--end::Modal body-->
                                    </div>
                                    <!--end::Modal content-->
                                </div>
                                <!--end::Modal dialog-->
                            </div>
                            
                        </div>
                        
                    </div>

                    <div class="card-body">

                        <!--begin::Accordion-->
                        <div class="accordion" id="rekapAccordion">
                            <div class="accordion-item  border border-gray-700 rounded-3 overflow-hidden mb-5">
                                <h2 class="accordion-header" id="rekap1Heading">
                                    <button class="accordion-button fs-4  " type="button"
                                            data-bs-toggle="collapse" data-bs-target="#rekap1Body"
                                            aria-expanded="true" aria-controls="rekap1Body">
                                         Data Rekapitulasi #1 – <span class="ms-1">Data Umum Rumah </span>
                                    </button>
                                </h2>
                                <div id="rekap1Body" class="accordion-collapse collapse show"
                                     aria-labelledby="rekap1Heading" data-bs-parent="#rekapAccordion">
                                    <div class="accordion-body p-5 bg-dark border-top border-gray-700">

                                        <!--begin::Table-->
                                        <div class="table-responsive">
                                            <table class="rekap-table table table-bordered align-middle text-center gy-3 mb-0 border border-gray-700">
                                                <thead class="bg-gray-900 text-gray-200 border-bottom border-gray-700">
                                                    <tr>
                                                        <th colspan="15" class="fs-6 fw-bold text-uppercase border-gray-700 bg-gray-800">
                                                            DATA REKAPITULASI #1<br><small>Data Umum Rumah</small>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th rowspan="2" class="border-gray-700 align-middle">No</th>
                                                        <th rowspan="2" class="border-gray-700 align-middle">Kelurahan</th>
                                                        <th colspan="3" class="border-gray-700">Jumlah</th>
                                                        <th colspan="2" class="border-gray-700">Kelayakan</th>
                                                        <th colspan="2" class="border-gray-700">Backlog</th>
                                                        <th colspan="2" class="border-gray-700">Aspek Keselamatan</th>
                                                        <th colspan="2" class="border-gray-700">Aspek Kesehatan</th>
                                                        <th colspan="2" class="border-gray-700">Aspek Komponen Bahan Bangunan</th>
                                                    </tr>
                                                    <tr>
                                                        <th class="border-gray-700">Rumah</th>
                                                        <th class="border-gray-700">KK</th>
                                                        <th class="border-gray-700">Penduduk</th>
                                                        <th class="border-gray-700">RLH</th>
                                                        <th class="border-gray-700">RTLH</th>
                                                        <th class="border-gray-700">Iya</th>
                                                        <th class="border-gray-700">Tidak</th>
                                                        <th class="border-gray-700">Prioritas</th>
                                                        <th class="border-gray-700">Tidak</th>
                                                        <th class="border-gray-700">Prioritas</th>
                                                        <th class="border-gray-700">Tidak</th>
                                                        <th class="border-gray-700">Prioritas</th>
                                                        <th class="border-gray-700">Tidak</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-gray-200">
                                                    @php
                                                        $no = 1;
                                                        $total = [
                                                            'jumlah_rumah' => 0, 'jumlah_kk' => 0, 'penduduk' => 0,
                                                            'rlh' => 0, 'rtlh' => 0, 'kk_lebih_1' => 0, 'kk_1' => 0,
                                                            'prioritas_a1' => 0, 'prioritas_a2' => 0,
                                                            'prioritas_b1' => 0, 'prioritas_b2' => 0,
                                                            'prioritas_c1' => 0, 'prioritas_c2' => 0,
                                                        ];
                                                    @endphp

                                                    @foreach($rekap1 as $a)
                                                        @php
                                                            $penduduk = $a['penghuni_laki'] + $a['penghuni_perempuan'];
                                                            $total['jumlah_rumah'] += $a['jumlah_rumah'];
                                                            $total['jumlah_kk'] += $a['jumlah_kk'];
                                                            $total['penduduk'] += $penduduk;
                                                            $total['rlh'] += $a['rlh'];
                                                            $total['rtlh'] += $a['rtlh'];
                                                            $total['kk_lebih_1'] += $a['kk_lebih_1'];
                                                            $total['kk_1'] += $a['kk_1'];
                                                            $total['prioritas_a1'] += $a['prioritas_a1'];
                                                            $total['prioritas_a2'] += $a['prioritas_a2'];
                                                            $total['prioritas_b1'] += $a['prioritas_b1'];
                                                            $total['prioritas_b2'] += $a['prioritas_b2'];
                                                            $total['prioritas_c1'] += $a['prioritas_c1'];
                                                            $total['prioritas_c2'] += $a['prioritas_c2'];
                                                        @endphp
                                                        <tr>
                                                            <td class="border-gray-700">{{ $no++ }}</td>
                                                            <td class="text-center border-gray-700">{{ $a['nama_kelurahan'] }}</td>
                                                            <td class="text-center border-gray-700">{{ number_format($a['jumlah_rumah'],0,',','.') }}</td>
                                                            <td class="text-center border-gray-700">{{ number_format($a['jumlah_kk'],0,',','.') }}</td>
                                                            <td class="text-center border-gray-700">{{ number_format($penduduk,0,',','.') }}</td>
                                                            <td class="text-center border-gray-700">{{ number_format($a['rlh'],0,',','.') }}</td>
                                                            <td class="text-center border-gray-700">{{ number_format($a['rtlh'],0,',','.') }}</td>
                                                            <td class="text-center border-gray-700">{{ number_format($a['kk_lebih_1'],0,',','.') }}</td>
                                                            <td class="text-center border-gray-700">{{ number_format($a['kk_1'],0,',','.') }}</td>
                                                            <td class="text-center border-gray-700">{{ number_format($a['prioritas_a1'],0,',','.') }}</td>
                                                            <td class="text-center border-gray-700">{{ number_format($a['prioritas_a2'],0,',','.') }}</td>
                                                            <td class="text-center border-gray-700">{{ number_format($a['prioritas_b1'],0,',','.') }}</td>
                                                            <td class="text-center border-gray-700">{{ number_format($a['prioritas_b2'],0,',','.') }}</td>
                                                            <td class="text-center border-gray-700">{{ number_format($a['prioritas_c1'],0,',','.') }}</td>
                                                            <td class="text-center border-gray-700">{{ number_format($a['prioritas_c2'],0,',','.') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>

                                                <tfoot class="fw-bold bg-gray-800 text-white border-top border-gray-700">
                                                    <tr>
                                                        <td colspan="2" class="text-center border-gray-700">TOTAL</td>
                                                        <td class="text-center border-gray-700">{{ number_format($total['jumlah_rumah'],0,',','.') }}</td>
                                                        <td class="text-center border-gray-700">{{ number_format($total['jumlah_kk'],0,',','.') }}</td>
                                                        <td class="text-center border-gray-700">{{ number_format($total['penduduk'],0,',','.') }}</td>
                                                        <td class="text-center border-gray-700">{{ number_format($total['rlh'],0,',','.') }}</td>
                                                        <td class="text-center border-gray-700">{{ number_format($total['rtlh'],0,',','.') }}</td>
                                                        <td class="text-center border-gray-700">{{ number_format($total['kk_lebih_1'],0,',','.') }}</td>
                                                        <td class="text-center border-gray-700">{{ number_format($total['kk_1'],0,',','.') }}</td>
                                                        <td class="text-center border-gray-700">{{ number_format($total['prioritas_a1'],0,',','.') }}</td>
                                                        <td class="text-center border-gray-700">{{ number_format($total['prioritas_a2'],0,',','.') }}</td>
                                                        <td class="text-center border-gray-700">{{ number_format($total['prioritas_b1'],0,',','.') }}</td>
                                                        <td class="text-center border-gray-700">{{ number_format($total['prioritas_b2'],0,',','.') }}</td>
                                                        <td class="text-center border-gray-700">{{ number_format($total['prioritas_c1'],0,',','.') }}</td>
                                                        <td class="text-center border-gray-700">{{ number_format($total['prioritas_c2'],0,',','.') }}</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <!--end::Table-->

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Accordion-->

                        <div class="accordion" id="rekap2Accordion">
                            <div class="accordion-item border border-gray-700 rounded-3 overflow-hidden mb-5">

                                <h2 class="accordion-header" id="rekap2Heading">
                                    <button class="accordion-button fs-4 " type="button"
                                            data-bs-toggle="collapse" data-bs-target="#rekap2Body"
                                            aria-expanded="true" aria-controls="rekap2Body">
                                         Data Rekapitulasi #2 – <span class="ms-1">Identitas Penghuni Rumah </span>
                                    </button>
                                </h2>

                                <div id="rekap2Body" class="accordion-collapse collapse show"
                                    aria-labelledby="rekap2Heading" data-bs-parent="#rekap2Accordion">
                                    <div class="accordion-body p-5 bg-dark border-top border-gray-700">

                                        <div class="table-responsive rekap-wrapper">

                                            <table class="rekap-table table table-bordered align-middle text-center gy-3 mb-0 border border-gray-700">

                                                {{-- ========================= --}}
                                                {{--        HEADER UTAMA       --}}
                                                {{-- ========================= --}}
                                                <thead class="bg-gray-900 text-gray-200 border-bottom border-gray-700">

                                                    <tr>
                                                        <th colspan="15" class="fs-6 fw-bold text-uppercase border-gray-700 bg-gray-800">
                                                            DATA REKAPITULASI #2<br><small>Identitas Penghuni Rumah</small>
                                                        </th>
                                                    </tr>

                                                    {{-- ========================= --}}
                                                    {{--     Header Baris 1        --}}
                                                    {{-- ========================= --}}
                                                    <tr>
                                                        <th rowspan="2" class="border-gray-700 align-middle">NO</th>
                                                        <th rowspan="2" class="border-gray-700 align-middle">KELURAHAN</th>

                                                        <th colspan="3" class="border-gray-700">JUMLAH</th>
                                                        <th colspan="4" class="border-gray-700">USIA</th>

                                                        <th colspan="{{ count($pendidikan) }}" class="border-gray-700">PENDIDIKAN TERAKHIR</th>
                                                        <th colspan="{{ count($pekerjaan) }}" class="border-gray-700">PEKERJAAN UTAMA</th>
                                                        <th colspan="{{ count($penghasilan) }}" class="border-gray-700">PENGHASILAN</th>
                                                        <th colspan="{{ count($pengeluaran) }}" class="border-gray-700">PENGELUARAN</th>

                                                        <th colspan="{{ count($statusTanah) }}" class="border-gray-700">STATUS TANAH</th>
                                                        <th colspan="{{ count($buktiTanah) }}" class="border-gray-700">BUKTI TANAH</th>
                                                        <th colspan="{{ count($statusRumah) }}" class="border-gray-700">STATUS RUMAH</th>

                                                        <th colspan="{{ count($statusImb) }}" class="border-gray-700">IMB</th>
                                                        <th colspan="{{ count($asetRumah) }}" class="border-gray-700">ASET RUMAH</th>
                                                        <th colspan="{{ count($asetTanah) }}" class="border-gray-700">ASET TANAH</th>

                                                        <th colspan="{{ count($bantuan) }}" class="border-gray-700">BANTUAN</th>
                                                        <th colspan="{{ count($kawasan) }}" class="border-gray-700">KAWASAN</th>
                                                    </tr>

                                                    {{-- ========================= --}}
                                                    {{--     Header Baris 2        --}}
                                                    {{-- ========================= --}}
                                                    <tr>

                                                        {{-- JUMLAH --}}
                                                        <th class="border-gray-700">Laki-laki</th>
                                                        <th class="border-gray-700">Perempuan</th>
                                                        <th class="border-gray-700">ABK</th>

                                                        {{-- USIA --}}
                                                        <th class="border-gray-700">5–11</th>
                                                        <th class="border-gray-700">12–25</th>
                                                        <th class="border-gray-700">26–45</th>
                                                        <th class="border-gray-700">46–65</th>

                                                        {{-- PENDIDIKAN --}}
                                                        @foreach ($pendidikan as $item)
                                                            <th class="border-gray-700">{{ $item->pendidikan_terakhir }}</th>
                                                        @endforeach

                                                        {{-- PEKERJAAN --}}
                                                        @foreach ($pekerjaan as $item)
                                                            <th class="border-gray-700">{{ $item->pekerjaan_utama }}</th>
                                                        @endforeach

                                                        {{-- PENGHASILAN --}}
                                                        @foreach ($penghasilan as $item)
                                                            <th class="border-gray-700">{{ $item->besar_penghasilan }}</th>
                                                        @endforeach

                                                        {{-- PENGELUARAN --}}
                                                        @foreach ($pengeluaran as $item)
                                                            <th class="border-gray-700">{{ $item->besar_pengeluaran }}</th>
                                                        @endforeach

                                                        {{-- STATUS TANAH --}}
                                                        @foreach ($statusTanah as $item)
                                                            <th class="border-gray-700">{{ $item->status_kepemilikan_tanah }}</th>
                                                        @endforeach

                                                        {{-- BUKTI TANAH --}}
                                                        @foreach ($buktiTanah as $item)
                                                            <th class="border-gray-700">{{ $item->bukti_kepemilikan_tanah }}</th>
                                                        @endforeach

                                                        {{-- STATUS RUMAH --}}
                                                        @foreach ($statusRumah as $item)
                                                            <th class="border-gray-700">{{ $item->status_kepemilikan_rumah }}</th>
                                                        @endforeach

                                                        {{-- IMB --}}
                                                        @foreach ($statusImb as $item)
                                                            <th class="border-gray-700">{{ $item->status_imb }}</th>
                                                        @endforeach

                                                        {{-- ASET RUMAH --}}
                                                        @foreach ($asetRumah as $item)
                                                            <th class="border-gray-700">{{ $item->aset_rumah_tempat_lain }}</th>
                                                        @endforeach

                                                        {{-- ASET TANAH --}}
                                                        @foreach ($asetTanah as $item)
                                                            <th class="border-gray-700">{{ $item->aset_tanah_tempat_lain }}</th>
                                                        @endforeach

                                                        {{-- BANTUAN --}}
                                                        @foreach ($bantuan as $item)
                                                            <th class="border-gray-700">{{ $item->pernah_mendapatkan_bantuan }}</th>
                                                        @endforeach

                                                        {{-- KAWASAN --}}
                                                        @foreach ($kawasan as $item)
                                                            <th class="border-gray-700">{{ $item->jenis_kawasan_lokasi }}</th>
                                                        @endforeach

                                                    </tr>

                                                </thead>

                                                {{-- ========================= --}}
                                                {{--         BODY TABLE        --}}
                                                {{-- ========================= --}}
                                                <tbody class="text-gray-200">

                                                    @foreach ($rekap2 as $index => $row)
                                                        <tr>
                                                            <td class="text-center">{{ $index + 1 }}</td>
                                                            <td class="text-start">{{ $row->nama_kelurahan }}</td>

                                                            {{-- JUMLAH --}}
                                                            <td>{{ number_format($row->jumlah_laki ?? 0) }}</td>
                                                            <td>{{ number_format($row->jumlah_perempuan ?? 0) }}</td>
                                                            <td>{{ number_format($row->jumlah_abk ?? 0) }}</td>

                                                            {{-- USIA --}}
                                                            @for ($i = 1; $i <= 4; $i++)
                                                                <td>{{ number_format($row->{'usia_'.$i} ?? 0) }}</td>
                                                            @endfor

                                                            {{-- PENDIDIKAN --}}
                                                            @foreach ($pendidikan as $i => $item)
                                                                <td>{{ number_format($row->{'pt_'.($i+1)} ?? 0) }}</td>
                                                            @endforeach

                                                            {{-- PEKERJAAN --}}
                                                            @foreach ($pekerjaan as $i => $item)
                                                                <td>{{ number_format($row->{'pu_'.($i+1)} ?? 0) }}</td>
                                                            @endforeach

                                                            {{-- PENGHASILAN --}}
                                                            @foreach ($penghasilan as $i => $item)
                                                                <td>{{ number_format($row->{'penghasilan_'.($i+1)} ?? 0) }}</td>
                                                            @endforeach

                                                            {{-- PENGELUARAN --}}
                                                            @foreach ($pengeluaran as $i => $item)
                                                                <td>{{ number_format($row->{'pengeluaran_'.($i+1)} ?? 0) }}</td>
                                                            @endforeach

                                                            {{-- STATUS TANAH --}}
                                                            @foreach ($statusTanah as $i => $item)
                                                                <td>{{ number_format($row->{'status_tanah_'.($i+1)} ?? 0) }}</td>
                                                            @endforeach

                                                            {{-- BUKTI TANAH --}}
                                                            @foreach ($buktiTanah as $i => $item)
                                                                <td>{{ number_format($row->{'bukti_tanah_'.($i+1)} ?? 0) }}</td>
                                                            @endforeach

                                                            {{-- STATUS RUMAH --}}
                                                            @foreach ($statusRumah as $i => $item)
                                                                <td>{{ number_format($row->{'status_rumah_'.($i+1)} ?? 0) }}</td>
                                                            @endforeach

                                                            {{-- IMB --}}
                                                            @foreach ($statusImb as $i => $item)
                                                                <td>{{ number_format($row->{'imb_'.($i+1)} ?? 0) }}</td>
                                                            @endforeach

                                                            {{-- ASET RUMAH --}}
                                                            @foreach ($asetRumah as $i => $item)
                                                                <td>{{ number_format($row->{'aset_rumah_'.($i+1)} ?? 0) }}</td>
                                                            @endforeach

                                                            {{-- ASET TANAH --}}
                                                            @foreach ($asetTanah as $i => $item)
                                                                <td>{{ number_format($row->{'aset_tanah_'.($i+1)} ?? 0) }}</td>
                                                            @endforeach

                                                            {{-- BANTUAN --}}
                                                            @foreach ($bantuan as $i => $item)
                                                                <td>{{ number_format($row->{'bantuan_'.($i+1)} ?? 0) }}</td>
                                                            @endforeach

                                                            {{-- KAWASAN --}}
                                                            @foreach ($kawasan as $i => $item)
                                                                <td>{{ number_format($row->{'kawasan_'.($i+1)} ?? 0) }}</td>
                                                            @endforeach

                                                        </tr>
                                                    @endforeach

                                                </tbody>

                                                {{-- ========================= --}}
                                                {{--         FOOTER            --}}
                                                {{-- ========================= --}}
                                                <tfoot class="bg-gray-800 text-white fw-bold">
                                                    <tr>
                                                        <td colspan="2" class="text-center">TOTAL</td>

                                                        @foreach($rekap2Sum as $col => $value)
                                                            <td>{{ number_format($value ?? 0) }}</td>
                                                        @endforeach
                                                    </tr>
                                                </tfoot>

                                            </table>

                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>

                        <div class="accordion" id="rekap3Accordion">
                            <div class="accordion-item border border-gray-700 rounded-3 overflow-hidden mb-5">

                                {{-- HEADER --}}
                                <h2 class="accordion-header" id="rekap3Heading">
                                    <button class="accordion-button fs-4"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#rekap3Body"
                                            aria-expanded="true"
                                            aria-controls="rekap3Body">
                                         Data Rekapitulasi #3 – <span class="ms-1">Aspek Keselamatan</span>
                                    </button>
                                </h2>

                                <div id="rekap3Body"
                                    class="accordion-collapse collapse show"
                                    aria-labelledby="rekap3Heading"
                                    data-bs-parent="#rekap3Accordion">

                                    <div class="accordion-body p-5 bg-dark border-top border-gray-700">

                                        <div class="table-responsive">
                                            <table class="rekap-table table table-bordered align-middle text-center gy-3 mb-0 border border-gray-700">

                                                {{-- ===================== --}}
                                                {{-- TABLE HEADER           --}}
                                                {{-- ===================== --}}
                                                <thead class="bg-gray-900 text-gray-200 border-bottom border-gray-700">

                                                    {{-- Title Bar --}}
                                                    <tr>
                                                        <th colspan="30" class="fs-6 fw-bold text-uppercase bg-gray-800 border-gray-700">
                                                            DATA REKAPITULASI #3 <br>
                                                            <small>Aspek Keselamatan</small>
                                                        </th>
                                                    </tr>

                                                    {{-- Row 1 --}}
                                                    <tr>
                                                        <th rowspan="2" class="border-gray-700">No</th>
                                                        <th rowspan="2" class="border-gray-700">Kelurahan</th>

                                                        <th colspan="2" class="border-gray-700">Pondasi</th>
                                                        <th colspan="5" class="border-gray-700">Kondisi Pondasi</th>
                                                        <th colspan="5" class="border-gray-700">Kondisi Sloof</th>
                                                        <th colspan="5" class="border-gray-700">Kondisi Kolom/Tiang</th>
                                                        <th colspan="5" class="border-gray-700">Kondisi Balok</th>
                                                        <th colspan="5" class="border-gray-700">Kondisi Struktur Atap</th>
                                                    </tr>

                                                    {{-- Row 2 --}}
                                                    <tr>
                                                        {{-- Pondasi --}}
                                                        @foreach($masterPondasi as $item)
                                                            <th class="border-gray-700">{{ $item->pondasi }}</th>
                                                        @endforeach

                                                        {{-- Kondisi Pondasi --}}
                                                        @foreach($masterKondisiPondasi as $item)
                                                            <th class="border-gray-700">{{ $item->kondisi_pondasi }}</th>
                                                        @endforeach

                                                        {{-- Sloof --}}
                                                        @foreach($masterSloof as $item)
                                                            <th class="border-gray-700">{{ $item->kondisi_sloof }}</th>
                                                        @endforeach

                                                        {{-- Kolom/Tiang --}}
                                                        @foreach($masterKolom as $item)
                                                            <th class="border-gray-700">{{ $item->kondisi_kolom_tiang }}</th>
                                                        @endforeach

                                                        {{-- Balok --}}
                                                        @foreach($masterBalok as $item)
                                                            <th class="border-gray-700">{{ $item->kondisi_balok }}</th>
                                                        @endforeach

                                                        {{-- Struktur Atap --}}
                                                        @foreach($masterAtap as $item)
                                                            <th class="border-gray-700">{{ $item->kondisi_struktur_atap }}</th>
                                                        @endforeach

                                                    </tr>

                                                </thead>

                                                {{-- ===================== --}}
                                                {{-- TABLE BODY             --}}
                                                {{-- ===================== --}}
                                                <tbody class="text-gray-200">
                                                    @foreach($rekap3 as $i => $row)
                                                        <tr>
                                                            <td class="border-gray-700">{{ $i+1 }}</td>
                                                            <td class="border-gray-700 text-start ps-2">{{ $row->nama_kelurahan }}</td>

                                                            {{-- PONDASI --}}
                                                            @foreach($masterPondasi as $item)
                                                                <td class="text-end border-gray-700">
                                                                    {{ number_format($row->{'p_'.$item->id_pondasi} ?? 0,0,',','.') }}
                                                                </td>
                                                            @endforeach

                                                            {{-- KONDISI PONDASI --}}
                                                            @foreach($masterKondisiPondasi as $item)
                                                                <td class="text-end border-gray-700">
                                                                    {{ number_format($row->{'kp_'.$item->id_kondisi_pondasi} ?? 0,0,',','.') }}
                                                                </td>
                                                            @endforeach

                                                            {{-- SLOOF --}}
                                                            @foreach($masterSloof as $item)
                                                                <td class="text-end border-gray-700">
                                                                    {{ number_format($row->{'ks_'.$item->id_kondisi_sloof} ?? 0,0,',','.') }}
                                                                </td>
                                                            @endforeach

                                                            {{-- KOLOM --}}
                                                            @foreach($masterKolom as $item)
                                                                <td class="text-end border-gray-700">
                                                                    {{ number_format($row->{'kk_'.$item->id_kondisi_kolom_tiang} ?? 0,0,',','.') }}
                                                                </td>
                                                            @endforeach

                                                            {{-- BALOK --}}
                                                            @foreach($masterBalok as $item)
                                                                <td class="text-end border-gray-700">
                                                                    {{ number_format($row->{'kb_'.$item->id_kondisi_balok} ?? 0,0,',','.') }}
                                                                </td>
                                                            @endforeach

                                                            {{-- STRUKTUR ATAP --}}
                                                            @foreach($masterAtap as $item)
                                                                <td class="text-end border-gray-700">
                                                                    {{ number_format($row->{'ksa_'.$item->id_kondisi_struktur_atap} ?? 0,0,',','.') }}
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                </tbody>

                                                {{-- ===================== --}}
                                                {{-- TABLE FOOTER          --}}
                                                {{-- ===================== --}}
                                                <tfoot class="bg-gray-800 text-white fw-bold">
                                                    <tr>
                                                        <td colspan="2" class="text-center">TOTAL</td>

                                                        @foreach($rekap3Sum as $col => $value)
                                                            <td>{{ number_format($value ?? 0) }}</td>
                                                        @endforeach
                                                    </tr>
                                                </tfoot>


                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                       <div class="accordion" id="rekap4Accordion">
                            <div class="accordion-item border border-gray-700 rounded-3 overflow-hidden mb-5">

                                <h2 class="accordion-header" id="rekap4Heading">
                                    <button class="accordion-button fs-4 "
                                        type="button" data-bs-toggle="collapse"
                                        data-bs-target="#rekap4Body" aria-expanded="true">
                                         Data Rekapitulasi #4 – Aspek Kesehatan
                                    </button>
                                </h2>

                                <div id="rekap4Body" class="accordion-collapse collapse show">
                                    <div class="accordion-body p-5 bg-dark border-top border-gray-700">

                                        <div class="table-responsive">
                                            <table class="rekap-table table table-bordered align-middle text-center border border-gray-700">

                                                <thead class="bg-gray-900 text-gray-200">

                                                    <!-- TITLE -->
                                                    <tr>
                                                        <th colspan="{{ 
                                                            2
                                                            + $masterJendela->count()
                                                            + $masterKondisiJendela->count()
                                                            + $masterVentilasi->count()
                                                            + $masterKondisiVentilasi->count()
                                                            + $masterKamarMandi->count()
                                                            + $masterKondisiKamarMandi->count()
                                                            + $masterJamban->count()
                                                            + $masterKondisiJamban->count()
                                                            + $masterSPAL->count()
                                                            + $masterKondisiSPAL->count()
                                                            + $masterFrekuensiSedot->count()
                                                            + $masterAirMinum->count()
                                                            + $masterKondisiAirMinum->count()
                                                            + $masterListrik->count()
                                                        }}" 
                                                            class="fs-6 fw-bold text-uppercase bg-gray-800">
                                                            DATA REKAPITULASI #4 <br>
                                                            <small>Aspek Kesehatan</small>
                                                        </th>
                                                    </tr>

                                                    <!-- HEADER KELOMPOK -->
                                                    <tr>
                                                        <th rowspan="2">No</th>
                                                        <th rowspan="2">Kelurahan</th>

                                                        <th colspan="{{ $masterJendela->count() }}">Jendela</th>
                                                        <th colspan="{{ $masterKondisiJendela->count() }}">Kondisi Jendela</th>
                                                        <th colspan="{{ $masterVentilasi->count() }}">Ventilasi</th>
                                                        <th colspan="{{ $masterKondisiVentilasi->count() }}">Kondisi Ventilasi</th>
                                                        <th colspan="{{ $masterKamarMandi->count() }}">Kamar Mandi</th>
                                                        <th colspan="{{ $masterKondisiKamarMandi->count() }}">Kondisi KM</th>
                                                        <th colspan="{{ $masterJamban->count() }}">Jamban</th>
                                                        <th colspan="{{ $masterKondisiJamban->count() }}">Kondisi Jamban</th>
                                                        <th colspan="{{ $masterSPAL->count() }}">SPAL</th>
                                                        <th colspan="{{ $masterKondisiSPAL->count() }}">Kondisi SPAL</th>
                                                        <th colspan="{{ $masterFrekuensiSedot->count() }}">Frekuensi Sedot</th>
                                                        <th colspan="{{ $masterAirMinum->count() }}">Air Minum</th>
                                                        <th colspan="{{ $masterKondisiAirMinum->count() }}">Kondisi Air</th>
                                                        <th colspan="{{ $masterListrik->count() }}">Listrik</th>
                                                    </tr>

                                                    <!-- SUBHEADER -->
                                                    <tr>
                                                        @foreach($masterJendela as $m)
                                                            <th>{{ $m->jendela_lubang_cahaya }}</th>
                                                        @endforeach

                                                        @foreach($masterKondisiJendela as $m)
                                                            <th>{{ $m->kondisi_jendela_lubang_cahaya }}</th>
                                                        @endforeach

                                                        @foreach($masterVentilasi as $m)
                                                            <th>{{ $m->ventilasi }}</th>
                                                        @endforeach

                                                        @foreach($masterKondisiVentilasi as $m)
                                                            <th>{{ $m->kondisi_ventilasi }}</th>
                                                        @endforeach

                                                        @foreach($masterKamarMandi as $m)
                                                            <th>{{ $m->kamar_mandi }}</th>
                                                        @endforeach

                                                        @foreach($masterKondisiKamarMandi as $m)
                                                            <th>{{ $m->kondisi_kamar_mandi }}</th>
                                                        @endforeach

                                                        @foreach($masterJamban as $m)
                                                            <th>{{ $m->jamban }}</th>
                                                        @endforeach

                                                        @foreach($masterKondisiJamban as $m)
                                                            <th>{{ $m->kondisi_jamban }}</th>
                                                        @endforeach

                                                        @foreach($masterSPAL as $m)
                                                            <th>{{ $m->sistem_pembuangan_air_kotor }}</th>
                                                        @endforeach

                                                        @foreach($masterKondisiSPAL as $m)
                                                            <th>{{ $m->kondisi_sistem_pembuangan_air_kotor }}</th>
                                                        @endforeach

                                                        @foreach($masterFrekuensiSedot as $m)
                                                            <th>{{ $m->frekuensi_penyedotan }}</th>
                                                        @endforeach

                                                        @foreach($masterAirMinum as $m)
                                                            <th>{{ $m->sumber_air_minum }}</th>
                                                        @endforeach

                                                        @foreach($masterKondisiAirMinum as $m)
                                                            <th>{{ $m->kondisi_sumber_air_minum }}</th>
                                                        @endforeach

                                                        @foreach($masterListrik as $m)
                                                            <th>{{ $m->sumber_listrik }}</th>
                                                        @endforeach
                                                    </tr>

                                                </thead>

                                                <tbody class="text-gray-200">

                                                    @foreach($rekap4 as $i => $row)
                                                        <tr>
                                                            <td>{{ $i+1 }}</td>
                                                            <td>{{ $row->nama_kelurahan }}</td>

                                                            @foreach($masterJendela as $m)
                                                                <td>{{ $row->{'a_'.$m->id_jendela_lubang_cahaya} ?? 0 }}</td>
                                                            @endforeach

                                                            @foreach($masterKondisiJendela as $m)
                                                                <td>{{ $row->{'b_'.$m->id_kondisi_jendela_lubang_cahaya} ?? 0 }}</td>
                                                            @endforeach

                                                            @foreach($masterVentilasi as $m)
                                                                <td>{{ $row->{'c_'.$m->id_ventilasi} ?? 0 }}</td>
                                                            @endforeach

                                                            @foreach($masterKondisiVentilasi as $m)
                                                                <td>{{ $row->{'d_'.$m->id_kondisi_ventilasi} ?? 0 }}</td>
                                                            @endforeach

                                                            @foreach($masterKamarMandi as $m)
                                                                <td>{{ $row->{'e_'.$m->id_kamar_mandi} ?? 0 }}</td>
                                                            @endforeach

                                                            @foreach($masterKondisiKamarMandi as $m)
                                                                <td>{{ $row->{'f_'.$m->id_kondisi_kamar_mandi} ?? 0 }}</td>
                                                            @endforeach

                                                            @foreach($masterJamban as $m)
                                                                <td>{{ $row->{'g_'.$m->id_jamban} ?? 0 }}</td>
                                                            @endforeach

                                                            @foreach($masterKondisiJamban as $m)
                                                                <td>{{ $row->{'h_'.$m->id_kondisi_jamban} ?? 0 }}</td>
                                                            @endforeach

                                                            @foreach($masterSPAL as $m)
                                                                <td>{{ $row->{'i_'.$m->id_sistem_pembuangan_air_kotor} ?? 0 }}</td>
                                                            @endforeach

                                                            @foreach($masterKondisiSPAL as $m)
                                                                <td>{{ $row->{'j_'.$m->id_kondisi_sistem_pembuangan_air_kotor} ?? 0 }}</td>
                                                            @endforeach

                                                            @foreach($masterFrekuensiSedot as $m)
                                                                <td>{{ $row->{'ia_'.$m->id_frekuensi_penyedotan} ?? 0 }}</td>
                                                            @endforeach

                                                            @foreach($masterAirMinum as $m)
                                                                <td>{{ $row->{'k_'.$m->id_sumber_air_minum} ?? 0 }}</td>
                                                            @endforeach

                                                            @foreach($masterKondisiAirMinum as $m)
                                                                <td>{{ $row->{'ka_'.$m->id_kondisi_sumber_air_minum} ?? 0 }}</td>
                                                            @endforeach

                                                            @foreach($masterListrik as $m)
                                                                <td>{{ $row->{'l_'.$m->id_sumber_listrik} ?? 0 }}</td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach

                                                </tbody>

                                                <tfoot class="bg-gray-800 text-white fw-bold">
                                                    <tr>
                                                        <td colspan="2" class="text-center">TOTAL</td>
                                                        @foreach($rekap4Sum as $v)
                                                            <td>{{ number_format($v) }}</td>
                                                        @endforeach
                                                    </tr>
                                                </tfoot>

                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="accordion" id="rekap5Accordion">
                            <div class="accordion-item border border-gray-700 rounded-3 overflow-hidden mb-5">

                                <h2 class="accordion-header" id="rekap5Heading">
                                    <button class="accordion-button fs-4"
                                        type="button" data-bs-toggle="collapse"
                                        data-bs-target="#rekap5Body" aria-expanded="true">
                                        Data Rekapitulasi #5 – Aspek Persyaratan Luas dan Kebutuhan Ruang
                                    </button>
                                </h2>

                                <div id="rekap5Body" class="accordion-collapse collapse show">

                                    <div class="accordion-body p-5 bg-dark border-top border-gray-700">

                                        <div class="table-responsive">
                                            <table class="rekap-table table table-bordered text-center align-middle border border-gray-700">

                                                <thead class="bg-gray-900 text-gray-200">

                                                    <!-- TITLE -->
                                                    <tr>
                                                        <th colspan="{{
                                                            2
                                                            + $masterRuangTidur->count()
                                                            + $masterJenisFisik->count()
                                                            + 3 /* C1-C3 */
                                                            + $masterFungsiRumah->count()
                                                            + $masterTipeRumah->count()
                                                            + $masterStatusDtks->count()
                                                        }}" class="fs-6 fw-bold text-uppercase bg-gray-800">
                                                            REKAPITULASI #5 <br>
                                                            <small>Fisik Bangunan & Kebutuhan Ruang</small>
                                                        </th>
                                                    </tr>

                                                    <!-- GROUP HEADER -->
                                                    <tr>
                                                        <th rowspan="2">No</th>
                                                        <th rowspan="2">Kelurahan</th>

                                                        <th colspan="{{ $masterRuangTidur->count() }}">Ruang Keluarga & Tidur</th>
                                                        <th colspan="{{ $masterJenisFisik->count() }}">Jenis Fisik Bangunan</th>
                                                        <th colspan="3">Jumlah Lantai</th>
                                                        <th colspan="{{ $masterFungsiRumah->count() }}">Fungsi Rumah</th>
                                                        <th colspan="{{ $masterTipeRumah->count() }}">Tipe Rumah</th>
                                                        <th colspan="{{ $masterStatusDtks->count() }}">Status DTKS</th>
                                                    </tr>

                                                    <!-- SUB HEADER -->
                                                    <tr>
                                                        {{-- A – Ruang Tidur --}}
                                                        @foreach ($masterRuangTidur as $m)
                                                            <th>{{ $m->ruang_keluarga_dan_tidur }}</th>
                                                        @endforeach

                                                        {{-- B – Jenis Fisik Bangunan --}}
                                                        @foreach ($masterJenisFisik as $m)
                                                            <th>{{ $m->jenis_fisik_bangunan }}</th>
                                                        @endforeach

                                                        {{-- C – Jumlah Lantai --}}
                                                        <th>1 Lantai</th>
                                                        <th>2 Lantai</th>
                                                        <th>≥3 Lantai</th>

                                                        {{-- D – Fungsi Rumah --}}
                                                        @foreach ($masterFungsiRumah as $m)
                                                            <th>{{ $m->fungsi_rumah }}</th>
                                                        @endforeach

                                                        {{-- E – Tipe Rumah --}}
                                                        @foreach ($masterTipeRumah as $m)
                                                            <th>{{ $m->tipe_rumah }}</th>
                                                        @endforeach

                                                        {{-- F – Status DTKS --}}
                                                        @foreach ($masterStatusDtks as $m)
                                                            <th>{{ $m->status_dtks }}</th>
                                                        @endforeach
                                                    </tr>

                                                </thead>

                                                <tbody class="text-gray-200">

                                                    @foreach ($rekap5 as $i => $r)
                                                        <tr>
                                                            <td>{{ $i + 1 }}</td>
                                                            <td class="text-start ps-3">{{ $r->nama_kelurahan }}</td>

                                                            {{-- A – Ruang Keluarga & Tidur --}}
                                                            @foreach($masterRuangTidur as $m)
                                                                <td>{{ number_format($r->{'a_'.$m->id_ruang_keluarga_dan_tidur} ?? 0) }}</td>
                                                            @endforeach

                                                            {{-- B – Jenis Fisik Bangunan --}}
                                                            @foreach($masterJenisFisik as $m)
                                                                <td>{{ number_format($r->{'b_'.$m->id_jenis_fisik_bangunan} ?? 0) }}</td>
                                                            @endforeach

                                                            {{-- C – Jumlah Lantai --}}
                                                            <td>{{ number_format($r->c_1 ?? 0) }}</td>
                                                            <td>{{ number_format($r->c_2 ?? 0) }}</td>
                                                            <td>{{ number_format($r->c_3 ?? 0) }}</td>

                                                            {{-- D – Fungsi Rumah --}}
                                                            @foreach($masterFungsiRumah as $m)
                                                                <td>{{ number_format($r->{'d_'.$m->id_fungsi_rumah} ?? 0) }}</td>
                                                            @endforeach

                                                            {{-- E – Tipe Rumah --}}
                                                            @foreach($masterTipeRumah as $m)
                                                                <td>{{ number_format($r->{'e_'.$m->id_tipe_rumah} ?? 0) }}</td>
                                                            @endforeach

                                                            {{-- F – Status DTKS --}}
                                                            @foreach($masterStatusDtks as $m)
                                                                <td>{{ number_format($r->{'f_'.$m->id_status_dtks} ?? 0) }}</td>
                                                            @endforeach

                                                        </tr>
                                                    @endforeach

                                                </tbody>

                                                <!-- FOOTER TOTAL -->
                                                <tfoot class="bg-gray-800 text-white fw-bold">
                                                    <tr>
                                                        <td colspan="2" class="text-center">TOTAL</td>

                                                        @foreach ($rekap5Sum as $value)
                                                            <td>{{ number_format($value ?? 0) }}</td>
                                                        @endforeach
                                                    </tr>
                                                </tfoot>

                                            </table>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>


                       <div class="accordion" id="rekap6Accordion">
                            <div class="accordion-item border border-gray-700 rounded-3 overflow-hidden mb-5">

                                <h2 class="accordion-header" id="rekap6Heading">
                                    <button class="accordion-button fs-4"
                                        type="button" data-bs-toggle="collapse"
                                        data-bs-target="#rekap6Body" aria-expanded="true">
                                        Data Rekapitulasi #6 – Aspek Komponen Bahan Bangunan
                                    </button>
                                </h2>

                                <div id="rekap6Body" class="accordion-collapse collapse show">

                                    <div class="accordion-body p-5 bg-dark border-top border-gray-700">

                                        <div class="table-responsive">
                                            <table class="rekap-table table table-bordered text-center align-middle border border-gray-700">

                                                {{-- ================= TITLE ================= --}}
                                                <thead class="bg-gray-900 text-gray-200">

                                                    <tr>
                                                        <th colspan="{{
                                                            2
                                                            + $materialAtap->count()
                                                            + $masterKondisiAtap->count()
                                                            + $masterDinding->count()
                                                            + $masterKondisiDinding->count()
                                                            + $masterLantai->count()
                                                            + $masterKondisiLantai->count()
                                                            + $masterAksesJalan->count()
                                                            + $masterMenghadapJalan->count()
                                                            + $masterMenghadapSungai->count()
                                                            + $masterBeradaLimbah->count()
                                                            + $masterBeradaSungai->count()
                                                        }}" class="fs-6 fw-bold text-uppercase bg-gray-800">
                                                            REKAPITULASI #6 <br>
                                                            <small>Komponen Material & Kondisi Bangunan</small>
                                                        </th>
                                                    </tr>

                                                    {{-- ================= GROUP HEADER ================= --}}
                                                    <tr>
                                                        <th rowspan="2">No</th>
                                                        <th rowspan="2">Kelurahan</th>

                                                        <th colspan="{{ $materialAtap->count() }}">A. Material Atap Terluas</th>
                                                        <th colspan="{{ $masterKondisiAtap->count() }}">B. Kondisi Penutup Atap</th>

                                                        <th colspan="{{ $masterDinding->count() }}">C. Material Dinding</th>
                                                        <th colspan="{{ $masterKondisiDinding->count() }}">D. Kondisi Dinding</th>

                                                        <th colspan="{{ $masterLantai->count() }}">E. Material Lantai</th>
                                                        <th colspan="{{ $masterKondisiLantai->count() }}">F. Kondisi Lantai</th>

                                                        <th colspan="{{ $masterAksesJalan->count() }}">G. Akses Jalan</th>
                                                        <th colspan="{{ $masterMenghadapJalan->count() }}">H. Menghadap Jalan</th>
                                                        <th colspan="{{ $masterMenghadapSungai->count() }}">I. Menghadap Sungai</th>
                                                        <th colspan="{{ $masterBeradaLimbah->count() }}">J. Berada Limbah</th>
                                                        <th colspan="{{ $masterBeradaSungai->count() }}">K. Berada Sungai</th>
                                                    </tr>

                                                    {{-- ================= SUB HEADER ================= --}}
                                                    <tr >

                                                        {{-- A --}}
                                                        @foreach ($materialAtap as $m)
                                                            <th>{{ $m->material_atap_terluas }}</th>
                                                        @endforeach

                                                        {{-- B --}}
                                                        @foreach ($masterKondisiAtap as $m)
                                                            <th>{{ $m->kondisi_penutup_atap }}</th>
                                                        @endforeach

                                                        {{-- C --}}
                                                        @foreach ($masterDinding as $m)
                                                            <th>{{ $m->material_dinding_terluas }}</th>
                                                        @endforeach

                                                        {{-- D --}}
                                                        @foreach ($masterKondisiDinding as $m)
                                                            <th>{{ $m->kondisi_dinding }}</th>
                                                        @endforeach

                                                        {{-- E --}}
                                                        @foreach ($masterLantai as $m)
                                                            <th>{{ $m->material_lantai_terluas }}</th>
                                                        @endforeach

                                                        {{-- F --}}
                                                        @foreach ($masterKondisiLantai as $m)
                                                            <th>{{ $m->kondisi_lantai }}</th>
                                                        @endforeach

                                                        {{-- G --}}
                                                        @foreach ($masterAksesJalan as $m)
                                                            <th>{{ $m->akses_ke_jalan }}</th>
                                                        @endforeach

                                                        {{-- H --}}
                                                        @foreach ($masterMenghadapJalan as $m)
                                                            <th>{{ $m->bangunan_menghadap_jalan }}</th>
                                                        @endforeach

                                                        {{-- I --}}
                                                        @foreach ($masterMenghadapSungai as $m)
                                                            <th>{{ $m->bangunan_menghadap_sungai }}</th>
                                                        @endforeach

                                                        {{-- J --}}
                                                        @foreach ($masterBeradaLimbah as $m)
                                                            <th>{{ $m->bangunan_berada_limbah }}</th>
                                                        @endforeach

                                                        {{-- K --}}
                                                        @foreach ($masterBeradaSungai as $m)
                                                            <th>{{ $m->bangunan_berada_sungai }}</th>
                                                        @endforeach

                                                    </tr>

                                                </thead>


                                                {{-- ================= TBODY ================= --}}
                                                <tbody class="text-gray-200">
                                                    @foreach($rekap6 as $i => $r)
                                                        <tr>
                                                            <td>{{ $i + 1 }}</td>
                                                            <td class="text-start ps-3">{{ $r->nama_kelurahan }}</td>

                                                            {{-- A --}}
                                                            @foreach ($materialAtap as $m)
                                                                <td>{{ number_format($r->{'a_'.$m->id_material_atap_terluas} ?? 0) }}</td>
                                                            @endforeach

                                                            {{-- B --}}
                                                            @foreach ($masterKondisiAtap as $m)
                                                                <td>{{ number_format($r->{'b_'.$m->id_kondisi_penutup_atap} ?? 0) }}</td>
                                                            @endforeach

                                                            {{-- C --}}
                                                            @foreach ($masterDinding as $m)
                                                                <td>{{ number_format($r->{'c_'.$m->id_material_dinding_terluas} ?? 0) }}</td>
                                                            @endforeach

                                                            {{-- D --}}
                                                            @foreach ($masterKondisiDinding as $m)
                                                                <td>{{ number_format($r->{'d_'.$m->id_kondisi_dinding} ?? 0) }}</td>
                                                            @endforeach

                                                            {{-- E --}}
                                                            @foreach ($masterLantai as $m)
                                                                <td>{{ number_format($r->{'e_'.$m->id_material_lantai_terluas} ?? 0) }}</td>
                                                            @endforeach

                                                            {{-- F --}}
                                                            @foreach ($masterKondisiLantai as $m)
                                                                <td>{{ number_format($r->{'f_'.$m->id_kondisi_lantai} ?? 0) }}</td>
                                                            @endforeach

                                                            {{-- G --}}
                                                            @foreach ($masterAksesJalan as $m)
                                                                <td>{{ number_format($r->{'g_'.$m->id_akses_ke_jalan} ?? 0) }}</td>
                                                            @endforeach

                                                            {{-- H --}}
                                                            @foreach ($masterMenghadapJalan as $m)
                                                                <td>{{ number_format($r->{'h_'.$m->id_bangunan_menghadap_jalan} ?? 0) }}</td>
                                                            @endforeach

                                                            {{-- I --}}
                                                            @foreach ($masterMenghadapSungai as $m)
                                                                <td>{{ number_format($r->{'i_'.$m->id_bangunan_menghadap_sungai} ?? 0) }}</td>
                                                            @endforeach

                                                            {{-- J --}}
                                                            @foreach ($masterBeradaLimbah as $m)
                                                                <td>{{ number_format($r->{'j_'.$m->id_bangunan_berada_limbah} ?? 0) }}</td>
                                                            @endforeach

                                                            {{-- K --}}
                                                            @foreach ($masterBeradaSungai as $m)
                                                                <td>{{ number_format($r->{'k_'.$m->id_bangunan_berada_sungai} ?? 0) }}</td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                </tbody>


                                                {{-- ================= FOOTER ================= --}}
                                                <tfoot class="bg-gray-800 text-white fw-bold">
                                                    <tr>
                                                        <td colspan="2" class="text-center">TOTAL</td>

                                                        @foreach($rekap6Sum as $sum)
                                                            <td>{{ number_format($sum ?? 0) }}</td>
                                                        @endforeach
                                                    </tr>
                                                </tfoot>

                                            </table>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>










                    </div>
                </div>
                <!--end::Card-->

            </div>
        </div>
        <!--end::Content-->

    </div>
</div>

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function () {
    window.addEventListener('swal:error', function (event) {
        console.log('🔥 swal:error diterima', event.detail);

        Swal.fire({
            icon: 'warning',
            title: event.detail[0].title,
            text: event.detail[0].text,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK',
        });

        // 🔹 Ambil elemen modal
        const modalEl = document.getElementById('kt_modal_export_users');

        // 🔹 Hapus backdrop lama & dispose instance modal agar bersih
        const oldBackdrops = document.querySelectorAll('.modal-backdrop');
        oldBackdrops.forEach(el => el.remove());

        const oldModal = bootstrap.Modal.getInstance(modalEl);
        if (oldModal) oldModal.dispose();

        // 🔹 Buka ulang modal tanpa duplikasi backdrop
        const modal = new bootstrap.Modal(modalEl);
        modal.show();
    });
});
</script>
<script>
document.addEventListener('livewire:navigated', initSelect2);
document.addEventListener('livewire:load', initSelect2);

function initSelect2() {
    console.log("✅ Init Select2 triggered");

    $('[data-control="select2"]').each(function() {
        const el = $(this);
       
        // Saat value diubah, kirim ke Livewire
        el.on('change', function () {
            const value = $(this).val();
            const name = el.data('name');
           // alert(value)
             const componentId = el.closest('[wire\\:id]').attr('wire:id');

    if (componentId) {
        const component = Livewire.find(componentId);
        if (component) {
            console.log('✅ Dispatch ke komponen:', component.name);
            component.$set('format', value);
            console.log('📦 format di-set:', value);

        }
    } else {
        console.warn('⚠️ Tidak menemukan komponen Livewire untuk select2');
    }
        });
    });
}
</script>
<script>
document.addEventListener('livewire:navigated', function () {

    Livewire.on('startDownload', url => {
        console.log("⬇️ Mulai download:", url);

        // Tampilkan loading
        const btn = document.querySelector('#kt_modal_export_users_form button[type="submit"]');
        btn.classList.add('loading');
        
        // Trigger download
        window.open(url, '_blank');

        // Setelah download mulai, reset loading
        setTimeout(() => {
            btn.classList.remove('loading');
        }, 3000);
    });

});
</script>

@endpush