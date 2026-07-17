<?php

namespace App\Providers;

use App\Interfaces\AIServiceInterface;
use App\Models\Lead;
use App\Observers\LeadObserver;
use App\Services\AI\GigaChatService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AIServiceInterface::class, GigaChatService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Lead::observe(LeadObserver::class);
    }
}
