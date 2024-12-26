<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
{
    /**
     * handle admin middleware
     *
     */
    public function handle(Request $request, Closure $next)
    { 
        //abort_if(!$request->user()->hasRole('admin'), 404);
        
        return $next($request);
    }
}