<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckLevel
{
    public function handle(Request $request, Closure $next, $level)
    {
        $user = Auth::user();
        
        if ($user && $user->level === $level) {
            return $next($request);
        }

        $logMessage = $user ? 'User Level: ' . $user->level . ', Required Level: ' . $level : 'No user authenticated';
        
        return redirect()->route('unauthorized.show');
    }
}
