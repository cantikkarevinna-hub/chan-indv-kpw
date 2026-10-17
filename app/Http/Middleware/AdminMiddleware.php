<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()?->role?->name !== 'admin') {
            abort(403, 'This area is restricted to administrators.');
        }

        return $next($request);
    }
}
