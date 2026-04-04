<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return redirect()->guest(route('login'));
        }

        if (! $request->user()->is_admin) {
            abort(Response::HTTP_FORBIDDEN, 'You do not have permission to moderate listings.');
        }

        return $next($request);
    }
}
