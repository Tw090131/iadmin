<?php

namespace App\Http\Middleware;

use Closure;

class CheckAppid
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
        if(request()->appid == ''){
            return   redirect('admin/index/gamelist');
        }
        return $next($request);
    }
}
