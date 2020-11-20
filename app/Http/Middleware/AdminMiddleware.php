<?php

namespace App\Http\Middleware;

use Closure;

class AdminMiddleware
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
        if (auth()->check() && auth()->user()->type == 'admin') {
            return $next($request);
        }
        return redirect(route('dashboard.login'))->with('class', 'alert alert-warning')->with('message', trans('dash.login_firstly'));
    }
}
