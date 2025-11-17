<div class="w-full overflow-x-auto rounded-xl shadow-lg border border-gray-700 bg-gray-900 mb-10">
    <table class="min-w-[1200px] w-full text-sm text-gray-200">

        {{-- HEADER UTAMA --}}
        <thead>
            <tr>
                <th colspan="15"
                    class="px-4 py-4 text-center text-lg font-bold uppercase tracking-wide bg-gray-800 border-b border-gray-700">
                    DATA UMUM RUMAH
                </th>
            </tr>

            {{-- HEADER LEVEL 1 --}}
            <tr class="bg-gray-900 text-gray-200 border-b border-gray-700 text-[13px]">
                <th rowspan="2" class="px-4 py-3 border border-gray-700">No</th>
                <th rowspan="2" class="px-4 py-3 border border-gray-700">Kelurahan</th>

                <th colspan="3" class="px-4 py-3 border border-gray-700">Jumlah</th>
                <th colspan="2" class="px-4 py-3 border border-gray-700">Kelayakan</th>
                <th colspan="2" class="px-4 py-3 border border-gray-700">Backlog</th>
                <th colspan="2" class="px-4 py-3 border border-gray-700">Aspek Keselamatan</th>
                <th colspan="2" class="px-4 py-3 border border-gray-700">Aspek Kesehatan</th>
                <th colspan="2" class="px-4 py-3 border border-gray-700">Komponen Bangunan</th>
            </tr>

            {{-- HEADER LEVEL 2 --}}
            <tr class="bg-gray-900 text-gray-300 border-b border-gray-700 text-[12px]">
                <th class="px-4 py-2 border border-gray-700">Rumah</th>
                <th class="px-4 py-2 border border-gray-700">KK</th>
                <th class="px-4 py-2 border border-gray-700">Penduduk</th>

                <th class="px-4 py-2 border border-gray-700">RLH</th>
                <th class="px-4 py-2 border border-gray-700">RTLH</th>

                <th class="px-4 py-2 border border-gray-700">Iya</th>
                <th class="px-4 py-2 border border-gray-700">Tidak</th>

                <th class="px-4 py-2 border border-gray-700">Prioritas</th>
                <th class="px-4 py-2 border border-gray-700">Tidak</th>

                <th class="px-4 py-2 border border-gray-700">Prioritas</th>
                <th class="px-4 py-2 border border-gray-700">Tidak</th>

                <th class="px-4 py-2 border border-gray-700">Prioritas</th>
                <th class="px-4 py-2 border border-gray-700">Tidak</th>
            </tr>
        </thead>

        {{-- BODY --}}
        <tbody>
            @php
                $no = 1;
                $total = [
                    'jumlah_rumah' => 0, 'jumlah_kk' => 0, 'penduduk' => 0,
                    'rlh' => 0, 'rtlh' => 0, 'kk_lebih_1' => 0, 'kk_1' => 0,
                    'prioritas_a1' => 0, 'prioritas_a2' => 0,
                    'prioritas_b1' => 0, 'prioritas_b2' => 0,
                    'prioritas_c1' => 0, 'prioritas_c2' => 0,
                ];
            @endphp

            @foreach($rekap1 as $a)
                @php
                    $penduduk = $a['penghuni_laki'] + $a['penghuni_perempuan'];

                    foreach ($total as $k => $v) {
                        if (isset($a[$k])) $total[$k] += $a[$k];
                    }
                    $total['penduduk'] += $penduduk;
                @endphp

                <tr class="hover:bg-gray-800 transition border-b border-gray-800">
                    <td class="px-4 py-2 text-center border border-gray-700">{{ $no++ }}</td>

                    <td class="px-4 py-2 border border-gray-700 text-left font-semibold text-gray-100">
                        {{ $a['nama_kelurahan'] }}
                    </td>

                    <td class="px-4 py-2 text-center border border-gray-700">{{ number_format($a['jumlah_rumah']) }}</td>
                    <td class="px-4 py-2 text-center border border-gray-700">{{ number_format($a['jumlah_kk']) }}</td>
                    <td class="px-4 py-2 text-center border border-gray-700">{{ number_format($penduduk) }}</td>

                    <td class="px-4 py-2 text-center text-green-400 border border-gray-700">{{ number_format($a['rlh']) }}</td>
                    <td class="px-4 py-2 text-center text-red-400 border border-gray-700">{{ number_format($a['rtlh']) }}</td>

                    <td class="px-4 py-2 text-center border border-gray-700">{{ number_format($a['kk_lebih_1']) }}</td>
                    <td class="px-4 py-2 text-center border border-gray-700">{{ number_format($a['kk_1']) }}</td>

                    <td class="px-4 py-2 text-center border border-gray-700">{{ number_format($a['prioritas_a1']) }}</td>
                    <td class="px-4 py-2 text-center border border-gray-700">{{ number_format($a['prioritas_a2']) }}</td>

                    <td class="px-4 py-2 text-center border border-gray-700">{{ number_format($a['prioritas_b1']) }}</td>
                    <td class="px-4 py-2 text-center border border-gray-700">{{ number_format($a['prioritas_b2']) }}</td>

                    <td class="px-4 py-2 text-center border border-gray-700">{{ number_format($a['prioritas_c1']) }}</td>
                    <td class="px-4 py-2 text-center border border-gray-700">{{ number_format($a['prioritas_c2']) }}</td>
                </tr>
            @endforeach
        </tbody>

        {{-- FOOTER TOTAL --}}
        <tfoot class="bg-gray-800 text-gray-100 font-semibold">
            <tr>
                <td colspan="2" class="px-4 py-2 text-center border border-gray-700">TOTAL</td>

                <td class="px-4 py-2 text-center border border-gray-700">{{ number_format($total['jumlah_rumah']) }}</td>
                <td class="px-4 py-2 text-center border border-gray-700">{{ number_format($total['jumlah_kk']) }}</td>
                <td class="px-4 py-2 text-center border border-gray-700">{{ number_format($total['penduduk']) }}</td>

                <td class="px-4 py-2 text-center border border-gray-700">{{ number_format($total['rlh']) }}</td>
                <td class="px-4 py-2 text-center text-red-400 border border-gray-700">{{ number_format($total['rtlh']) }}</td>

                <td class="px-4 py-2 text-center border border-gray-700">{{ number_format($total['kk_lebih_1']) }}</td>
                <td class="px-4 py-2 text-center border border-gray-700">{{ number_format($total['kk_1']) }}</td>

                <td class="px-4 py-2 text-center border border-gray-700">{{ number_format($total['prioritas_a1']) }}</td>
                <td class="px-4 py-2 text-center border border-gray-700">{{ number_format($total['prioritas_a2']) }}</td>

                <td class="px-4 py-2 text-center border border-gray-700">{{ number_format($total['prioritas_b1']) }}</td>
                <td class="px-4 py-2 text-center border border-gray-700">{{ number_format($total['prioritas_b2']) }}</td>

                <td class="px-4 py-2 text-center border border-gray-700">{{ number_format($total['prioritas_c1']) }}</td>
                <td class="px-4 py-2 text-center border border-gray-700">{{ number_format($total['prioritas_c2']) }}</td>
            </tr>
        </tfoot>

    </table>
</div>
