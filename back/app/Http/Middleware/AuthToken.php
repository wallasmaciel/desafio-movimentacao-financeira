<?php

namespace App\Http\Middleware;

use App\Http\Controllers\UserController;
use Closure;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->header("Authorization");
        if (!$token) {
            return response()->json([
                "message" => "Autenticação não foi encontrada."
            ], 401);
        }

        try {
            $token = str_replace('Bearer ', '', $token);
            $decoded = JWT::decode($token, new Key(
                env("JWT_SECRET", "token_jwt"), "HS256"));
            $request->auth = $decoded;
            // 
            return $next($request);
        } catch (Exception $e) {
            return response()->json([
                "message" => "Token inválido ou expirado."
            ], 401);
        }
    }
}
