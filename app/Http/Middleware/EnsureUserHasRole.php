<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = Auth::guard($role)->user();

        if (! $user) {
            $otherRole = $role === 'admin' ? 'kasir' : 'admin';
            $user = Auth::guard($otherRole)->user();
        }

        if (! $user) {
            return $next($request);
        }

        if ($user->role !== $role) {
            $dashboardRoute = match ($user->role) {
                'admin' => 'admin.dashboard',
                'kasir' => 'kasir.index',
                default => 'login',
            };

            return redirect()->route($dashboardRoute);
        }

        if ($request->isMethod('GET') && ! $request->expectsJson()) {
            $sessionKey = 'role_last_page_' . $role;
            $currentPath = $request->getRequestUri();
            $previousPath = $request->session()->get($sessionKey);
            $isDashboard = in_array($request->route()?->getName(), ['admin.dashboard', 'kasir.index'], true);

            if (! $this->wasOpenedFromApplication($request)
                && $previousPath !== $currentPath) {
                if (is_string($previousPath) && str_starts_with($previousPath, '/')) {
                    return redirect()->to($previousPath);
                }

                if (! $isDashboard) {
                    return redirect()->route($role === 'admin' ? 'admin.dashboard' : 'kasir.index');
                }
            }

            $response = $next($request);
            if ($response->isSuccessful()) {
                $request->session()->put($sessionKey, $currentPath);
            }

            return $response;
        }

        return $next($request);
    }

    private function wasOpenedFromApplication(Request $request): bool
    {
        $referer = $request->headers->get('referer');
        $refererHost = $referer ? parse_url($referer, PHP_URL_HOST) : null;

        return is_string($refererHost)
            && strcasecmp($refererHost, $request->getHost()) === 0;
    }
}