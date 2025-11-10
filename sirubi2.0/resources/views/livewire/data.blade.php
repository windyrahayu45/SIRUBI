<div x-data x-init="window.livewireComponentId = $el.getAttribute('wire:id')" wire:key="price-table" class="d-flex flex-column flex-fill">
    <div class="d-flex flex-column flex-column-fluid">

        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Data Rumah
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ url('/') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Pendataan</li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Rumah</li>
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
                                    placeholder="Cari rumah..." />
                            </div>
                            <!--end::Search-->
                        </div>
                        <div class="card-toolbar" data-select2-id="select2-data-132-9owp">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                <!--begin::Filter-->
                                <a href="{{ route('rumah.filter') }}" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->Filter</a>
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
                                
                                <div class="d-flex align-items-center gap-2 gap-lg-3">
                                    <a href="{{ route('rumah.add') }}" class="btn btn-primary">  <span class="svg-icon svg-icon-2">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                                                    </svg>
                                                </span>Tambah Rumah</a>
                                </div>
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
                                                        <option value="geojson">Geojson (.geojson)</option>
                                                        
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
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->
                        <div wire:ignore>
                        <table id="rumahTable" class="table align-middle table-row-dashed fs-6 gy-5 w-100">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                    <th width="10"></th>
                                    <th width="10">#</th>
                                    <th class="min-w-150px">Nama Pemilik</th>
                                    <th class="min-w-150px">Alamat</th>
                                    <th class="min-w-125px">Kecamatan</th>
                                    <th class="min-w-125px">Kelurahan</th>
                                    <th class="min-w-125px">Status Rumah</th>
                                    <th class="min-w-125px">Status Backlog</th>
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
    if (!$('#rumahTable').length) return;

    // Hapus instance lama
    if ($.fn.DataTable.isDataTable('#rumahTable')) {
        $('#rumahTable').DataTable().destroy();
        $('#rumahTable').empty();
    }

    // Inisialisasi tabel
    window.rumahTable = $('#rumahTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: { url: "{{ route('livewire.datatables.rumah') }}", type: "GET" },
        columns: [
            { data: 'expand', orderable: false, searchable: false },
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'nama_pemilik' },
            { data: 'alamat' },
            { data: 'kecamatan' },
            { data: 'kelurahan' },
            { data: 'status_rumah' },
            { data: 'status_backlog', orderable: false, searchable: false },
            { data: 'action', orderable: false, searchable: false }
        ],
        order: [[1, 'asc']]
    });

	// ✅ Jalankan setiap tabel selesai render ulang
	window.rumahTable.on('draw', function () {
		if (typeof KTMenu !== 'undefined') {
			KTMenu.createInstances();
		}
	});

	// ✅ Jalankan juga pertama kali load
	if (typeof KTMenu !== 'undefined') {
		KTMenu.createInstances();
	}


	window.viewRumah = function(id) {
    // ✅ Contoh buka modal detail
    Swal.fire({
        title: 'View Rumah',
        text: 'Menampilkan detail rumah ID: ' + id,
        icon: 'info',
        confirmButtonText: 'Tutup'
    });
	}

	window.editRumah = function(id) {
		// ✅ Contoh redirect ke halaman edit
		window.location.href = '/rumah/edit/' + id;
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
        if (window.rumahTable) {
            window.rumahTable.ajax.reload(null, false);
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
        window.rumahTable.search(this.value).draw();
    });

    // Expand detail row
    $('#rumahTable').on('click', '.toggle-detail', function () {
		const tr = $(this).closest('tr');
		const row = window.rumahTable.row(tr);
		const id = $(this).data('id');
		
		const icon = $(this).find('i');

		if (row.child.isShown()) {
			row.child.hide();
			icon.removeClass('fa-minus').addClass('fa-plus');
		} else {
			icon.removeClass('fa-plus').addClass('fa-spinner fa-spin');
			const url = "{{ route('datatable.rumah.detail', ['id' => ':id']) }}".replace(':id', id);
			$.get(url, function (html) {
				row.child(html).show();
				icon.removeClass('fa-spinner fa-spin').addClass('fa-minus');

				// Re-init accordion Metronic
				if (typeof KTAccordion !== 'undefined') {
					KTAccordion.createInstances();
				}
			}).fail(() => {
				icon.removeClass('fa-spinner fa-spin').addClass('fa-plus');
				alert('Gagal memuat detail rumah');
			});
		}
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
            component.$set('exportFormat', value);
            console.log('📦 exportFormat di-set:', value);

        }
    } else {
        console.warn('⚠️ Tidak menemukan komponen Livewire untuk select2');
    }
        });
    });
}
</script>
@endpush
