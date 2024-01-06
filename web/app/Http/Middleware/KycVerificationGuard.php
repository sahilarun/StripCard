<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Constants\GlobalConst;
use App\Providers\Admin\BasicSettingsProvider;

class KycVerificationGuard
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
        $basic_settings = BasicSettingsProvider::get();
        $user = auth()->user();
        if($basic_settings->kyc_verification){
            if( $user->kyc_verified == 0){
                return redirect()->route('user.authorize.kyc')->with(['error' => ['Please submit kyc information']]);
            }elseif($user->kyc_verified == 2){
                return redirect()->route('user.authorize.kyc')->with(['error' => ['Please wait before admin approved your kyc information']]);
            }elseif($user->kyc_verified == 3){
                return redirect()->route('user.authorize.kyc')->with(['error' => ['Admin rejected your kyc information, Please re-submit again']]);
            }
        }
        return $next($request);
    }
}
