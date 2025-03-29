<?php

namespace App\Providers;

use App\Models\User;
use App\Services\Companies\CompanyService;
use App\Services\Companies\CompanyServiceContract;
use App\Services\Invoices\InvoiceService;
use App\Services\Invoices\InvoiceServiceContract;
use App\Services\Users\UserService;
use App\Services\Users\UserServiceContract;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserServiceContract::class, UserService::class);
        $this->app->bind(CompanyServiceContract::class, CompanyService::class);
        $this->app->bind(InvoiceServiceContract::class, InvoiceService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Gate::define('create-invoice', function (User $user, array $invoiceData) {
            $authorId = $invoiceData['author_id'];
            $companyId = $invoiceData['sender_company_id'];
            $allow = false;

            if ($user->id === $authorId && $user->company_id = $companyId) {
                $allow = true;
            }

            return $allow;
        });
    }
}
