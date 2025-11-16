@include('layouts.pdf_style')
@include('layouts.pdf_header')

@php
    $total = [
        'jumlah_rumah' => $rekap1->sum('jumlah_rumah'),
        'jumlah_kk' => $rekap1->sum('jumlah_kk'),
        'penduduk' => $rekap1->sum(fn($r) => $r['penghuni_laki'] + $r['penghuni_perempuan']),
        'rlh' => $rekap1->sum('rlh'),
        'rtlh' => $rekap1->sum('rtlh'),
        'kk_lebih_1' => $rekap1->sum('kk_lebih_1'),
        'kk_1' => $rekap1->sum('kk_1'),
        'prioritas_a1' => $rekap1->sum('prioritas_a1'),
        'prioritas_a2' => $rekap1->sum('prioritas_a2'),
        'prioritas_b1' => $rekap1->sum('prioritas_b1'),
        'prioritas_b2' => $rekap1->sum('prioritas_b2'),
        'prioritas_c1' => $rekap1->sum('prioritas_c1'),
        'prioritas_c2' => $rekap1->sum('prioritas_c2'),
    ];
@endphp

<h2 class="pdf-title">DATA REKAPITULASI #1 – DATA UMUM RUMAH</h2>
<table class="pdf-table">
    <thead>
        <tr>
            <th rowspan="2">NO</th>
            <th rowspan="2">KELURAHAN</th>

            <th colspan="3">JUMLAH</th>
            <th colspan="2">KELAYAKAN</th>
            <th colspan="2">BACKLOG</th>
            <th colspan="2">ASPEK KESELAMATAN</th>
            <th colspan="2">ASPEK KESEHATAN</th>
            <th colspan="2">ASPEK KOMPONEN</th>
        </tr>
        <tr>
            <th>Rumah</th>
            <th>KK</th>
            <th>Penduduk</th>
            <th>RLH</th>
            <th>RTLH</th>
            <th>Iya</th>
            <th>Tidak</th>
            <th>Prioritas</th>
            <th>Tidak</th>
            <th>Prioritas</th>
            <th>Tidak</th>
            <th>Prioritas</th>
            <th>Tidak</th>
        </tr>
    </thead>

    <tbody>
        @php $no = 1; @endphp

        @foreach($rekap1 as $r)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $r['nama_kelurahan'] }}</td>

            <td>{{ $r['jumlah_rumah'] }}</td>
            <td>{{ $r['jumlah_kk'] }}</td>
            <td>{{ $r['penghuni_laki'] + $r['penghuni_perempuan'] }}</td>

            <td>{{ $r['rlh'] }}</td>
            <td>{{ $r['rtlh'] }}</td>

            <td>{{ $r['kk_lebih_1'] }}</td>
            <td>{{ $r['kk_1'] }}</td>

            <td>{{ $r['prioritas_a1'] }}</td>
            <td>{{ $r['prioritas_a2'] }}</td>

            <td>{{ $r['prioritas_b1'] }}</td>
            <td>{{ $r['prioritas_b2'] }}</td>

            <td>{{ $r['prioritas_c1'] }}</td>
            <td>{{ $r['prioritas_c2'] }}</td>
        </tr>
        @endforeach

        <tr class="total-row">
            <td></td>
            <td>TOTAL</td>

            <td>{{ $total['jumlah_rumah'] }}</td>
            <td>{{ $total['jumlah_kk'] }}</td>
            <td>{{ $total['penduduk'] }}</td>

            <td>{{ $total['rlh'] }}</td>
            <td>{{ $total['rtlh'] }}</td>

            <td>{{ $total['kk_lebih_1'] }}</td>
            <td>{{ $total['kk_1'] }}</td>

            <td>{{ $total['prioritas_a1'] }}</td>
            <td>{{ $total['prioritas_a2'] }}</td>

            <td>{{ $total['prioritas_b1'] }}</td>
            <td>{{ $total['prioritas_b2'] }}</td>

            <td>{{ $total['prioritas_c1'] }}</td>
            <td>{{ $total['prioritas_c2'] }}</td>
        </tr>
    </tbody>
</table>
