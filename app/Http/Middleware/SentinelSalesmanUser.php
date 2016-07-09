<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class SentinelSalesmanUser
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
        $user = Sentinel::getUser();
        $admin = Sentinel::findRoleBySlug('salesman');

        if (!$user->inRole($admin)) {
            return redirect()->route('login');
        }
        return $next($request);
    }
}
