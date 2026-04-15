<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NonAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->isAdmin()) {
            return redirect('/admin/dashboard')->with('error', 'Akses ditolak.');
        }
        return $next($request);
    }
}
