<?php

use Illuminate\Support\Facades\Route;

$getVueTemplate = function () {
    return view('vue');
};


Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', App\Http\Controllers\Admin\MainController::class)->name('admin.dashboard');
    Route::get('/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('admin.login');
    Route::get('/register', [App\Http\Controllers\Admin\AuthController::class, 'register'])->name('admin.register');

    Route::resource('/user', App\Http\Controllers\Admin\UserController::class);
    Route::resource('/company', App\Http\Controllers\Admin\CompanyController::class);
});

Route::group(['prefix' => 'user'], function () use ($getVueTemplate) {
    Route::get('/', $getVueTemplate);
});

Route::get('/welcome', $getVueTemplate);

Auth::routes();
