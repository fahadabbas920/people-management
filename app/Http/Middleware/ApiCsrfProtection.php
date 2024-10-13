<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiCsrfProtection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Allow any API requests to pass without CSRF token verification
        if ($request->is('api/*')) {
            return $next($request);
        }

        return csrf_token(); // You can return the CSRF token if needed
    }
}

