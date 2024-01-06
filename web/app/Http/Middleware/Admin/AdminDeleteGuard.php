<?php

namespace App\Http\Middleware\Admin;

use App\Constants\AdminRoleConst;
use Closure;
use Illuminate\Http\Request;

class AdminDeleteGuard
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
        $request->validate([
            'target'    => 'required|string|exists:admins,username'
        ]);
        $admin = get_admin($request->target);
        $roles = $admin->getRolesCollection();

        if(in_array(AdminRoleConst::SUPER_ADMIN,$roles)) {
            return back()->with(['warning' => ['Can\'t deletable system super admin']]);
        }else if($admin->username == auth()->user()->username) {
            return back()->with(['warning' => ['Can\'t delete account by yourself.']]);
        }
        return $next($request);
    }
}
