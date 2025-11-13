@include('layouts.pdf_style')
@include('layouts.pdf_header')

<h2 class="pdf-title">DATA REKAPITULASI #5 – Fisik Bangunan & Kebutuhan Ruang</h2>

@foreach ($chunks as $chunkIndex => $chunk)
    @php
        // Ambil grup dalam chunk saat ini
        $grouped = collect($chunk)->groupBy('group');
    @endphp

    <table class="pdf-table mt-2">
        <thead>

            {{-- ─────────────────────────────────────────────── --}}
            {{-- ROW 1 – GROUP HEADER --}}
            {{-- ─────────────────────────────────────────────── --}}
            <tr>
                <th rowspan="2" style="width: 35px;">NO</th>
                <th rowspan="2" style="width: 120px;">KELURAHAN</th>

                @foreach ($grouped as $groupName => $cols)
                    <th colspan="{{ count($cols) }}">
                        {{ strtoupper($groupName) }}
                    </th>
                @endforeach
            </tr>

            {{-- ─────────────────────────────────────────────── --}}
            {{-- ROW 2 – COLUMN LABELS --}}
            {{-- ─────────────────────────────────────────────── --}}
            <tr>
                @foreach ($chunk as $col)
                    <th>{{ $col['label'] }}</th>
                @endforeach
            </tr>

        </thead>

        <tbody>

            {{-- ─────────────────────────────────────────────── --}}
            {{-- DATA ROWS --}}
            {{-- ─────────────────────────────────────────────── --}}
            @foreach ($data as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td style="text-align: left; padding-left: 6px;">
                        {{ $row->nama_kelurahan }}
                    </td>

                    @foreach ($chunk as $col)
                        @php
                            $colName = $col['prefix'] . $col['key'];
                            $value = $row->$colName ?? 0;
                        @endphp
                        <td>{{ number_format($value, 0, ',', '.') }}</td>
                    @endforeach
                </tr>
            @endforeach

            {{-- ─────────────────────────────────────────────── --}}
            {{-- TOTAL ROW --}}
            {{-- ─────────────────────────────────────────────── --}}
            <tr class="total-row">
                <td></td>
                <td style="font-weight: bold;">TOTAL</td>

                @foreach ($chunk as $col)
                    @php
                        $colName = $col['prefix'] . $col['key'];
                        $totalCol = $data->sum($colName);
                    @endphp
                    <td>{{ number_format($totalCol, 0, ',', '.') }}</td>
                @endforeach
            </tr>

        </tbody>
    </table>

    {{-- PAGE BREAK KECUALI HALAMAN TERAKHIR --}}
    @if(!$loop->last)
        <div class="page-break"></div>
    @endif

@endforeach
