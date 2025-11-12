<div x-data x-init="window.livewireComponentId = $el.getAttribute('wire:id')" wire:key="rekap-tabel" class="d-flex flex-column flex-fill">
    <div class="d-flex flex-column flex-column-fluid">

        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex fw-bold fs-3 flex-column justify-content-center my-0 text-white">
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
                            📊 Rekapitulasi Data Rumah
                        </h3>
                    </div>

                    <div class="card-body">

                        <!--begin::Accordion-->
                        <div class="accordion" id="rekapAccordion">
                            <div class="accordion-item  border border-gray-700 rounded-3 overflow-hidden mb-5">
                                <h2 class="accordion-header" id="rekap1Heading">
                                    <button class="accordion-button fs-4 fw-bold bg-gray-900 " type="button"
                                            data-bs-toggle="collapse" data-bs-target="#rekap1Body"
                                            aria-expanded="true" aria-controls="rekap1Body">
                                        📋 Data Rekapitulasi #1 – <span class="ms-1">Data Umum Rumah (Kecamatan {{ $kecamatanNama }})</span>
                                    </button>
                                </h2>
                                <div id="rekap1Body" class="accordion-collapse collapse show"
                                     aria-labelledby="rekap1Heading" data-bs-parent="#rekapAccordion">
                                    <div class="accordion-body p-5 bg-dark border-top border-gray-700">

                                        <!--begin::Table-->
                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle text-center gy-3 mb-0 border border-gray-700">
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

                    </div>
                </div>
                <!--end::Card-->

            </div>
        </div>
        <!--end::Content-->

    </div>
</div>
