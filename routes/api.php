<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\ReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public Routes
Route::post('company/register', [CompanyController::class, 'register']);
Route::get('report/payments', [ReportController::class, 'paymentReport']);

// Protected Routes
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('company/assign-package', [CompanyController::class, 'assignPackage']);
    Route::post('company/check-package', [CompanyController::class, 'checkPackage']);
});
