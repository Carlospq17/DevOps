<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogEndpoint
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        Log::info('API Endpoint Request',
        [
            'url'=> $request->fullUrl(),
            'method' => $request->method(),
            'queryParameters' => json_encode($request->all()),
            'routeParameters' => json_encode($request->route()->parameters()),
            'headers' => json_encode($request->header())
        ]);
        return $next($request);
    }
}
