<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class SentinelAgentUser
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
        $admin = Sentinel::findRoleBySlug('agent');

        if (!$user->inRole($admin)) {
            return redirect()->route('login');
        }
        return $next($request);
    }
}
