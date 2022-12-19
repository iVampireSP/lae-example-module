<?php

namespace App\Http\Controllers\Remote\Exports;

use App\Http\Controllers\Controller;
use App\Models\Ip;
use Illuminate\Http\Request;

class IpController extends Controller
{

    public function __construct(Request $request)
    {
        // 检测 X-Module 是否是 ip-manager
        if ($request->header('X-Module') !== 'ip-manager') {
            abort(403, 'X-Module header is not ip-manager');
        }
    }

    /**
     * 显示指定的 IP 地址，用户判断是否绑定成功。
     * 尽量保持默认，否则可能会误触发删除。
     */
    public function show(Ip $ip)
    {
        //

        return $this->success($ip);
    }



    /**
     * 移除绑定的 IP 地址，比如给指定网卡断网，然后移除。
     */
    public function destroy(Ip $ip)
    {
        //

        return $this->success($ip);
    }
}
