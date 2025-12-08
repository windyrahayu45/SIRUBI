<div wire:key="pengaduan-table" class="d-flex flex-column flex-fill">

    <div class="d-flex flex-column flex-column-fluid">

        <!-- TOOLBAR -->
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">

                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-dark fw-bold fs-3 my-0">
                        Data Pengaduan Masyarakat
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">
                            <a href="/" class="text-muted text-hover-primary">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <span class="bullet bg-gray-400 w-5px h-2px"></span>
                        </li>
                        <li class="breadcrumb-item text-muted">Pengaduan</li>
                    </ul>
                </div>

            </div>
        </div>

        <!-- CONTENT -->
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">

                <div class="card">

                    <!-- HEADER -->
                    <div class="card-header border-0 pt-6">
                        <div class="card-title">
                            <div class="d-flex align-items-center position-relative my-1">
                                <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control form-control-solid w-250px ps-15"
                                       wire:model.live="search"
                                       placeholder="Cari pengaduan..." />
                            </div>
                        </div>
                    </div>

                    <!-- TABLE -->
                    <div class="card-body pt-0">

                        <table class="table table-row-dashed fs-6 gy-5">
                            <thead>
                                <tr class="text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Pelapor</th>
                                    <th>No HP</th>
                                    <th>Kategori</th>
                                    <th>Status</th>
                                    <th class="text-end">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($items as $i => $row)
                                <tr>
                                    <td>{{ $items->firstItem() + $i }}</td>
                                    <td>{{ $row->judul }}</td>
                                    <td>{{ $row->nama_pelapor }}</td>
                                    <td>{{ $row->no_hp }}</td>
                                    <td><span class="badge badge-light-primary">{{ $row->kategori }}</span></td>

                                    <td>
                                        @if($row->status == 'pending')
                                            <span class="badge badge-light-warning">Pending</span>
                                        @elseif($row->status == 'diproses')
                                            <span class="badge badge-light-info">Diproses</span>
                                        @else
                                            <span class="badge badge-light-success">Selesai</span>
                                        @endif
                                    </td>

                                    <td class="text-end">

                                        <!-- DROPDOWN ACTIONS -->
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light btn-active-light-primary"
                                                data-kt-menu-trigger="click"
                                                data-kt-menu-placement="bottom-end">
                                                Actions
                                                <span class="svg-icon svg-icon-5 m-0">
																<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
																	<path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor"></path>
																</svg>
															</span>
                                            </button>

                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600
                                                        menu-state-bg-light-primary fw-semibold fs-7 w-150px py-4"
                                                 data-kt-menu="true">

                                                <div class="menu-item px-3">
                                                    <a href="javascript:void(0)"
                                                       onclick="openDetail({{ $row->id }})"
                                                       class="menu-link px-3">Detail</a>
                                                </div>

                                                <div class="menu-item px-3">
                                                    <a href="javascript:void(0)"
                                                       onclick="confirmDelete({{ $row->id }})"
                                                       class="menu-link px-3 text-danger">Hapus</a>
                                                </div>

                                            </div>
                                        </div>

                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-10">
                                        Tidak ada data pengaduan.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>

                        </table>

                        <div class="mt-5">
                            {{ $items->links() }}
                        </div>

                    </div>

                </div>

            </div>
        </div>


        <!-- MODAL DETAIL -->
        <div class="modal fade" id="modalDetailPengaduan" tabindex="-1" aria-hidden="true" wire:ignore>
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">

                    <div class="modal-header">
                        <h2 class="fw-bold">Detail Pengaduan</h2>
                        <button class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    <div class="modal-body px-7 py-5">
                        <div id="detailContainer"></div>

                        <hr class="my-5">

                        <div class="mb-3">
                            <label>Status</label>
                            <select wire:model="status" class="form-select">
                                <option value="pending">Pending</option>
                                <option value="diproses">Diproses</option>
                                <option value="selesai">Selesai</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Catatan Admin</label>
                            <textarea wire:model="catatan_admin" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="text-end">
                            <button class="btn btn-light me-3" data-bs-dismiss="modal">Tutup</button>
                            <button class="btn btn-primary" wire:click="updateStatus">Simpan Perubahan</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>




@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function openDetail(id) {
    Livewire.dispatch("viewDetail", { id:id });
}

function confirmDelete(id) {
    Swal.fire({
        title: "Hapus Pengaduan?",
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Hapus",
        cancelButtonText: "Batal",
    }).then(result => {
        if (result.isConfirmed) {
            Livewire.dispatch("confirmDelete", { id:id });
        }
    });
}


document.addEventListener('livewire:initialized', () => {

   Livewire.on('openDetailModal', ([data]) => {

        

        let photosHtml = "";

        if (data.photos?.length) {
            photosHtml = data.photos.map(p => `
                <div class="col-4 mb-4">
                    <img src="/storage/${p.file_path}"
                        class="img-fluid w-150 h-200px object-fit-cover rounded preview-foto shadow-sm border"
                        style="cursor:pointer;"
                        data-bs-toggle="modal"
                        data-bs-target="#previewModal"
                        data-src="/storage/${p.file_path}">
                </div>
            `).join('');
        } else {
            photosHtml = `<p class="text-muted">Tidak ada foto</p>`;
        }

        let html = `
            <div class="mb-5">
                <h4 class="fw-bold text-primary">${data.judul}</h4>
                <div class="text-gray-700">${data.deskripsi ?? '-'}</div>
            </div>

            <div class="row mb-3">
                <div class="col-6"><strong>Pelapor:</strong> ${data.nama_pelapor}</div>
                <div class="col-6"><strong>No HP:</strong> ${data.no_hp}</div>
            </div>

            <div class="row mb-3">
                <div class="col-6"><strong>Kategori:</strong> <span class="badge badge-light-primary">${data.kategori}</span></div>
                <div class="col-6"><strong>Lokasi:</strong> ${data.lokasi}</div>
            </div>

            <hr class="my-4">

            <h5 class="fw-bold mb-3">Dokumentasi Foto</h5>
            <div class="row">
                ${photosHtml}
            </div>
        `;

        document.getElementById("detailContainer").innerHTML = html;

        // SHOW MODAL
        new bootstrap.Modal(document.getElementById("modalDetailPengaduan")).show();
    });


    // ===== SWEETALERT SUCCESS =====
   


    // ===== PREVIEW MODAL FOTO =====
    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("preview-foto")) {
            const src = e.target.getAttribute("data-src");
            document.getElementById("previewImage").src = src;
        }
    });

});
document.addEventListener('DOMContentLoaded', function () {
        Livewire.on('showAlert', (data) => {
            Swal.fire({
                icon: data[0].type ?? 'success',
                title: data[0].message ?? '',
                timer: 2000,
                showConfirmButton: false
            });
        });
        
        Livewire.on('hideModalTambahDokumen', () => {
            let modalEl = document.getElementById('modalDetailPengaduan');
            let modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();
            if (window.dokumenTable) {
                window.dokumenTable.ajax.reload(null, false);
            }
        });

});
</script>
@endpush
