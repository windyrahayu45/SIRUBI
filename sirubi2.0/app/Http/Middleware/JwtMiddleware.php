<?php

namespace App\Http\Middleware;

use App\Helpers\JwtHelper;
use Closure;
use Exception;
use Firebase\JWT\ExpiredException;

class JwtMiddleware
{
    public function handle($request, Closure $next)
    {
        $header = $request->header('Authorization');

        if (!$header) {
            return response()->json([
                'status' => false,
                'message' => 'Authorization header missing'
            ], 401);
        }

        try {
            $token = str_replace('Bearer ', '', $header);
            $decoded = JwtHelper::decodeToken($token);
            $request->auth = $decoded;
        } catch (ExpiredException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Token sudah expired'
            ], 401);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Token tidak valid: '.$e->getMessage()
            ], 401);
        }

        return $next($request);
    }
}
