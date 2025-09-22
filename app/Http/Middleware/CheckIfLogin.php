<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use App\Models\Menu;

class CheckIfLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Language logic :Temporary added here
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        }
        if (Auth::check()) {
            $message = [
                "message" => [
                    "type" => "error",
                    "title" => __('dashboard.bad'),
                    "description" => __('dashboard.for_admin_only')
                ]
            ];

            // Remove true once complete DB
            if (false && Auth::user()->user_type != '1') {
                $haveAccess = false;
                if (!empty(Auth::user()->menus)) {
                    $menu = Menu::select('route')
                        ->where("status", 1)
                        ->whereIn('id', explode(',', Auth::user()->menus->menuIds))
                        ->get()->toArray();

                    foreach ($menu as $key => $value) {
                        if ($value["route"] == Route::currentRouteName() || ($value["route"] != "dashboard" && (strpos(Route::currentRouteName(), $value["route"]) === 0))) {
                            $haveAccess = true;
                            break;
                        }
                    }
                }
                // Default access to dashboard
                if (Route::currentRouteName() == "dashboard") {
                    $haveAccess = true;
                }
                if ($haveAccess == false) {
                    return redirect()->route('dashboard')->with($message);
                }
            }
            return $next($request);
        } else {
            return redirect()->route('login');
        }
    }
}
