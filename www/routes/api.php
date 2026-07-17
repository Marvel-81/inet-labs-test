<?php

use App\Http\Controllers\Api\LeadController;
use Illuminate\Support\Facades\Route;

Route::post('/contact', [LeadController::class, 'store'])->name('api.contact.store');
