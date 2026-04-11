<?php

namespace App\Http\Expense;

use App\Http\Expense\ExpenseController;
use Illuminate\Support\Facades\Route;

Route::prefix('expenses')->group(function () {
    Route::get('/', [ExpenseController::class, 'index']);
    Route::post('/create', [ExpenseController::class, 'store']);
});