<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Middleware\CheckIfLogin;
use App\Http\Middleware\CheckLanguage;

use App\Http\Controllers\Dashboard\BlogController;
use App\Http\Controllers\Dashboard\BlogCategoryController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\NotificationController;
use App\Http\Controllers\Dashboard\ContactController;
use App\Http\Controllers\Dashboard\TaskController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('language/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'hi', 'gj'])) {
        abort(400);
    } else {
        app()->setLocale($locale);
        session()->put('locale', $locale);
        return redirect()->back();
    }
})->name('language');

Route::get('test', [LoginController::class, 'test'])->name('test');
Route::get('login', [LoginController::class, 'authenticate'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.post');
Route::get('logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware([CheckIfLogin::class, CheckLanguage::class])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('dashboard/notification', [NotificationController::class, 'index'])->name('dashboard.notification');
    Route::get('dashboard/notification/action/{action}', [NotificationController::class, 'action'])->name('dashboard.notification.action');

    Route::get('dashboard/contact', [ContactController::class, 'index'])->name('dashboard.contact');

    Route::get('dashboard/user', [UserController::class, 'index'])->name('dashboard.user');
    Route::post('dashboard/user/create', [UserController::class, 'store'])->name('dashboard.user.create');
    Route::get('dashboard/user/edit/{id}', [UserController::class, 'edit'])->name('dashboard.user.edit');
    Route::post('dashboard/user/edit/{id}', [UserController::class, 'store'])->name('dashboard.user.edit.post');
    Route::get('dashboard/user/view/{id}', [UserController::class, 'view'])->name('dashboard.user.view');
    Route::post('dashboard/user/access/{id}', [UserController::class, 'access'])->name('dashboard.user.access');
    Route::get('dashboard/user/delete/{id}', [UserController::class, 'delete'])->name('dashboard.user.delete');

    Route::get('dashboard/blog', [BlogController::class, 'index'])->name('dashboard.blog');
    Route::get('dashboard/blog/create', [BlogController::class, 'create'])->name('dashboard.blog.create');
    Route::get('dashboard/blog/edit/{id}', [BlogController::class, 'edit'])->name('dashboard.blog.edit');
    Route::post('dashboard/blog/edit/{id}', [BlogController::class, 'store'])->name('dashboard.blog.edit.post');
    Route::get('dashboard/blog/view/{id}', [BlogController::class, 'view'])->name('dashboard.blog.view');
    Route::get('dashboard/blog/delete/{id}', [BlogController::class, 'delete'])->name('dashboard.blog.delete');

    Route::get('dashboard/task', [TaskController::class, 'index'])->name('dashboard.task');
    Route::get('dashboard/task/create', [TaskController::class, 'create'])->name('dashboard.task.create');
    Route::get('dashboard/task/edit/{id}', [TaskController::class, 'edit'])->name('dashboard.task.edit');
    Route::post('dashboard/task/edit/{id}', [TaskController::class, 'store'])->name('dashboard.task.edit.post');
    Route::get('dashboard/task/view/{id}', [TaskController::class, 'view'])->name('dashboard.task.view');
    Route::get('dashboard/task/list/{id}', [TaskController::class, 'list'])->name('dashboard.task.list');
    Route::get('dashboard/task/delete/{id}', [TaskController::class, 'delete'])->name('dashboard.task.delete');

    Route::get('dashboard/blog-category', [BlogCategoryController::class, 'index'])->name('dashboard.blog.category');
    Route::get('dashboard/blog-category/create', [BlogCategoryController::class, 'create'])->name('dashboard.blog.category.create');
    Route::get('dashboard/blog-category/edit/{id}', [BlogCategoryController::class, 'edit'])->name('dashboard.blog.category.edit');
    Route::post('dashboard/blog-category/edit/{id}', [BlogCategoryController::class, 'store'])->name('dashboard.blog.category.edit.post');
    Route::get('dashboard/blog-category/view/{id}', [BlogCategoryController::class, 'view'])->name('dashboard.blog.category.view');
    Route::get('dashboard/blog-category/delete/{id}', [BlogCategoryController::class, 'delete'])->name('dashboard.blog.category.delete');
});
