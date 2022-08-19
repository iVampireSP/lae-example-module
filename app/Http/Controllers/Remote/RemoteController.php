<?php

namespace App\Http\Controllers\Remote;

use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;

class RemoteController extends Controller
{
    // invoke
    public function __invoke()
    {
        return $this->success([
            'name' => config('remote.module_name'),
        ]);
    }
}
