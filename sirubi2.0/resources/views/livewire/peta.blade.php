<div x-data x-init="window.livewireComponentId = $el.getAttribute('wire:id')" wire:key="price-table" class="d-flex flex-column flex-fill">
    <div class="d-flex flex-column flex-column-fluid">

        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                       Peta Sebaran RLTH
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ url('/') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Peta</li>
                        {{-- <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li> --}}
                        {{-- <li class="breadcrumb-item text-muted">Rumah</li> --}}
                    </ul>
                </div>
                <!--end::Page title-->

                <!--begin::Actions-->
               
                <!--end::Actions-->
            </div>
        </div>
        <!--end::Toolbar-->

        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">

                <!--begin::Card-->
                <div class="card" id="cardPeta">
                    
                     <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Peta Sebaran Rumah</h3>
                        <button id="btnFullscreen" class="btn btn-light btn-sm">
                            <i class="ki-duotone ki-maximize fs-2"></i> Fullscreen
                        </button>
                    </div>

                    <div class="card-body p-0" style="position: relative;">
                        <div id="map" style="height: 600px; width: 100%; border-radius: 0 0 8px 8px;"></div>
                    </div>
                </div>
                <!--end::Card-->

            </div>
        </div>
        <!--end::Content-->

    </div>
</div>


 @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster/dist/MarkerCluster.Default.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/ismyrnow/leaflet-groupedlayercontrol@gh-pages/dist/leaflet.groupedlayercontrol.min.css" />
    
    <link href="{{ asset('assets/js/leaflet/leaflet-control-credits.css') }}" rel="stylesheet" type="text/css" />
    <style>
        .legend {
            padding:6px 8px;
            font:14px Arial,Helvetica,sans-serif;
            background:rgba(255, 255, 255, 0.452);
            box-shadow:0 0 15px rgba(0,0,0,0.3);
            border-radius:5px;
            line-height:24px;
        }
        .legend i {width:18px;height:18px;float:left;margin:0 8px 0 0;}
        .layer-toggle-btn {
            position:absolute;top:10px;right:10px;z-index:9999;
            background:white;border:1px solid #ccc;
            padding:5px 10px;border-radius:4px;cursor:pointer;
            box-shadow:0 2px 6px rgba(0,0,0,0.2);
            font-size:14px;font-weight:600;
        }

            /* 🧩 default (normal mode) */
    .leaflet-bottom.leaflet-right {
        margin-bottom: 20px !important;
        margin-right: 10px !important;
    }

    .leaflet-bottom.leaflet-left {
        margin-bottom: 20px !important;
        margin-left: 20px !important;
    }

    /* 🧭 saat elemen cardPeta fullscreen */
    #cardPeta:fullscreen .leaflet-bottom.leaflet-right {
        margin-bottom: 55px !important;
        margin-right: 55px !important;
    }

    #cardPeta:fullscreen .leaflet-bottom.leaflet-left {
        margin-bottom: 65px !important;
        margin-left: 55px !important; /* ← kamu typo: harus px, bukan 505x 😄 */
    }


    </style>
@endpush

@push('js')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.markercluster/dist/leaflet.markercluster.js"></script>
<script src="https://cdn.jsdelivr.net/gh/ismyrnow/leaflet-groupedlayercontrol@gh-pages/dist/leaflet.groupedlayercontrol.min.js"></script>
<script src="{{ asset('assets/js/leaflet/leaflet-control-credits-src.js') }}"></script>
   <script>
    console.log("GroupedLayerControl:", L.control.groupedLayers);

    // === Fullscreen toggle ===
  document.addEventListener("DOMContentLoaded", () => {
    const card = document.getElementById('cardPeta');
    const mapContainer = document.getElementById('map');
    const btn = document.getElementById('btnFullscreen');

    // pastikan variabel peta global tersedia
    const resizeMap = () => {
        if (window._peta) {
            setTimeout(() => {
                window._peta.invalidateSize();

                // 🧭 pastikan kontrol legend & credits tidak keluar layar
                document.querySelectorAll('.leaflet-control').forEach(ctrl => {
                    ctrl.style.maxWidth = 'calc(100vw - 40px)';
                    ctrl.style.maxHeight = 'calc(100vh - 40px)';
                });

                // tambahkan margin ulang agar posisi enak dilihat
                const legend = document.querySelector('.legend');
                if (legend) {
                    legend.style.marginBottom = '15px';
                    legend.style.marginRight = '15px';
                    legend.style.border = '1px solid rgba(0,0,0,0.2)';
                }

                const credits = document.querySelector('.leaflet-control-credits');
                if (credits) {
                    credits.style.marginLeft = '15px';
                    credits.style.marginBottom = '15px';
                    credits.style.background = 'rgba(255,255,255,0.9)';
                    credits.style.borderRadius = '5px';
                    credits.style.boxShadow = '0 1px 5px rgba(0,0,0,0.3)';
                    credits.style.padding = '4px 8px';
                }
            }, 600);
        }
    };

    // 🧩 Tombol fullscreen handler
    btn.addEventListener('click', () => {
        if (!document.fullscreenElement) {
            card.requestFullscreen?.().then(() => {
                mapContainer.style.height = '100vh';
                btn.innerHTML = '<i class="ki-duotone ki-minimize fs-2"></i> Exit';
                resizeMap();
            });
        } else {
            document.exitFullscreen?.().then(() => {
                mapContainer.style.height = '600px';
                btn.innerHTML = '<i class="ki-duotone ki-maximize fs-2"></i> Fullscreen';
                resizeMap();
            });
        }
    });

    // 🎯 Ketika user tekan ESC atau keluar fullscreen manual
    document.addEventListener('fullscreenchange', () => {
        resizeMap();
    });

    // juga kalau window resize manual
    window.addEventListener('resize', () => {
        resizeMap();
    });
});


    // === PETA LIVEWIRE ===
    document.addEventListener('livewire:init', () => {
        Livewire.on('initMap', (data) => {
            console.log("✅ Data map siap:", data);

            const map = L.map('map', {
                center: [-0.303431, 100.374528],
                zoom: 13,
                layers: []
            });

            // 🗺️ Base maps
            const baseMaps = {
                "Google Hybrid": L.tileLayer('https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
                    maxZoom: 21, subdomains: ['mt0','mt1','mt2','mt3']
                }).addTo(map),
                "Google Streets": L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                    maxZoom: 21, subdomains: ['mt0','mt1','mt2','mt3']
                })
            };

            const groups = {
                kecamatan: new L.LayerGroup(),
                kawasan_kumuh: new L.LayerGroup(),
                kawasan_permukiman: new L.LayerGroup(),
                kawasan_rawan: new L.LayerGroup(),
                sp_1: L.markerClusterGroup(),
                sp_2: L.markerClusterGroup(),
                sp_3: L.markerClusterGroup()
            };

            // 🧭 Polygon Kelurahan per kecamatan
            const kecGroups = {};
            data[0].polygon_kelurahan.forEach(p => {
                const namaKec = p.nama_kecamatan || 'Tidak Diketahui';
                if (!kecGroups[namaKec]) kecGroups[namaKec] = new L.LayerGroup();

                try {
                    L.geoJson(JSON.parse(p.polygon), {
                        color: p.warna || 'yellow',
                        weight: 2,
                        fillOpacity: 0.2
                    }).bindPopup(`
                       <div style="color:#000; background:#fff; border:1px solid #000; border-radius:6px; padding:6px; font-size:13px;">
                            <table style="width:100%; border-collapse:collapse; border:1px solid #000;">
                                <thead>
                                    <tr>
                                        <th colspan="3"
                                            style="background:#f2f2f2; color:#000; border:1px solid #000;
                                                text-align:center; font-weight:bold;">
                                            INFORMASI KELURAHAN
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="border:1px solid #000; padding:4px; width:110px;">Kecamatan</td>
                                        <td style="border:1px solid #000; padding:4px; width:10px;">:</td>
                                        <td style="border:1px solid #000; padding:4px;">${p.nama_kecamatan ?? '-'}</td>
                                    </tr>
                                    <tr>
                                        <td style="border:1px solid #000; padding:4px;">Kelurahan</td>
                                        <td style="border:1px solid #000; padding:4px;">:</td>
                                        <td style="border:1px solid #000; padding:4px;">${p.nama_kelurahan ?? '-'}</td>
                                    </tr>
                                    <tr>
                                        <td style="border:1px solid #000; padding:4px;">Luas</td>
                                        <td style="border:1px solid #000; padding:4px;">:</td>
                                        <td style="border:1px solid #000; padding:4px;">${p.luas ?? '-'} Ha</td>
                                    </tr>
                                    <tr>
                                        <td style="border:1px solid #000; padding:4px;">Keterangan</td>
                                        <td style="border:1px solid #000; padding:4px;">:</td>
                                        <td style="border:1px solid #000; padding:4px;">${p.keterangan ?? '-'}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    `).addTo(kecGroups[namaKec]);
                } catch (e) {
                    console.warn('Invalid polygon kelurahan:', e);
                }
            });

            // 🏞️ Polygon Kawasan
            data[0].polygon_kawasan.forEach(group => {
                group.data.forEach(p => {
                    try {
                        const poly = L.geoJson(JSON.parse(p.polygon), {
                            color: group.color, weight: 2, fillOpacity: 0.3
                        }).bindPopup(`
                           <div style="color:#000; background:#fff; border:1px solid #000; border-radius:6px; padding:6px; font-size:13px;">
                                <table style="width:100%; border-collapse:collapse; border:1px solid #000;">
                                    <thead>
                                        <tr>
                                            <th colspan="3" 
                                                style="background:#f2f2f2; color:#000; border:1px solid #000; text-align:center; font-weight:bold;">
                                                INFORMASI ${p.jenis_polygon?.toUpperCase() ?? 'KAWASAN'}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="border:1px solid #000; padding:4px; width:110px;">Nama Kawasan</td>
                                            <td style="border:1px solid #000; padding:4px; width:10px;">:</td>
                                            <td style="border:1px solid #000; padding:4px;">${p.nama_kawasan ?? '-'}</td>
                                        </tr>
                                        <tr>
                                            <td style="border:1px solid #000; padding:4px;">Jenis</td>
                                            <td style="border:1px solid #000; padding:4px;">:</td>
                                            <td style="border:1px solid #000; padding:4px;">${p.jenis_polygon ?? '-'}</td>
                                        </tr>
                                        <tr>
                                            <td style="border:1px solid #000; padding:4px;">Luas</td>
                                            <td style="border:1px solid #000; padding:4px;">:</td>
                                            <td style="border:1px solid #000; padding:4px;">${p.luas ?? '-'} Ha</td>
                                        </tr>
                                        <tr>
                                            <td style="border:1px solid #000; padding:4px;">Keterangan</td>
                                            <td style="border:1px solid #000; padding:4px;">:</td>
                                            <td style="border:1px solid #000; padding:4px;">${p.keterangan ?? '-'}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        `);
                        if (p.jenis_polygon.includes('Kumuh')) poly.addTo(groups.kawasan_kumuh);
                        else if (p.jenis_polygon.includes('Permukiman')) poly.addTo(groups.kawasan_permukiman);
                        else poly.addTo(groups.kawasan_rawan);
                    } catch (e) {
                        console.warn('Invalid polygon kawasan:', e);
                    }
                });
            });

            // 🏠 Marker Rumah per prioritas
            const icons = {
                sp_1: L.icon({ iconUrl: '/assets/images/icon2.png', iconSize: [30, 33] }),
                sp_2: L.icon({ iconUrl: '/assets/images/icon4.png', iconSize: [30, 33] }),
                sp_3: L.icon({ iconUrl: '/assets/images/icon3.png', iconSize: [30, 33] })
            };

            // Loop semua kategori SP
            Object.entries(data[0].rumah).forEach(([key, rumahList]) => {
                rumahList.forEach(r => {
                    const lat = parseFloat(r.latitude), lng = parseFloat(r.longitude);
                    if (isNaN(lat) || isNaN(lng)) return;

                    const foto = r.foto_url
                        ? `<img width="250px" src="${r.foto_url}" onerror="this.src='/images/no_photo.jpg'">`
                        : `<img width="250px" src="/images/no_photo.jpg">`;

                    const prioritasHTML = cekPrioritas(r.prioritas_a, r.prioritas_b, r.prioritas_c);

                    const popupHTML = `
                        <div style="color:#000; background:#fff; border:1px solid #000; border-radius:6px; padding:6px; font-size:13px;">
                            <table style="width:100%; border-collapse:collapse; border:1px solid #000;">
                                <thead>
                                    <tr>
                                        <th colspan="3" style="background:#f2f2f2; color:#000; border:1px solid #000; text-align:center; font-weight:bold;">
                                            INFORMASI RUMAH<br>
                                            <small>${r.status_rumah ?? '-'}</small>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="3" style="text-align:center; padding:5px;">
                                            ${foto}
                                        </td>
                                    </tr>
                                    <tr><td style="border:1px solid #000;">Nama</td><td style="border:1px solid #000;">:</td><td style="border:1px solid #000;">${r.nama_kk ?? '-'}</td></tr>
                                    <tr><td style="border:1px solid #000;">Kelurahan</td><td style="border:1px solid #000;">:</td><td style="border:1px solid #000;">${r.nama_kelurahan ?? '-'}</td></tr>
                                    <tr><td style="border:1px solid #000;">Kecamatan</td><td style="border:1px solid #000;">:</td><td style="border:1px solid #000;">${r.nama_kecamatan ?? '-'}</td></tr>
                                    <tr><td style="border:1px solid #000;">Latitude</td><td style="border:1px solid #000;">:</td><td style="border:1px solid #000;">${r.latitude}</td></tr>
                                    <tr><td style="border:1px solid #000;">Longitude</td><td style="border:1px solid #000;">:</td><td style="border:1px solid #000;">${r.longitude}</td></tr>
                                    <tr><td style="border:1px solid #000;">Prioritas</td><td style="border:1px solid #000;">:</td><td style="border:1px solid #000;">${prioritasHTML}</td></tr>
                                    
                                    <tr>
                                        <td colspan="3" style="border:1px solid #000; text-align:center; padding-top:6px;">
                                            <a href="/rumah/detail/${r.id_rumah}" target="_blank">
                                                <button class="btn btn-sm btn-primary">Detail</button>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>`;


                    const marker = L.marker([lat, lng], { icon: icons[key] }).bindPopup(popupHTML);
                    groups[key].addLayer(marker);
                });
            });

            // 🧩 Layer Control
            const groupedOverlays = {
                "<b>KECAMATAN</b>": Object.fromEntries(
                    Object.entries(kecGroups).map(([nama, layer]) => [nama, layer])
                ),
                "<b>JENIS KAWASAN</b>": {
                    "Kawasan Kumuh": groups.kawasan_kumuh,
                    "Kawasan Permukiman": groups.kawasan_permukiman,
                    "Kawasan Rawan Bencana": groups.kawasan_rawan
                },
                "<b>SKALA PRIORITAS</b>": {
                    "Prioritas 1": groups.sp_1,
                    "Prioritas 2": groups.sp_2,
                    "Prioritas 3": groups.sp_3
                }
            };
            // 🟢 Tambahkan SEMUA layer ke peta supaya langsung aktif saat load
                Object.values(kecGroups).forEach(layer => map.addLayer(layer));
                map.addLayer(groups.kawasan_kumuh);
                map.addLayer(groups.kawasan_permukiman);
                map.addLayer(groups.kawasan_rawan);
                map.addLayer(groups.sp_1);
                map.addLayer(groups.sp_2);
                map.addLayer(groups.sp_3);

                // 🔘 Tambahkan control ke peta
                L.control.groupedLayers(baseMaps, groupedOverlays, { collapsed: false }).addTo(map);

                // 🏙️ Credit control seperti di CI3
            const credctrl = L.controlCredits({
                image: `${window.location.origin}/assets/images/favicon_peta.png`,
                link :'/',
                text: "Credits<br/>Control"
            }).addTo(map);

            // ubah teksnya setelah delay kecil
            setTimeout(() => {
                credctrl.setText("Sistem Informasi Rumah<br/>Kota Bukittinggi");
            }, 500);


            // 🧭 Legend
            const legend = L.control({ position: "bottomright" });
            legend.onAdd = function(map) {
                const div = L.DomUtil.create("div", "legend");
                div.innerHTML = `
                    <h4 style="margin-bottom:6px;">Keterangan</h4>
                    <div style="line-height:22px;">
                        <i class="icon" style="
                            background-image:url('${window.location.origin}/assets/images/icon2.png');
                            background-size:contain;
                            background-repeat:no-repeat;
                            display:inline-block;
                            width:18px; height:18px; vertical-align:middle;
                            margin-right:6px;
                        "></i><span>RTLH Prioritas 1</span><br>

                        <i class="icon" style="
                            background-image:url('${window.location.origin}/assets/images/icon4.png');
                            background-size:contain;
                            background-repeat:no-repeat;
                            display:inline-block;
                            width:18px; height:18px; vertical-align:middle;
                            margin-right:6px;
                        "></i><span>RTLH Prioritas 2</span><br>

                        <i class="icon" style="
                            background-image:url('${window.location.origin}/assets/images/icon3.png');
                            background-size:contain;
                            background-repeat:no-repeat;
                            display:inline-block;
                            width:18px; height:18px; vertical-align:middle;
                            margin-right:6px;
                        "></i><span>RTLH Prioritas 3</span><br>

                        <i style="
                            background:purple; display:inline-block;
                            width:18px; height:18px; vertical-align:middle;
                            margin-right:6px;
                        "></i><span>Kawasan Kumuh</span><br>

                        <i style="
                            background:green; display:inline-block;
                            width:18px; height:18px; vertical-align:middle;
                            margin-right:6px;
                        "></i><span>Kawasan Permukiman</span><br>

                        <i style="
                            background:black; display:inline-block;
                            width:18px; height:18px; vertical-align:middle;
                            margin-right:6px;
                        "></i><span>Kawasan Rawan Bencana</span>
                    </div>
                `;
                return div;
            };

            legend.addTo(map);

            // 💡 Helper prioritas
            function cekPrioritas(a, b, c) {
                let html = '';

                if (a == 2)
                    html += '<span class="badge bg-danger" style="margin-right:4px;">Prioritas 1</span>';
                if (b == 2)
                    html += '<span class="badge bg-warning text-dark" style="margin-right:4px;">Prioritas 2</span>';
                if (c == 2)
                    html += '<span class="badge bg-success" style="margin-right:4px;">Prioritas 3</span>';

                return html || '<span class="badge bg-secondary">Tidak Ada</span>';
            }

        });
    });



</script>
@endpush
