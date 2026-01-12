<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FilamentRoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Only apply to filament admin panel paths
        $path = trim($request->path(), '/');

        if (!str_starts_with($path, 'admin')) {
            return $next($request);
        }

        $user = Auth::user();

        if ($user) {
            try {
                if ((bool) call_user_func([$user, 'hasRole'], ['Admin', 'Owner'])) {
                    return $next($request);
                }
            } catch (\Throwable $e) {
                // proceed as non-admin
            }
        }

        // For non-admin users allow only dashboard and production kanban pages (tracking produksi)
        // Allow login/logout and assets used by Filament
        $allowedPrefixes = [
            'admin',
            'admin/login',
            'admin/logout',
            'admin/pages/production-kanban',
            'admin/pages/production-kanban/',
            'admin/livewire',
            'admin/_debugbar',
            'admin/assets',
            'admin/vendor',
        ];

        foreach ($allowedPrefixes as $prefix) {
            if ($path === trim($prefix, '/')) {
                return $next($request);
            }

            if (str_starts_with($path, rtrim($prefix, '/'))) {
                return $next($request);
            }
        }

        // If not allowed, redirect to dashboard or abort
        if ($request->wantsJson()) {
            abort(403);
        }

        return redirect()->to('/admin');
    }
}
