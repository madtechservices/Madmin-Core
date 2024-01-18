<?php

namespace Madtechservices\MadminCore\app\Http\Middlewares;

use Madtechservices\MadminCore\app\Models\User;
use Illuminate\Support\Facades\Auth;

class AccountCheckMiddleware
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
        if(!backpack_user()) abort(403);

        /** @var User $user */
        $user = backpack_user();

        if($user->selectable_accounts->count() <= 0) abort(403);

        if(!session()->has('account_id'))
        {
            session()->put('account_id', $user->selectable_accounts->first()->id);
        }

        return $next($request);
    }
    
}
