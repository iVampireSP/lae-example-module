<?php

namespace App\Http\Controllers\Remote;

use App\Http\Controllers\Controller;
use App\Models\Host;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HostController extends Controller
{
    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        $request->upstream_id = $request->id;

        $host = Host::create($request->all());

        return $this->created($host);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
