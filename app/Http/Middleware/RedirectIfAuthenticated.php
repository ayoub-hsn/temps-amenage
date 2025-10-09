<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                switch (auth()->user()->role_id) {
                    case 1:
                        return redirect()->route('sup-admin.dashboard');
                        break;
                    case 2:
                        return redirect()->route('admin-etab.dashboard');
                        break;
                    case 3:
                        return redirect()->route('admin-filiere.dashboard');
                        break;
                    case 4:
                        return redirect()->route('etudiant.dashboard');
                        break;
                    case 5:
                        return redirect()->route('visiteur.dashboard');
                        break;
                    default:
                        return redirect(RouteServiceProvider::HOME);
                        break;
                }
            }
        }

        return $next($request);
    }
}
