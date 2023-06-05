<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{

    public function handle($request, Closure $next)
    {
        $user = User::all()->count();
        if (!($user == 1)) {
            if (!Auth::user()->hasRole('admin')) //If user does //not have this permission
            {
                abort('401');
            }
        }
        return $next($request);
    }
}
