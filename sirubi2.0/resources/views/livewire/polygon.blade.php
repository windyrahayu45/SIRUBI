<div x-data x-init="window.livewireComponentId = $el.getAttribute('wire:id')" wire:key="price-table" class="d-flex flex-column flex-fill">
    <div class="d-flex flex-column flex-column-fluid">

        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Data Polygon
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ url('/') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Polygon</li>
                        
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
                <div class="card">
                    <!--begin::Card header-->
                    <div class="card-header border-0 pt-6">
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546"
                                            height="2" rx="1" transform="rotate(45 17.0365 15.1223)"
                                            fill="currentColor" />
                                        <path
                                            d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                            fill="currentColor" />
                                    </svg>
                                </span>
                                <input type="text" id="searchRumah"
                                    class="form-control form-control-solid w-250px ps-15"
                                    placeholder="Cari Polygon.." />
                            </div>
                            <!--end::Search-->
                        </div>
                        <div class="card-toolbar" data-select2-id="select2-data-132-9owp">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                <!--begin::Filter-->
                                
                                <!--begin::Menu 1-->
                                
                                <!--end::Menu 1-->
                                <!--end::Filter-->
                                <!--begin::Export-->
                                 @if (auth()->user()->level != 3)
                                <div class="d-flex align-items-center gap-2 gap-lg-3">
                                    <a href="{{ route('polygon.add') }}" class="btn btn-primary">  <span class="svg-icon svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                                        </svg>
                                    </span>Tambah Data</a>
                                </div>
                                @endif
                                
                                
                            </div>
                            
                        </div>
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->
                        <div wire:ignore>
                        <table id="polygonTable" class="table align-middle table-row-dashed fs-6 gy-5 w-100">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                    
                                    <th width="10">No</th>
                                    <th class="min-w-150px">Kawasan</th>
                                    <th class="min-w-150px">Jenis</th>
                                    <th class="min-w-125px">Luas</th>
                                    <th class="min-w-125px">Keterangan</th>
                                    <th class="text-end min-w-100px">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                        </div>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>
                <!--end::Card-->

            </div>
        </div>
        <!--end::Content-->

    </div>



</div>

@push('js')
<script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
<script src="{{ asset('assets/js/custom/widgets.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', initTable);
document.addEventListener('livewire:load', initTable);

function initTable() {
    if (!$('#polygonTable').length) return;

    // Hapus instance lama
    if ($.fn.DataTable.isDataTable('#polygonTable')) {
        $('#polygonTable').DataTable().destroy();
        $('#polygonTable').empty();
    }

    // Inisialisasi tabel
    window.polygonTable = $('#polygonTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: { url: "{{ route('livewire.datatables.polygon') }}", type: "GET" },
        columns: [
           
             { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'nama_kawasan' },
            { data: 'jenis' },
            { data: 'luas' },
            { data: 'keterangan' },
            { data: 'action', orderable: false, searchable: false }
        ],
        order: [[1, 'asc']]
    });

	// ✅ Jalankan setiap tabel selesai render ulang
	window.polygonTable.on('draw', function () {
		if (typeof KTMenu !== 'undefined') {
			KTMenu.createInstances();
		}
	});

	// ✅ Jalankan juga pertama kali load
	if (typeof KTMenu !== 'undefined') {
		KTMenu.createInstances();
	}




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

    // ✅ Tangkap event dari Livewire
    Livewire.on('rumahDeleted', (data) => {
        if (window.polygonTable) {
            window.polygonTable.ajax.reload(null, false);
        }

        Swal.fire({
            toast: true,
            icon: 'success',
            title: 'Data berhasil dihapus!',
            text: 'Data berhasil dihapus!',
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
        
        
        });
    });


    // Search real-time
    $('#searchRumah').on('keyup', function () {
        window.polygonTable.search(this.value).draw();
    });

    

}
</script>


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

     Livewire.on('showAlert', (data) => {
        Swal.fire({
            icon: data[0].type ?? 'success',
            title: data[0].message ?? '',
            timer: 2000,
            showConfirmButton: false
        });
    });


    Livewire.on('showEditModal', () => {
        let modal = new bootstrap.Modal(document.getElementById('editModal'));
        modal.show();
    });

    Livewire.on('hideEditModal', () => {
        let modalEl = document.getElementById('editModal');
        let modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
         if (window.bantuanTable) {
            window.bantuanTable.ajax.reload(null, false);
        }
    });

     Livewire.on('hideImportModal', () => {
        let modalEl = document.getElementById('kt_modal_import_data');
        let modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
         if (window.bantuanTable) {
            window.bantuanTable.ajax.reload(null, false);
        }
    });

    

   



});
</script>

@endpush
