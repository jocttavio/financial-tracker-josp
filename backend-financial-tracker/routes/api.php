<?php

use App\Exceptions\CustomError;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    throw new CustomError("Este es un error personalizado", 400, null, ['info' => 'Datos adicionales del error']);
});
