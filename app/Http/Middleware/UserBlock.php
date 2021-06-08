<?php

namespace App\Http\Middleware;

use App\Responses\AjaxResponse;
use Closure;
use Illuminate\Http\Request;

class UserBlock
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (! (auth()->check() && auth()->user()->isBlock())){
            return $next($request);
        }

        return  AjaxResponse::ok('user is blocked' , 403 );
    }
}
