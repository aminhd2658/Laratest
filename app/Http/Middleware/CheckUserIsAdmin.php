<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserIsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() and auth()->user()->type == 'admin') return $next($request);

        return back();
    }
}
