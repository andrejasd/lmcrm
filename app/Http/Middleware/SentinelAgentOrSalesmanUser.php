<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class SentinelAgentOrSalesmanUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!Sentinel::inRole('salesman') && !Sentinel::inRole('agent')) {
            return redirect()->route('login');
        }
        return $next($request);
    }
}
