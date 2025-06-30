<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        if (Auth::check()) {
            // Cek apakah user punya role "admin"
            $hasAdminRole = Auth::user()->roles()->where('title', 'admin')->exists();

            if ($hasAdminRole) {
                return $next($request);
            }

            return redirect('/')->with('error', 'Akses hanya untuk admin.');
        }

        return redirect('/login');
    }
}
