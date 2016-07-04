<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LeftMenuViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['partials.left-menu', 'partials.top-nav'], 'App\Http\ViewComposers\MenuViewComposer');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
