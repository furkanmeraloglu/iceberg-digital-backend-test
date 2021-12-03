<?php

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

Route::post('login', [ApiController::class, 'authenticate'])->name('authenticate');
Route::post('register', [ApiController::class, 'register'])->name('register');
Route::group(['middleware' => ['jwt.verify']], function (){
   Route::get('logout', [ApiController::class, 'logout'])->name('logout');
   Route::get('get_user', [ApiController::class, 'get_user'])->name('get_user');
});
