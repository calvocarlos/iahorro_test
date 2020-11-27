<?php

use App\Http\Controllers\Api\MortgageExpertController;
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

Route::get('mortgage-experts/{id}', [MortgageExpertController::class, 'show'])
    ->name('api.v1.mortgage.experts.show')
    ->where('id', '[0-9]+');
Route::get('mortgage-experts', [MortgageExpertController::class, 'index'])
    ->name('api.v1.mortgage.experts.index');

Route::get('mortgage-applications/expert/{mortgage_expert_id}', [MortgageApplicationController::class, 'getMortgageApplicationsByMortgageExpertId'])
    ->name('api.v1.mortgage.applications.expert.index')
    ->where('mortgage_expert_id', '[0-9]+');
Route::get('mortgage-applications/{id}', [MortgageApplicationController::class, 'show'])
    ->name('api.v1.mortgage.applications.show')
    ->where('id', '[0-9]+');
Route::get('mortgage-applications', [MortgageApplicationController::class, 'index'])
    ->name('api.v1.mortgage.applications.index');
Route::post('mortgage-applications', [MortgageApplicationController::class, 'store'])
    ->name('api.v1.mortgage.applications.store');

Route::fallback(function(){
    return response()->json([
        'errors' => [
            'status' => "404",
            'source' => [
                'pointer' => ''
            ],
            'title' => 'Page Not Found.',
            'detail' => 'Page Not Found. Not valid Route. Check the API specification.'
        ]
    ], 404);
});
