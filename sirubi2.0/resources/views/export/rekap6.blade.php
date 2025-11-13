@include('layouts.pdf_style')
@include('layouts.pdf_header')

<h2 class="pdf-title">DATA REKAPITULASI #6 – Komponen Material & Kondisi Bangunan</h2>

@foreach ($chunks as $chunkIndex => $chunk)

    @php
        $grouped = collect($chunk)->groupBy('group');
    @endphp

    <table class="pdf-table mt-2">
        <thead>

            {{-- GROUP HEADER --}}
            <tr>
                <th rowspan="2" style="width:35px;">NO</th>
                <th rowspan="2" style="width:140px;">KELURAHAN</th>

                @foreach ($grouped as $groupName => $cols)
                    <th colspan="{{ count($cols) }}">{{ strtoupper($groupName) }}</th>
                @endforeach
            </tr>

            {{-- SUB HEADER --}}
            <tr>
                @foreach ($chunk as $col)
                    <th>{{ $col['label'] }}</th>
                @endforeach
            </tr>
        </thead>

        <tbody>

            {{-- DATA --}}
            @foreach ($data as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td style="text-align:left; padding-left:6px;">{{ $row->nama_kelurahan }}</td>

                    @foreach ($chunk as $col)
                        @php
                            $colName = $col['prefix'].$col['key'];
                        @endphp
                        <td>{{ number_format($row->$colName ?? 0, 0, ',', '.') }}</td>
                    @endforeach
                </tr>
            @endforeach

            {{-- TOTAL --}}
            <tr class="total-row">
                <td></td>
                <td>TOTAL</td>

                @foreach ($chunk as $col)
                    @php
                        $colName = $col['prefix'].$col['key'];
                        $totalCol = $data->sum($colName);
                    @endphp
                    <td>{{ number_format($totalCol, 0, ',', '.') }}</td>
                @endforeach
            </tr>
        </tbody>
    </table>

    @if(!$loop->last)
        <div class="page-break"></div>
    @endif

@endforeach
