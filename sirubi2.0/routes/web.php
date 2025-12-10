<?php

use App\Http\Controllers\CetakController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RekapExportController;
use App\Livewire\Admin\Pengaduan as AdminPengaduan;
use App\Livewire\Bantuan;
use App\Livewire\Bantuan\Show as BantuanShow;
use App\Livewire\Dashboard;
use App\Livewire\Data;
use App\Livewire\Dokumentasi;
use App\Livewire\Home;
use App\Livewire\Pengaduan as LivewirePengaduan;
use App\Livewire\Peta;
use App\Livewire\Polygon;
use App\Livewire\Polygon\Add as PolygonAdd;
use App\Livewire\Question\Daftar;
use App\Livewire\Rekap;
use App\Livewire\Rumah\Add;
use App\Livewire\Rumah\Edit;
use App\Livewire\Rumah\Filter;
use App\Livewire\Rumah\Show;
use App\Livewire\Setting;
use App\Livewire\Users;
use App\Models\Pengaduan;
use App\Models\Rumah;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return redirect()->route('login');
// });

Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

Route::middleware('log.visitor')->group(function () {
   Route::get('/', Home::class)->name('home');
    // route lain yang ingin dicatat visitor
});

Route::get('/download-export/{timestamp}', function ($timestamp) {
    $filename = "export_data_{$timestamp}.zip";
    $filepath = storage_path("app/public/{$filename}");
    
    if (file_exists($filepath)) {
        return response()->download($filepath)
            ->deleteFileAfterSend(true);
    }
    
    abort(404, 'File export tidak ditemukan');
})->name('download.export');


Route::get('/add-test', Add::class)->name('add.test');
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
    
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/data', Data::class)->name('data');
    Route::get('/peta', Peta::class)->name('peta');
    Route::get('/rekap', Rekap::class)->name('rekap');
    Route::get('/pengaduan', LivewirePengaduan::class)->name('pengaduan');
    Route::get('/bantuan', Bantuan::class)->name('bantuan');
    Route::get('/polygon', Polygon::class)->name('polygon');
    Route::get('/dokumentasi', Dokumentasi::class)->name('dokumentasi');
    Route::get('/users', Users::class)->name('users');
    Route::get('/pertanyaan', Daftar::class)->name('pertanyaan');
    Route::get('/setting', Setting::class)->name('setting');
    Route::get('/datatable/rumah', [Data::class, 'getData'])->name('livewire.datatables.rumah');
    Route::get('/datatable/bantuan', [Bantuan::class, 'getData'])->name('livewire.datatables.bantuan');
    Route::get('/datatable/polygon', [Polygon::class, 'getData'])->name('livewire.datatables.polygon');
    Route::get('/datatable/dokumentasi', [Dokumentasi::class, 'getData'])->name('livewire.datatables.dokumentasi');
    Route::get('/datatable/question', [Daftar::class, 'getData'])->name('livewire.datatables.question');
    Route::get('/datatable/user', [Users::class, 'getData'])->name('livewire.datatables.user');
    Route::get('/master', \App\Livewire\MasterCrud::class)->name('master.crud');

    Route::get('/datatable/rumah/detail/{id}', function ($id) {
        $rumah = Rumah::with([
            'kepemilikan','sosialEkonomi','fisik','sanitasi','penilaian','bantuan','dokumen',
            'kepalaKeluarga.anggota','kelurahan.kecamatan'
        ])->findOrFail($id);

        return view('livewire.partials.detail-row', compact('rumah'))->render();
    })->name('datatable.rumah.detail');

    Route::get('/rumah/{id}', Show::class)->name('rumah.show');
    Route::get('/bantuan/{id}', BantuanShow::class)->name('bantuan.show');
// halaman edit rumah
    Route::get('/rumah/{id}/edit', Edit::class)->name('rumah.edit');

    Route::get('/rumah-add', Add::class)->name('rumah.add');
    Route::get('/polygon-add', PolygonAdd::class)->name('polygon.add');
    Route::get('/polygon/edit/{id}', \App\Livewire\Polygon\Add::class)->name('polygon.edit');

     Route::get('/rumah-filter', Filter::class)->name('rumah.filter');

    Route::get('/rumah/{id}/pdf', [CetakController::class, 'cetak'])->name('rumah.pdf');

    Route::get('/api/kelurahan-by-kecamatan', [CetakController::class, 'getKelurahan'])
    ->name('api.kelurahan-by-kecamatan');

    Route::get('/rekap/export/all-excel/{kecamatan}', 
    [RekapExportController::class, 'exportAllExcel']
    )->name('rekap.export.all.excel');

    Route::get('/rekap/export/all-pdf/{kecamatan}', 
        [RekapExportController::class, 'exportAllPdf']
    )->name('rekap.export.all.pdf');

 

    Route::get('/download-geojson/{filename}', function ($filename) {
        $path = storage_path("app/public/$filename");

        if (!file_exists($path)) {
            abort(404, 'File not found');
        }

        return response()->download($path)->deleteFileAfterSend(true);
    })->name('geojson.download');







});
require __DIR__.'/auth.php';
