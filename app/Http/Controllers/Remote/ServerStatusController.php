<?php

namespace App\Http\Controllers\Remote;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use ivampiresp\Cocoa\Http\Controller;
use ivampiresp\Cocoa\Models\Admin;
use ivampiresp\Cocoa\Models\Server;

// use Illuminate\Http\Request;

class ServerStatusController extends Controller
{
    /**
     * 返回全部服务器状态，不需要包裹任何数据。
     *
     * @return array
     */
    public function index(): array
    {
        return Server::all()->toArray();
    }
}
