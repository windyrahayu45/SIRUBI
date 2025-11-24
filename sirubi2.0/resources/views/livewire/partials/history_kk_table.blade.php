<div class="mb-3">
    <h6 class="fw-bold">{{ $label }}</h6>

    @if(!$data)
        <span class="text-muted">Tidak ada data</span>
    @else

        {{-- ===== TABEL KK ===== --}}
        <table class="table table-sm table-bordered w-auto">
            <tr>
                <th>Kode KK</th>
                <td>{{ $data['kode_kk'] }}</td>
            </tr>
            <tr>
                <th>No KK</th>
                <td>{{ $data['no_kk'] }}</td>
            </tr>
        </table>

        {{-- ===== TABEL ANGGOTA ===== --}}
        <h6 class="fw-bold mt-3">Anggota</h6>
        <table class="table table-sm table-bordered">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama</th>
                    <th>NIK</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['anggota'] as $a)
                    <tr>
                        <td>{{ $a['kode_anggota'] }}</td>
                        <td>{{ $a['nama'] }}</td>
                        <td>{{ $a['nik'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @endif
</div>
