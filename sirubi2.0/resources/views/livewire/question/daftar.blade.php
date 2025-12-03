<div wire:key="question-table" class="d-flex flex-column flex-fill">
    <div class="d-flex flex-column flex-column-fluid">

        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">

                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 my-0">Daftar Pertanyaan Dinamis</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ url('/') }}" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item"><span class="bullet bg-gray-400 w-5px h-2px"></span></li>
                        <li class="breadcrumb-item text-muted">Pertanyaan Dinamis</li>
                    </ul>
                </div>

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
                                    placeholder="Cari Pertanyaan.." />
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
                                <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_modal_tambah_pertanyaan">
                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr078.svg-->
                                <span class="svg-icon svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor"></rect>
                                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor"></rect>
                                    </svg>
                                </span>
                                <!--end::Svg Icon-->Tambah Data</button>
                                
                                
                            </div>
                            
                            
                        </div>
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body pt-0">
                        <!--begin::Table-->
                        <div wire:ignore>
                        <table id="questionTable" class="table align-middle table-row-dashed fs-6 gy-5 w-100">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                    
                                    <th>No</th>
                                    <th>Pertanyaan</th>
                                    <th>Module</th>
                                    <th>Kondisi</th>
                                    {{-- <th>Key</th> --}}
                                    <th>Tipe</th>
                                    <th>Wajib</th>
                                    <th>Opsi</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                        </div>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                </div>


            </div>
        </div>
        <!--end::Content-->

    </div>


    <!-- =============================== -->
    <!-- MODAL TAMBAH PERTANYAAN (AKTIF) -->
    <!-- =============================== -->
    <div class="modal fade" 
     id="kt_modal_tambah_pertanyaan" 
     tabindex="-1" 
     wire:ignore.self
     data-bs-backdrop="static"
     data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">

                <div class="modal-header">
                    <h2 class="fw-bold">
                        {{ $editMode ? 'Edit Pertanyaan' : 'Tambah Pertanyaan' }}
                    </h2>

                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal"  wire:click="resetForm">
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" fill="none">
                                <rect opacity="0.5" x="6" y="17.31" width="16" height="2" rx="1"
                                    transform="rotate(-45 6 17.31)" fill="currentColor" />
                                <rect x="7.41" y="6" width="16" height="2" rx="1"
                                    transform="rotate(45 7.41 6)" fill="currentColor" />
                            </svg>
                        </span>
                    </div>
                </div>

                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">

                    <!-- TEXT -->
                    <div class="mb-5">
                        <label class="form-label">Teks Pertanyaan</label>
                        <input type="text" class="form-control form-control-solid" wire:model="label" style="border-color: rgb(54 54 96);">
                    </div>

                    <!-- KEY -->
                    {{-- <div class="mb-5">
                        <label class="form-label">Key</label>
                        <input type="text" class="form-control form-control-solid" wire:model="key" style="border-color: rgb(54 54 96);">
                    </div> --}}

                    <!-- TIPE INPUT + OPSI -->
                    <div x-data="{ jenis: @entangle('type') }" x-cloak>

                        <!-- Tipe Input -->
                        <div class="mb-5">
                            <label class="form-label">Tipe Input</label>
                            <select class="form-select form-select-solid"
                                    x-model="jenis"
                                    wire:model="type" style="border-color: rgb(54 54 96);">
                                <option value="">-- Pilih Tipe --</option>
                                @foreach($types as $t)
                                    <option value="{{ $t->name }}">{{ $t->label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-5">
                            <label class="form-label">Modul</label>
                            <select class="form-select form-select-solid"
                                    wire:model="module" style="border-color: rgb(54 54 96);">
                                <option value="">-- Pilih Modul --</option>
                                @foreach($modules as $m)
                                    <option value="{{ $m->module }}">{{ $m->label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- OPSI -->
                        <div x-show="['select','radio','checkbox'].includes(jenis)" x-transition>
                            <label class="form-label">Opsi Jawaban</label>

                            @foreach($options as $i => $opt)
                                <div class="d-flex gap-2 mb-2">

                                    <input class="form-control form-control-solid"
                                        placeholder="Label opsi…"
                                        wire:model="options.{{ $i }}.label" style="border-color: rgb(54 54 96);">

                                    <button class="btn btn-light-danger"
                                            wire:click="removeOption({{ $i }})">
                                        x
                                    </button>
                                </div>
                            @endforeach

                            <button class="btn btn-light-primary mt-3" wire:click="addOption">
                                + Tambah Opsi
                            </button>
                        </div>
                    </div>

                    <!-- WAJIB -->
                    <div class="mb-5 mt-5">
                        <label class="form-label">Wajib?</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" wire:model="is_required">
                        </div>
                    </div>

                    <!-- CONDITIONAL QUESTION (opsional) -->
                    <div class="mb-5">
                        <label class="form-label fw-bold">Pertanyaan Ini Muncul Jika</label>

                        <!-- pilih parent -->
                        <select class="form-select form-select-solid mb-3"
                                wire:model="parent_question_id" wire:change="handleParentChange($event.target.value)" style="border-color: rgb(54 54 96);">
                            <option value="">-- Pertanyaan Utama (Tidak Ada Parent) --</option>

                            @foreach($availableParents as $p)
                                {{-- saat edit, jangan pilih diri sendiri --}}
                                @if(!$editMode || $editId != $p->id)
                                    <option value="{{ $p->id }}">{{ $p->label }}</option>
                                @endif
                            @endforeach
                        </select>

                        <!-- pilih opsi pemicu -->
                        @if($parent_question_id)
                            <select class="form-select form-select-solid"
                                    wire:model="trigger_option_id" style="border-color: rgb(54 54 96);">
                                <option value="">-- Pilih Opsi Pemicu --</option>

                                @foreach($availableTriggerOptions as $opt)
                                    <option value="{{ $opt->id }}">{{ $opt->label }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>

                    <!-- BUTTON -->
                    <div class="text-center mt-10">
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal" wire:click="resetForm">Batal</button>

                        @if($editMode)
                            <button type="button" class="btn btn-primary" wire:click="update" wire:loading.attr="disabled">
                                <span wire:loading.remove>Update</span>
                                <span wire:loading>Mengupdate...</span>
                            </button>
                        @else
                            <button type="button" class="btn btn-primary" wire:click="save" wire:loading.attr="disabled">
                                <span wire:loading.remove>Simpan</span>
                                <span wire:loading>Menyimpan...</span>
                            </button>
                        @endif
                    </div>

                </div>

            </div>
        </div>
    </div>



</div>


@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', initTable);
document.addEventListener('livewire:load', initTable);

function initTable() {
    if (!$('#questionTable').length) return;

    // Hapus instance lama
    if ($.fn.DataTable.isDataTable('#dokumenTable')) {
        $('#questionTable').DataTable().destroy();
        $('#questionTable').empty();
    }

    // Inisialisasi tabel
    window.questionTable = $('#questionTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: { url: "{{ route('livewire.datatables.question') }}", type: "GET" },
        columns: [
           
              { data: 'DT_RowIndex', orderable:false, searchable:false },
    { data: 'label' },
     { data: 'module' },
      { data: 'kondisi' },
   
    { data: 'type' },
    { data: 'required' },
    { data: 'options', orderable:false, searchable:false },
   {
    data: 'action',
    orderable: false,
    searchable: false,
    className: "text-end"
}

        ],
        order: [[1, 'asc']]
    });

	// ✅ Jalankan setiap tabel selesai render ulang
	window.questionTable.on('draw', function () {
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
                console.log('🔥 Dispatch deleteQuestion untuk ID:', id);
                Livewire.dispatch('deleteQuestion', [{ id: id }]);

        }
        });
    };

    // ✅ Tangkap event dari Livewire
    Livewire.on('questionDeleted', (data) => {
        if (window.questionTable) {
            window.questionTable.ajax.reload(null, false);
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
        window.questionTable.search(this.value).draw();
    });

    

}
</script>

<script>
document.addEventListener('livewire:load', function () {

    let modalEl = document.getElementById('kt_modal_tambah_pertanyaan');

    modalEl.addEventListener('hidden.bs.modal', function () {
        Livewire.dispatch('resetForm');
    });

});

document.addEventListener('DOMContentLoaded', function () {
    
 Livewire.on('closeModalTambahPertanyaan', () => {
        let m = bootstrap.Modal.getInstance(document.getElementById('kt_modal_tambah_pertanyaan'));
        if (m) m.hide();

        if (window.questionTable) {
            window.questionTable.ajax.reload(null, false);
        }

        Swal.fire({
            icon: 'success',
            title: 'Pertanyaan Berhasil Ditambahkan',
            timer: 2000,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
        });
    });
    

 

    Livewire.on('hideModalTambahDokumen', () => {
        let modalEl = document.getElementById('kt_modal_tambah_data');
        let modal = bootstrap.Modal.getInstance(modalEl);
        if (modal) modal.hide();
         if (window.dokumenTable) {
            window.dokumenTable.ajax.reload(null, false);
        }
    });

     Livewire.on('showAlert', (data) => {
        Swal.fire({
            icon: data[0].type ?? 'success',
            title: data[0].message ?? '',
            timer: 2000,
            showConfirmButton: false
        });
    });


    

   



});
</script>
<script>
function onEditQuestion(id) {
    Livewire.dispatch("editQuestion", [{ id: id }]);

    let modal = new bootstrap.Modal(document.getElementById('kt_modal_tambah_pertanyaan'));
    modal.show();
}

</script>
@endpush
