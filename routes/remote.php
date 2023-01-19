<?php

use App\Http\Controllers\Remote\Exports;
use Illuminate\Support\Facades\Route;

// 注意，以下路由都是暴露给用户的，并且必须经过 'Remote' 中间件，否则这些路由将不安全。

/**
 * Export functions
 * 导出函数，提供给其他模块访问，进行模块联调。
 * 例如，你可以在这里导出一个函数，让其他模块调用，从而实现模块间的数据交互。
 * 但是请注意，请求内容不能过大，必须在 5s 内完成请求，否则会导致请求失败。
 */

Route::group(['prefix' => '/exports', 'as' => 'exports.'], function () {
    Route::apiResource('hosts', Exports\HostController::class);
    Route::apiResource('ips', Exports\IpController::class)->only(['show', 'destroy']);
});
