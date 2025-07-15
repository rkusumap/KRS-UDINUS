<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Module;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

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
        if (Schema::hasTable('ms_module')) {
            $moduleAppServiceProvider = \App\Models\Module::where('induk_module', '0')
                ->orderBy('order_module', 'ASC')
                ->get();

            View::share('moduleAppServiceProvider', $moduleAppServiceProvider);
        } else {
            View::share('moduleAppServiceProvider', collect()); // Share empty collection if table doesn't exist
        }

        if (Schema::hasTable('ms_option')) {
            $optionAppServiceProvider = \App\Models\Option::find(1);

            View::share('optionAppServiceProvider', $optionAppServiceProvider);
        } else {
            View::share('optionAppServiceProvider', collect()); // Share empty collection if table doesn't exist
        }
    }
}
