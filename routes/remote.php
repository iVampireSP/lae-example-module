<?php

use App\Http\Controllers\Remote\Exports;
use App\Http\Controllers\Remote\Functions;
use Illuminate\Support\Facades\Route;

// 注意，以下路由都是暴露给用户的，并且必须经过 'Remote' 中间件，否则这些路由将不安全。

/**
 * Export functions
 * 导出函数，提供给用户访问。
 * 请求方式将会透传, 您定义了什么请求方式，在前端中就应该使用哪种类型的请求方式。
 */

// 当前模块的函数。服务器启停，创建，销毁，都需要进过这里。
Route::group(['prefix' => '/functions', 'as' => 'functions.'], function () {
    Route::apiResource('hosts', Functions\HostController::class);
});

// 导出函数。用于给其它集成模块调用。做到模块之间相互交换信息或控制。
Route::group(['prefix' => '/exports', 'as' => 'exports.'], function () {
    Route::apiResource('hosts', Exports\HostController::class);
    Route::apiResource('ips', Exports\IpController::class)->only(['show', 'destroy']);
});
