<?php

namespace App\Http\Middleware;

use App\Services\SettingService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        $isMaintenance = SettingService::get('maintenance_mode', false);

        if ($isMaintenance) {
            // Allow logged-in admin users
            if (auth()->check() && auth()->user()->isAdmin()) {
                return $next($request);
            }

            // Allow admin panel routes and auth login/logout routes
            if (
                $request->is('admin*') ||
                $request->is('login') ||
                $request->is('logout') ||
                $request->is('build/*') ||
                $request->is('storage/*')
            ) {
                return $next($request);
            }

            // Return custom bakery maintenance mode view for customers / guests
            return response()->view('maintenance', [
                'settings' => SettingService::all()
            ], 503);
        }

        return $next($request);
    }
}
