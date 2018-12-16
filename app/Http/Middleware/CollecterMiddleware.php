<?php

namespace App\Http\Middleware;

use Closure;

class CollecterMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->input('token') != env('APP_SECRET')) {
            return response('Unauthorized.', 401);
        }
        return $next($request);
    }
}
