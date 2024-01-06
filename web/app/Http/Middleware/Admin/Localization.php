<?php

namespace App\Http\Middleware\Admin;

use App\Models\Admin\Language;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class Localization
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
        if($request->routeIs('admin.*')) {
            if(session()->has('local')) {
                $local = session()->get("local");
                App::setLocale($local);
            }
            return $next($request);
        }else{
            session()->put('lang', $this->getCode());
            app()->setLocale(session('lang',  $this->getCode()));
            return $next($request);
        }

    }
    public function getCode()
    {
        if (session()->has('lang')) {
            return session('lang');
        }

        $language = "en";

        try{
            $language_record = Language::where('status', 1)->first();
            $language = $language_record->code;
        }catch(Exception $e) {
            //
        }

        return $language;
    }
}
