
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Data Rumah – {{ $namaPemilik ?? 'Tanpa Nama' }}</title>
<style>
    @page { margin: 25px 30px; }
    body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #000; }
    h2 { text-align: center; text-transform: uppercase; margin-bottom: 5px; }
    h4 { text-align: center; margin-top: 0; font-weight: normal; }
    .header { text-align: center; margin-bottom: 20px; }
    .header img { width: 70px; margin-bottom: 5px; }
    .section-title { background:#f2f2f2; padding:5px 8px; font-weight:bold; margin-top:12px; }
    table { width:100%; border-collapse: collapse; margin-top:6px; }
    th, td { border:1px solid #777; padding:4px; vertical-align:top; }
    .text-center { text-align:center; }
    .fw-bold { font-weight:bold; }
    .mt-2 { margin-top:8px; }
    .img-fluid { max-width:100%; height:auto; border-radius:6px; }
    .badge { display:inline-block; padding:2px 6px; border-radius:4px; font-size:9px; }
    .bg-success { background:#d1e7dd; }
    .bg-danger { background:#f8d7da; }
    .bg-warning { background:#fff3cd; }
</style>
</head>
<body>

{{-- HEADER --}}
<!-- Header PDF: Pemerintah Kota Bukittinggi -->
<!-- Header PDF: Pemerintah Kota Bukittinggi -->
<div class="header" style="text-align: center; margin-bottom: 10px;">
    <table width="100%" style="border: none; border-collapse: collapse;">
        <tr>
            <td width="15%" style="text-align: right; vertical-align: middle; border: none;">
                <img src="{{ public_path('assets/media/logos/logo.png') }}" alt="Logo" width="80">
            </td>
            <td width="85%" style="text-align: center; vertical-align: middle; border: none;">
                <div style="line-height: 1.3;">
                    <h3 style="margin: 0; font-size: 16px;">PEMERINTAH KOTA BUKITTINGGI</h3>
                    <h2 style="margin: 0; font-size: 18px;">DINAS PERUMAHAN DAN KAWASAN PERMUKIMAN</h2>
                    <p style="margin: 0; font-size: 12px;">
                        Jalan Soekarno Hatta No. 45, Bukittinggi – Sumatera Barat<br>
                        Telp. (0752) 123456 – Kode Pos 26115
                    </p>
                </div>
            </td>
            
        </tr>
    </table>

    <div style="height: 1px; background-color: #000; margin: 6px 0;"></div>
    <h3 style="margin: 0; font-size: 16px;">DATA RUMAH a.n  {{ strtoupper($namaPemilik ?? 'Nama Anggota KK 1') }}</h3>
   
</div>



{{-- ================== KONTEN =================== --}}
<div id="kt_app_content" class="app-content flex-column-fluid">
 
    @include('pdf.rumah-content', [
         'rumah' => $rumah,
        'namaPemilik' => $namaPemilik,
        'bantuanRiwayat' => $bantuanRiwayat,

        // Ini WAJIB
        'pertanyaanLokasi'        => $pertanyaanLokasi,
        'pertanyaanKk'            => $pertanyaanKk,
        'pertanyaanIdentitas'     => $pertanyaanIdentitas,
        'pertanyaanKeselamatan'   => $pertanyaanKeselamatan,
        'pertanyaanKesehatan'     => $pertanyaanKesehatan,
        'pertanyaanLuasBangunan'  => $pertanyaanLuasBangunan,
        'pertanyaanBahanBangunan' => $pertanyaanBahanBangunan,
        'pertanyaanDokumentasi'   => $pertanyaanDokumentasi,
        'pertanyaanLainnya'       => $pertanyaanLainnya,

        'childQuestions'          => $childQuestions,
        'questionAnswers'         => $questionAnswers,
        'displayAnswer'               => $displayAnswer ?? null,
    ])
</div>

{{-- FOOTER --}}
<div style="margin-top:40px; text-align:right; font-size:10px;">
    Dicetak pada {{ now()->format('d M Y H:i') }}
</div>
</body>
</html>
