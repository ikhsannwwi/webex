<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    // public function handle($request, Closure $next)
    // {
    //     if (auth()->guard('admin')->check()) {
    //         return $next($request);
    //     }

    //     if (request()->is('admin/login')) {
    //         if (auth()->guard('admin')->check()) {
    //             // Jika pengguna sudah memiliki sesi admin, dan mencoba mengakses halaman login, maka arahkan ke dashboard
    //             return redirect()->route('admin.dashboard')->with('error', 'Anda sudah memiliki sesi.');
    //         }
    //     }

    //     // Jika pengguna tidak memiliki sesi admin, arahkan ke halaman login
    //     return redirect()->route('admin.login')->with('error', 'Anda tidak memiliki sesi.');
    // }

    public function handle($request, Closure $next)
{
    if (auth()->guard('admin')->check() && $request->is('admin/login')) {
        // Jika pengguna sudah memiliki sesi admin dan mencoba mengakses halaman login, maka arahkan ke dashboard
        return redirect()->route('admin.dashboard')->with('error', 'Anda sudah memiliki sesi.');
    }

    // Jika pengguna tidak memiliki sesi admin dan mencoba mengakses halaman selain login, arahkan ke halaman login
    if (!auth()->guard('admin')->check() && !$request->is('admin/login')) {
        return redirect()->route('admin.login')->with('error', 'Anda tidak memiliki sesi.');
    }

    return $next($request);
}

}
