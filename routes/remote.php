<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Remote;

// Remote routes

Route::get('remote', Remote\RemoteController::class);

Route::resource('hosts', Remote\HostController::class);
