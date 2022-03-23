<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CekLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (Auth::guard('user')->check()) {
            if (in_array($request->user()->role, $roles)) {
                return $next($request);
            }
            // diarahkan sesuai level ketika mengakses halaman yg tidak boleh diakses
            if (Auth::guard('user')->user()->role == 'owner') {
                session()->flash('info', '<strong>Oppss</strong>, Anda tidak memiliki akses ke halaman itu!');
                return redirect()->route('owner');
            } elseif (Auth::guard('user')->user()->role == 'kasir') {
                session()->flash('info', '<strong>Oppss</strong>, Anda tidak memiliki akses ke halaman itu!');
                return redirect()->route('kasir');
            }
        }
    }
}
