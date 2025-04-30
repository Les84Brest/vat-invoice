<?php

use Illuminate\Support\Facades\Route;

$getVueTemplate = function () {
    return view('vue');
};


Route::get('/', [App\Http\Controllers\WelcomeController::class, 'welcome'] );

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
Auth::routes();


Route::get('/welcome', $getVueTemplate);
Route::get('/login', [App\Http\Controllers\Vat\VatController::class, 'login'])->name('login');
Route::get('/register', [App\Http\Controllers\Vat\VatController::class, 'register'])->name('register');

Route::group(['prefix' => 'vat', 'middleware' => 'auth:sanctum'], function () use ($getVueTemplate) {
    Route::get('/', $getVueTemplate);
    Route::get('/{all}', $getVueTemplate)->where('all', '.*');
    
});

