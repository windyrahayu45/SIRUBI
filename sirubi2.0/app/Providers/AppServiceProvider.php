<?php

namespace App\Providers;

use App\Models\IKecamatan;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        App::instance('path.public', env('PUBLIC_PATH', base_path('public')));
         try {
            $kecamatans = cache()->remember('all_kecamatans', 3600, function () {
                return IKecamatan::select('id_kecamatan', 'nama_kecamatan')->orderBy('nama_kecamatan')->get();
            });

            View::share('kecamatans', $kecamatans);
        } catch (\Throwable $e) {
            // Jangan sampai error saat artisan migrate / fresh install
            View::share('kecamatans', collect());
        }

        

        

    }
}
