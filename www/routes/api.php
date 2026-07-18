<?php

use App\Http\Controllers\Api\HealthCheckController;
use App\Http\Controllers\Api\LeadController;
use Illuminate\Support\Facades\Route;

Route::post('/contact', [LeadController::class, 'store'])->name('api.contact.store')
            ->middleware('throttle:' . config('rate_limits.contact.per_minute').',1');

Route::get('/leads', [LeadController::class, 'index'])->name('api.leads.index');

Route::get('/health', HealthCheckController::class)
    ->name('api.health.check');
