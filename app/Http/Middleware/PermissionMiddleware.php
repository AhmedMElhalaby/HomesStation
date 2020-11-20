<?php

namespace App\Http\Middleware;

use Closure;

class PermissionMiddleware
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
        if (\App\User::find(auth()->user()->id)->Role->plan == "*") {
            return $next($request);
        } else {
            $perms = $request->route()->getName();
            $plan = \App\User::find(auth()->user()->id)->Role->plan;
            if (!$plan) {
                die('you have not permission');
            }
            $check_perms = in_array($perms, $plan);
            if ($check_perms != true) {
                abort(403);
            }
            return $next($request);
        }
    }
}
