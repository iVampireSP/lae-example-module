<?php

namespace App\Http\Middleware;

use App\Models\Client;
use Closure;
use Illuminate\Http\Request;

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

        return $next($request);
    }

    public function unauthorized() {
        return response()->json([
            'message' => 'Unauthorized.'
        ], 401);
    }
}
