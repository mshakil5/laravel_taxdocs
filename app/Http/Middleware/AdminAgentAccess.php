<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminAgentAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user()->is_type == '1' || auth()->user()->is_type == '2'){
            return $next($request);
        }

        return redirect('home')->with('error',"You don't have admin access.");
    }
}
