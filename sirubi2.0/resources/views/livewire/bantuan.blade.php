<div x-data x-init="window.livewireComponentId = $el.getAttribute('wire:id')" wire:key="price-table" class="d-flex flex-column flex-fill">
    <div class="d-flex flex-column flex-column-fluid">

        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
                <!--begin::Page title-->
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                        Data Bantuan
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ url('/') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Bantuan</li>
                        
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
                                    placeholder="Cari Bantuan.." />
                            </div>
                            <!--end::Search-->
                        </div>
                        <div class="card-toolbar" data-select2-id="select2-data-132-9owp">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                                <!--begin::Filter-->

                                 @if (auth()->user()->level != 3)
                                <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#modalIntegrasiDokumen">
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr078.svg-->
                                    <span class="svg-icon svg-icon-2">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">

                                            <!-- Left block -->
                                            <rect opacity="0.3" x="3" y="4" width="7" height="6" rx="1.5" fill="currentColor"/>

                                            <!-- Right block -->
                                            <rect opacity="0.3" x="14" y="14" width="7" height="6" rx="1.5" fill="currentColor"/>

                                            <!-- Arrow down-right -->
                                            <path d="M10 9L14 13M14 13H11M14 13V10" stroke="currentColor" stroke-width="1.8"
                                                stroke-linecap="round" stroke-linejoin="round"/>

                                            <!-- Arrow up-left -->
                                            <path d="M14 11L10 15M10 15H13M10 15V12" stroke="currentColor" stroke-width="1.8"
                                                stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>

                                    </span>
                                    <!--end::Svg Icon-->Integrasi Dokumen</button>
                                
                                <!--begin::Menu 1-->
                                
                                <!--end::Menu 1-->
                                <!--end::Filter-->
                                <!--begin::Export-->
                                <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_import_data">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr078.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1" transform="rotate(90 12.75 4.25)" fill="currentColor"></rect>
                                        <path d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z" fill="currentColor"></path>
                                        <path opacity="0.3" d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->Import</button>

                                @endif
                                
                                
                            </div>
                            <!--end::Toolbar-->
                            <div class="modal fade" id="kt_modal_import_data" tabindex="-1" aria-hidden="true" wire:ignore.self>
                                <div class="modal-dialog modal-dialog-centered mw-650px">
                                    <div class="modal-content">

                                        <!-- Header -->
                                        <div class="modal-header">
                                            <h2 class="fw-bold">Import Data</h2>

                                            <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                                <span class="svg-icon svg-icon-1">
                                                    <svg width="24" height="24" fill="none">
                                                        <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                                            transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                                        <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                            transform="rotate(45 7.41422 6)" fill="currentColor" />
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Body -->
                                        <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">

                                            <!-- Tidak wire:model di input! -->
                                            <input type="file"
                                                id="import_file"
                                                class="form-control form-control-solid mb-10"
                                                accept=".xls,.xlsx,.csv">

                                            <div class="text-center mt-10">

                                                <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">
                                                    Batal
                                                </button>

                                                <!-- Trigger upload -->
                                                <button type="button" class="btn btn-primary"
                                                        wire:loading.attr="disabled"
                                                        onclick="startImport()">

                                                    <!-- Normal -->
                                                    <span class="indicator-label" wire:loading.remove wire:target="importData">
                                                        Import
                                                    </span>

                                                    <!-- Loading -->
                                                    <span class="indicator-progress" wire:loading wire:target="importData">
                                                        Mohon Tunggu...
                                                        <span class="spinner-border spinner-border-sm ms-2"></span>
                                                    </span>
                                                </button>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                        <div class="modal fade" id="modalIntegrasiDokumen" tabindex="-1" aria-hidden="true" wire:ignore.self>
                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                <div class="modal-content">

                                    <!-- HEADER -->
                                    <div class="modal-header">
                                        <h2 class="fw-bold">Integrasi Dokumen Bantuan</h2>

                                        <button type="button" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                                            <span class="svg-icon svg-icon-1">
                                                <svg width="24" height="24" fill="none">
                                                    <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                                        transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                                    <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                                        transform="rotate(45 7.41422 6)" fill="currentColor" />
                                                </svg>
                                            </span>
                                        </button>
                                    </div>

                                    <!-- BODY -->
                                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">

                                        <!-- Nama Bantuan -->
                                        <div class="fv-row mb-7">
                                            <label class="fw-semibold fs-6 mb-2">Nama Bantuan</label>
                                            <input type="text"
                                                class="form-control form-control-solid"
                                                placeholder="Masukkan nama bantuan"
                                                wire:model="nama_bantuan_input">
                                        </div>

                                        <!-- Nama Program -->
                                        <div class="fv-row mb-7">
                                            <label class="fw-semibold fs-6 mb-2">Nama Program</label>
                                            <input type="text"
                                                class="form-control form-control-solid"
                                                placeholder="Masukkan nama program"
                                                wire:model="nama_program_input">
                                        </div>

                                        <!-- Tahun Bantuan -->
                                        <div class="fv-row mb-7">
                                            <label class="fw-semibold fs-6 mb-2">Tahun Bantuan</label>
                                            <input type="number"
                                                class="form-control form-control-solid"
                                                placeholder="Contoh: 2024"
                                                wire:model="tahun_bantuan_input">
                                        </div>

                                        <!-- Dokumen Select -->
                                        <div class="fv-row mb-7" wire:ignore>
                                            <label class="required fs-6 fw-semibold mb-2">Pilih Dokumen</label>
                                            <select class="form-select" 
                                                    id="dokumen_input"
                                                    data-control="select2"
                                                    data-placeholder="Pilih dokumen"
                                                    data-name="dokumen_input">
                                                <option value="">-- Pilih Dokumen --</option>
                                                @foreach($dokumens as $item)
                                                    <option value="{{ $item->id_dokumen }}">{{ $item->nama_dokumen }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- BUTTONS -->
                                        <div class="text-center mt-10">
                                            <button type="button"
                                                    class="btn btn-primary"
                                                       wire:click="submitIntegrasi"
                                                    wire:loading.attr="disabled">

                                                <span class="indicator-label" wire:loading.remove wire:target="submitIntegrasi">
                                                    Simpan
                                                </span>

                                                <span class="indicator-progress" wire:loading wire:target="submitIntegrasi">
                                                    Mohon Tunggu...
                                                    <span class="spinner-border spinner-border-sm ms-2"></span>
                                                </span>
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>



                            
                        </div>
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->
                        <div wire:ignore>
                        <table id="bantuanTable" class="table align-middle table-row-dashed fs-6 gy-5 w-100">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                    
                                    <th width="10">No</th>
                                    <th class="min-w-150px">No KK / NIK</th>
                                    <th class="min-w-150px">Nama Bantuan</th>
                                    <th class="min-w-125px">Program Bantuan</th>
                                    <th class="min-w-125px">Nominal</th>
                                    <th class="min-w-125px">Tahun</th>
                                    <th class="min-w-125px">Dokumen</th>
                                    <th class="min-w-125px">Status Data</th>
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


    <div class="modal fade" id="editModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <!-- Header -->
                <div class="modal-header pb-0 border-0">
                    <h5 class="modal-title">Edit Data Bantuan</h5>

                    <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                    transform="rotate(-45 6 17.3137)" fill="currentColor"/>
                                <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                    transform="rotate(45 7.41422 6)" fill="currentColor"/>
                            </svg>
                        </span>
                    </button>
                </div>

                <div class="separator my-0"></div>

                <!-- Body -->
                <div class="modal-body py-5 px-10">

                    <div class="row">

                        <!-- NO KK -->
                        <div class="col-md-6 mb-7 fv-row">
                            <label class="required fw-semibold fs-6 mb-2">Nomor KK</label>
                            <input type="text" class="form-control form-control-solid"
                                wire:model="form.no_kk" readonly />
                        </div>

                        <!-- Nama Bantuan -->
                        <div class="col-md-6 mb-7 fv-row">
                            <label class="required fw-semibold fs-6 mb-2">Nama Bantuan</label>
                            <input type="text" class="form-control form-control-solid"
                                wire:model="form.nama_bantuan" />
                        </div>

                        <!-- Program Bantuan -->
                        <div class="col-md-6 mb-7 fv-row">
                            <label class="required fw-semibold fs-6 mb-2">Program Bantuan</label>
                            <input type="text" class="form-control form-control-solid"
                                wire:model="form.program_bantuan" />
                        </div>

                        <!-- Nominal -->
                        <div class="col-md-6 mb-7 fv-row">
                            <label class="required fw-semibold fs-6 mb-2">Nominal (Rp)</label>
                            <input type="text" class="form-control form-control-solid"
                                wire:model="form.nominal" />
                        </div>

                        <!-- Tahun -->
                        <div class="col-md-6 mb-7 fv-row">
                            <label class="required fw-semibold fs-6 mb-2">Tahun Bantuan</label>
                            <input type="number" class="form-control form-control-solid"
                                wire:model="form.tahun" />
                        </div>


                        <div class="col-md-6 fv-row" wire:ignore>
                            <label class="required fs-5 fw-semibold mb-2">Dokumen</label>
                            <select class="form-select" 
                                    data-control="select2"
                                    data-placeholder="Pilih Dokumen"
                                    data-name="id_dokumen"
                                    id="id_dokumen"
                                    required>
                                <option value="">-- Pilih Dokumen --</option>
                                @foreach($dokumens ?? [] as $item)
                                    <option value="{{ $item->id_dokumen }}">{{ $item->nama_dokumen }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                </div>

                <!-- Footer -->
                <div class="modal-footer border-0 pt-0 px-10 pb-5">

                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button class="btn btn-primary"
                                wire:click="updateData"
                                wire:loading.attr="disabled"
                                wire:target="updateData">

                            <!-- Label normal -->
                            <span class="indicator-label" wire:loading.remove wire:target="updateData">
                                Simpan Perubahan
                            </span>

                            <!-- Loading state -->
                            <span class="indicator-progress" wire:loading wire:target="updateData">
                                Mohon Tunggu...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>

                    </div>


            </div>
        </div>
    </div>

</div>

@push('js')
<script src="{{ asset('assets/js/widgets.bundle.js') }}"></script>
<script src="{{ asset('assets/js/custom/widgets.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function startImport() {
    const fileInput = document.getElementById('import_file');

    if (!fileInput.files.length) {
        Livewire.dispatch('showAlert', {
            type: 'error',
            message: 'Silakan pilih file dulu!'
        });
        return;
    }

    // ambil instance livewire component
    const component = Livewire.find(
        document.querySelector('[wire\\:id]').getAttribute('wire:id')
    );

    // upload file baru saat klik IMPORT
    component.upload(
        'file_import',
        fileInput.files[0],
        () => component.call('importData'),  // sukses upload → jalankan import
        () => Livewire.dispatch('showAlert', {
            type: 'error',
            message: 'Gagal mengupload file'
        })
    );
}
</script>

<script>
document.addEventListener('DOMContentLoaded', initTable);
document.addEventListener('livewire:load', initTable);

function initTable() {
    if (!$('#bantuanTable').length) return;

    // Hapus instance lama
    if ($.fn.DataTable.isDataTable('#bantuanTable')) {
        $('#bantuanTable').DataTable().destroy();
        $('#bantuanTable').empty();
    }

    // Inisialisasi tabel
    window.bantuanTable = $('#bantuanTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: { url: "{{ route('livewire.datatables.bantuan') }}", type: "GET" },
        columns: [
           
             { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'kk' },
            { data: 'nama' },
            { data: 'nama_program' },
            { data: 'nominal' },
            { data: 'tahun' },
             { data: 'dokumen' },
             {data : 'status_kk'},
            
            
            { data: 'action', orderable: false, searchable: false }
        ],
        order: [[1, 'asc']]
    });

	// ✅ Jalankan setiap tabel selesai render ulang
	window.bantuanTable.on('draw', function () {
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
        if (window.bantuanTable) {
            window.bantuanTable.ajax.reload(null, false);
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
        window.bantuanTable.search(this.value).draw();
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

     Livewire.on('hideIntegrasiModal', () => {
        let modalEl = document.getElementById('modalIntegrasiDokumen');
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


document.addEventListener("DOMContentLoaded", () => {
    initSelect2();
});
// Tambahkan hook ini ‼️

function initSelect2() {
    console.log("✅ Init Select2 triggered");

    $('[data-control="select2"]').each(function() {
        const el = $(this);

        //Pastikan tidak diinisialisasi dua kali
        // if (el.data('select2')) {
        //     el.select2('destroy');
        // }
        // console.log(el.data('placeholder'))
        // el.select2({
          
        //     width: '100%',
        //     placeholder: el.data('placeholder') ?? '',
          
        // });
        if (!el.data('select2')) {
            el.select2({
                width: '100%',
                placeholder: el.data('placeholder') ?? '',
            });
        }
       


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
            component.call('select2Changed', { name, value });
        }
    } else {
        console.warn('⚠️ Tidak menemukan komponen Livewire untuk select2');
    }
        });
    });
}
</script>

@endpush
