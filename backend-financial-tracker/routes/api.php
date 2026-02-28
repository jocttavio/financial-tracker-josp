<?php

use App\Exceptions\CustomError;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DefaultController;

Route::get('/user', function (Request $request) {
    throw new CustomError("Este es un error personalizado", 400, null, ['info' => 'Datos adicionales del error']);
});

Route::prefix('default')->group(function () {
    Route::get('/categories', [DefaultController::class, 'getCategories']);
    Route::post('/categories/create', [DefaultController::class, 'createCategories']);
    Route::get('/products-services', [DefaultController::class, 'getProductsServices']);
    Route::post('/products-services/create', [DefaultController::class, 'createProductsServices']);
    Route::get('/accounts', [DefaultController::class, 'getAccounts']);
    Route::post('/account/create', [DefaultController::class, 'createAccount']);
});
require base_path('app/Http/Revenue/RevenueRoutes.php');
require base_path('app/Http/Auth/AuthRoutes.php');
