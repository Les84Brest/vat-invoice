<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/get', App\Http\Controllers\GetController::class);
});

Route::prefix('v1')->as('api.')->group(function () {
    require __DIR__.'/api_v1.php';
});