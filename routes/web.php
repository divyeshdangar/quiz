<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    if(Auth::check()){
        echo "123";
    } else {
        echo "234";
    }
    die;
    return view('welcome');
})->name('home');


Route::get('login', [LoginController::class, 'authenticate'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.post');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
