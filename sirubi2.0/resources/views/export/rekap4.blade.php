@include('layouts.pdf_style')
@include('layouts.pdf_header')

<h2 class="pdf-title">DATA REKAPITULASI #4 – ASPEK KESEHATAN</h2>

@foreach ($chunks as $chunkIndex => $chunk)

    @php
        // Ambil group pada chunk ini
        $currentGroups = collect($chunk)->groupBy('group');
    @endphp

    <table class="pdf-table">

        <thead>
            {{-- ROW 1: GROUP TITLE --}}
            <tr>
                <th rowspan="2">NO</th>
                <th rowspan="2">KELURAHAN</th>

                @foreach ($currentGroups as $group => $cols)
                    <th colspan="{{ count($cols) }}">{{ strtoupper($group) }}</th>
                @endforeach
            </tr>

            {{-- ROW 2: SUBHEADER --}}
            <tr>
                @foreach ($chunk as $col)
                    <th>{{ $col['label'] }}</th>
                @endforeach
            </tr>
        </thead>

        <tbody>

            @foreach ($rekap4 as $i => $row)
                <tr>
                    <td>{{ $i+1 }}</td>
                    <td>{{ $row->nama_kelurahan }}</td>

                    @foreach ($chunk as $col)
                        @php
                            // Tentukan nama kolom dari group
                            $colName = match ($col['group']) {
                                'Jendela'               => "a_"  . $col['key'],
                                'Kondisi Jendela'       => "b_"  . $col['key'],

                                'Ventilasi'             => "c_"  . $col['key'],
                                'Kondisi Ventilasi'     => "d_"  . $col['key'],

                                'Kamar Mandi'           => "e_"  . $col['key'],
                                'Kondisi KM'            => "f_"  . $col['key'],

                                'Jamban'                => "g_"  . $col['key'],
                                'Kondisi Jamban'        => "h_"  . $col['key'],

                                'SPAL'                  => "i_"  . $col['key'],
                                'Kondisi SPAL'          => "j_"  . $col['key'],

                                'Frekuensi Sedot'       => "ia_" . $col['key'],

                                'Air Minum'             => "k_"  . $col['key'],
                                'Kondisi Air'           => "ka_" . $col['key'],

                                'Listrik'               => "l_"  . $col['key'],
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
                        $colName = match ($col['group']) {
                            'Jendela'               => "a_"  . $col['key'],
                            'Kondisi Jendela'       => "b_"  . $col['key'],

                            'Ventilasi'             => "c_"  . $col['key'],
                            'Kondisi Ventilasi'     => "d_"  . $col['key'],

                            'Kamar Mandi'           => "e_"  . $col['key'],
                            'Kondisi KM'            => "f_"  . $col['key'],

                            'Jamban'                => "g_"  . $col['key'],
                            'Kondisi Jamban'        => "h_"  . $col['key'],

                            'SPAL'                  => "i_"  . $col['key'],
                            'Kondisi SPAL'          => "j_"  . $col['key'],

                            'Frekuensi Sedot'       => "ia_" . $col['key'],

                            'Air Minum'             => "k_"  . $col['key'],
                            'Kondisi Air'           => "ka_" . $col['key'],

                            'Listrik'               => "l_"  . $col['key'],
                        };
                    @endphp
                    <td>{{ $rekap4->sum($colName) }}</td>
                @endforeach
            </tr>

        </tbody>

    </table>

    {{-- Page Break per chunk --}}
    <div class="page-break"></div>

@endforeach
