<?php

namespace App\Http\Revenue;

use App\Http\Revenue\RevenueController;
use Illuminate\Support\Facades\Route;

Route::prefix('revenue')->group(function () {
    Route::get('/', [RevenueController::class, 'index']);
    Route::post('/create', [RevenueController::class, 'store']);
});