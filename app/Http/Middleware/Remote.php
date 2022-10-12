<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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

        if ($request->user_id) {
            $user = User::where('id', $request->user_id)->first();
            // if user null
            if (!$user) {
                $http = Http::remote('remote')->asForm();
                $user = $http->get('/users/' . $request->user_id)->json();

                $user = User::create([
                    'id' => $user['data']['id'],
                    'name' => $user['data']['name'],
                    'email' => $user['data']['email'],
                    'created_at' => Carbon::parse($user['data']['created_at']),
                    'updated_at' => Carbon::parse($user['data']['updated_at']),
                ]);
            }

            Auth::guard('user')->login($user);
        }


        if ($request->created_at) {
            // created_at and updated_at 序列化

            $request->merge([
                'created_at' => Carbon::parse($request->created_at)->toDateTimeString(),
                'updated_at' => Carbon::parse($request->updated_at)->toDateTimeString(),
            ]);
        }

        return $next($request);
    }

    public function unauthorized()
    {
        return response()->json([
            'message' => 'Unauthorized.'
        ], 401);
    }
}
