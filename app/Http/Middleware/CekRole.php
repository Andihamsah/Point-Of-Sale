<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class CekRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $user = User::admin();
        // dd($user);
        if($user && $user->role != $role){
            return redirect('/');
        }
        else return $next($request);
    }
}
