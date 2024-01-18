<?php

namespace Madtechservices\MadminCore\app\Http\Middlewares;


use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class SetLangMiddleware
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
        if(!session()->has('lang') && Auth::user())
        {
            session()->put('lang', Auth::user()?->lang ?? config('app.locale'));
        }

        if(session()->has('lang')){
            App::setLocale(session()->get('lang'));
        }

        return $next($request);
    }
    
}
