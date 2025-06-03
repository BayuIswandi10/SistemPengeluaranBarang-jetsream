<?php

// app/Http/Middleware/CheckKendaraanAccess.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckKendaraanAccess
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user && ($user->level === 'Super Admin' || $user->seksi === 'GENERAL SERVICES')) {
            return $next($request);
        }

        return redirect()->route('unauthorized.show');
    }
}
