<?php

namespace App\Http\Middleware;

use Closure;

class CheckBoleh
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
        $username = env('AUTH_USERNAME',null);
        $pass = env('AUTH_PASSWORD',null);
        
        $auth = explode(' ', $request->header('Authorization'));
        $valid = !empty($auth[1]) ? $auth[1] : null ;
        if($valid == base64_encode($username.':'.$pass)){
            return $next($request);
        }
        else{
            return response('Akses Dilarang', 401);
        }
        
    }
}
