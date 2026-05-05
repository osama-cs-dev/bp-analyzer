<?php

use App\Http\Controllers\HealthController;
use Illuminate\Support\Facades\Route;

Route::get('/',              [HealthController::class, 'index'])->name('health.form');
Route::post('/analyze',      [HealthController::class, 'analyze'])->name('health.analyze');
Route::get('/result/{userHealthData}', [HealthController::class, 'result'])->name('health.result');
Route::get('/admin',         [HealthController::class, 'admin'])->name('health.admin');
