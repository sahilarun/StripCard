<?php

namespace App\Http\Middleware;

use App\Http\Helpers\Api\Helpers;
use App\Http\Helpers\ResponseHelper;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckStatusApiUser
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
        $user = auth()->user();
        if((Auth::user()->email_verified == 1 ) && (Auth::user()->status == 1)){
            return $next($request);
        }else{
            if(Auth::user()->status == 0){
                $error = ['errors'=>['Account Is Deactivated']];
                return Helpers::error($error);
            }elseif($user->email_verified == false){;
                return mailVerificationTemplateApi($user);
            }
        }
    }
}
