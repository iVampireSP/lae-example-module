<?php

namespace App\Http\Controllers\Remote;

use App\Http\Controllers\Controller;
use App\Models\Host;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HostController extends Controller
{
    public function store(Request $request)
    {
        // 创建云端任务(告知用户执行情况)

        $task = $this->http->asForm()->post('/tasks', [
            'title' => '正在寻找服务器',
            'host_id' => $request->id,
            'status' => 'processing',
        ])->json();

        // Log::debug($task['data']);
        // 寻找服务器的逻辑

        $task_id = $task['data']['id'];

        $this->http->asForm()->patch('/tasks/' . $task_id, [
            'title' => '已找到服务器',
        ]);


        $this->http->asForm()->patch('/tasks/' . $task_id, [
            'title' => '正在创建您的服务。',
        ]);

        $host = Host::create($request->all());


        $this->http->asForm()->patch('/tasks/' . $task_id, [
            'title' => '已完成创建。',
            'status' => 'success',
        ]);

        // 将 price 添加到 host
        $host->price = 1002;

        return $this->created($host);
    }

    public function calculatePrice(Request $request)
    {
        // return

        // 如果参数正确
        return $this->success([
            'price' => 1
        ]);

        // 如果参数错误
        return $this->error([
            'message' => '参数错误'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Host $host
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Host $host)
    {
        // patch
        switch ($request->status) {
            case 'running':
                // 当启动或解除暂停时
                $host->update($request->all());
                break;

            case 'stopped':
                // 当停止时（一般用于关机）
                $host->update($request->all());
                break;

            case 'suspended':
                // 执行暂停操作，然后标记为暂停状态

                $host->update($request->all());
                break;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Host $host
     * @return \Illuminate\Http\Response
     */
    public function destroy(Host $host)
    {
        // 具体删除逻辑

        // 比如销毁硬盘，踢掉用户等。   
        $host->delete();


        return $this->deleted($host);
    }
}
