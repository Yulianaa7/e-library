<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class Checkrole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!session()->has('user_id')) {
            return redirect()->route('login');
        }

        $user = User::find(session('user_id'));
        
        if (!$user) {
            session()->flush();
            return redirect()->route('login');
        }

        $userRole = $user->role;
        
        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized action.');
        }
        
        return $next($request);
    }
}