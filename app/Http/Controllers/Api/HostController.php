<?php

namespace App\Http\Controllers\Api;

use App\Actions\HostAction;
use App\Exceptions\HostActionException;
use App\Models\Host;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use ivampiresp\Cocoa\Http\Controller;

class HostController extends Controller
{
    public function index()
    {
        $hosts = Host::thisUser()->get();

        return $this->success($hosts);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            // 'status' => 'required|string',
        ]);

        $hostAction = new HostAction();

        $requests = $request->all();

        try {
            // 价格预留 0.01 可以用来验证用户是否有足够的余额。如果是周期性计费，则需要一次填写好。
            $host = $hostAction->createCloudHost($hostAction->calculatePrice($requests), [
                'name' => $request->input('name'),
                // 'status' => $request->input('status'), 测试用的状态
                'configuration' => $request->all(), // 保存所有的配置，比如 CPU，硬盘这些，之后队列里面会用到。
            ]);
        } catch (HostActionException $e) {
            return $this->error($e->getMessage());
        }

        return $this->created($host);
    }

    public function show(Host $host)
    {
        $this->isUser($host);

        return $this->success($host);
    }

    public function isUser(Host $host)
    {
        if (auth('api')->check()) {
            if ($host->user_id !== auth('api')->id()) {
                abort(403);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  Host  $host
     * @return JsonResponse
     */
    public function update(Request $request, Host $host)
    {
        $this->isUser($host);

        $hostAction = new HostAction();

        $host = $hostAction->update($host, $request->only([
            'name',
            'status',
        ]));

        return $this->updated($host);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Host  $host
     * @return JsonResponse
     */
    public function destroy(Host $host)
    {
        $this->isUser($host);

        // 具体删除逻辑
        $hostAction = new HostAction();

        try {
            $hostAction->destroy($host);
        } catch (HostActionException $e) {
            $this->error($e->getMessage());
        }

        return $this->deleted($host);
    }
}
