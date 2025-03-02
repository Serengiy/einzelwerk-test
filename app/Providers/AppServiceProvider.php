<?php

namespace App\Providers;

use App\Interfaces\ContractorInformationFetcherInterface;
use App\Services\API\DadataService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ContractorInformationFetcherInterface::class, DadataService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
