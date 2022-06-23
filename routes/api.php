<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubmittedSurveyController;
use App\Http\Controllers\SurveyController;
use Illuminate\Http\Request;
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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function() {
  // Route::get('/user', function (Request $request) {
  //   return $request->user();
  // });
  Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
  Route::get('/getDashboardNumbers', [AuthController::class, 'getDashboardNumbers']);
  Route::get('/getDashboardSurveys', [AuthController::class, 'getDashboardSurveys']);
  Route::resource('survey', SurveyController::class);
  Route::post('/submitSurveyAnswers', [SubmittedSurveyController::class, 'store']);

});