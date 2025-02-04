<?php

use App\Http\Controllers\Api\V1\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthDataController;

Route::apiResource('posts', PostController::class);
Route::apiResource('invoice', App\Http\Controllers\Api\V1\InvoiceController::class);

// Route::group(['prefix'=>'vat','middleware' => 'auth:sanctum'], function () {
//     Route::get('/vat/auth_user', App\Http\Controllers\);
// });

Route::middleware('auth:sanctum')->get('/auth_user', [AuthDataController::class, 'getAuthUser']);
