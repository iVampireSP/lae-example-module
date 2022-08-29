<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class Remote
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // add json header
        $request->headers->set('Accept', 'application/json');

        if (!$request->hasHeader('X-Remote-Api-Token')) {
            return $this->unauthorized();
        }

        $token = $request->header('X-Remote-Api-Token');
        if ($token !== config('remote.api_token')) {
            return $this->unauthorized();
        }

        // if request has user
        if ($request->user_id) {
            // find user if exists
            $user = User::where('remote_id', $request->user_id)->first();
            // find or create client
            if (!$user) {
                $user = User::create([
                    'remote_id' => $request->user_id,
                ]); 
            }
        }

        // created_at and updated_at 序列化
        $request->merge([
            'created_at' => Carbon::parse($request->created_at)->toDateTimeString(),
            'updated_at' => Carbon::parse($request->updated_at)->toDateTimeString(),
        ]);


        return $next($request);
    }

    public function unauthorized() {
        return response()->json([
            'message' => 'Unauthorized.'
        ], 401);
    }
}
