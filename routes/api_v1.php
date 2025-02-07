<?php

use App\Http\Controllers\Api\V1\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthDataController;
use App\Http\Controllers\Api\V1\InvoiceController;
use App\Http\Controllers\Api\V1\RecieverCompanyController;

Route::apiResource('posts', PostController::class);
Route::apiResource('invoice', App\Http\Controllers\Api\V1\InvoiceController::class);

Route::middleware('auth:sanctum')->get('/auth_user', [AuthDataController::class, 'getAuthUser']);
Route::middleware('auth:sanctum')->get('/reciever_tax_ids', [RecieverCompanyController::class, 'getRecieverIds']);
Route::middleware('auth:sanctum')->get('/reciever_company', [RecieverCompanyController::class, 'getRecieverCompany']);
Route::middleware('auth:sanctum')->get('/create_invoice_data', [InvoiceController::class, 'getInitialData']);

