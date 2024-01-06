<?php

namespace App\Http\Middleware\Admin;

use App\Constants\AdminRoleConst;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class RoleGuard
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
        if(auth_has_no_role() || admin_permission_by_name(AdminRoleConst::DASHBOARD) === false) {
            Auth::logout();
            return back()->with(['error' => ['Sorry! You don\'t have permission to access admin dashboard.']]);
            exit;
        }

        if(auth_is_super_admin() === false) {
            if(auth_admin_incomming_permission() === false)  abort(404);
        }

        return $next($request);
    }
}
