<?php

use App\Http\Controllers\AppointmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});
Route::group(['middleware' => 'api', 'prefix' => 'appointments'], function($router){
   Route::get('/', [AppointmentController::class, 'index']);
   Route::post('/', [AppointmentController::class, 'store']);
   Route::put('/{id}', [AppointmentController::class, 'update']);
   Route::delete('/{id}', [AppointmentController::class, 'destroy']);
});
