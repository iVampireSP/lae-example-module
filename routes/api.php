<?php

use App\Http\Controllers\Api\HostController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API 路由。这里的路由都经过了封装，它们经过 auth:lae 中间件，从 莱云 获取用户信息并认证。
| 你只需要将业务逻辑写这边就可以了。
|--------------------------------------------------------------------------
*/

// GET your_module.test/api/user
Route::get('/user', UserController::class);

Route::resource('hosts', HostController::class);
