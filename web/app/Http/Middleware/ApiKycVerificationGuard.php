<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Constants\GlobalConst;
use App\Http\Helpers\Api\Helpers;
use App\Providers\Admin\BasicSettingsProvider;

class ApiKycVerificationGuard
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
        if($basic_settings->kyc_verification) {
            $user = auth()->user();
            if($user->kyc_verified != GlobalConst::APPROVED) {
                $message = ['error' => ['Please verify your KYC information before any transactional action']];
                if($user->kyc_verified == GlobalConst::PENDING) {
                    $message = ['error' => ['Your KYC information is pending. Please wait for admin confirmation.']];
                }
                if(auth()->guard(get_auth_guard())->check()) {
                    return Helpers::error($message, [], 200);
                }
            }
        }
        return $next($request);
    }
}
