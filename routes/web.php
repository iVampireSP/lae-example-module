<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;

Route::view('/login', 'login')->name('login');
Route::post('/login', [IndexController::class, 'login']);
Route::get('/', [IndexController::class, 'index']);


// Auth group
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [IndexController::class, 'index']);
});
