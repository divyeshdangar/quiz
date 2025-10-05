<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Middleware\SubstituteBindings;
use App\Http\Controllers\Api\TaskController;

Route::middleware(['verify.apikey', 'throttle:60,1'])
    ->group(function () {
        Route::get('/task', [TaskController::class, 'show'])->name('task.show');
        Route::post('/task/submit', [TaskController::class, 'submit'])->name('task.submit');
    });