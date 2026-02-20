<?php

use Illuminate\Support\Facades\Route;
use App\Http\Auth\AuthController;

Route::prefix('login')->group(function () {
  Route::post('/create',             [AuthController::class, 'createUser']);
  Route::post('/sign-in',          [AuthController::class, 'signIn']);
  Route::post('/refresh_token',   [AuthController::class, 'refreshTokenController']);
  
  Route::post('/change_password', [AuthController::class, 'changePasswordController']);
  Route::post('/update_account',  [AuthController::class, 'updateAccountController']);
  });
  
  Route::post('/logout',          [AuthController::class, 'logoutController']);