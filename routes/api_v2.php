<?php

use App\Http\Controllers\Api\MortgageApplicationControllerOld;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MortgageApplicationController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('mortgage-applications/{mortgage_application}', [MortgageApplicationControllerOld::class, 'show'])
    ->name('api.v2.mortgage.applications.show');
Route::get('mortgage-applications', [MortgageApplicationControllerOld::class, 'index'])
    ->name('api.v2.mortgage.applications.index');
Route::post('mortgage-applications', [MortgageApplicationControllerOld::class, 'store'])
    ->name('api.v2.mortgage.applications.store');
Route::delete('mortgage-applications', [MortgageApplicationControllerOld::class, 'destroy'])
    ->name('api.v2.mortgage.applications.destroy');
