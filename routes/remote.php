<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Remote;

// Remote routes

Route::get('/', Remote\RemoteController::class);

Route::resource('hosts', Remote\HostController::class);
// Route::post('hosts', [Remote\HostController::class, 'createHost']);
// Route::post('hosts/price', [Remote\HostController::class, 'calculatePrice']);
// Route::match(['put', 'patch'], 'hosts/{host}', [Remote\HostController::class, 'update']);
// Route::delete('hosts/{host}', [Remote\HostController::class, 'destroy']);




Route::resource('work-orders', Remote\WorkOrder\WorkOrderController::class);
Route::resource('work-orders.replies', Remote\WorkOrder\ReplyController::class);


/**
 * Export functions
 * 导出函数，提供给用户访问。
 * 所有方法都必须使用 POST 请求。
 */

// Host 函数，比如控制服务器的启停
Route::group(['prefix' => 'hosts/{host}/functions'], function () {
    Route::post('/test', function () {
        return ['test'];
    });
});

// Module 函数，比如修改用户在此模块的信息
Route::group(['prefix' => '/functions'], function () {
    Route::post('/module_func', function () {
        return ['module_func'];
    });
    Route::post('/calcPrice', function () {
        return ['module_func'];
    });
});
