<div>
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
                <div class="d-flex align-items-center gap-2 gap-lg-3">
                    <a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal"
                        data-bs-target="#kt_modal_add_rumah">Tambah Rumah</a>
                </div>
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
@endpush
