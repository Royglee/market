<?php

namespace App\Http\Middleware;

use Closure;

class EditAccountMiddleware
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
        $account = app()->router->getCurrentRoute()->getParameter('account');
        if ($account->user_id != $request->user()->id){
            return redirect()->action('AccountsController@show', [$account]);
        }

        return $next($request);
    }
}
