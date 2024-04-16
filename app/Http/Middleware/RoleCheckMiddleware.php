<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Ambil user yang sedang terautentikasi
        $user = Auth::user();

        // Periksa jika user ada dan memiliki id_role yang sesuai
        if ($user) {
            if ($user->id_role == 1) {
                // Super Admin
                return $next($request);
            } elseif ($user->id_role == 2) {
                // Admin
                return $next($request);
            }
        }

        // Jika tidak, kembalikan response Unauthorized
        return response()->json(['message' => 'Unauthorized'], 401);
    }

}
