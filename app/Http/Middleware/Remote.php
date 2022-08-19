<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Client;
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

        $request->merge([
            'upstream_id' => $request->id,
        ]);


        // if request has user
        if ($request->user) {
            $remote_user = $request->toArray()['user'];
            // find client if exists
            $client = Client::where('email', $remote_user['email'])->first();
            // find or create client
            if (!$client) {
                $client = Client::create([
                    'id' => $remote_user['id'],
                    'name' => $remote_user['name'],
                    'email' => $remote_user['email'],
                ]);
            }

            // $request->client_id = $remote_user['id'];

            // map $request->user_id to $request->client_id
            $request->merge([
                'client_id' => $client->id,
            ]);

            unset($request->user);

            // add client to request
            $request->merge(['client' => $client]);
        }

        if ($request->has('user_id')) {
            $request->merge([
                'client_id' => $request->user_id,
            ]);
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
