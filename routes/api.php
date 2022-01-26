<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('buyer-signup',[ApiController::class,'buyerSignup']);
Route::post('buyer-login',[ApiController::class,'buyerLogin']);
Route::post('buyer-logout',[ApiController::class,'buyerLogout']);
Route::get('buyer-details',[ApiController::class,'buyerDetails']);
