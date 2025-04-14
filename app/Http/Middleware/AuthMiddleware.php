<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\key;
use Firebase\JWT\ExpiredException;

class AuthMiddleware
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
        // Pre-Middleware Action
       
        if (!$request->header('Authorization')) {

            return response()->json([
                'error' => 'Se requiere el token'
            ], 401);
        }
        $token = $request->header('Authorization');

        try {

            $credentials = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));

        } catch (ExpiredException $e) {
            return response()->json([
                'error' => 'El token ha expirado'
            ], 401);
        }
        catch (Exception $e) {
            return response()->json([
                'error' => 'No se pudo decodear el token'
            ], 401);
        }

        $user = User::find($credentials->sub);
        $request->auth= $user;
        // dd($user);
        return $next($request);
    }
}
