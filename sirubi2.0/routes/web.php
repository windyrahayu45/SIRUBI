<?php

use App\Http\Controllers\CetakController;
use App\Http\Controllers\DashboardController;
use App\Livewire\Dashboard;
use App\Livewire\Data;
use App\Livewire\Rumah\Add;
use App\Livewire\Rumah\Edit;
use App\Livewire\Rumah\Show;
use App\Models\Rumah;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');
Route::get('/test', function() {
    return 'Route OK';
});


Route::get('/add-test', Add::class)->name('add.test');
Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
    
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/data', Data::class)->name('data');
    Route::get('/datatable/rumah', [Data::class, 'getData'])->name('livewire.datatables.rumah');

    Route::get('/datatable/rumah/detail/{id}', function ($id) {
        $rumah = Rumah::with([
            'kepemilikan','sosialEkonomi','fisik','sanitasi','penilaian','bantuan','dokumen',
            'kepalaKeluarga.anggota','kelurahan.kecamatan'
        ])->findOrFail($id);

        return view('livewire.partials.detail-row', compact('rumah'))->render();
    })->name('datatable.rumah.detail');

    Route::get('/rumah/{id}', Show::class)->name('rumah.show');

// halaman edit rumah
    Route::get('/rumah/{id}/edit', Edit::class)->name('rumah.edit');

   Route::get('/rumah-add', Add::class)->name('rumah.add');

    Route::get('/rumah/{id}/pdf', [CetakController::class, 'cetak'])->name('rumah.pdf');




});
require __DIR__.'/auth.php';
