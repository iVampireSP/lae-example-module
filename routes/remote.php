<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Remote;

// Remote routes

Route::apiResource('remote', Remote\RemoteController::class);
