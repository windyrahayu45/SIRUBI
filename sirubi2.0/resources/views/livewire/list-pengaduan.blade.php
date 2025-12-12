<div x-data x-init="window.livewireComponentId = $el.getAttribute('wire:id')" 
     wire:key="pengaduan-table" 
     class="d-flex flex-column flex-fill">

    <div class="d-flex flex-column flex-column-fluid">

        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">

                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Data Pengaduan Rumah
                    </h1>

                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ url('/') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Pengaduan</li>
                    </ul>
                </div>
                <!--end::Page title-->

            </div>
        </div>
        <!--end::Toolbar-->


        <!--begin::Content-->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">

                <div class="card">

                    <!--begin::Card header-->
                    <div class="card-header border-0 pt-6">
                        <div class="card-title">

                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                    {{-- <svg width="24" height="24" viewBox="0 0 24 24">
                                        <rect opacity="0.5" x="17" y="15" width="8" height="2" transform="rotate(45)" />
                                        <path d="M11 19C6.5 19 3 15.4 3 11S6.5 3 11 3s8 3.6 8 8-3.5 8-8 8z" />
                                    </svg> --}}
                                </span>

                                <input type="text" id="searchPengaduan"
                                    class="form-control form-control-solid w-250px ps-15"
                                    placeholder="Cari Pengaduan.." />
                            </div>
                            <!--end::Search-->

                        </div>
                    </div>
                    <!--end::Card header-->


                    <!--begin::Card body-->
                    <div class="card-body pt-0">

                        <div wire:ignore>
                            <table id="pengaduanTable" 
                                   class="table align-middle table-row-dashed fs-6 gy-5 w-100">
                                <thead>
                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                        <th width="10">No</th>
                                        <th class="min-w-150px">NIK / KK</th>
                                        <th class="min-w-150px">Alamat</th>
                                        <th class="min-w-125px">Wilayah</th>
                                        <th class="min-w-125px">Keterangan</th>
                                        <th class="min-w-125px">Status</th>
                                        <th class="text-end min-w-100px">Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                    </div>
                    <!--end::Card body-->

                </div>

            </div>
        </div>
        <!--end::Content-->

    </div>


    <!-- ##########################################################
         MODAL DETAIL PENGADUAN
         ##########################################################-->
        <div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
    <div class="modal-dialog mw-800px">
        <div class="modal-content">

            <!--======================
                HEADER METRONIC STYLE
            =======================-->
            <div class="modal-header pb-0 border-0 justify-content-end">
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <span class="svg-icon svg-icon-1">
                        <svg width="24" height="24" viewBox="0 0 24 24">
                            <rect opacity="0.5" x="6" y="17.3" width="16" height="2" rx="1"
                                transform="rotate(-45 6 17.3)" fill="currentColor"></rect>
                            <rect x="7.4" y="6" width="16" height="2" rx="1"
                                transform="rotate(45 7.4 6)" fill="currentColor"></rect>
                        </svg>
                    </span>
                </div>
            </div>

            <!-- TITLE -->
            <div class="text-center mb-5">
                <h1 class="fw-bold">Detail Pengaduan Rumah</h1>
                <div class="text-muted fw-semibold fs-6">
                    Informasi lengkap pengaduan & foto pendukung.
                </div>
            </div>

            <!--======================
                BODY
            =======================-->
            <div class="modal-body scroll-y mx-5 mx-xl-10 pt-0 pb-10">

                <div class="row g-10">

                    <!-- LEFT SIDE -->
                    <div class="col-md-6">
                        <div class="mb-8">
                            <h3 class="fs-5 fw-bold mb-4">Identitas Pelapor</h3>

                            <div class="fs-6 text-gray-700">
                                <p><b>NIK:</b> {{ $detailData['nik'] ?? '-' }}</p>
                                <p><b>KK:</b> {{ $detailData['kk'] ?? '-' }}</p>
                                <p><b>Alamat:</b> {{ $detailData['alamat'] ?? '-' }}</p>
                                <p><b>RT/RW:</b> {{ $detailData['rt'] ?? '-' }}/{{ $detailData['rw'] ?? '-' }}</p>
                                <p><b>Kelurahan:</b> {{ $detailData['kelurahan']['nama_kelurahan'] ?? '-' }}</p>
                                <p><b>Kecamatan:</b> {{ $detailData['kecamatan']['nama_kecamatan'] ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="mb-0">
                            <h3 class="fs-5 fw-bold mb-4">Keterangan Pengaduan</h3>
                            <div class="text-gray-700 fw-semibold">
                                {{ $detailData['keterangan'] ?? '-' }}
                            </div>
                        </div>
                    </div>

                    <!-- RIGHT SIDE -->
                    <div class="col-md-6">
                        <h3 class="fs-5 fw-bold mb-4">Foto Pengaduan</h3>

                        <div class="row g-5 mh-350px scroll-y pe-3">

                            @foreach ($detailFotos as $item)
                                <div class="col-6">

                                    <div class="symbol symbol-150px symbol-circle mb-3"
                                         style="cursor: pointer; overflow:hidden;"
                                         data-bs-toggle="modal"
                                         data-bs-target="#previewModal"
                                         data-src="{{ asset('storage/' . $item->file_path) }}">

                                        <img src="{{ asset('storage/' . $item->file_path) }}"
                                             class="w-100 h-100 object-fit-cover">
                                    </div>

                                    <div class="text-center text-gray-600 small fw-semibold">
                                        {{ $item->deskripsi ?? '-' }}
                                    </div>

                                </div>
                            @endforeach

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>




    <!-- ##########################################################
         MODAL UBAH STATUS
         ##########################################################-->
    <div class="modal fade" id="statusModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered mw-500px">
            <div class="modal-content">

                <div class="modal-header pb-0 border-0">
                    <h5 class="modal-title">Ubah Status Pengaduan</h5>

                    <button type="button" class="btn btn-sm btn-icon" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-2"></i>
                    </button>
                </div>

                <div class="separator"></div>

                <div class="modal-body py-5 px-10">

                    <label class="form-label">Pilih Status Baru</label>
                    <select class="form-select" wire:model="statusBaru">
                        <option value="pending">Pending</option>
                        <option value="proses">Proses</option>
                        <option value="selesai">Selesai</option>
                    </select>

                </div>

                <div class="modal-footer border-0 pt-0 px-10 pb-5">
                    <button class="btn btn-light" data-bs-dismiss="modal">Batal</button>

                    <button class="btn btn-primary"
                        wire:click="updateStatus"
                        wire:loading.attr="disabled">
                        Simpan Perubahan
                    </button>
                </div>

            </div>
        </div>
    </div>


</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', initTablePengaduan);
document.addEventListener('livewire:load', initTablePengaduan);

function initTablePengaduan() {

    if ($.fn.DataTable.isDataTable('#pengaduanTable')) {
        $('#pengaduanTable').DataTable().destroy();
        $('#pengaduanTable').empty();
    }

    window.pengaduanTable = $('#pengaduanTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: { 
            url: "{{ route('livewire.datatables.pengaduan') }}", 
            type: "GET" 
        },
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'nik_kk' },
            { data: 'alamat' },
            { data: 'wilayah' },
            { data: 'keterangan' },
            { data: 'status_badge' },
            { data: 'action', orderable: false, searchable: false }
        ],
        order: [[1, 'asc']]
    });

    // Re-init Metronic menu each draw
    window.pengaduanTable.on('draw', function () {
        if (typeof KTMenu !== 'undefined') {
            KTMenu.createInstances();
        }
    });

    $('#searchPengaduan').on('keyup', function () {
        window.pengaduanTable.search(this.value).draw();
    });

    // SHOW DETAIL MODAL
    Livewire.on('showDetailModal', () => {
        new bootstrap.Modal(document.getElementById('detailModal')).show();
    });

    // SHOW STATUS MODAL
    Livewire.on('showStatusModal', () => {
        new bootstrap.Modal(document.getElementById('statusModal')).show();
    });

    // CLOSE STATUS MODAL
    Livewire.on('hideStatusModal', () => {
        let modal = bootstrap.Modal.getInstance(document.getElementById('statusModal'));
        if (modal) modal.hide();
        window.pengaduanTable.ajax.reload(null, false);
    });

}
</script>
@endpush
