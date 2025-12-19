<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class CheckManualSession
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah ada session user_id
        if (!session()->has('user_id')) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu');
        }
        
        // Pastikan user masih ada di database
        $user = User::find(session('user_id'));
        if (!$user) {
            session()->flush();
            return redirect()->route('login')->with('error', 'Session invalid');
        }
        
        // Share user data ke semua view agar bisa diakses
        view()->share('currentUser', $user);
        
        return $next($request);
    }
}