<?php

namespace App\Providers;

use App\Interfaces\TokenInterface;
use App\Services\Auth\SanctumTokenService;
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
        $this->app->bind(TokenInterface::class, SanctumTokenService::class);
    }
}
