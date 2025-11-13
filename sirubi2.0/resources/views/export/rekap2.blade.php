@include('layouts.pdf_style')
@include('layouts.pdf_header')

@php
    // Build master columns
    $masterGroups = [
        'Pendidikan Terakhir' => DB::table('i_pendidikan_terakhir')->pluck('pendidikan_terakhir', 'id_pendidikan_terakhir'),
        'Pekerjaan Utama'     => DB::table('i_pekerjaan_utama')->pluck('pekerjaan_utama', 'id_pekerjaan_utama'),
        'Penghasilan'         => DB::table('i_besar_penghasilan')->pluck('besar_penghasilan', 'id_besar_penghasilan'),
        'Pengeluaran'         => DB::table('i_besar_pengeluaran')->pluck('besar_pengeluaran', 'id_besar_pengeluaran'),
        'Status Tanah'        => DB::table('i_status_kepemilikan_tanah')->pluck('status_kepemilikan_tanah', 'id_status_kepemilikan_tanah'),
        'Bukti Tanah'         => DB::table('i_bukti_kepemilikan_tanah')->pluck('bukti_kepemilikan_tanah', 'id_bukti_kepemilikan_tanah'),
        'Status Rumah'        => DB::table('i_status_kepemilikan_rumah')->pluck('status_kepemilikan_rumah', 'id_status_kepemilikan_rumah'),
        'IMB'                 => DB::table('i_status_imb')->pluck('status_imb', 'id_status_imb'),
        'Aset Rumah'          => DB::table('i_aset_rumah_tempat_lain')->pluck('aset_rumah_tempat_lain', 'id_aset_rumah_tempat_lain'),
        'Aset Tanah'          => DB::table('i_aset_tanah_tempat_lain')->pluck('aset_tanah_tempat_lain', 'id_aset_tanah_tempat_lain'),
        'Bantuan'             => DB::table('i_pernah_mendapatkan_bantuan')->pluck('pernah_mendapatkan_bantuan', 'id_pernah_mendapatkan_bantuan'),
        'Kawasan'             => DB::table('i_jenis_kawasan_lokasi')->pluck('jenis_kawasan_lokasi', 'id_jenis_kawasan_lokasi'),
    ];

    // Flatten semua kolom dinamis
    $flatCols = collect([]);
    foreach ($masterGroups as $group => $cols) {
        foreach ($cols as $key => $label) {
            $flatCols->push([
                'group' => $group,
                'key'   => $key,
                'label' => $label
            ]);
        }
    }

    // Max kolom per halaman (selain NO dan Kelurahan)
    $maxCols = 12;
    $chunks = $flatCols->chunk($maxCols);

    // Total utama
    $sum = [
        'l' => $rekap2->sum('jumlah_laki'),
        'p' => $rekap2->sum('jumlah_perempuan'),
        'abk' => $rekap2->sum('jumlah_abk'),
        'u1' => $rekap2->sum('usia_1'),
        'u2' => $rekap2->sum('usia_2'),
        'u3' => $rekap2->sum('usia_3'),
        'u4' => $rekap2->sum('usia_4'),
    ];
@endphp

<h2 class="pdf-title">DATA REKAPITULASI #2 – IDENTITAS PENGHUNI RUMAH</h2>

@foreach ($chunks as $chunkIndex => $chunk)

    <table class="pdf-table">
        <thead>
            {{-- ROW 1 --}}
            <tr>
                <th rowspan="2">NO</th>
                <th rowspan="2">KELURAHAN</th>

                {{-- Only dynamic groups --}}
                @php
                    $currentGroups = collect($chunk)->groupBy('group');
                @endphp

                @foreach ($currentGroups as $group => $cols)
                    <th colspan="{{ count($cols) }}">{{ strtoupper($group) }}</th>
                @endforeach
            </tr>

            {{-- ROW 2 --}}
            <tr>
                @foreach ($chunk as $col)
                    <th>{{ $col['label'] }}</th>
                @endforeach
            </tr>
        </thead>

        <tbody>
            @foreach ($rekap2 as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $row->nama_kelurahan }}</td>

                    {{-- render dynamic only --}}
                    @foreach ($chunk as $col)
                        @php
                            $colName = match($col['group']) {
                                'Pendidikan Terakhir' => "pt_" . $col['key'],
                                'Pekerjaan Utama'     => "pu_" . $col['key'],
                                'Penghasilan'         => "penghasilan_" . $col['key'],
                                'Pengeluaran'         => "pengeluaran_" . $col['key'],
                                'Status Tanah'        => "status_tanah_" . $col['key'],
                                'Bukti Tanah'         => "bukti_tanah_" . $col['key'],
                                'Status Rumah'        => "status_rumah_" . $col['key'],
                                'IMB'                 => "imb_" . $col['key'],
                                'Aset Rumah'          => "aset_rumah_" . $col['key'],
                                'Aset Tanah'          => "aset_tanah_" . $col['key'],
                                'Bantuan'             => "bantuan_" . $col['key'],
                                'Kawasan'             => "kawasan_" . $col['key'],
                            };
                        @endphp
                        <td>{{ $row->$colName ?? 0 }}</td>
                    @endforeach

                </tr>
            @endforeach

            {{-- ROW TOTAL --}}
            <tr class="total-row">
                <td></td>
                <td>TOTAL</td>

                @foreach ($chunk as $col)
                    @php
                        $colName = match($col['group']) {
                            'Pendidikan Terakhir' => "pt_" . $col['key'],
                            'Pekerjaan Utama'     => "pu_" . $col['key'],
                            'Penghasilan'         => "penghasilan_" . $col['key'],
                            'Pengeluaran'         => "pengeluaran_" . $col['key'],
                            'Status Tanah'        => "status_tanah_" . $col['key'],
                            'Bukti Tanah'         => "bukti_tanah_" . $col['key'],
                            'Status Rumah'        => "status_rumah_" . $col['key'],
                            'IMB'                 => "imb_" . $col['key'],
                            'Aset Rumah'          => "aset_rumah_" . $col['key'],
                            'Aset Tanah'          => "aset_tanah_" . $col['key'],
                            'Bantuan'             => "bantuan_" . $col['key'],
                            'Kawasan'             => "kawasan_" . $col['key'],
                        };
                    @endphp
                    <td>{{ $rekap2->sum($colName) }}</td>
                @endforeach
            </tr>
        </tbody>
    </table>

    <div class="page-break"></div>

@endforeach
