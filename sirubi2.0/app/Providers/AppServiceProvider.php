<?php

namespace App\Providers;

use App\Models\IKecamatan;
use App\Services\VisitorStats;
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

          View::composer('*', function ($view) {
            try {
                $view->with('visitorStats', VisitorStats::getStats());
            } catch (\Throwable $e) {
                $view->with('visitorStats', [
                    'online' => 0,
                    'today' => 0,
                    'week' => 0,
                    'month' => 0,
                    'year' => 0,
                ]);
            }
        });

        

        

    }
}
