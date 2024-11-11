<?php

namespace App\Providers;

use App\Models\MenuGroup;
use App\Models\Profil;
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
        $profil = Profil::where('id', 1)->first();
        View::share('profil', $profil);

        // Menampilkan menu groups dan menu items
        $menus = MenuGroup::with('items')->get();  // Mengambil menu groups beserta items
        View::share('menus', $menus);
    }
}
