<?php

namespace App\Providers;

use App\Models\Pengaturan;
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
        // Suntikkan data pengaturan toko ke SEMUA view secara otomatis,
        // supaya nama toko dkk selalu sinkron di manapun tanpa perlu
        // passing manual dari tiap controller.
        View::composer('*', function ($view) {
            static $pengaturan = null;
            $pengaturan ??= Pengaturan::ambil();

            $view->with('namaToko', $pengaturan->nama_toko);
            $view->with('pengaturanToko', $pengaturan);
        });
    }

}
