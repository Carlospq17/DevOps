<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;

class JwtMiddleware
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
        try {
            if(empty($request->bearerToken())){
                Log::error("Token Validation", ['error'=> 'No Token Found' . $request->bearerToken()]);
                return response()->json(['message' => 'Authorization Token not found'], 401);
            }
            $user = JWTAuth::parseToken()->authenticate();
            return $next($request);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $tie) {
            Log::error("Token Validation", ['error'=> 'Invalid Token ' . $request->bearerToken()]);
            return response()->json(['message' => 'Token is Invalid'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $tee) {
            Log::error("Token Validation", ['error'=> 'Expired Token ' . $request->bearerToken()]);
            return response()->json(['message' => 'Token is Expired'], 401);
        } catch (Exception $e) {
            Log::error("Token Validation", ['error'=> 'No Token Found' . $request->bearerToken()]);
            return response()->json(['message' => 'Authorization Token not found'], 401);
        }
    }
}
