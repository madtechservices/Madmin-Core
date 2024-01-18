<?php

namespace Madtechservices\MadminCore\app\Http\Middlewares;

class DisableDebugbarMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        if (class_exists(\Debugbar::class)) {
            \Debugbar::disable();
        }

        return $next($request);
    }
    
}
