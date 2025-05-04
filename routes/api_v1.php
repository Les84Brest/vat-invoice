<?php

use App\Http\Controllers\Api\V1\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthDataController;
use App\Http\Controllers\Api\V1\InvoiceController;
use App\Http\Controllers\Api\V1\PasswordConfirmController;
use App\Http\Controllers\Api\V1\RecieverCompanyController;

Route::apiResource('posts', PostController::class);
Route::get("/invoice/{id}", [App\Http\Controllers\Api\V1\InvoiceController::class, 'show']);
Route::apiResource('invoice', App\Http\Controllers\Api\V1\InvoiceController::class);/* ->middleware('auth:sanctum');
 */
Route::middleware('auth:sanctum')->get('/auth_user', [AuthDataController::class, 'getAuthUser']);
Route::middleware('auth:sanctum')->get('/reciever_tax_ids', [RecieverCompanyController::class, 'getRecieverIds']);
Route::middleware('auth:sanctum')->get('/reciever_company', [RecieverCompanyController::class, 'getRecieverCompany']);

Route::middleware('auth:sanctum')->post('/confirm-password', [PasswordConfirmController::class, 'confirm']);

Route::middleware('auth:sanctum')->post('/invoice/submit-and-store', [App\Http\Controllers\Api\V1\InvoiceController::class, 'storeSubmittedInvoice']);
Route::middleware('auth:sanctum')->post('/invoice/submit-invoice', [App\Http\Controllers\Api\V1\InvoiceController::class, 'submitInvoice']);
Route::post('/register', [App\Http\Controllers\Api\V1\RegisterUserController::class, 'register']);

Route::middleware('auth:sanctum')->get('/dashboard-data', [App\Http\Controllers\Api\V1\VatDashboardController::class, 'dashboardData']);
