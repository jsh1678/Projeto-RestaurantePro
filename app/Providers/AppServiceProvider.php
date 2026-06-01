<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
<<<<<<< HEAD
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
=======

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
    public function register(): void
    {
        //
    }

<<<<<<< HEAD
    public function boot(): void
    {
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
=======
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
>>>>>>> f04186cf0d2473ded7258548bd95edb40a327568
    }
}
