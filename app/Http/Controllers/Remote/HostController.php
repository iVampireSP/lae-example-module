<?php

namespace App\Http\Controllers\Remote;

use App\Http\Controllers\Controller;
use App\Models\Host;
use Illuminate\Http\Request;

class HostController extends Controller
{
    /**
     * 获取主机的数据
     * 这个方法非常重要！！！
     * 如果返回 404，莱云则判断主机不存在，会发起删除请求。
     * 一般情况下，只需要返回主机数据即可。
     */
    public function show(Host $host)
    {
        return $this->success($host);
    }

    public function update(Request $request)
    {
        //
        $host = Host::where('host_id', $request->route('host'))->firstOrFail();

        switch ($request->status) {
            case 'running':

                if ($host->status == 'running') {
                    return;
                }

                $this->http->post('/tasks', [
                    'title' => '正在解除暂停。',
                    'host_id' => $host->host_id,
                    'status' => 'done',
                ])->json();

                $host->status = 'running';
                $host->save();

                return $this->success($host);

                break;

            case 'suspended':

                // 如果主机被暂停，则代表主机进入待删除状态。
                // 这个操作不能被用户调用，所以要判断是否是平台调用。

                // 执行暂停操作，然后标记为暂停状态

                // 检测是不是平台调用
                if ($host->status == 'suspended') {
                    return;
                }

                $host->update($request->all());

                // 执行一系列暂停操作

                $this->http->post('/tasks', [
                    'title' => '服务器已暂停。',
                    'host_id' => $host->host_id,
                    'status' => 'done',
                ])->json();

                break;

            case 'error':
                $host->update($request->all());

                break;
        }

        $host->update($request->all());

        return $this->updated($host);
    }

    public function destroy(Request $request)
    {
        // 如果你想要拥有自己的一套删除逻辑，可以不处理这个。返回 false 即可。
        // return false;

        $host = Host::where('host_id', $request->route('host'))->firstOrFail();


        // 或者执行 Functions/HostController.php 中的 destroy 方法。

        $HostController = new Functions\HostController();

        return $HostController->destroy($host);
    }
}
