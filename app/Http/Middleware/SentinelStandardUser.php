<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;

class SentinelStandardUser
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
        $users = Sentinel::findRoleBySlug('users');

        if (!$user->inRole($users)) {
            return redirect()->route('login');
        }
        return $next($request);
    }
}
