<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class RbacMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $permissions = User::with(['role.permission'])->find(auth()->user()->id)->role->permission;
        $allowedRoutes = [];
        foreach ($permissions as $permission) {
            $allowedRoutes[] = $permission->nama_route;
        }

        // Check if current route is in the array of allowed routes
        $currentRoute = Route::currentRouteName(); // Get the current route name
        if (in_array($currentRoute, $allowedRoutes)) {
            return $next($request);
        } else {
            return redirect()->route('access_denied');
        }
    }
}
