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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // patch
        $host = Host::where('upstream_id', $id);

        switch ($request->type) {
            case 'suspend':
                $host->update($request->all());
                break;
            case 'unsuspend':
                $host->update($request->all());
                break;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // patch
        $host = Host::where('upstream_id', $id);
        $host->delete();
    }
}
