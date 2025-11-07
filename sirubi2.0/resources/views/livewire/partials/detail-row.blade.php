<div class="p-5 bg-light rounded">
    <div class="row g-4">

        {{-- 🏠 Foto Rumah --}}
        <div class="col-lg-6 col-md-6 text-center">
            <h6 class="fw-bold mb-3">Foto Rumah</h6>
            @if($rumah->dokumen && $rumah->dokumen->foto_rumah_satu)
                <img src="{{ asset('storage/' . $rumah->dokumen->foto_rumah_satu) }}"
                    class="img-fluid rounded shadow-sm mb-2 preview-foto"
                    style="max-height: 180px; object-fit: cover; cursor: pointer;"
                    data-bs-toggle="modal"
                    data-bs-target="#previewModal"
                    data-src="{{ asset('storage/' . $rumah->dokumen->foto_rumah_satu) }}">
            @else
                <span class="text-muted">Foto rumah belum diunggah.</span>
            @endif
        </div>


        {{-- 💰 Data Sosial Ekonomi --}}
        <div class="col-lg-6 col-md-6">
            <h6 class="fw-bold mb-3"> Sosial Ekonomi</h6>
            @if($rumah->sosialEkonomi)
                <table class="table table-sm table-borderless mb-0">
                    <tr><td>Jumlah KK</td><td>: {{ $rumah->sosialEkonomi->jumlahKK->jumlah_kk ?? '-' }}</td></tr>
                    <tr><td>Pekerjaan Utama</td><td>: {{ $rumah->sosialEkonomi->pekerjaanUtama->pekerjaan_utama ?? '-' }}</td></tr>
                    <tr><td>Penghasilan</td><td>: {{ $rumah->sosialEkonomi->besarPenghasilan->besar_penghasilan ?? '-' }}</td></tr>
                </table>
            @else
                <span class="text-muted">Belum ada data sosial ekonomi.</span>
            @endif
        </div>

        {{-- 🧮 Penilaian Rumah --}}
        <div class="col-lg-6 col-md-6">
            <h6 class="fw-bold mb-3"> Penilaian Rumah</h6>
            @if($rumah->penilaian)
                <table class="table table-sm table-borderless mb-0">
                    <tr><td>Nilai Keselamatan</td><td>: {{ $rumah->penilaian->nilai_a ?? '-' }}</td></tr>
                    <tr><td>Nilai Kesehatan</td><td>: {{ $rumah->penilaian->nilai_b ?? '-' }}</td></tr>
                    <tr><td>Nilai Komponen dan Bahan Bangunan</td><td>: {{ $rumah->penilaian->nilai_c ?? '-' }}</td></tr>
                    <tr><td>Total</td><td>: {{ $rumah->penilaian->nilai ?? '-' }}</td></tr>
                    <tr>
                        <td>Status</td>
                        <td>:
                            @php $status = strtoupper($rumah->penilaian->status_rumah ?? '-'); @endphp
                            @if($status === 'RTLH')
                                <span class="badge badge-light-danger fw-bold px-3 py-2">{{ $status }}</span>
                            @elseif($status !== '-' && $status !== '')
                                <span class="badge badge-light-success fw-bold px-3 py-2">{{ $status }}</span>
                            @else
                                <span class="badge badge-light-info fw-bold px-3 py-2">-</span>
                            @endif
                        </td>
                    </tr>

                </table>
            @else
                <span class="text-muted">Belum ada data penilaian.</span>
            @endif
        </div>

        {{-- 🏡 Kepemilikan & Bantuan Rumah --}}
        <div class="col-lg-6 col-md-6">
            <h6 class="fw-bold mb-3"> Kepemilikan &  Bantuan</h6>
            @if($rumah->kepemilikan)
                <table class="table table-sm table-borderless mb-0">
                    <tr><td>Status Tanah</td><td>: {{ $rumah->kepemilikan->statusKepemilikanTanah->status_kepemilikan_tanah ?? '-' }}</td></tr>
                    <tr><td>Bukti</td><td>: {{ $rumah->kepemilikan->buktiKepemilikanTanah->bukti_kepemilikan_tanah ?? '-' }}</td></tr>
                    <tr><td>Status Rumah</td><td>: {{ $rumah->kepemilikan->statusKepemilikanRumah->status_kepemilikan_rumah ?? '-' }}</td></tr>
                    <tr><td>Status IMB</td><td>: {{ $rumah->kepemilikan->statusImb->status_imb ?? '-' }}</td></tr>
                </table>
            @else
                <span class="text-muted">Belum ada data kepemilikan.</span>
            @endif

            <hr class="my-2">

            @if($rumah->bantuan)
                <table class="table table-sm table-borderless mb-0">
                    <tr><td>Pernah Dapat</td><td>: {{ $rumah->bantuan->pernahMendapatkanBantuan->pernah_mendapatkan_bantuan ?? '-' }}</td></tr>
                    <tr><td>Nama Bantuan</td><td>: {{ $rumah->bantuan->nama_bantuan ?? '-' }}</td></tr>
                    <tr><td>Tahun</td><td>: {{ $rumah->bantuan->tahun_bantuan ?? '-' }}</td></tr>
                </table>
            @else
                <span class="text-muted">Belum ada data bantuan.</span>
            @endif
        </div>

    </div>
</div>
