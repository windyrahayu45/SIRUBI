@include('layouts.pdf_style')
@include('layouts.pdf_header')

@php
    // ============================
    // MASTER GROUPS REKAP 3
    // ============================
    $masterGroups = [
        'Pondasi'           => DB::table('a_pondasi')->pluck('pondasi', 'id_pondasi'),
        'Kondisi Pondasi'   => DB::table('a_kondisi_pondasi')->pluck('kondisi_pondasi', 'id_kondisi_pondasi'),
        'Kondisi Sloof'     => DB::table('a_kondisi_sloof')->pluck('kondisi_sloof', 'id_kondisi_sloof'),
        'Kondisi Kolom'     => DB::table('a_kondisi_kolom_tiang')->pluck('kondisi_kolom_tiang', 'id_kondisi_kolom_tiang'),
        'Kondisi Balok'     => DB::table('a_kondisi_balok')->pluck('kondisi_balok', 'id_kondisi_balok'),
        'Struktur Atap'     => DB::table('a_kondisi_struktur_atap')->pluck('kondisi_struktur_atap', 'id_kondisi_struktur_atap'),
    ];

    // ============================
    // FLATTEN / DATAR
    // ============================
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

    // ============================
    // SPLIT PER 12 KOLOM
    // ============================
    $maxCols = 12;
    $chunks = $flatCols->chunk($maxCols);

@endphp

<h2 class="pdf-title">DATA REKAPITULASI #3 – ASPEK KESELAMATAN</h2>

@foreach ($chunks as $chunkIndex => $chunk)

    <table class="pdf-table">
        <thead>
            {{-- ============================
                 HEADER BARIS 1
            ============================= --}}
            <tr>
                <th rowspan="2">NO</th>
                <th rowspan="2">KELURAHAN</th>

                @php
                    $currentGroups = collect($chunk)->groupBy('group');
                @endphp

                @foreach ($currentGroups as $group => $cols)
                    <th colspan="{{ count($cols) }}">{{ strtoupper($group) }}</th>
                @endforeach
            </tr>

            {{-- ============================
                 HEADER BARIS 2 (LABEL)
            ============================= --}}
            <tr>
                @foreach ($chunk as $col)
                    <th>{{ $col['label'] }}</th>
                @endforeach
            </tr>
        </thead>

        <tbody>
            @foreach ($rekap3 as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $row->nama_kelurahan }}</td>

                    {{-- HANYA KOLOM DINAMIS --}}
                    @foreach ($chunk as $col)

                        @php
                            $colName = match($col['group']) {
                                'Pondasi'           => "p_"  . $col['key'],
                                'Kondisi Pondasi'   => "kp_" . $col['key'],
                                'Kondisi Sloof'     => "ks_" . $col['key'],
                                'Kondisi Kolom'     => "kk_" . $col['key'],
                                'Kondisi Balok'     => "kb_" . $col['key'],
                                'Struktur Atap'     => "ksa_". $col['key'],
                            };
                        @endphp

                        <td>{{ $row->$colName ?? 0 }}</td>

                    @endforeach
                </tr>
            @endforeach

            {{-- ============================
                ROW TOTAL
            ============================= --}}
            <tr class="total-row">
                <td></td>
                <td>TOTAL</td>

                @foreach ($chunk as $col)

                    @php
                        $colName = match($col['group']) {
                            'Pondasi'           => "p_"  . $col['key'],
                            'Kondisi Pondasi'   => "kp_" . $col['key'],
                            'Kondisi Sloof'     => "ks_" . $col['key'],
                            'Kondisi Kolom'     => "kk_" . $col['key'],
                            'Kondisi Balok'     => "kb_" . $col['key'],
                            'Struktur Atap'     => "ksa_". $col['key'],
                        };
                    @endphp

                    <td>{{ $rekap3->sum($colName) }}</td>

                @endforeach

            </tr>
        </tbody>
    </table>

    <div class="page-break"></div>

@endforeach
