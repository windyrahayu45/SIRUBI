<div x-data x-init="window.livewireComponentId = $el.getAttribute('wire:id')" wire:key="price-table">

    
    <div class="d-flex flex-column flex-column-fluid">
        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <!--begin::Title-->
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Tambah Data Polygon</h1>
                    <!--end::Title-->
                    <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ url('/') }}" class="text-muted text-hover-primary">Beranda</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Polygon</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Tambah Polygon</li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page title-->
                
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Careers - Apply-->
                <div class="card">
                    <!--begin::Body-->
                    <div class="card-body">

                        <div class="row">
                            <!-- Map -->
                            <div class="col-md-6">
                                <div id="map" style="height: 500px; border-radius: 8px;" wire:ignore></div>
                            </div>

                            <!-- Form -->
                            <div class="col-md-6">

                                <div class="mb-5">
                                    <label class="form-label">Nama Kawasan</label>
                                    <input type="text" class="form-control form-control-solid"
                                        wire:model="nama_kawasan" style="border-color: rgb(54 54 96);">
                                </div>

                                <div class="mb-5">
                                    <label class="form-label">Jenis Kawasan</label>
                                    <select class="form-select form-select-solid"
                                            wire:model="jenis_id" style="border-color: rgb(54 54 96);">
                                        <option value="">Pilih Jenis Kawasan</option>
                                        @foreach($jenisPolygon as $jenis)
                                            <option value="{{ $jenis->id_jenis_polygon }}">
                                                {{ $jenis->jenis_polygon }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-5">
                                    <label class="form-label">Luas</label>
                                    <input 
                                        type="text" 
                                        class="form-control form-control-solid"
                                        wire:model.live="luas"
                                        placeholder="e.g: 10.2"
                                        oninput="this.value = this.value.replace(/[^0-9.]/g, '')"
                                        style="border-color: rgb(54 54 96);">
                                </div>

                                <div class="mb-5">
                                    <label class="form-label">Keterangan</label>
                                    <textarea class="form-control form-control-solid"
                                            wire:model="keterangan" rows="3" style="border-color: rgb(54 54 96);"></textarea>
                                </div>

                                <div class="mb-5">
                                    <label class="form-label fw-bold">Upload Shapefile (.zip) (Jika ada file polygon lain selain buat sendiri)</label>
                                    <input type="file" id="file" class="form-control form-control-solid"
                                         accept=".zip"
                                        style="border-color: rgb(54 54 96);">

                                    @error('zipfile') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <!-- HIDDEN polygon -->
                                <textarea wire:model="polygon" id="polygon_geojson" class="d-none"></textarea>
                                <button class="btn btn-primary"
                                        wire:click="{{ $mode == 'create' ? 'save' : 'update' }}"
                                        wire:loading.attr="disabled"
                                        wire:target="{{ $mode == 'create' ? 'save' : 'update' }}">

                                    <!-- Normal -->
                                    <span class="indicator-label" wire:loading.remove wire:target="{{ $mode == 'create' ? 'save' : 'update' }}">
                                       
                                        {{ $mode == 'create' ? 'Simpan' : 'Update' }}
                                    </span>

                                    <!-- Loading -->
                                    <span class="indicator-progress" wire:loading wire:target="{{ $mode == 'create' ? 'save' : 'update' }}">
                                        Mohon Tunggu...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>

                                </button>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css"/>

<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
<script src="https://unpkg.com/shpjs/dist/shp.min.js"></script>
<script>
   
document.addEventListener('livewire:navigated', function () {

 

    Livewire.on('showAlert', (data) => {
        Swal.fire({
            icon: data[0].type ?? 'success',
            title: data[0].message ?? '',
            timer: 1500,
            showConfirmButton: false
        }).then(() => {
            window.location.href = "{{ route('polygon') }}";
        });
    });

      Livewire.on('errorAlert', (data) => {
        Swal.fire({
            icon: data[0].type ?? 'success',
            title: data[0].message ?? '',
            timer: 1500,
            showConfirmButton: false
        });
    });

     document.getElementById('file').addEventListener('change', async (e) => {
     const file = e.target.files[0];
        if (!file) return;

        if (!file.name.endsWith(".zip")) {
            Swal.fire({
                icon: "error",
                title: "File harus ZIP",
                text: "Upload file .zip yang berisi shapefile"
            });
            return;
        }

        try {
            /** ================================
             * 1) BACA ZIP SEBAGAI ARRAYBUFFER
             * ================================ */
            const arrayBuffer = await file.arrayBuffer();

            /** ================================
             * 2) BACA ZIP UNTUK VALIDASI
             * ================================ */
            const zip = await JSZip.loadAsync(arrayBuffer);
            const entries = Object.keys(zip.files);

            const hasShp = entries.some(e => e.endsWith('.shp'));
            const hasShx = entries.some(e => e.endsWith('.shx'));
            const hasDbf = entries.some(e => e.endsWith('.dbf'));

            if (!hasShp || !hasShx || !hasDbf) {
                Swal.fire({
                    icon: "error",
                    title: "ZIP tidak lengkap",
                    html: "Harus ada file:<br>• .shp<br>• .shx<br>• .dbf"
                });
                return;
            }

            /** ================================
             * 3) PROSES SHP.JS
             *    gunakan arrayBuffer, bukan file!
             * ================================ */
            const geojson = await shp(arrayBuffer); // << INI FIX-nya 🔥🔥🔥

            console.log("GEOJSON:", geojson);

            const json = JSON.stringify(geojson);

            // Set ke hidden field
            document.getElementById('polygon_geojson').value = json;

            // Kirim ke Livewire
          Livewire.find(window.livewireComponentId)
            .set('polygon', json);

             Livewire.dispatch('polygonUploaded', { geojson: json });

            Swal.fire({
                icon: "success",
                title: "Berhasil membaca SHP!",
                timer: 1500,
                showConfirmButton: false
            });

        } catch (err) {
            console.error(err);
            Swal.fire({
                icon: "error",
                title: "Gagal memproses SHP",
                text: err.toString()
            });
        }
    });

    Livewire.on('polygonUploaded', (payload) => {
        console.log("Polygon diterima dari upload ZIP:", payload.geojson);

        if (!payload.geojson) return;

        let geo = JSON.parse(payload.geojson);

        drawnItems.clearLayers();

        // jika featureCollection
        L.geoJSON(geo, {
            style: { color: "#ff0000", weight: 2 }
        }).eachLayer(layer => {
            drawnItems.addLayer(layer);
            map.fitBounds(layer.getBounds());
        });
    });


   


});
</script>

<script>
let map = null;
let drawnItems = null;


Livewire.on('loadPolygonOnMap', (payload) => {

    console.log("EVENT loadPolygonOnMap diterima:", payload.polygon);

    // payload = string GeoJSON, bukan object
    let polygon = payload.polygon;

    if (!polygon || polygon === "null") {
        console.log("Polygon kosong");
        return;
    }

    let geo = JSON.parse(polygon);

    if (!drawnItems) {
        console.log("drawnItems belum siap, delay...");
        setTimeout(() => Livewire.dispatch('loadPolygonOnMap', payload), 300);
        return;
    }

    drawnItems.clearLayers();

    let layer = L.geoJSON(geo, {
        style: { color: '#ff0000', weight: 3 }
    });

    layer.addTo(map);
    drawnItems.addLayer(layer);

    map.fitBounds(layer.getBounds());
});



function initPolygonMap() {

    console.log("INIT MAP...");

    // Buat map hanya sekali
    if (map !== null) {
        return;
    }

    map = L.map('map').setView([-0.303431, 100.374528], 14);

    let googleHybrid = L.tileLayer(
        'https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}',
        {subdomains: ['mt0','mt1','mt2','mt3'], maxZoom: 21}
    ).addTo(map);

    // GLOBAL DRAWN ITEMS
    drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);

    let drawControl = new L.Control.Draw({
        draw: {
            polygon: true,
            polyline: true,
            rectangle: true,
            circle: false,
            marker: false
        },
        edit: {
            featureGroup: drawnItems
        }
    });

    map.addControl(drawControl);

    map.on('draw:created', (e) => {
        drawnItems.addLayer(e.layer);
        updateGeoJSON();
    });

    map.on('draw:edited', () => {
        updateGeoJSON();
    });

    console.log("MAP READY");
}

function updateGeoJSON() {
    console.log("UPDATE GEOJSON...");

    // pastikan drawnItems tidak null
    if (!drawnItems) {
        console.log("drawnItems not found!");
        return;
    }

    let geojson = JSON.stringify(drawnItems.toGeoJSON());
    console.log("GEOJSON:", geojson);

    document.getElementById('polygon_geojson').value = geojson;

    // kirim ke livewire
   Livewire.find(window.livewireComponentId)
        .set('polygon', geojson);
}

// HARUS: untuk load pertama
document.addEventListener('livewire:load', initPolygonMap);

// HARUS: untuk SPA mode jika pakai navigate()
document.addEventListener('livewire:navigated', initPolygonMap);
</script>


@endpush
