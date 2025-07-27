<?php

use Illuminate\Support\Facades\Route;

$getVueTemplate = function () {
    return view('vue');
};


Route::get('/', [App\Http\Controllers\WelcomeController::class, 'welcome']);

Route::get('/admin/login', [App\Http\Controllers\Admin\AuthController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [App\Http\Controllers\Admin\AuthController::class, 'loginUser']);
Route::get('/admin/register', [App\Http\Controllers\Admin\AuthController::class, 'register'])->name('admin.register')->middleware('guest');

Route::group(['prefix' => 'admin', 'middleware' => 'auth:sanctum', 'verified'], function () {
    Route::get('/', App\Http\Controllers\Admin\MainController::class)->name('admin.dashboard');
    Route::resource('/user', App\Http\Controllers\Admin\UserController::class);
    Route::resource('/company', App\Http\Controllers\Admin\CompanyController::class);
    Route::resource('/invoice', App\Http\Controllers\Admin\InvoiceAdminController::class);
});


Auth::routes();


Route::get('/welcome', $getVueTemplate);
Route::get('/login', [App\Http\Controllers\Vat\VatController::class, 'login'])->name('login');
Route::get('/register', [App\Http\Controllers\Vat\VatController::class, 'register'])->name('register');

Route::group(['prefix' => 'vat', 'middleware' => 'auth:sanctum'], function () use ($getVueTemplate) {
    Route::get('/', $getVueTemplate);
    Route::get('/{all}', $getVueTemplate)->where('all', '.*');
});
