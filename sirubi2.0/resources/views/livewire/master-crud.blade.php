<div class="d-flex flex-column flex-fill">

@push('styles')
<style>
    /* FIX PAGINATION LARAVEL + METRONIC (TANPA PANAH) */

    .pagination {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }

    .pagination .page-link {
        padding: 6px 10px;
        border-radius: 6px !important;
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* HILANGKAN PANAH NEXT & PREV */
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        font-size: 0 !important;  /* hilangkan › dan ‹ */
    }

    .pagination .page-item:first-child .page-link::after,
    .pagination .page-item:last-child .page-link::after {
        content: "" !important;   /* kosongkan isi */
    }

    .pagination .active .page-link {
        background-color: #0095e8 !important;
        border-color: #0095e8 !important;
        color: #fff !important;
    }

    .pagination .disabled .page-link {
        opacity: .5;
    }

    .pagination-nav {
        display: flex;
        justify-content: end;
    }
</style>
@endpush


    <!-- =========================== -->
    <!--        TOOLBAR HEADER       -->
    <!-- =========================== -->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">

            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading text-dark fw-bold fs-3 my-0">
                    {{ $this->cleanName($table) }}
                </h1>

                <ul class="breadcrumb fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ url('/') }}" class="text-muted text-hover-primary">Home</a>
                    </li>
                    {{-- <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li> --}}
                    <li class="breadcrumb-item text-muted">Data Master</li>
                    <li class="breadcrumb-item text-muted">{{ $this->cleanName($table) }}</li>
                </ul>
            </div>

        </div>
    </div>

    <!-- =========================== -->
    <!--           CONTENT           -->
    <!-- =========================== -->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">

            <div class="card">

                <!-- =========================== -->
                <!--        CARD HEADER          -->
                <!-- =========================== -->
                <div class="card-header border-0 pt-6">

                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1">
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg width="24" height="24" fill="none">
                                    <rect opacity="0.5" x="17" y="15" width="8" height="2" rx="1"
                                        transform="rotate(45 17 15)" fill="currentColor"/>
                                    <path d="M11 19A8 8 0 1 1 11 3a8 8 0 0 1 0 16Z" fill="currentColor"/>
                                </svg>
                            </span>

                            <input type="text" wire:model.live="search"
                                class="form-control form-control-solid w-250px ps-15"
                                placeholder="Cari data…"/>
                        </div>
                    </div>

                    <div class="card-toolbar">

                        <!-- Tombol Tambah -->
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addEditModal">
                            <i class="fas fa-plus me-2"></i>Tambah
                        </button>

                    </div>

                </div>

                <!-- =========================== -->
                <!--        CARD BODY            -->
                <!-- =========================== -->
                <div class="card-body pt-0">

                    <table class="table table-striped align-middle gs-0 gy-3">
                        <thead>
                            <tr class="fw-bold text-muted text-uppercase">
                                <th class="min-w-50px">{{ strtoupper($primaryKey) }}</th>

                                @foreach ($columns as $col)
                                    <th>{{ strtoupper(str_replace('_',' ', $col)) }}</th>
                                @endforeach

                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($rows as $row)
                                <tr>
                                    <td>{{ $row->$primaryKey }}</td>

                                    @foreach($columns as $col)
                                        <td>{{ $row->$col }}</td>
                                    @endforeach

                                    <td class="text-end">
                                        <button class="btn btn-light btn-sm"
                                            wire:click="edit({{ $row->$primaryKey }})"
                                            data-bs-toggle="modal"
                                            data-bs-target="#addEditModal">
                                            Edit
                                        </button>

                                        <button class="btn btn-danger btn-sm"
                                                onclick="confirmDelete({{ $row->$primaryKey }})">
                                            Hapus
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>

                    <div class="mt-5 pagination-nav">
    {{ $rows->links() }}
</div>

                </div>
            </div>

        </div>
    </div>

    <!-- =========================== -->
    <!--        MODAL EDIT/ADD       -->
    <!-- =========================== -->
    <div class="modal fade" id="addEditModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">

                <div class="modal-header pb-0 border-0">
                    <h5 class="modal-title">
                        {{ $editId ? 'Edit Data' : 'Tambah Data' }}
                    </h5>

                    <button type="button" class="btn btn-sm btn-icon btn-active-color-primary"
                        data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">✖</span>
                    </button>
                </div>

                <div class="separator my-0"></div>

                <div class="modal-body px-10 py-5">
                    <div class="row">

                        @foreach($columns as $col)
                            <div class="col-md-6 mb-5">
                                <label class="form-label fw-semibold mb-2">
                                    {{ strtoupper(str_replace('_',' ', $col)) }}
                                </label>
                                <input type="text" wire:model="data.{{ $col }}"
                                       class="form-control form-control-solid">
                            </div>
                        @endforeach

                    </div>
                </div>

                <div class="modal-footer border-0 pt-0 pb-5 px-10">

                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button class="btn btn-primary" wire:click="save">
                        {{ $editId ? 'Simpan Perubahan' : 'Tambah' }}
                    </button>

                </div>

            </div>
        </div>
    </div>

</div>
@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: "Yakin ingin menghapus?",
        text: "Data akan dinonaktifkan",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal",
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6c757d",
    }).then((result) => {
        if (result.isConfirmed) {
            Livewire.dispatch('confirmDelete', { id: id });
        }
    });
}

// SWEETALERT SUCCESS
Livewire.on('alert', (data) => {
    Swal.fire({
        toast: true,
        icon: data.type ?? 'success',
        title: data.message,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2000
    });
});

// TUTUP MODAL
Livewire.on('close-modal', () => {
  
    const modal = bootstrap.Modal.getInstance(document.getElementById('addEditModal'));
    if (modal) modal.hide();

    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
});
</script>
@endpush
