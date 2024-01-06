<?php

namespace App\Http\Middleware\Admin;

use App\Http\Helpers\Api\Helpers;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;

class AppModeGuardApi
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
        if(in_array($request->method(),['POST','PUT','DELETE'])) {
            $ignore_routes = ['logout'];

            $request_path = $request->path();
            $request_path = explode('?',$request_path);
            $request_path = array_shift($request_path);
            $request_path = explode("/",$request_path);
            $request_path = array_pop($request_path);
            
            if(!in_array($request_path,$ignore_routes)) {
                if(env("APP_MODE") != 'live') {
                    $message = ['error'=>['Can\'t change anything for demo application.']];
                    return Helpers::unauthorized($data = null, $message);
                }
            }

        }
        return $next($request);
    }
}
