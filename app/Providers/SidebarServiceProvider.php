<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Auth;

class SidebarServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('sidebar', function ($view) {
            $user = Auth::user();
            $namaDepan = $user->namadepan;
            $namaBelakang = $user->namabelakang;
            $namaLengkap = $namaDepan . ' ' . $namaBelakang;

            $view->with('namaLengkap', $namaLengkap);
        });
    }

    public function register()
    {
        //
    }
}
