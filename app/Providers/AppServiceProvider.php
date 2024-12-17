<?php

namespace App\Providers;

use App\Contracts\Video\VideoHosting;
use App\Services\Video\Vimeo;
use App\Services\Video\Youtube;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(VideoHosting::class, function ($app) {
            return new Vimeo();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
