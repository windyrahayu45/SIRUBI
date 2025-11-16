<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <!--begin::Toolbar container-->
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <!--begin::Title-->
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Dashboard</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="#" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">Dashboards</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->
            
            <!--end::Actions-->
        </div>
        <!--end::Toolbar container-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Row-->

            <div class="row gy-5 g-xl-10">
                <!--begin::Col-->
                <div class="col-xl-12 mb-xl-10">
                    <!--begin::Chart widget 10-->
                    <div class="card card-flush h-xxl-100">
                        <!--begin::Header-->
                        <div class="card-header pt-7">
                            <!--begin::Title-->
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">Data Rekapitulasi</span>
                                
                            </h3>
                            <!--end::Title-->
                           
                           
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body d-flex flex-column justify-content-between pb-5 px-0">
                            <!--begin::Nav-->
                            <ul class="nav nav-pills nav-pills-custom mb-3 mx-9">
                                <!--begin::Item-->
                                <li class="nav-item mb-3 me-3 me-lg-6">
                                    <!--begin::Link-->
                                     <button wire:click="changeTab('rumah')" class="nav-link btn btn-outline btn-flex btn-active-color-primary flex-column overflow-hidden w-80px h-85px pt-5 pb-2 {{ $tab == 'rumah' ? 'active' : '' }}" data-bs-toggle="pill" id="kt_charts_widget_10_tab_1" href="#kt_charts_widget_10_tab_content_1">
                                        <!--begin::Icon-->
                                        <div class="nav-icon mb-3">
                                           <i class="fonticon-house fs-1 p-0 text-primary"></i>
                                        </div>
                                        <!--end::Icon-->
                                        <!--begin::Title-->
                                        <span class="nav-text text-gray-800 fw-bold fs-6 lh-1">Rumah</span>
                                        <!--end::Title-->
                                        <!--begin::Bullet-->
                                        <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                        <!--end::Bullet-->
                                    </button>
                                    <!--end::Link-->
                                </li>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <li class="nav-item mb-3 me-3 me-lg-6">
                                    <!--begin::Link-->
                                       <button wire:click="changeTab('penduduk')"class="nav-link btn btn-outline btn-flex btn-active-color-primary flex-column overflow-hidden w-80px h-85px pt-5 pb-2 {{ $tab == 'penduduk' ? 'active' : '' }}" data-bs-toggle="pill" id="kt_charts_widget_10_tab_2" href="#kt_charts_widget_10_tab_content_2">
                                        <!--begin::Icon-->
                                        <div class="nav-icon mb-3">
                                          <i class="fonticon-user fs-1 p-0 text-primary"></i>

                                        </div>
                                        <!--end::Icon-->
                                        <!--begin::Title-->
                                        <span class="nav-text text-gray-800 fw-bold fs-6 lh-1">Penduduk</span>
                                        <!--end::Title-->
                                        <!--begin::Bullet-->
                                        <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                        <!--end::Bullet-->
                                    </button>
                                    <!--end::Link-->
                                </li>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <li class="nav-item mb-3 me-3 me-lg-6">
                                    <!--begin::Link-->
                                    <button wire:click="changeTab('kawasan')" class="nav-link btn btn-outline btn-flex btn-active-color-primary flex-column overflow-hidden w-80px h-85px pt-5 pb-2 {{ $tab == 'kawasan' ? 'active' : '' }}" data-bs-toggle="pill" id="kt_charts_widget_10_tab_3" href="#kt_charts_widget_10_tab_content_3">
                                        <!--begin::Icon-->
                                        <div class="nav-icon mb-3">
                                         <i class="fonticon-layers fs-1 p-0  text-primary"></i>
                                        </div>
                                        <!--end::Icon-->
                                        <!--begin::Title-->
                                        <span class="nav-text text-gray-800 fw-bold fs-6 lh-1">Kawasan</span>
                                        <!--end::Title-->
                                        <!--begin::Bullet-->
                                        <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                        <!--end::Bullet-->
                                    </button>
                                    <!--end::Link-->
                                </li>
                                <!--end::Item-->
                                <!--begin::Item-->
                               
                                <!--end::Item-->
                            </ul>
                            <!--end::Nav-->
                            <!--begin::Tab Content-->
                            <div class="px-9">
                                 <div id="rekap_chart" style="height: 300px;"></div>
                            </div>

                            <!--end::Tab Content-->
                        </div>
                        <!--end: Card Body-->
                    </div>
                    <!--end::Chart widget 10-->
                </div>
                <!--end::Col-->
            </div>
           

            <div class="row g-5 g-xl-10">

                <!-- 1️⃣ TOTAL RUMAH -->
                <div class="col-xl-3 mb-xl-10">
                    <div class="card h-lg-100">
                        <div class="card-body d-flex justify-content-between align-items-start flex-column">
                            
                            <!-- ICON -->
                            <div class="m-0">
                                <span class="svg-icon svg-icon-2hx svg-icon-gray-600">
                                    <i class="ki-duotone ki-home fs-1"></i>
                                </span>
                            </div>

                            <!-- NUMBER + LABEL -->
                            <div class="d-flex flex-column my-7">
                                <span class="fw-semibold fs-3x text-gray-800 lh-1 ls-n2">
                                    {{ number_format($stat['total_rumah']) }}
                                </span>
                                <div class="m-0">
                                    <span class="fw-semibold fs-6 text-gray-400">Total Rumah</span>
                                </div>
                            </div>

                            <!-- BADGE -->
                            <span class="badge badge-light-primary fs-base">Update</span>

                        </div>
                    </div>
                </div>

                <!-- 2️⃣ TOTAL RTLH -->
                <div class="col-xl-3 mb-xl-10">
                    <div class="card h-lg-100">
                        <div class="card-body d-flex justify-content-between align-items-start flex-column">

                            <div class="m-0">
                                <span class="svg-icon svg-icon-2hx svg-icon-danger">
                                    <i class="ki-duotone ki-element-11 fs-1"></i>
                                </span>
                            </div>

                            <div class="d-flex flex-column my-7">
                                <span class="fw-semibold fs-3x text-danger lh-1 ls-n2">
                                    {{ number_format($stat['total_rtlh']) }}
                                </span>
                                <div class="m-0">
                                    <span class="fw-semibold fs-6 text-gray-400">Rumah Tidak Layak Huni</span>
                                </div>
                            </div>

                            <span class="badge badge-light-danger fs-base">RTLH</span>

                        </div>
                    </div>
                </div>

                <!-- 3️⃣ TOTAL PENDUDUK -->
                <div class="col-xl-3 mb-xl-10">
                    <div class="card h-lg-100">
                        <div class="card-body d-flex justify-content-between align-items-start flex-column">

                            <div class="m-0">
                                <span class="svg-icon svg-icon-2hx svg-icon-primary">
                                    <i class="ki-duotone ki-user fs-1"></i>
                                </span>
                            </div>

                            <div class="d-flex flex-column my-7">
                                <span class="fw-semibold fs-3x text-primary lh-1 ls-n2">
                                    {{ number_format($stat['total_penduduk']) }}
                                </span>
                                <div class="m-0">
                                    <span class="fw-semibold fs-6 text-gray-400">Total Penduduk</span>
                                </div>
                            </div>

                            <span class="badge badge-light-info fs-base">Penduduk</span>

                        </div>
                    </div>
                </div>

                <!-- 4️⃣ TOTAL DTKS -->
                <div class="col-xl-3 mb-xl-10">
                    <div class="card h-lg-100">
                        <div class="card-body d-flex justify-content-between align-items-start flex-column">

                            <div class="m-0">
                                <span class="svg-icon svg-icon-2hx svg-icon-success">
                                    <i class="ki-duotone ki-briefcase fs-1"></i>
                                </span>
                            </div>

                            <div class="d-flex flex-column my-7">
                                <span class="fw-semibold fs-3x text-success lh-1 ls-n2">
                                    {{ number_format($stat['total_dtks']) }}
                                </span>
                                <div class="m-0">
                                    <span class="fw-semibold fs-6 text-gray-400">Penduduk DTKS</span>
                                </div>
                            </div>

                            <span class="badge badge-light-success fs-base">DTKS</span>

                        </div>
                    </div>
                </div>

            </div>


            <div class="row g-5 g-xl-8 mt-5">

                <!-- PIE 1: STATUS IMB -->
                <div class="col-xl-6  mb-xl-10">
                    <div class="card h-lg-100">
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title">
                                <span class="card-label fw-bold text-gray-800">Status IMB</span>
                            </h3>
                        </div>
                        <div class="card-body">
                            <div id="pie_imb_chart" style="height: 350px;" wire:ignore></div>
                        </div>
                    </div>
                </div>

                <!-- PIE 2: STATUS DTKS -->
                <div class="col-xl-6  mb-xl-10">
                    <div class="card h-lg-100">
                        <div class="card-header border-0 pt-5">
                            <h3 class="card-title">
                                <span class="card-label fw-bold text-gray-800">Status DTKS</span>
                            </h3>
                        </div>
                        <div class="card-body">
                            <div id="pie_dtks_chart" style="height: 350px;"  wire:ignore></div>
                        </div>
                    </div>
                </div>

            </div>

            
            <div class="row g-5 g-xl-8 mt-5">

                <div class="col-xxl-6 mb-xxl-10">
                    <div class="card card-flush h-md-100">

                        <!-- HEADER -->
                        <div class="card-header py-7">
                            <div class="m-0">

                                <!-- Heading -->
                                <div class="d-flex align-items-center mb-2">
                                    <span class="card-label fw-bold text-dark" style="font-size :18px">
                                        Top RTLH
                                    </span>
                                    <span class="badge badge-light-primary fs-base">
                                        10 Kelurahan
                                    </span>
                                </div>

                                <span class="fs-6 fw-semibold text-gray-400">
                                    Kelurahan dengan jumlah RTLH terbanyak
                                </span>
                            </div>

                        
                        </div>

                        <!-- BODY -->
                        <div class="card-body pt-0">

                            <div class="mb-0">

                                @foreach ($topKelurahan as $i => $row)

                                <!-- Item -->
                                <div class="d-flex flex-stack">

                                    <!-- LEFT -->
                                    <div class="d-flex align-items-center me-5">

                                        <div class="symbol symbol-30px me-5">
                                            <span class="symbol-label">
                                                <span class="svg-icon svg-icon-3 svg-icon-gray-600">
                                                    <!-- Location Icon -->
                                                    <svg width="24" height="24" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3"
                                                            d="M12 2C7.03 2 3 6.03 3 11c0 5.25 7.5 11 9 11s9-5.75 9-11c0-4.97-4.03-9-9-9z"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M12 6a4 4 0 100 8 4 4 0 000-8z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                            </span>
                                        </div>

                                        <div class="me-5">
                                            <a class="text-gray-800 fw-bold text-hover-primary fs-6">
                                                {{ $row['nama_kelurahan'] }}
                                            </a>

                                            <span class="text-gray-400 fw-semibold fs-7 d-block">
                                                Ranking #{{ $i + 1 }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- RIGHT -->
                                    <div class="d-flex align-items-center">

                                        <span class="text-gray-800 fw-bold fs-6 me-3">
                                            {{ number_format($row['jumlah']) }}
                                        </span>

                                        <div class="d-flex flex-center">

                                            @php
                                                $isUp = $row['persen'] > 5;
                                                $badge = $isUp ? 'badge-light-success' : 'badge-light-danger';
                                                $arrow = $isUp ? 'arr066' : 'arr065';
                                            @endphp

                                            <span class="badge {{ $badge }} fs-base">

                                                <span class="svg-icon svg-icon-5 ms-n1">
                                                    @if($isUp)
                                                    <!-- Up Arrow -->
                                                    <svg width="24" height="24" viewBox="0 0 24 24"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect opacity="0.5" x="13" y="6" width="13" height="2"
                                                            rx="1" transform="rotate(90 13 6)" fill="currentColor"></rect>
                                                        <path
                                                            d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z"
                                                            fill="currentColor"></path>
                                                    </svg>
                                                    @else
                                                    <!-- Down Arrow -->
                                                    <svg width="24" height="24" viewBox="0 0 24 24"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect opacity="0.5" x="11" y="18" width="13" height="2"
                                                            rx="1" transform="rotate(-90 11 18)" fill="currentColor"></rect>
                                                        <path
                                                            d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z"
                                                            fill="currentColor"></path>
                                                    </svg>
                                                    @endif
                                                </span>

                                                {{ $row['persen'] }}%
                                            </span>
                                        </div>
                                    </div>

                                </div>

                                <!-- Separator -->
                                @if(!$loop->last)
                                <div class="separator separator-dashed my-3"></div>
                                @endif

                                @endforeach

                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-xxl-6 mb-xxl-10">
                    <div class="card card-flush h-md-100">

                        <!-- HEADER -->
                        <div class="card-header py-7">
                            <div class="m-0">

                                <!-- Heading -->
                                <div class="d-flex align-items-center mb-2">
                                    <span class="card-label fw-bold text-dark" style="font-size:18px;">
                                        Top Kelurahan — Bantuan Sosial
                                    </span>

                                    <span class="badge badge-light-primary fs-base ms-2">
                                        {{ count($bantuanList) }} Kelurahan
                                    </span>
                                </div>

                                <span class="fs-6 fw-semibold text-gray-400">
                                    Kelurahan dengan jumlah penerima bantuan terbanyak
                                </span>
                            </div>
                        </div>

                        <!-- BODY -->
                        <div class="card-body pt-0">
                            <div class="mb-0">

                                @foreach ($bantuanList as $i => $row)

                                <!-- Item -->
                                <div class="d-flex flex-stack">

                                    <!-- LEFT -->
                                    <div class="d-flex align-items-center me-5">

                                        <div class="symbol symbol-30px me-5">
                                            <span class="symbol-label">
                                                <span class="svg-icon svg-icon-3 svg-icon-gray-600">
                                                    <svg width="24" height="24" viewBox="0 0 24 24">
                                                        <path opacity="0.3"
                                                            d="M12 2C7.03 2 3 6.03 3 11c0 5.25 7.5 11 9 11s9-5.75 9-11c0-4.97-4.03-9-9-9z"
                                                            fill="currentColor"/>
                                                        <path d="M12 6a4 4 0 100 8 4 4 0 000-8z"
                                                            fill="currentColor"/>
                                                    </svg>
                                                </span>
                                            </span>
                                        </div>

                                        <div class="me-5">
                                            <div class="text-gray-800 fw-bold fs-6">
                                                {{ $row['nama_kelurahan'] }}
                                            </div>

                                            <span class="text-gray-400 fw-semibold fs-7">
                                                Ranking #{{ $i + 1 }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- RIGHT -->
                                    <div class="d-flex align-items-center">

                                        <span class="text-gray-800 fw-bold fs-6 me-3">
                                            {{ number_format($row['jumlah']) }}
                                        </span>

                                        {{-- <span class="badge badge-light-info fs-base">
                                            Bantuan
                                        </span> --}}
                                    </div>
                                </div>

                                @if(!$loop->last)
                                <div class="separator separator-dashed my-3"></div>
                                @endif

                                @endforeach

                            </div>
                        </div>

                    </div>
                </div>



            </div>



            <!--end::Row-->
          
        
            
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</div>

@push('js')
<script>
let chart = null;

function renderChart(data) {

    let el = document.querySelector("#rekap_chart");
    if (!el) {
        return setTimeout(() => renderChart(data), 200);
    }

    let height = el.offsetHeight || 300;

    if (height < 50) {
        return setTimeout(() => renderChart(data), 200);
    }

    if (chart) chart.destroy();

    let s = getComputedStyle(document.documentElement);

    let gray500     = s.getPropertyValue('--kt-gray-500');
    let borderColor = s.getPropertyValue('--kt-border-dashed-color');

    // ⭐ Clean Data
    let cleanLabels = (data.labels || []).flat().filter(i => i != null);
    let cleanSeries = (data.series || []).flat().filter(i => typeof i === "number");

    let metronicBlue = "#00A3FF";  // ⭐ warna bar utama (persis seperti di screenshot)

    let options = {
        series: [{
            name: 'Total',
            data: cleanSeries
        }],

        chart: {
            type: 'bar',
            height: height,
            fontFamily: "inherit",
            toolbar: { show: false },
            animations: {
                enabled: true,
                easing: "easeinout",
                speed: 800
            }
        },

        plotOptions: {
            bar: {
                horizontal: false,
                columnWidth: "28%",
                borderRadius: 8,
                endingShape: "rounded",
                dataLabels: {
                    position: 'top'        // ⭐ posisi angka di atas bar
                }
            }
        },

        // ⭐ MENAMPILKAN ANGKA DI ATAS BAR
        dataLabels: {
            enabled: true,
            offsetY: -22,
           style: {
                fontSize: "15px",
                fontWeight: "600",
                colors: [
                    getComputedStyle(document.documentElement)
                        .getPropertyValue('--kt-text-inverse')?.trim() || 
                    getComputedStyle(document.documentElement)
                        .getPropertyValue('--kt-text-dark')?.trim()
                ]
            },

            formatter: function (value) {
                return value.toLocaleString("id-ID"); // tampilkan angka 12.500 → 12.500
            }
        },

        stroke: {
            show: true,
            width: 2,
            colors: ["rgba(0,163,255,1)"]
        },

        fill: {
            opacity: 1
        },

        colors: ["#00A3FF"],      // ⭐ warna utama bar

        xaxis: {
            categories: cleanLabels,
            labels: {
                style: {
                    colors: gray500,
                    fontSize: "14px",
                    fontWeight: 500
                }
            },
            axisTicks: { show: false },
            axisBorder: { show: false }
        },

        yaxis: {
            labels: {
                style: {
                    colors: gray500,
                    fontSize: "13px"
                }
            }
        },

        grid: {
            borderColor: borderColor,
            strokeDashArray: 4,
            yaxis: { lines: { show: true } }
        },

        tooltip: {
            style: { fontSize: "12px" },
            y: {
                formatter: (val) => val.toLocaleString('id-ID') + " "
            }
        }
};

    setTimeout(() => {
        chart = new ApexCharts(el, options);
        chart.render();
    }, 150);
}


// LIVEWIRE
document.addEventListener("livewire:navigated", () => {
    renderChart(@json($rumah));
});

// TAB CHANGE
window.addEventListener("chart-update", (e) => {
   
    renderChart(e.detail[0]);
});
</script>
<script>
function renderPieChart(elId, data) {

    let el = document.querySelector(elId);
    if (!el) return;

    let styles = getComputedStyle(document.documentElement);
    let gray500 = styles.getPropertyValue('--kt-gray-500');

    let options = {
        series: data.series,
        labels: data.labels,
        chart: {
            type: 'donut',
            height: 350
        },
        legend: {
            position: 'bottom',
            labels: {
                colors: gray500
            }
        },
        dataLabels: {
            enabled: true,
            style: {
                fontSize: '14px',
                fontWeight: '600',
                colors: ['#fff']
            }
        },
        stroke: { width: 2 },
        colors: ['#00A3FF', '#50CD89'], // biru - hijau ala metronic
    };

    let chart = new ApexCharts(el, options);
    chart.render();
}

document.addEventListener("livewire:navigated", () => {
    renderPieChart("#pie_imb_chart", @json($pieImb));
    renderPieChart("#pie_dtks_chart", @json($pieDtks));
});
</script>

@endpush

