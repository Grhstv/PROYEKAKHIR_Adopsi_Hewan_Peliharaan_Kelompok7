<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Di Vercel request masuk lewat proxy HTTPS; paksa link/aset memakai https.
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
