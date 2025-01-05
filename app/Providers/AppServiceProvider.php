<?php

namespace App\Providers;

use App\Services\Companies\CompanyService;
use App\Services\Companies\CompanyServiceContract;
use App\Services\Users\UserService;
use App\Services\Users\UserServiceContract;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserServiceContract::class, UserService::class);
        $this->app->bind(CompanyServiceContract::class, CompanyService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
